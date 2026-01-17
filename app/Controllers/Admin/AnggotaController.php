<?php

namespace App\Controllers\Admin;

use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{
    public function index()
    {
        $model = new AnggotaModel();
        return view('anggota/index', [
            'anggota' => $model->findAll()
        ]);
    }

    public function create()
    {
        $model = new AnggotaModel();
        $model->insert($this->request->getPost());
        return redirect()->back()->with('success','Data berhasil disimpan');
    }

    public function delete($id)
    {
        $model = new AnggotaModel();
        $model->delete($id);
        return redirect()->back()->with('success','Data berhasil dihapus');
    }
}
