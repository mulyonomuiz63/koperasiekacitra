<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Services\Admin\MenuService;

class MenuController extends BaseController
{
    protected $menu;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->service = new MenuService();
        $this->menuId = $this->setMenu('menus');
    }

    public function index()
    {
        return $this->view('admin/menus/index');
    }

    public function datatable()
    {
        if (! $this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }

        $request = $this->request->getPost();
        $result  = $this->service->datatable($request);

        // inject permission di controller
        foreach ($result['data'] as &$row) {
            $row['can_edit']   = can($this->menuId, 'update');
            $row['can_delete'] = can($this->menuId, 'delete');
        }

        return $this->response->setJSON($result);
    }

    public function children(string $parentId)
    {
        if (! $this->request->is('get')) {
            return $this->response->setStatusCode(403);
        }

        $children = $this->service->getChildren($parentId);

        $data = array_map(function ($m) {
            return [
                'id'         => $m['id'],
                'name'       => $m['name'],
                'url'        => $m['url'],
                'menu_order' => $m['menu_order'],
                'is_active'  => $m['is_active'],
                'can_edit'   => can($this->menuId, 'update'),
                'can_delete' => can($this->menuId, 'delete'),
            ];
        }, $children);

        return $this->response->setJSON(['data' => $data]);
    }




    public function create()
    {
        $this->menuId;
        return view('admin/menus/form', [
            'parents' => $this->menu->where('parent_id', null)->findAll()
        ]);
    }

    public function store()
    {
        try {
            // Ambil input dari form
            $data = $this->request->getPost();

            // Panggil service untuk menyimpan
            $this->service->createMenu($data);

            return redirect()->to('/menus')->with('success', 'Menu berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Jika ada kesalahan (misal database error)
            return redirect()->back()->withInput()->with('error', 'Gagal menambah menu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->menuId;
        return view('admin/menus/form', [
            'menu' => $this->menu->find($id),
            'parents' => $this->menu->where('parent_id', null)->findAll()
        ]);
    }

    public function update($id)
    {
        try {
            $data = $this->request->getPost();

            // Eksekusi via service
            $this->service->updateMenu($id, $data);

            return redirect()->to('/menus')->with('success', 'Menu berhasil diupdate');
        } catch (\Throwable $e) {
            // Balikkan ke form dengan pesan error yang spesifik
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Panggil service untuk menghapus secara rekursif
            $this->service->deleteMenuRecursive($id);

            return redirect()->back()->with('success', 'Menu dan semua sub-menu berhasil dihapus');
        } catch (\Throwable $e) {
            // Tangkap pesan error jika terjadi kegagalan
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
