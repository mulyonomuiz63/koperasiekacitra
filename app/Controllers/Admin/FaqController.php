<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;

class FaqController extends BaseController
{
    protected $faq;
    protected $menuId;

    public function __construct()
    {
        $this->faq = new FaqModel();
        $this->menuId = $this->setMenu('faq');
    }

    public function index()
    {
        return $this->view('admin/faq/index');
    }

    public function datatable()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->faq->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'        => $row['id'],
                'question'  => $row['question'],
                'answer'    => word_limiter(strip_tags($row['answer']), 20),
                'is_active' => $row['is_active'],
                
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

    public function create()
    {
        return view('admin/faq/create');
    }

    public function store()
    {
        $this->faq->insert([
            'question'   => $this->request->getPost('question'),
            'answer'     => $this->request->getPost('answer'),
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
            'is_active'  => 1
        ]);

        return redirect()->to(base_url('faq'))->with('success', 'FAQ berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin/faq/edit', [
            'faq' => $this->faq->find($id)
        ]);
    }

    public function update($id)
    {
        $this->faq->update($id, [
            'question'   => $this->request->getPost('question'),
            'answer'     => $this->request->getPost('answer'),
            'sort_order' => $this->request->getPost('sort_order'),
        ]);

        return redirect()->to(base_url('faq'))->with('success', 'FAQ berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->faq->delete($id);
        return redirect()->to(base_url('faq'))->with('success', 'FAQ berhasil dihapus');
    }

    public function toggle()
    {
        $id  = $this->request->getPost('id');
        $faq = $this->faq->find($id);

        $this->faq->update($id, [
            'is_active' => $faq['is_active'] ? 0 : 1
        ]);

        return $this->response->setJSON(['status' => true]);
    }
}
