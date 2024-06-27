<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Konsultasi;

class LaporanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $start = $this->field('start');
            $end = $this->field('end');
            $data = Konsultasi::with(['user.pasien', 'penyakit.penyakit', 'gejala.gejala'])
                ->whereBetween('tanggal', [$start, $end])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.laporan.konsultasi');
    }

    public function pdf()
    {
        $start = $this->field('start');
        $end = $this->field('end');
        $data = Konsultasi::with(['user.pasien', 'penyakit.penyakit', 'gejala.gejala'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('created_at', 'DESC')
            ->get();
        return $this->convertToPdf('admin.laporan.cetak-konsultasi', [
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);

    }


}
