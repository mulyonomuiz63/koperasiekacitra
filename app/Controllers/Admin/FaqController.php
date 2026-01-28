<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;
use App\Services\Admin\FaqService;

class FaqController extends BaseController
{
    protected $faq;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->faq = new FaqModel();
        $this->service = new FaqService();
        $this->menuId = $this->setMenu('faq');
    }

    public function index()
    {
        return $this->view('admin/faq/index');
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
        return view('admin/faq/create');
    }

    public function store()
    {
        try {
            // Ambil semua input post
            $data = $this->request->getPost();

            // Panggil service
            $this->service->createFaq($data);

            return redirect()->to(base_url('faq'))->with('success', 'FAQ berhasil ditambahkan');
        } catch (\Throwable $e) {
            // Jika ada error (misal field database kurang atau mati)
            return redirect()->back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin/faq/edit', [
            'faq' => $this->faq->find($id)
        ]);
    }

    public function update($id)
    {
        try {
            // Ambil data dari post
            $data = $this->request->getPost();

            // Panggil service
            $this->faq->updateFaq($id, $data);

            return redirect()->to(base_url('faq'))->with('success', 'FAQ berhasil diperbarui');
        } catch (\Throwable $e) {
            // Jika gagal (data tidak ada atau error database)
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Panggil service
            $this->faq->deleteFaq($id);

            return redirect()->to(base_url('faq'))->with('success', 'FAQ berhasil dihapus');
        } catch (\Throwable $e) {
            // Jika ID salah atau ada kendala database
            return redirect()->to(base_url('faq'))->with('error', $e->getMessage());
        }
    }

    public function toggle()
    {
        try {
            $id = $this->request->getPost('id');

            // Panggil service
            $this->service->toggleFaqStatus($id);

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Status berhasil diperbarui'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => $e->getMessage()
            ])->setStatusCode(400);
        }
    }
}
