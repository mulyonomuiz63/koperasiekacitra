<?php 
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Services\Admin\NewsService;

class NewsController extends BaseController
{
    protected $categoryModel;
    protected $tagModel;
    protected $menuId;
    protected $service;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();
        $this->service = new NewsService();
        $this->menuId = $this->setMenu('news');
    }
    public function index()
    {
        return $this->view('admin/news/index');
    }

    public function datatable()
    {
        if (! $this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }

        return $this->response->setJSON(
            $this->service->get(
                $this->request->getPost(),
                $this->menuId
            )
        );
    }
    public function create()
    {
        $this->categoryModel = new CategoryModel();
        $this->tagModel = new TagModel();

        $data = [
            'categories' => $this->categoryModel->findAll(),
            'tags'       => $this->tagModel->findAll()
        ];

        return view('admin/news/create', $data);
    }

    public function store()
    {
        $newsModel = new \App\Models\NewsModel();
        $db = \Config\Database::connect();
        
        // 1. Validasi Input
        if (!$this->validate([
            'title' => 'required',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]',
        ])) {
            return redirect()->back()->withInput();
        }

        // 2. Olah Gambar (Patenkan Ukuran)
        $img = $this->request->getFile('image');
        $newName = $img->getRandomName();
        
        // Simpan gambar asli
        $img->move(FCPATH . 'uploads/news/', $newName);

        // 3. Simpan Data Berita
        $dataNews = [
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'content'     => $this->request->getPost('content'),
            'author'      => $this->request->getPost('author'),
            'image'       => $newName,
            'status'      => 'publish'
        ];

        $newsId = $newsModel->insert($dataNews);

        // --- PROSES TAG OTOMATIS ---
        $tags = $this->request->getPost('tags');
        if (!empty($tags)) {
            foreach ($tags as $tagInput) {
                // REGEX untuk mendeteksi format UUID (8-4-4-4-12 chars)
                $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $tagInput);

                if (!$isUuid) {
                    // 1. Cek dulu apakah tag teks tersebut sebenarnya sudah ada di database 
                    // (untuk menghindari duplikasi jika user mengetik tag yang sudah ada)
                    $existingTag = $db->table('tags')->where('tag_name', $tagInput)->get()->getRow();

                    if ($existingTag) {
                        $tagId = $existingTag->id;
                    } else {
                        // 2. Simpan sebagai tag baru jika benar-kan belum ada
                        $newTagData = [
                            'tag_name' => $tagInput,
                            'tag_slug' => url_title($tagInput, '-', true)
                        ];
                        $tagId = $this->tagModel->insert($newTagData);
                    }
                } else {
                    $tagId = $tagInput; // Jika angka, berarti menggunakan ID yang sudah ada
                }

                // 3. Simpan ke tabel pivot news_tags
                $db->table('news_tags')->insert([
                    'news_id' => $newsId,
                    'tag_id'  => $tagId
                ]);
            }
        }

        return redirect()->to('/news')->with('success', 'Berita berhasil disimpan!');
    }
    public function edit($id)
    {
        $newsModel = new \App\Models\NewsModel();
        $catModel = new \App\Models\CategoryModel();
        $tagModel = new \App\Models\TagModel();
        $db = \Config\Database::connect();

        $data = [
            'news'         => $newsModel->find($id),
            'categories'   => $catModel->findAll(),
            'tags'         => $tagModel->findAll(),
            'current_tags' => $db->table('news_tags')->where('news_id', $id)->get()->getResult()
        ];

        return view('admin/news/edit', $data);
    }

    public function update($id)
    {
        $newsModel = new \App\Models\NewsModel();
        $db        = \Config\Database::connect();

        // 1. Ambil data lama untuk pengecekan gambar
        $news = $newsModel->find($id);
        if (!$news) {
            return redirect()->back()->with('error', 'Data berita tidak ditemukan.');
        }

        // Mulai Transaksi Database
        $db->transStart();

        try {
            $img = $this->request->getFile('image');
            $fileName = $news['image'];

            // 2. Olah Gambar
            if ($img->isValid() && !$img->hasMoved()) {
                $fileName = $img->getRandomName();
                $img->move(FCPATH . 'uploads/news/', $fileName);
                
                // Hapus file lama jika ada
                if ($news['image'] != 'default.jpg' && file_exists(FCPATH . 'uploads/news/' . $news['image'])) {
                    @unlink(FCPATH . 'uploads/news/' . $news['image']);
                }
            }

            // 3. Update Data Berita Utama
            $dataUpdate = [
                'category_id' => $this->request->getPost('category_id'),
                'title'       => $this->request->getPost('title'),
                'content'     => $this->request->getPost('content'),
                'author'      => $this->request->getPost('author'),
                'image'       => $fileName,
            ];
            
            $newsModel->update($id, $dataUpdate);

            // 4. Update Tags (UUID Handling)
            // Hapus relasi lama terlebih dahulu
            $db->table('news_tags')->where('news_id', $id)->delete();
            
            $tags = $this->request->getPost('tags');
            if (!empty($tags)) {
                foreach ($tags as $tagInput) {
                    // REGEX untuk mendeteksi format UUID (8-4-4-4-12 chars)
                    $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $tagInput);

                    if (!$isUuid) {
                        // 1. Cek dulu apakah tag teks tersebut sebenarnya sudah ada di database 
                        // (untuk menghindari duplikasi jika user mengetik tag yang sudah ada)
                        $existingTag = $db->table('tags')->where('tag_name', $tagInput)->get()->getRow();

                        if ($existingTag) {
                            $tagId = $existingTag->id;
                        } else {
                            // 2. Simpan sebagai tag baru jika benar-kan belum ada
                            $newTagData = [
                                'tag_name' => $tagInput,
                                'tag_slug' => url_title($tagInput, '-', true)
                            ];
                            $tagId = $this->tagModel->insert($newTagData);
                        }
                    } else {
                        $tagId = $tagInput; // Jika angka, berarti menggunakan ID yang sudah ada
                    }

                    // 3. Simpan ke tabel pivot news_tags
                    $db->table('news_tags')->insert([
                        'news_id' => $id,
                        'tag_id'  => $tagId
                    ]);
                }
            }

            // Jika sampai sini tidak ada error, Commit transaksi
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Jika transaksi gagal secara internal
                throw new \Exception('Gagal memproses transaksi database.');
            }

            return redirect()->to('/news')->with('success', 'Berita berhasil diperbarui.');

        } catch (\Exception $e) {
            // Rollback otomatis jika terjadi error di blok try
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $newsModel = new \App\Models\NewsModel();
        $db = \Config\Database::connect();
        
        // Cari data berita
        $news = $newsModel->find($id);

        if (!$news) {
            return redirect()->to('/news')->with('error', 'Berita tidak ditemukan.');
        }

        $db->transStart();
        try {
            // 1. Hapus Gambar Fisik
            if ($news['image'] != 'default.jpg' && file_exists(FCPATH . 'uploads/news/' . $news['image'])) {
                @unlink(FCPATH . 'uploads/news/' . $news['image']);
            }

            // 2. Hapus Relasi di tabel news_tags
            $db->table('news_tags')->where('news_id', $id)->delete();

            // 3. Hapus Data Berita
            $newsModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menghapus data dari database.');
            }

            return redirect()->to('/news')->with('success', 'Berita berhasil dihapus.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/news')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}