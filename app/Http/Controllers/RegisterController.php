<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;

class RegisterController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        return view('register');
    }
}
