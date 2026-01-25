<?php

namespace App\Services\Admin;

use CodeIgniter\HTTP\Files\UploadedFile;

class TinyMceUploadService
{
    protected array $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
    protected string $uploadPath = 'uploads/tinymce/galeri';

    /**
     * Upload image for TinyMCE
     */
    public function uploadImage(?UploadedFile $file): array
    {
        if (! $file || ! $file->isValid()) {
            throw new \RuntimeException('File tidak valid');
        }

        $ext = strtolower($file->getExtension());

        if (! in_array($ext, $this->allowedExt)) {
            throw new \RuntimeException('Format gambar tidak didukung');
        }

        $path = FCPATH . $this->uploadPath . '/';

        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $name = $file->getRandomName();

        if (! $file->move($path, $name)) {
            throw new \RuntimeException('Gagal menyimpan file');
        }

        return [
            'location' => base_url($this->uploadPath . '/' . $name)
        ];
    }
}
