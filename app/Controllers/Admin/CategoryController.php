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
        $this->category->insert($this->request->getPost());
        return redirect()->to('/category')->with('success', 'Category berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin/category/edit', [
            'category' => $this->category->find($id),
        ]);
    }

    public function update($id)
    {
        $this->category->update($id, $this->request->getPost());
        return redirect()->to('/category')->with('success', 'Category berhasil diupdate');
    }

    public function delete($id)
    {
        // Pastikan data ada
        $category = $this->category->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'category tidak ditemukan');
        }

        // Hapus parent + semua child
        $this->category->delete($id);

        return redirect()->back()->with('success', 'Category berhasil dihapus');
    }

}
