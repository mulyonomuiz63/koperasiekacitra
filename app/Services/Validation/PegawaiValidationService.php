<?php

namespace App\Services\Validation;

use CodeIgniter\Validation\Validation;

class PegawaiValidationService
{
    protected Validation $validation;

    public function __construct()
    {
        $this->validation = service('validation');
    }

    /**
     * Validasi create pegawai
     */
    public function validateCreate(array $data): bool
    {
        $this->validation->setRules($this->createRules());

        return $this->validation->run($data);
    }

    /**
     * Validasi update pegawai
     */
    public function validateUpdate(array $data, string $pegawaiId): bool
    {
        $this->validation->setRules(
            $this->updateRules($pegawaiId)
        );

        return $this->validation->run($data);
    }

    /**
     * Ambil error validasi
     */
    public function getErrors(): array
    {
        return $this->validation->getErrors();
    }

    /**
     * =============================
     * RULES
     * =============================
     */
    protected function createRules(): array
    {
        return [
            'user_id' => [
                'rules'  => 'required|is_unique[pegawai.user_id]',
                'errors' => [
                    'required'  => 'User wajib dipilih.',
                    'is_unique' => 'User sudah terdaftar sebagai pegawai.',
                ],
            ],
            'nip' => [
                'rules'  => 'permit_empty|is_unique[pegawai.nip]',
                'errors' => [
                    'is_unique' => 'NIP sudah digunakan.',
                ],
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ],
            ],
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp'          => 'required',
            'perusahaan_id'  => 'required',
            'jabatan_id'     => 'required',
            'tanggal_masuk'  => 'required',
            'status'         => 'required',
            'alamat'         => 'required',
        ];
    }

    protected function updateRules(string $pegawaiId): array
    {
        return [
            'user_id' => [
                'rules'  => "required|is_unique[pegawai.user_id,id,{$pegawaiId}]",
                'errors' => [
                    'required'  => 'User wajib dipilih.',
                    'is_unique' => 'User sudah terdaftar sebagai pegawai.',
                ],
            ],
            'nip' => [
                'rules'  => "permit_empty|is_unique[pegawai.nip,id,{$pegawaiId}]",
                'errors' => [
                    'is_unique' => 'NIP sudah digunakan.',
                ],
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ],
            ],
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp'          => 'required',
            'perusahaan_id'  => 'required',
            'jabatan_id'     => 'required',
            'tanggal_masuk'  => 'required',
            'status'         => 'required',
            'alamat'         => 'required',
        ];
    }
}
