<?php


namespace App\Http\Controllers\Pasien;


use App\Helper\CustomController;

class KonsultasiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('pasien.konsultasi');
    }
}
