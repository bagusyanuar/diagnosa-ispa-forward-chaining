<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;

class LoginController extends CustomController
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
        'username.required' => 'kolom usernam wajib di isi',
        'password.required' => 'kolom password wajib di isi',
    ];

    public function login()
    {
        return view('login');
    }
}
