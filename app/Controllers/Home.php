<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('dashboard');
    }
    public function tes(): string
    {
        return view('anggota/dashboard');
    }
}
