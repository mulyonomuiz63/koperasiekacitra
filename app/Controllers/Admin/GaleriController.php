<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Services\Admin\GaleriService;

class GaleriController extends BaseController
{
    protected $galeriModel;
    protected $service;
    protected $menuId;
    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        $this->service = new GaleriService();
        $this->menuId = $this->setMenu('galeri');
    }

    public function index()
    {
        $galeri = $this->galeriModel->orderBy('created_at', 'DESC')->findAll();
        return $this->view('admin/galeri/index', ['galeri' => $galeri]);
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
        return view('admin/galeri/create');
    }

    public function store()
    {
        $file = $this->request->getFile('filename');
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file'        => $file
        ];

        $result = $this->service->create($data);

        if ($result['status'] === 'success') {
            return redirect()->to(base_url('galeri'))->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    public function edit($id)
    {
        $data = $this->service->find($id);

        if (!$data) {
            return redirect()->to(base_url('galeri'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/galeri/edit', ['galeri' => $data]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('filename');
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file'        => $file
        ];

        $result = $this->service->update($id, $data);

        if ($result['status'] === 'success') {
            return redirect()->to(base_url('galeri'))->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }


    public function delete($id)
    {
        $galeri = $this->galeriModel->find($id);

        if (!$galeri) {
            return redirect()->to(base_url('galeri'))->with('error', 'Data tidak ditemukan.');
        }

        $uploadPath = FCPATH.'uploads/galeri';
        $thumbPath  = FCPATH.'uploads/galeri/thumbs';

        // Hapus file full-size
        if ($galeri['filename'] && file_exists($uploadPath.'/'.$galeri['filename'])) {
            unlink($uploadPath.'/'.$galeri['filename']);
        }

        // Hapus thumbnail
        if ($galeri['filename'] && file_exists($thumbPath.'/'.$galeri['filename'])) {
            unlink($thumbPath.'/'.$galeri['filename']);
        }

        // Hapus record dari DB
        $this->galeriModel->delete($id);

        return redirect()->to(base_url('galeri'))->with('success', 'Data galeri berhasil dihapus.');
    }

}
