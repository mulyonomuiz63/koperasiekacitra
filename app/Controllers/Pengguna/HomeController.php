<?php

namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Services\Pengguna\HomeService;

class HomeController extends BaseController
{
    protected $service;
    public function __construct()
    {
        $this->service = new HomeService();
    }
    public function index(): string
    {
        $userId = session()->get('user_id');

        // Cukup panggil service, biarkan service yang pusing memikirkan cache & query
        $data = $this->service->getAggregatedStats($userId);

        return view('anggota/dashboard', $data);
    }
}
