<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;

class GaleriController extends BaseController
{
    protected $galeriModel;
    protected $menuId;
    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        $this->menuId = $this->setMenu('galeri');
    }

    public function index()
    {
        $galeri = $this->galeriModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/galeri/index', ['galeri' => $galeri]);
    }

    public function datatable()
    {
        $request = $this->request;
        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;
        $search = $request->getPost('search')['value'] ?? '';

        $builder = $this->galeriModel;

        // Search
        if ($search) {
            $builder = $builder->like('title', $search)
                            ->orLike('description', $search);
        }

        $totalRecords = $builder->countAllResults(false); // false agar query belum dieksekusi
        $data = $builder->orderBy('created_at', 'DESC')
                        ->findAll($length, $start);

        $json_data = [];
        foreach ($data as $row) {
            $json_data[] = [
                'id'          => $row['id'],
                'title'       => $row['title'],
                'description' => $row['description'],
                'filename'    => '<img src="'.base_url('uploads/galeri/thumbs/'.$row['filename']).'" style="width:80px;height:60px;object-fit:cover;">',
                // 🔐 PERMISSION (INTI)
                'can_edit'   => can($this->menuId, 'update'),
                'can_delete' => can($this->menuId, 'delete'),
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $this->galeriModel->countAll(),
            'recordsFiltered' => $totalRecords,
            'data' => $json_data
        ]);
    }


    public function create()
    {
        return view('admin/galeri/create');
    }

    public function store()
    {
        $request = $this->request;
        $file = $request->getFile('filename');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadPath = FCPATH.'uploads/galeri';
            $thumbPath  = FCPATH.'uploads/galeri/thumbs';

            // Buat folder jika belum ada
            if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);
            if (!is_dir($thumbPath)) mkdir($thumbPath, 0777, true);

            // Nama file acak
            $filename = $file->getRandomName();
            $filePath = $uploadPath.'/'.$filename;

            // Pindahkan file ke folder utama
            $file->move($uploadPath, $filename);

            // Compress / resize full-size max width 1024px
            \Config\Services::image()
                ->withFile($filePath)
                ->resize(1024, 1024, true, 'width')
                ->save($filePath, 80); // kualitas 80%

            // Buat thumbnail 150x100px
            \Config\Services::image()
                ->withFile($filePath)
                ->resize(150, 100, true, 'width')
                ->save($thumbPath.'/'.$filename, 80);

            // Simpan ke database
            $this->galeriModel->insert([
                'title'       => $request->getPost('title'),
                'description' => $request->getPost('description'),
                'filename'    => $filename,
            ]);

            return redirect()->to(base_url('galeri'))->with('success', 'Gambar berhasil diupload dan thumbnail dibuat.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload gambar.');
    }

    public function edit($id)
    {
        $data = $this->galeriModel->find($id);

        if (!$data) {
            return redirect()->to(base_url('galeri'))->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/galeri/edit', ['galeri' => $data]);
    }

    public function update($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to(base_url('galeri'))->with('error', 'Data tidak ditemukan.');
        }

        $request = $this->request;
        $inputs = [
            'title'       => $request->getPost('title'),
            'description' => $request->getPost('description')
        ];

        $file = $request->getFile('filename');
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $uploadPath = FCPATH.'uploads/galeri';
            $thumbPath  = FCPATH.'uploads/galeri/thumbs';

            // Hapus file lama
            if ($galeri['filename']) {
                if (file_exists($uploadPath.'/'.$galeri['filename'])) {
                    unlink($uploadPath.'/'.$galeri['filename']);
                }
                if (file_exists($thumbPath.'/'.$galeri['filename'])) {
                    unlink($thumbPath.'/'.$galeri['filename']);
                }
            }

            // Upload file baru
            $filename = $file->getRandomName();
            $filePath = $uploadPath.'/'.$filename;
            $file->move($uploadPath, $filename);

            // Compress full-size
            \Config\Services::image()
                ->withFile($filePath)
                ->resize(1024, 1024, true, 'width')
                ->save($filePath, 80);

            // Buat thumbnail
            \Config\Services::image()
                ->withFile($filePath)
                ->resize(150, 100, true, 'width')
                ->save($thumbPath.'/'.$filename, 80);

            $inputs['filename'] = $filename;
        }

        $this->galeriModel->update($id, $inputs);

        return redirect()->to(base_url('galeri'))->with('success', 'Data galeri berhasil diupdate.');
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
