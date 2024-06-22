<?php


namespace App\Http\Controllers\Pasien;


use App\Helper\CustomController;
use App\Models\Konsultasi;

class RiwayatController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Konsultasi::with(['user', 'penyakit.penyakit', 'gejala.gejala'])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('pasien.riwayat.index');
    }

    public function detail($id)
    {
        $data = Konsultasi::with(['user', 'penyakit.penyakit', 'gejala.gejala'])
            ->findOrFail($id);
        return view('pasien.riwayat.detail')->with(['data' => $data]);
    }
}
