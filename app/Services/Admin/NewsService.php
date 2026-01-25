<?php

namespace App\Services\Admin;

use App\Models\NewsModel;
use CodeIgniter\Files\File;
use Config\Services;

class NewsService
{
    protected $news;

    protected $uploadPath;
    protected $thumbPath;

    public function __construct()
    {
        $this->news = new NewsModel();
        $this->uploadPath  = FCPATH . 'uploads/news';
        $this->thumbPath   = FCPATH . 'uploads/news/thumbs';

        if (!is_dir($this->uploadPath)) mkdir($this->uploadPath, 0777, true);
        if (!is_dir($this->thumbPath)) mkdir($this->thumbPath, 0777, true);
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->news->getDatatable($request);

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
            'view'        => $row['views'],
            'filename'    => '<img src="'.base_url('uploads/news/'.$row['image']).'" style="width:80px;height:60px;object-fit:cover;">',
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    /**
     * Simpan news baru
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
        $this->news->insert([
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'filename'    => $filename,
        ]);

        return ['status' => 'success', 'message' => 'Gambar berhasil diupload dan thumbnail dibuat.'];
    }

    /**
     * Update news
     *
     * @param int $id
     * @param array $data (title, description, file: File|null)
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $news = $this->news->find($id);
        if (!$news) {
            return ['status' => 'error', 'message' => 'Data tidak ditemukan'];
        }

        $inputs = [
            'title'       => $data['title'] ?? $news['title'],
            'description' => $data['description'] ?? $news['description']
        ];

        $file = $data['file'] ?? null;

        if ($file instanceof File && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama
            if ($news['filename']) {
                $oldFile = $this->uploadPath . '/' . $news['filename'];
                $oldThumb = $this->thumbPath . '/' . $news['filename'];
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

        $this->news->update($id, $inputs);

        return ['status' => 'success', 'message' => 'Data news berhasil diupdate.'];
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
     * Ambil data news
     *
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        return $this->news->find($id);
    }
}
