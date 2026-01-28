<?php

namespace App\Services\Admin;

use App\Models\FaqModel;

class FaqService
{
    protected $faq;

    public function __construct()
    {
        $this->faq = new FaqModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->faq->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {
            $data[] = $this->mapRow($row, $menuId);
        }

        return [
            'draw'            => (int) $request['draw'],
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ];
    }

    protected function mapRow(array $row, string $menuId): array
    {
        return [
            'id'         => $row['id'],
            'question'   => $row['question'],
            'answer'     => word_limiter(strip_tags($row['answer']), 20),
            'is_active'  => $row['is_active'],

            // permission
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function createFaq(array $data)
    {
        // Susun data agar sesuai dengan kolom tabel
        $saveData = [
            'question'   => $data['question'],
            'answer'     => $data['answer'],
            'sort_order' => $data['sort_order'] ?: 0, // Jika kosong isi 0
            'is_active'  => 1 // Default aktif untuk FAQ baru
        ];

        return $this->faq->insert($saveData);
    }

    public function updateFaq(string $id, array $data)
    {
        // 1. Cek keberadaan data
        $faq = $this->faq->find($id);

        if (!$faq) {
            throw new \Exception('Data FAQ tidak ditemukan.');
        }

        // 2. Susun data yang akan diupdate
        $updateData = [
            'question'   => $data['question'],
            'answer'     => $data['answer'],
            'sort_order' => $data['sort_order'] ?? $faq['sort_order'],
        ];

        // 3. Eksekusi update
        return $this->faq->update($id, $updateData);
    }

    public function deleteFaq(string $id)
    {
        // Cek apakah data ada
        $faq = $this->faq->find($id);

        if (!$faq) {
            throw new \Exception('FAQ tidak ditemukan atau sudah dihapus.');
        }

        // Eksekusi hapus
        return $this->faq->delete($id);
    }

    public function toggleFaqStatus(string $id): bool
    {
        $faq = $this->faq->find($id);

        if (!$faq) {
            throw new \Exception('FAQ tidak ditemukan.');
        }

        // Balikkan nilai: jika 1 jadi 0, jika 0 jadi 1
        $newStatus = $faq['is_active'] ? 0 : 1;

        return $this->faq->update($id, [
            'is_active' => $newStatus
        ]);
    }
}
