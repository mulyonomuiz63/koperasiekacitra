<?php

namespace App\Services\Admin;

use App\Models\SliderModel;
use CodeIgniter\Files\File;
use Config\Services;

class SliderService
{
    protected $slider;

    protected $uploadPath;
    protected $thumbPath;

    public function __construct()
    {
        $this->slider = new SliderModel();
        $this->uploadPath  = FCPATH . 'uploads/slider';
        $this->thumbPath   = FCPATH . 'uploads/slider/thumbs';

        if (!is_dir($this->uploadPath)) mkdir($this->uploadPath, 0777, true);
        if (!is_dir($this->thumbPath)) mkdir($this->thumbPath, 0777, true);
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->slider->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = $this->mapRow($row, $menuId);
        }

        return [
            'draw'            => (int) $request['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    protected function mapRow(array $row, string $menuId): array
    {
        return [
            'id'          => $row['id'],
            'title'       => $row['title'],
            'filename'    => img_lazy('uploads/slider/thumbs/' . $row['filename'], $row['title'], ['width'  => 80, 'height' => 60, 'style'  => 'width:80px; height:60px; object-fit:cover;', 'class'  => 'img-thumbnail']),
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    /**
     * Simpan slider baru
     *
     * @param array $data (title, description, file: File)
     * @return array
     */
    public function create(array $data): array
    {
        $file = $data['file'] ?? null;

        if (!$file instanceof File || !$file->isValid()) {
            return ['status' => 'error', 'message' => 'File tidak valid'];
        }

        // Upload file
        $filename = $file->getRandomName();
        $filePath = $this->uploadPath . '/' . $filename;
        $file->move($this->uploadPath, $filename);

        // Compress dan buat thumbnail
        $this->compressImage($filePath, $this->thumbPath . '/' . $filename);

        // Simpan ke DB
        $this->slider->insert([
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'filename'    => $filename,
            'jenis_slider' => $data['jenis_slider'] ?? '',
        ]);

        return ['status' => 'success', 'message' => 'Gambar berhasil diupload dan thumbnail dibuat.'];
    }

    /**
     * Update slider
     *
     * @param int $id
     * @param array $data (title, description, file: File|null)
     * @return array
     */
    public function update(string $id, array $data): array
    {
        $slider = $this->slider->find($id);
        if (!$slider) {
            return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
        }

        $inputs = [
            'title'       => $data['title'] ?? $slider['title'],
            'description' => $data['description'] ?? $slider['description'],
            'jenis_slider' => $data['jenis_slider'] ?? $slider['jenis_slider']
        ];

        $file = $data['file'] ?? null;

        if ($file instanceof File && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama
            if ($slider['filename']) {
                $oldFile = $this->uploadPath . '/' . $slider['filename'];
                $oldThumb = $this->thumbPath . '/' . $slider['filename'];
                if (file_exists($oldFile)) unlink($oldFile);
                if (file_exists($oldThumb)) unlink($oldThumb);
            }

            // Upload file baru
            $filename = $file->getRandomName();
            $filePath = $this->uploadPath . '/' . $filename;
            $file->move($this->uploadPath, $filename);

            // Compress dan buat thumbnail
            $this->compressImage($filePath, $this->thumbPath . '/' . $filename);

            $inputs['filename'] = $filename;
        }

        $this->slider->update($id, $inputs);

        return ['status' => 'success', 'message' => 'Data slider berhasil diupdate.'];
    }

    /**
     * Compress image dan buat thumbnail
     *
     * @param string $filePath
     * @param string $thumbPath
     * @param int $quality
     * @return void
     */
    private function compressImage(string $filePath, string $thumbPath, int $quality = 80): void
    {
        // Compress full-size max width 1024px
        Services::image()
            ->withFile($filePath)
            ->resize(1024, 1024, true, 'width')
            ->save($filePath, $quality);

        // Thumbnail 150x100px
        Services::image()
            ->withFile($filePath)
            ->resize(150, 100, true, 'width')
            ->save($thumbPath, $quality);
    }

    /**
     * Ambil data slider
     *
     * @param int $id
     * @return array|null
     */
    public function find(string $id): ?array
    {
        return $this->slider->find($id);
    }

    public function deleteSlider(string $id)
    {
        try {
            // 1. Cari data slider
            $slider = $this->slider->find($id);

            if (!$slider) {
                throw new \Exception('Data slider tidak ditemukan.');
            }

            $filename = $slider['filename'];
            $uploadPath = FCPATH . 'uploads/slider/';
            $thumbPath  = FCPATH . 'uploads/slider/thumbs/';

            // 2. Hapus file full-size jika ada
            if ($filename && is_file($uploadPath . $filename)) {
                @unlink($uploadPath . $filename);
            }

            // 3. Hapus thumbnail jika ada
            if ($filename && is_file($thumbPath . $filename)) {
                @unlink($thumbPath . $filename);
            }

            // 4. Hapus record dari Database
            return $this->slider->delete($id);
        } catch (\Throwable $e) {
            throw new \Exception("Gagal menghapus slider: " . $e->getMessage());
        }
    }
}
