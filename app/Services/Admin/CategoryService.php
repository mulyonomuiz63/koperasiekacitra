<?php

namespace App\Services\Admin;

use App\Models\CategoryModel;

class CategoryService
{
    protected $category;

    public function __construct()
    {
        $this->category = new CategoryModel();
    }

    public function get(array $request, string $menuId): array
    {
        $result = $this->category->getDatatable($request);

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
            'id'                    => $row['id'],
            'category_name'         => $row['category_name'],

            // 🔐 PERMISSION (INTI)
            'can_edit'   => can($menuId, 'update'),
            'can_delete' => can($menuId, 'delete'),
        ];
    }

    public function createCategory(array $data)
    {
        // Anda bisa menambahkan logika validasi atau manipulasi data di sini
        return $this->category->insert($data);
    }

    public function updateCategory(string $id, array $data)
    {
        // Cek dulu apakah data kategorinya ada
        $category = $this->category->find($id);

        if (!$category) {
            throw new \Exception('Kategori tidak ditemukan.');
        }

        // Lakukan update
        return $this->category->update($id, $data);
    }

    public function deleteCategory(string $id)
    {
        // 1. Cari datanya
        $category = $this->category->find($id);

        if (!$category) {
            throw new \Exception('Kategori tidak ditemukan.');
        }

        // 2. Opsi Tambahan: Cek relasi (Contoh)
        // if ($this->productModel->where('category_id', $id)->first()) {
        //     throw new \Exception('Kategori tidak bisa dihapus karena masih memiliki produk.');
        // }

        // 3. Eksekusi Hapus
        return $this->category->delete($id);
    }
}
