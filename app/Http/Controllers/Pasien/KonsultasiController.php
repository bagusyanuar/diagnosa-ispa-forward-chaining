<?php


namespace App\Http\Controllers\Pasien;


use App\Helper\CustomController;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Models\KonsultasiGejala;
use App\Models\KonsultasiPenyakit;
use App\Models\Penyakit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KonsultasiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            return $this->store_consult_result();
        }

        $gejalas = Gejala::with([])
            ->get();
        return view('pasien.konsultasi')->with([
            'gejalas' => $gejalas
        ]);
    }

    private function store_consult_result()
    {
        try {
            DB::beginTransaction();
            $inputs = $this->request->get('gejala');
            if (is_array($inputs)) {
                $penyakits = Penyakit::with(['aturan.gejala'])
                    ->get();

                //check
                $diseaseWeights = [];
                $summarySymptomsWeight = 0;
                foreach ($penyakits as $penyakit) {
                    $tmp = [
                        'code' => 'p_' . $penyakit->id
                    ];
                    $weight = $penyakit->aturan->sum('bobot');
                    $tmp['total_weight'] = $weight;


                    /** @var Collection $rWeight */
                    $rWeight = $penyakit->aturan;
                    $symptomsWeights = [];
                    $totalSymptomsWeight = 0;
                    foreach ($inputs as $symptom) {
                        $vSymptom = $rWeight->where('gejala_id', '=', $symptom)->first();
                        $sWeight = 0;
                        if ($vSymptom) {
                            $sWeight = $vSymptom->bobot;
                        }
                        $totalSymptomsWeight = $totalSymptomsWeight + $sWeight;
                        $tmpSymptomsWeight = [
                            'code' => $symptom,
                            'weight' => $sWeight
                        ];
                        array_push($symptomsWeights, $tmpSymptomsWeight);
                    }
                    $tmp['symptoms'] = $symptomsWeights;
                    $tmp['total_symptoms_weight'] = $totalSymptomsWeight;
                    $summarySymptomsWeight = $summarySymptomsWeight + $totalSymptomsWeight;
                    array_push($diseaseWeights, $tmp);
                }

                $resultMaps = [];
                foreach ($diseaseWeights as $diseaseWeight) {
                    $code = $diseaseWeight['code'];
                    $weight = $diseaseWeight['total_symptoms_weight'];
                    $value = ($weight / $summarySymptomsWeight) * 100;
                    $tmpResultMap = [
                        'code' => $code,
                        'value' => round($value, 2, PHP_ROUND_HALF_UP),
                        'formula' => '(' . $weight . ' / ' . $summarySymptomsWeight . ') * 100%'
                    ];
                    array_push($resultMaps, $tmpResultMap);
                }

                usort($resultMaps, function ($a, $b) {
                    return $a['value'] < $b['value'];
                });

                $diseaseMap = [
                    'total_symptoms_weight' => $summarySymptomsWeight,
                    'result_map' => $resultMaps,
                    'data_map' => $diseaseWeights,
                ];

                $data_consult = [
                    'user_id' => auth()->id(),
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                    'no_konsultasi' => 'KS-' . date('YmdHis')
                ];

                $consult = Konsultasi::create($data_consult);
                foreach ($resultMaps as $resultMap) {
                    $diseaseID = explode('_', $resultMap['code']);
                    $data_penyakits = [
                        'konsultasi_id' => $consult->id,
                        'penyakit_id' => $diseaseID[1],
                        'persentase' => $resultMap['value']
                    ];
                    KonsultasiPenyakit::create($data_penyakits);
                }

                foreach ($inputs as $input) {
                    $data_gejala = [
                        'konsultasi_id' => $consult->id,
                        'gejala_id' => $input
                    ];
                    KonsultasiGejala::create($data_gejala);
                }
                DB::commit();
                return redirect()->route('pasien.riwayat.detail', ['id' => $consult->id]);

            } else {
                DB::rollBack();
                return redirect()->back()->with('failed', 'input tidak sesuai...');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', 'terjadi kesalahan server...');
        }
    }

    public function result_page()
    {
//        $results = [];
        if (Session::has('result')) {
            $results = Session::get('result');
        } else {
            return redirect()->route('pasien.konsultasi');
        }
//        Session::flush();
//        if (count($results) <= 0) {
//            return redirect()->route('pasien.konsultasi');
//        }
        return view('pasien.hasil-konsultasi')->with([
            'results' => $results
        ]);
    }

    private function findDiseasesWithPercentage($rules, $knownFacts)
    {
        $diseaseCounts = [];
        $gejalaCounts = [];

        // Hitung jumlah total aturan untuk setiap penyakit dan jumlah gejala yang cocok
        foreach ($rules as $rule) {
            $penyakit = $rule['penyakit'];
            $gejalaList = $rule['gejala'];

            if (!isset($gejalaCounts[$penyakit])) {
                $gejalaCounts[$penyakit] = count($gejalaList);
            }

            foreach ($gejalaList as $gejala) {
                if (in_array($gejala, $knownFacts)) {
                    if (!isset($diseaseCounts[$penyakit])) {
                        $diseaseCounts[$penyakit] = 0;
                    }
                    $diseaseCounts[$penyakit]++;
                }
            }
        }


        // Hitung persentase gejala yang cocok untuk setiap penyakit
        $diseasePercentages = [];
        foreach ($diseaseCounts as $penyakit => $count) {
            $totalGejala = $gejalaCounts[$penyakit];
            $diseasePercentages[$penyakit] = ($count / $totalGejala) * 100;
        }

        return $diseasePercentages;
    }

//                return $this->jsonSuccessResponse('success', $diseaseMap);
//                $rules = [];
//                foreach ($penyakits as $penyakit) {
//                    $tmpRules['penyakit'] = (string)$penyakit->id;
//
//                    $gejalas = $penyakit['aturan'];
//                    $arrGejalas = [];
//                    foreach ($gejalas as $gejala) {
//                        array_push($arrGejalas, (string)$gejala->gejala->id);
//                    }
//                    $tmpRules['gejala'] = $arrGejalas;
//                    array_push($rules, $tmpRules);
//                }
//                $results = $this->findDiseasesWithPercentage($rules, $inputs);
//                if (count($results) > 0) {
//                    $arrKeys = array_keys($results);
//                    $resPenyakits = Penyakit::with([])
//                        ->whereIn('id', $arrKeys)
//                        ->get();
//                    $res = [];
//                    foreach ($resPenyakits as $resPenyakit) {
//                        $tmpRes['id'] = $resPenyakit->id;
//                        $tmpRes['nama'] = $resPenyakit->nama;
//                        $tmpRes['persentase'] = 0;
//                        if (array_key_exists($resPenyakit->id, $results)) {
//                            $tmpRes['persentase'] = round($results[$resPenyakit->id], 2, PHP_ROUND_HALF_UP);
//                        }
//                        array_push($res, $tmpRes);
//
//                    }
//                    usort($res, function ($a, $b) {
//                        return $a['persentase'] < $b['persentase'];
//                    });
//
//                    if (count($res) <= 0) {
//                        DB::rollBack();
//                        return redirect()->back()->with('failed', 'hasil diagnosa tidak ditemukan...');
//                    }
}
