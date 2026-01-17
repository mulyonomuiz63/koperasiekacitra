<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class TinymceController extends Controller
{
    public function upload()
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'error' => 'File tidak valid'
            ]);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = $file->getExtension();

        if (!in_array($ext, $allowed)) {
            return $this->response->setJSON([
                'error' => 'Format gambar tidak didukung'
            ]);
        }

        $path = FCPATH . 'uploads/tinymce/galeri/';

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $name = $file->getRandomName();
        $file->move($path, $name);

        return $this->response->setJSON([
            'location' => base_url('uploads/tinymce/' . $name)
        ]);
    }
}
