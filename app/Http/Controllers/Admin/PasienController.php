<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Pasien;

class PasienController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Pasien::with(['user'])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.pasien.index');
    }
}
