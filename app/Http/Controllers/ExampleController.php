<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;

class ExampleController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $rules = [
            ['gejala' => ['demam', 'batuk'], 'penyakit' => 'flu'],
            ['gejala' => ['sakit_tenggorokan', 'batuk'], 'penyakit' => 'radang_tenggorokan'],
            ['gejala' => ['pilek', 'sakit_kepala'], 'penyakit' => 'common_cold'],
            ['gejala' => ['demam', 'nyeri_otot'], 'penyakit' => 'dengue'],
            ['gejala' => ['batuk', 'sesak_nafas'], 'penyakit' => 'asma'],
        ];

        $knownFacts = ['demam', 'batuk'];

        $results = $this->findDiseasesWithPercentage($rules, $knownFacts);
        return $this->jsonSuccessResponse('success', $results);

    }

    function findDiseasesWithPercentage($rules, $knownFacts) {
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

        return [$diseaseCounts, $gejalaCounts];

        // Hitung persentase gejala yang cocok untuk setiap penyakit
        $diseasePercentages = [];
        foreach ($diseaseCounts as $penyakit => $count) {
            $totalGejala = $gejalaCounts[$penyakit];
            $diseasePercentages[$penyakit] = ($count / $totalGejala) * 100;
        }

        return $diseasePercentages;
    }
}
