<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;
use App\Services\Admin\SliderService;

class SliderController extends BaseController
{
    protected $sliderModel;
    protected $service;
    protected $menuId;
    public function __construct()
    {
        $this->sliderModel = new SliderModel();
        $this->service = new SliderService();
        $this->menuId = $this->setMenu('slider');
    }

    public function index()
    {
        $slider = $this->sliderModel->orderBy('created_at', 'DESC')->findAll();
        return $this->view('admin/slider/index', ['slider' => $slider]);
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
        return view('admin/slider/create');
    }

    public function store()
    {
        $file = $this->request->getFile('filename');
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file'        => $file,
            'jenis_slider' => $this->request->getPost('jenis_slider'),
        ];

        $result = $this->service->create($data);

        if ($result['status'] === 'success') {
            return redirect()->to('slider')->with('success', $result['message']);
        }

        return redirect()->to('slider/create')->with('error', $result['message']);
    }

    public function edit($id)
    {
        $data = $this->service->find($id);

        if (!$data) {
            return redirect()->to(base_url('slider'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/slider/edit', ['slider' => $data]);
    }

    public function update($id)
    {
        $file = $this->request->getFile('filename');
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file'        => $file,
            'jenis_slider' => $this->request->getPost('jenis_slider'),
        ];

        $result = $this->service->update($id, $data);

        if ($result['status'] === 'success') {
            return redirect()->to('slider')->with('success', $result['message']);
        }

        return redirect()->to('slider/edit/'.$id)->with('error', $result['message']);
    }


    public function delete($id)
    {
        try {
            // Eksekusi penghapusan melalui service
            $this->service->deleteSlider($id);

            return redirect()->to('slider')
                ->with('success', 'Data slider berhasil dihapus.');
        } catch (\Throwable $e) {
            // Tangkap pesan error jika data tidak ditemukan atau gagal hapus
            return redirect()->to('slider')
                ->with('error', $e->getMessage());
        }
    }
}
