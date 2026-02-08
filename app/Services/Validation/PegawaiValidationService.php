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
            'nik' => [
                // Gunakan 'required' jika NIK tidak boleh kosong
                'rules'  => 'required|numeric|exact_length[16]|is_unique[pegawai.nik]',
                'errors' => [
                    'required'     => 'NIK wajib diisi.',
                    'is_unique'    => 'NIK sudah digunakan.',
                    'numeric'      => 'NIK harus berupa angka.',
                    'exact_length' => 'NIK harus tepat 16 digit.',
                ],
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ],
            ],
            'no_hp' => [
                'rules'  => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required'   => 'Nomor HP wajib diisi.',
                    'numeric'    => 'Nomor HP harus berupa angka.',
                    'min_length' => 'Nomor HP minimal 10 digit.',
                    'max_length' => 'Nomor HP maksimal 15 digit.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih jenis kelamin.']
            ],
            'tanggal_lahir' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal lahir harus diisi.']
            ],
            'perusahaan_id' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih perusahaan.']
            ],
            'jabatan_id' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih jabatan.']
            ],
            'tanggal_masuk' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal daftar anggota harus diisi.']
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Status pegawai harus dipilih.']
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat lengkap wajib diisi.']
            ],
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
            'nik' => [
                'rules'  => "permit_empty|numeric|exact_length[16]|is_unique[pegawai.nik,id,{$pegawaiId}]",
                'errors' => [
                    'is_unique' => 'NIK sudah digunakan.',
                    'numeric'      => 'NIK harus berupa angka.',
                    'exact_length' => 'NIK harus tepat 16 digit.',
                ],
            ],
            'nama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.',
                ],
            ],
            'no_hp' => [
                'rules'  => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required'   => 'Nomor HP wajib diisi.',
                    'numeric'    => 'Nomor HP harus berupa angka.',
                    'min_length' => 'Nomor HP minimal 10 digit.',
                    'max_length' => 'Nomor HP maksimal 15 digit.'
                ]
            ],
            'jenis_kelamin' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih jenis kelamin.']
            ],
            'tanggal_lahir' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal lahir harus diisi.']
            ],
            'perusahaan_id' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih perusahaan.']
            ],
            'jabatan_id' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Silakan pilih jabatan.']
            ],
            'tanggal_masuk' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal daftar anggota harus diisi.']
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Status pegawai harus dipilih.']
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat lengkap wajib diisi.']
            ],
        ];
    }
}
