<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\Admin\HomeService;

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

        // Panggil Service
        $stats = $this->service->getDashboardStats($userId);

        return view('admin/dashboard', $stats);
    }
}
