<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Gejala;

class GejalaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Gejala::with([])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.gejala.index');
    }
}
