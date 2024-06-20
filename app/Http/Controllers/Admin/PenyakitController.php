<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PenyakitController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Penyakit::with([])
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.penyakit.index');
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        return view('admin.penyakit.add');
    }

    public function edit($id)
    {
        $data = Penyakit::with([])
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            return $this->patch($data);
        }
        return view('admin.penyakit.edit')->with(['data' => $data]);
    }

    public function delete($id)
    {
        try {
            Penyakit::destroy($id);
            return $this->jsonSuccessResponse('Berhasil menghapus data...');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse();
        }
    }

    private $rule = [
        'name' => 'required',
    ];

    private $message = [
        'name.required' => 'kolom nama penyakit wajib diisi',
    ];

    private function store()
    {
        try {
            $validator = Validator::make($this->request->all(), $this->rule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'Harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
            }
            $data_request = [
                'nama' => $this->postField('name'),
            ];

            Penyakit::create($data_request);
            return redirect()->back()->with('success', 'Berhasil menyimpan data penyakit...');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'terjadi kesalahan server...');
        }
    }

    /**
     * @param Model $data
     * @return \Illuminate\Http\RedirectResponse
     */
    private function patch($data)
    {
        try {
            $validator = Validator::make($this->request->all(), $this->rule, $this->message);
            if ($validator->fails()) {
                return redirect()->back()->with('failed', 'Harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
            }
            $data_request = [
                'nama' => $this->postField('name'),
            ];

            $data->update($data_request);
            return redirect()->back()->with('success', 'Berhasil merubah data penyakit...');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'terjadi kesalahan server...');
        }
    }
}
