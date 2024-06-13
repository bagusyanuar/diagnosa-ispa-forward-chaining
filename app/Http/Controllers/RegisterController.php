<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private $rule = [
        'username' => 'required',
        'password' => 'required',
    ];

    private $message = [
        'username.required' => 'kolom username wajib di isi',
        'password.required' => 'kolom password wajib di isi',
    ];

    public function register()
    {
        if ($this->request->method() === 'POST') {
            try {
                DB::beginTransaction();
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->with('failed', 'harap mengisi kolom dengan benar...')->withErrors($validator)->withInput();
                }

                $data_user = [
                    'username' => $this->postField('username'),
                    'password' => Hash::make($this->postField('password')),
                    'role' => 'pasien'
                ];

                $user = User::create($data_user);
                $data_pasien = [
                    'user_id' => $user->id,
                    'nama' => $this->postField('name'),
                    'alamat' => $this->postField('address'),
                    'jenis_kelamin' => $this->postField('gender')
                ];
                Pasien::create($data_pasien);
                DB::commit();
                return redirect()->back()->with('success', 'Registrasi Berhasil...');
            }catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'internal server error');
            }

        }
        return view('register');
    }
}
