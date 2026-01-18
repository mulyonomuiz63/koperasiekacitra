<?php
namespace App\Controllers\Pengguna;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PembayaranModel;

class ActivityController extends BaseController
{
    public function index()
    {
        $pegawai = (new PegawaiModel())
            ->where('user_id', session()->get('user_id'))
            ->first();

        $pembayaran = (new PembayaranModel())
            ->where('pegawai_id', $pegawai['id'] ?? 0)
            ->orderBy('tgl_bayar', 'DESC')
            ->first();

        return view('anggota/activity/index', [
            'pegawai' => $pegawai,
            'pembayaran' => $pembayaran
        ]);
    }

    public function lengkapiData()
    {
        return view('anggota/activity/lengkapi_data');
    }

    public function saveData()
    {
        (new PegawaiModel())
            ->where('user_id', session()->get('user_id'))
            ->set([
                'nip' => $this->request->getPost('nip'),
                'nik' => $this->request->getPost('nik'),
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'tanggal_masuk' => date('Y-m-d')
            ])->update();

        return redirect()->to('/sw-anggota/activity');
    }
    public function uploadPembayaran()
    {
        $file = $this->request->getFile('bukti_bayar');

        // Ambil data pegawai
        $pegawai = (new PegawaiModel())
            ->where('user_id', session()->get('user_id'))
            ->first();

        // Ambil data pembayaran terakhir pegawai
        $pembayaranModel = new PembayaranModel();
        $pembayaran = $pembayaranModel->where('pegawai_id', $pegawai['id'])->where('status','pending')->orderBy('tgl_bayar', 'DESC')->first();

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $path = FCPATH . 'uploads/bukti-bayar/';

            // Simpan file baru
            $file->move($path, $namaFile);

            // Kompres gambar jika jpg/jpeg/png
            $this->compressImage($path . $namaFile);

            if ($pembayaran) {
                // Hapus file lama jika ada
                if (!empty($pembayaran['bukti_bayar']) && file_exists($path . $pembayaran['bukti_bayar'])) {
                    unlink($path . $pembayaran['bukti_bayar']);
                }

                // Update record pembayaran
                $pembayaranModel->update($pembayaran['id'], [
                    'bukti_bayar' => $namaFile,
                    'tgl_bayar'   => date('Y-m-d H:i:s'),
                    'status'      => 'pending'
                ]);
            } else {
                // Jika belum ada record pembayaran, insert baru
                $pembayaranModel->insert([
                    'pegawai_id'  => $pegawai['id'],
                    'bukti_bayar' => $namaFile,
                    'tgl_bayar'   => date('Y-m-d H:i:s'),
                    'status'      => 'pending'
                ]);
            }

            return redirect()->to('/sw-anggota/activity')->with('success', 'File berhasil diupload/diupdate, menunggu approval admin');
        }

        return redirect()->to('/sw-anggota/activity')->with('error', 'Gagal upload file');
    }


    private function compressImage($filePath, $quality = 75)
    {
        $info = getimagesize($filePath);

        if (!$info) return false;

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($filePath);
                imagejpeg($image, $filePath, $quality);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filePath);
                // convert quality 0-9 ke 0-100
                $pngQuality = (int)((100 - $quality) / 10);
                imagepng($image, $filePath, $pngQuality);
                break;
            default:
                return false;
        }

        imagedestroy($image);
        return true;
    }

}
