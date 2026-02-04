<?php
namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PembayaranModel;
use App\Services\Pengguna\ActivityService;

class ActivityController extends BaseController
{
    protected $service;

    public function __construct()
    {
        $this->service = new ActivityService();
    }

    public function index()
    {
        try {
            $data = $this->service->getUserActivity(session()->get('user_id'));
            return view('anggota/activity/index', $data);
        } catch (\Throwable $e) {
            return redirect()->back()
                     ->withInput() // Agar input user tidak hilang saat refresh
                     ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }    

    public function lengkapiData()
    {
        return view('anggota/activity/lengkapi_data');
    }

    public function saveData()
    {
        try {
            $this->service->savePegawaiData(session()->get('user_id'), $this->request->getPost());
            return redirect()->to('/sw-anggota/activity')->with('success', 'Data pegawai berhasil disimpan.');
        } catch (\Throwable $e) {
            return redirect()->back()
                     ->withInput() // Agar input user tidak hilang saat refresh
                     ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function uploadPembayaran()
    {
        try {
            $result = $this->service->uploadPembayaran(
                session()->get('user_id'),
                $this->request->getFile('bukti_bayar'),
                $this->request->getPost()
            );

            if ($result['status']) {
                return redirect()->to('/sw-anggota/activity')->with('success', $result['message']);
            }

            return redirect()->to('/sw-anggota/activity')->with('error', $result['message']);

        } catch (\Throwable $e) {
            return redirect()->back()
                     ->withInput() // Agar input user tidak hilang saat refresh
                     ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
