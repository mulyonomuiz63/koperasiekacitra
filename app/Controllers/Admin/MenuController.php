<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class MenuController extends BaseController
{
    protected $menu;
    protected $menuId;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->menuId = $this->setMenu('menus');
    }

    public function index()
    {
        return $this->view('admin/menus/index');
    }

    public function datatable()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->menu->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'         => $row['id'],
                'name'       => $row['name'],
                'url'        => $row['url'],
                'menu_order' => $row['menu_order'],
                'is_active'  => $row['is_active'],
                'parent_id'  => $row['parent_id'],
                'has_child'  => $row['has_child'],

                // 🔐 PERMISSION (INTI)
                'can_edit'   => can($this->menuId, 'update'),
                'can_delete' => can($this->menuId, 'delete'),
            ];
        }


        return $this->response->setJSON([
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ]);
    }

    public function children($parentId)
    {
        if (!$this->request->is('get')) {
            return $this->response->setStatusCode(403);
        }


        $children = $this->menu
            ->where('parent_id', $parentId)
            ->orderBy('menu_order', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'data' => array_map(function ($m) {
                return [
                    'id'         => $m['id'],
                    'name'       => $m['name'],
                    'url'        => $m['url'],
                    'menu_order' => $m['menu_order'],
                    'is_active'  => $m['is_active'],
                    'can_edit'   => can($this->menuId, 'update'),
                    'can_delete' => can($this->menuId, 'delete'),
                ];
            }, $children),
        ]);

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
        $this->menu->insert($this->request->getPost());
        return redirect()->to('/menus')->with('success', 'Menu berhasil ditambahkan');
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
        $this->menu->update($id, $this->request->getPost());
        return redirect()->to('/menus')->with('success', 'Menu berhasil diupdate');
    }

    public function delete($id)
    {
        // Pastikan data ada
        $menu = $this->menu->find($id);

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        // Hapus parent + semua child
        $this->deleteRecursive($id);

        return redirect()->back()->with('success', 'Menu & sub menu berhasil dihapus');
    }

    private function deleteRecursive($parentId)
    {
        // Ambil semua child
        $children = $this->menu
            ->where('parent_id', $parentId)
            ->findAll();

        foreach ($children as $child) {
            // Hapus child-anaknya dulu
            $this->deleteRecursive($child['id']);

            // Hapus child
            $this->menu->delete($child['id']);
        }

        // Terakhir hapus parent
        $this->menu->delete($parentId);
    }

}
