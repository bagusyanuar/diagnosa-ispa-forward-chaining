<?php


namespace App\Http\Controllers\Pasien;


use App\Helper\CustomController;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Penyakit;
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
//            $inputs = $this->request->get('gejala');
            $inputs = ['1', '2', '5'];
            if (is_array($inputs)) {
                $penyakits = Penyakit::with(['aturan.gejala'])
                    ->get();
                $rules = [];
                foreach ($penyakits as $penyakit) {
                    $tmpRules['penyakit'] = (string)$penyakit->id;

                    $gejalas = $penyakit['aturan'];
                    $arrGejalas = [];
                    foreach ($gejalas as $gejala) {
                        array_push($arrGejalas, (string)$gejala->gejala->id);
                    }
                    $tmpRules['gejala'] = $arrGejalas;
                    array_push($rules, $tmpRules);
                }
                $results = $this->findDiseasesWithPercentage($rules, $inputs);
                if (count($results) > 0) {
                    $arrKeys = array_keys($results);
                    $resPenyakits = Penyakit::with([])
                        ->whereIn('id', $arrKeys)
                        ->get();
                    $res = [];
                    foreach ($resPenyakits as $resPenyakit) {
                        $tmpRes['id'] = $resPenyakit->id;
                        $tmpRes['nama'] = $resPenyakit->nama;
                        $tmpRes['persentase'] = 0;
                        if (array_key_exists($resPenyakit->id, $results)) {
                            $tmpRes['persentase'] = round($results[$resPenyakit->id], 2, PHP_ROUND_HALF_UP);
                        }
                        array_push($res, $tmpRes);

                    }
                    usort($res, function ($a, $b) {
                        return $a['persentase'] < $b['persentase'];
                    });
                    return redirect()->route('pasien.konsultasi.hasil')->with('result', $res);
//                    dd($res);
                } else {
                    return redirect()->back()->with('failed', 'hasil diagnosa tidak ditemukan...');
                }
//                dd(count($results));
            } else {
                return redirect()->back()->with('failed', 'terjadi kesalahan server..');
            }
        }
        $gejalas = Gejala::with([])
            ->get();
        return view('pasien.konsultasi')->with([
            'gejalas' => $gejalas
        ]);
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
}
