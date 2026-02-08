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
        // Mengambil data kategori dan tags dari Service
        $data = $this->service->getCreateData();

        return view('admin/news/create', $data);
    }

    public function store()
    {
        // 1. Validasi Input (Tetap di Controller agar mudah handling redirect back)
        if (!$this->validate([
            'title' => 'required',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]',
        ])) {
            return redirect()->to('/news')->withInput();
        }

        try {
            $data = $this->request->getPost();
            $file = $this->request->getFile('image');

            // 2. Eksekusi via Service
            $this->service->createNews($data, $file);

            return redirect()->to('/news')->with('success', 'Berita berhasil disimpan!');
        } catch (\Throwable $e) {
            return redirect()->to('/news/create')->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data = $this->service->getNewsForEdit($id);

            return view('admin/news/edit', $data);
        } catch (\Throwable $e) {
            return redirect()->to('/news')->with('error', $e->getMessage());
        }
    }
    public function update($id)
    {
        // Validasi dasar
        if (!$this->validate(['title' => 'required'])) {
            return redirect()->to('/news')->withInput();
        }

        try {
            $data = $this->request->getPost();
            $file = $this->request->getFile('image');

            // Eksekusi via Service
            $this->service->updateNews($id, $data, $file);

            return redirect()->to('/news')->with('success', 'Berita berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/news/edit/'.$id)->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Eksekusi via Service
            $this->service->deleteNews($id);

            return redirect()->to('/news')->with('success', 'Berita berhasil dihapus.');
        } catch (\Throwable $e) {
            // Tangkap pesan error (misal: data tidak ditemukan atau gagal hapus)
            return redirect()->to('/news')->with('error', $e->getMessage());
        }
    }
}
