<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Services\Admin\LaporanService;

class LaporanController extends BaseController
{
    protected $jabatan;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->service = new LaporanService();
        $this->menuId = $this->setMenu('laporan');
    }

    public function index()
    {
        return $this->view('admin/laporan/index');
    }

    public function datatable()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun') ?? date('Y');
        $search = $request->getPost('search')['value'];

        $db = \Config\Database::connect();
        $builder = $db->table('pegawai p');

        // Query Pivot
        $builder->select('p.nama');
        $months = [
            1 => 'jan',
            2 => 'feb',
            3 => 'mar',
            4 => 'apr',
            5 => 'mei',
            6 => 'jun',
            7 => 'jul',
            8 => 'agu',
            9 => 'sep',
            10 => 'okt',
            11 => 'nov',
            12 => 'des'
        ];

        foreach ($months as $num => $alias) {
            // Menambahkan parameter false (parameter kedua) sangat penting
            $builder->select("MAX(CASE WHEN i.bulan = $num THEN i.jumlah_iuran ELSE 0 END) AS $alias", false);
        }

        $builder->join('iuran_bulanan i', "i.pegawai_id = p.id AND i.tahun = $tahun AND i.status = 'S'", 'left',false);
        $builder->where('p.status_iuran', 'A');


        if ($search) {
            $builder->like('p.nama', $search);
        }

        $builder->groupBy('p.id');

        // Pagination (Simple version for Server-side)
        $start = $request->getPost('start');
        $length = $request->getPost('length');

        $totalData = $db->table('pegawai')->countAllResults();
        $data = $builder->get($length, $start)->getResultArray();

        return $this->response->setJSON([
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData, // Sesuaikan jika ada filter pencarian yang kompleks
            'data' => $data
        ]);
    }
}
