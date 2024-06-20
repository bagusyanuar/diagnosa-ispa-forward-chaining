<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Aturan;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AturanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Penyakit::with(['aturan.gejala'])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.aturan.index');
    }

    public function setRule($id)
    {
        if ($this->request->ajax()) {
            $aturanGejala = Aturan::with(['gejala', 'penyakit'])
                ->where('penyakit_id', '=', $id)
                ->get();
            return $this->basicDataTables($aturanGejala);
        }

        $data = Penyakit::with(['aturan'])
            ->findOrFail($id);

        if ($this->request->method() === 'POST') {
            return $this->store($data);
        }

        $gejalas = Gejala::with([])
            ->get();
        return view('admin.aturan.edit')->with([
            'data' => $data,
            'gejalas' => $gejalas
        ]);
    }


    private $rule = [
        'gejala' => 'required',
    ];

    private $message = [
        'gejala.required' => 'kolom nama penyakit wajib diisi',
    ];

    /**
     * @param Model $data
     * @return \Illuminate\Http\RedirectResponse
     */
    private function store($data)
    {
        try {
            $validator = Validator::make($this->request->all(), $this->rule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'Harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
            }

            $gejalaID = $this->postField('gejala');

            $data_request = [
                'penyakit_id' => $data->id,
                'gejala_id' => $gejalaID,
            ];

            $isRuleExist = Aturan::with([])
                ->where('penyakit_id', '=', $data->id)
                ->where('gejala_id', '=', $gejalaID)
                ->exists();

            if ($isRuleExist) {
                return redirect()->back()->with('failed', 'Data Aturan Sudah Ada...');
            }

            Aturan::create($data_request);
            return redirect()->back()->with('success', 'Berhasil menyimpan data penyakit...');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'terjadi kesalahan server...');
        }
    }
}
