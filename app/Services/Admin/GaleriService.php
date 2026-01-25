<?php

namespace App\Services\Admin;

use App\Models\GaleriModel;
use CodeIgniter\Files\File;
use Config\Services;

class GaleriService
{
    protected $galeri;

    protected $uploadPath;
    protected $thumbPath;

    public function __construct()
    {
        $this->galeri = new GaleriModel();
        $this->uploadPath  = FCPATH . 'uploads/galeri';
        $this->thumbPath   = FCPATH . 'uploads/galeri/thumbs';

        if (!is_dir($this->uploadPath)) mkdir($this->uploadPath, 0777, true);
        if (!is_dir($this->thumbPath)) mkdir($this->thumbPath, 0777, true);
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->galeri->getDatatable($request);

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
            'description' => $row['description'],
            'filename'    => '<img src="'.base_url('uploads/galeri/thumbs/'.$row['filename']).'" style="width:80px;height:60px;object-fit:cover;">',
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    /**
     * Simpan galeri baru
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
        $this->galeri->insert([
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'filename'    => $filename,
        ]);

        return ['status' => 'success', 'message' => 'Gambar berhasil diupload dan thumbnail dibuat.'];
    }

    /**
     * Update galeri
     *
     * @param int $id
     * @param array $data (title, description, file: File|null)
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $galeri = $this->galeri->find($id);
        if (!$galeri) {
            return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
        }

        $inputs = [
            'title'       => $data['title'] ?? $galeri['title'],
            'description' => $data['description'] ?? $galeri['description']
        ];

        $file = $data['file'] ?? null;

        if ($file instanceof File && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama
            if ($galeri['filename']) {
                $oldFile = $this->uploadPath . '/' . $galeri['filename'];
                $oldThumb = $this->thumbPath . '/' . $galeri['filename'];
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

        $this->galeri->update($id, $inputs);

        return ['status' => 'success', 'message' => 'Data galeri berhasil diupdate.'];
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
     * Ambil data galeri
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        return $this->galeri->find($id);
    }
}
