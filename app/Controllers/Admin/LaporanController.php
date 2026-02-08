<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Services\Admin\LaporanService;
use Config\Database;

class LaporanController extends BaseController
{
    protected $jabatan;
    protected $service;
    protected $menuId;
    protected $db;

    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->service = new LaporanService();
        $this->menuId = $this->setMenu('laporan');
        $this->db = Database::connect();
    }

    public function index()
    {

        $data['pegawai'] = $this->db->table('pegawai')
            ->select('id, nama, nik')
            ->where('status', 'A')
            ->where('status_iuran', 'A')
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        $data['tahunList'] = $this->db->table('iuran_bulanan')
            ->select('tahun')
            ->where('status', 'S')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()
            ->getResultArray();
        return $this->view('admin/laporan/index', $data);
    }

    public function datatable()
    {
        $request = \Config\Services::request();
        $tahun = $request->getPost('tahun') ?? date('Y');
        $search = $request->getPost('search')['value'];

        $builder = $this->db->table('pegawai p');

        // 1. Select Nama Pegawai
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

        // 2. Query Pivot untuk Nominal DAN Status
        foreach ($months as $num => $alias) {
            // Ambil jumlah iuran (Gunakan NULL jika tidak ada data agar tampil dash di JS)
            $builder->select("MAX(CASE WHEN i.bulan = $num THEN i.jumlah_iuran END) AS $alias", false);

            // Ambil status (Penting untuk warna badge di View)
            $builder->select("MAX(CASE WHEN i.bulan = $num THEN i.status END) AS {$alias}_status", false);
        }

        // 3. Join & Filter
        $builder->join('iuran_bulanan i', "i.pegawai_id = p.id AND i.tahun = " . $this->db->escape($tahun), 'left', false);
        $builder->where('p.status_iuran', 'A');

        if ($search) {
            $builder->like('p.nama', $search);
        }

        $builder->groupBy('p.id');

        // 4. Pagination & Total Data
        $start = $request->getPost('start');
        $length = $request->getPost('length');

        // Hitung total data pegawai yang aktif (status_iuran = A)
        $totalData = $this->db->table('pegawai')->where('status_iuran', 'A')->countAllResults();

        // Ambil data hasil query pivot
        $data = $builder->get($length, $start)->getResultArray();

        return $this->response->setJSON([
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $data
        ]);
    }

    public function simpanManual()
    {
        try {
            // 1. Validasi Input Dasar
            $rules = [
                'pegawai_id'    => 'required',
                'tahun'         => 'required|numeric',
                'bulan_mulai'   => 'required|numeric',
                'bulan_selesai' => 'required|numeric',
                'status'        => 'required',
                'jumlah'        => 'required|numeric',
            ];

            if (!$this->validate($rules)) {
                throw new \Exception("Data yang diinput tidak valid atau belum lengkap.");
            }

            $post = $this->request->getPost();

            // 2. Validasi Logika Rentang Bulan
            if ((int)$post['bulan_mulai'] > (int)$post['bulan_selesai']) {
                throw new \Exception("Rentang bulan salah: Bulan mulai tidak boleh melampaui bulan selesai.");
            }

            // 3. Panggil Service
            $this->service->simpanManual($post);

            // Jika sampai sini berarti sukses
            return redirect()->back()->with('success', 'Data iuran berhasil diperbarui untuk rentang bulan yang dipilih.');
        } catch (\Exception $e) {
            // Tangkap pesan error dari Service atau dari validasi di atas
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
