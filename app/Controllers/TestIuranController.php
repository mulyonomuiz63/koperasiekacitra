<?php

namespace App\Controllers;

use App\Libraries\IuranService;

class TestIuranController extends BaseController
{
    public function generate()
    {
        $model = new IuranService();
        $total = $model->generateBulanan();

        return $this->response->setJSON([
            'status' => 'OK',
            'generated' => $total
        ]);
    }
}
