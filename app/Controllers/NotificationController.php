<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\NotificationService;

class NotificationController extends BaseController
{
    protected $db;
    protected $service;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->service = new NotificationService();
    }

    /**
     * Mengambil data notifikasi terbaru untuk user yang sedang login
     */
    public function getNotifications()
    {
        try {
            // 1. Ambil ID dari session
            $userId = session()->get('user_id');

            if (!$userId) {
                return $this->response->setStatusCode(401)->setJSON([
                    'status'   => 'error',
                    'message'  => 'Sesi telah berakhir, silakan login kembali',
                ]);
            }

            // 2. Panggil service untuk ambil data
            $result = $this->service->getUnreadNotifications($userId);

            // 3. Kembalikan respon sukses
            return $this->response->setJSON([
                'status'       => 'success',
                'data'         => $result['notifications'],
                'unread_count' => $result['unread_count'],
            ]);
        } catch (\Exception $e) {
            // 4. Tangkap error dan kirim sebagai JSON agar JS tidak 'Unexpected token <'
            return $this->response->setStatusCode(500)->setJSON([
                'status'   => 'error',
                'message'  => 'Gagal memuat notifikasi: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Menandai notifikasi telah dibaca saat diklik
     */
    public function markAsRead()
    {
        $uuid = $this->request->getPost('uuid');
        $userId = session()->get('user_id');

        if (!$uuid) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'UUID missing'
            ]);
        }

        try {
            $success = $this->service->markSingleAsRead($uuid, $userId);

            if (!$success) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status'  => 'error',
                    'message' => 'Data tidak ditemukan atau gagal diperbarui'
                ]);
            }

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Notifikasi ditandai telah dibaca',
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function markAllRead()
    {
        try {
            $userId = session()->get('user_id');
            $this->service->markAllAsRead($userId);

            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Semua telah dibaca',
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
