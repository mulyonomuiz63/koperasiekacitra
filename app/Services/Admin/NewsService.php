<?php

namespace App\Services\Admin;

use App\Models\CategoryModel;
use App\Models\NewsModel;
use App\Models\TagModel;
use Config\Database;

class NewsService
{
    protected $news;
    protected $category;
    protected $tag;
    protected $db;

    public function __construct()
    {
        $this->news = new NewsModel();
        $this->category = new CategoryModel();
        $this->tag = new TagModel();
        $this->db = Database::connect();
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
            'filename'    => img_lazy('uploads/news/' . $row['image'], $row['title'], ['width'  => 80, 'height' => 60, 'style'  => 'width:80px; height:60px; object-fit:cover;', 'class'  => 'img-thumbnail']),
            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function getCreateData(): array
    {
        return [
            'categories' => $this->category->findAll(),
            'tags'       => $this->tag->findAll()
        ];
    }
    public function createNews(array $data, $imageFile)
    {
        $this->db->transBegin();

        try {
            // 1. Olah Gambar
            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/news/', $newName);

            // 2. Simpan Berita
            $dataNews = [
                'category_id' => $data['category_id'],
                'title'       => $data['title'],
                'keyword'     => $data['keyword'],
                'content'     => $data['content'],
                'author'      => $data['author'],
                'image'       => $newName,
                'status'      => 'publish'
            ];
            $newsId = $this->news->insert($dataNews);

            // 3. Proses Tags (Many-to-Many)
            if (!empty($data['tags'])) {
                $this->processTags($newsId, $data['tags']);
            }

            $this->db->transCommit();
            return true;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            // Hapus gambar jika transaksi gagal agar tidak jadi sampah
            if (isset($newName) && file_exists(FCPATH . 'uploads/news/' . $newName)) {
                unlink(FCPATH . 'uploads/news/' . $newName);
            }
            throw new \Exception("Gagal menyimpan berita: " . $e->getMessage());
        }
    }

    private function processTags($newsId, array $tags)
    {
        foreach ($tags as $tagInput) {
            // Cek apakah format UUID
            $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $tagInput);

            if (!$isUuid) {
                // Cek nama tag di DB
                $existingTag = $this->tag->where('tag_name', $tagInput)->first();

                if ($existingTag) {
                    $tagId = $existingTag['id'];
                } else {
                    $tagId = $this->tag->insert([
                        'tag_name' => $tagInput,
                        'tag_slug' => url_title($tagInput, '-', true)
                    ]);
                }
            } else {
                $tagId = $tagInput;
            }

            // Simpan ke Pivot
            $this->db->table('news_tags')->insert([
                'news_id' => $newsId,
                'tag_id'  => $tagId
            ]);
        }
    }

    public function getNewsForEdit(string $id): array
    {
        $news = $this->news->find($id);

        if (!$news) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Berita dengan ID $id tidak ditemukan.");
        }


        // Ambil hanya ID tag yang terelasi untuk mempermudah pengecekan di view
        $currentTags = $this->db->table('news_tags')
            ->where('news_id', $id)
            ->get()
            ->getResultArray();

        // Ubah array object menjadi array flat ID: [uuid1, uuid2, ...]
        $selectedTagIds = array_column($currentTags, 'tag_id');

        return [
            'news'           => $news,
            'categories'     => $this->category->findAll(),
            'tags'           => $this->tag->findAll(),
            'selectedTagIds' => $selectedTagIds
        ];
    }

    public function updateNews(string $id, array $data, $imageFile)
    {
        $this->db->transBegin();

        try {
            // 1. Ambil data lama
            $news = $this->news->find($id);
            if (!$news) {
                throw new \Exception('Data berita tidak ditemukan.');
            }

            $fileName = $news['image'];

            // 2. Olah Gambar (Jika ada upload baru)
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $fileName = $imageFile->getRandomName();
                $imageFile->move(FCPATH . 'uploads/news/', $fileName);

                // Hapus file lama jika bukan default
                if ($news['image'] != 'default.jpg' && file_exists(FCPATH . 'uploads/news/' . $news['image'])) {
                    @unlink(FCPATH . 'uploads/news/' . $news['image']);
                }
            }

            // 3. Update Data Utama
            $dataUpdate = [
                'category_id' => $data['category_id'],
                'title'       => $data['title'],
                'keyword'     => $data['keyword'],
                'content'     => $data['content'],
                'author'      => $data['author'],
                'image'       => $fileName,
            ];
            $this->news->update($id, $dataUpdate);

            // 4. Sinkronisasi Tags
            // Hapus relasi lama
            $this->db->table('news_tags')->where('news_id', $id)->delete();

            // Input relasi baru (menggunakan method privat yang sudah kita buat sebelumnya)
            if (!empty($data['tags'])) {
                $this->processTags($id, $data['tags']);
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return false;
            }

            $this->db->transCommit();
            return true;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteNews(string $id)
    {
        $this->db->transBegin();

        try {
            // 1. Cari data berita
            $news = $this->news->find($id);

            if (!$news) {
                throw new \Exception('Berita tidak ditemukan.');
            }

            // 2. Hapus Gambar Fisik
            if ($news['image'] != 'default.jpg' && is_file(FCPATH . 'uploads/news/' . $news['image'])) {
                @unlink(FCPATH . 'uploads/news/' . $news['image']);
            }

            // 3. Hapus Relasi di tabel news_tags (Pivot)
            $this->db->table('news_tags')->where('news_id', $id)->delete();

            // 4. Hapus Data Berita di DB
            $this->news->delete($id);

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return false;
            }

            $this->db->transCommit();
            return true;
        } catch (\Throwable $e) {
            $this->db->transRollback();
            throw new \Exception($e->getMessage());
        }
    }
}
