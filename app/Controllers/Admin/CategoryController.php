<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Services\Admin\CategoryService;

class CategoryController extends BaseController
{
    protected $category;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->category = new CategoryModel();
        $this->service = new CategoryService();
        $this->menuId = $this->setMenu('category');
    }


    public function index()
    {
        return $this->view('admin/category/index');
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
        return view('admin/category/create');
    }

    public function store()
    {
        try {
            // Ambil semua data input
            $data = $this->request->getPost();

            // Panggil fungsi di service
            $this->service->createCategory($data);

            return redirect()->to('/category')->with('success', 'Category berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Tangani jika ada error (misal: duplicate entry atau database down)
            return redirect()->back()->withInput()->with('error', 'Gagal menambah kategori: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin/category/edit', [
            'category' => $this->category->find($id),
        ]);
    }

    public function update($id)
    {
        try {
            $data = $this->request->getPost();

            // Panggil service
            $this->service->updateCategory($id, $data);

            return redirect()->to('/category')->with('success', 'Category berhasil diupdate');
        } catch (\Throwable $e) {
            // Jika error (misal ID tidak ditemukan), lempar balik ke form
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Panggil service untuk menghapus
            $this->service->deleteCategory($id);

            return redirect()->back()->with('success', 'Category berhasil dihapus');
        } catch (\Throwable $e) {
            // Tangkap pesan error dari service (misal: data tidak ditemukan)
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
