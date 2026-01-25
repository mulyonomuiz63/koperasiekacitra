<?php
namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\Pengguna\ProfileService;

class ProfilController extends BaseController
{
    protected $user;
    protected $service;
    protected $menuId;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->service = new ProfileService();
        $this->menuId = $this->setMenu('profil');
    }

    public function index()
    {
        $db = \Config\Database::connect();
            $builder = $db->table('iuran_bulanan')
            ->join('pegawai','pegawai.id=iuran_bulanan.pegawai_id');
        $data['total_saldo'] = $builder->where('iuran_bulanan.status', 'S')
                                    ->where('pegawai.id',session()->get('user_id'))
                                    ->selectSum('jumlah_iuran')
                                    ->get()->getRow()->jumlah_iuran ?? 0;
        $data['user'] = $this->user
                        ->join('pegawai','pegawai.user_id=users.id')
                        ->join('perusahaan','perusahaan.id=pegawai.perusahaan_id')
                        ->join('jabatan','jabatan.id=pegawai.jabatan_id')
                        ->select('users.email, perusahaan.nama_perusahaan, jabatan.nama_jabatan, pegawai.*')->first();
        return $this->view('anggota/profil/index', $data);
    }

    public function saveData()
    {
        try {
            $this->service->savePegawaiData($this->request->getPost('pegawai_id'), $this->request->getPost());
            return redirect()->to('/sw-anggota/profil')->with('success', 'Data pegawai berhasil diubah.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pegawai.');
        }
    }
}
