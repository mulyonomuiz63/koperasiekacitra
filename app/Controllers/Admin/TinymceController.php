<?php

namespace App\Controllers\Admin;

use App\Services\Admin\TinyMceUploadService;
use CodeIgniter\Controller;

class TinymceController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->service = new TinyMceUploadService();
    }
    public function upload()
    {
        try {
            $result = $this->service->uploadImage(
                $this->request->getFile('file')
            );

            return $this->response->setJSON($result);

        } catch (\Throwable $e) {

            return $this->response->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function uploadSlider()
    {
        try {
            $result = $this->service->uploadImageSlider(
                $this->request->getFile('file')
            );

            return $this->response->setJSON($result);

        } catch (\Throwable $e) {

            return $this->response->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }
}
