<?php

namespace App\Services\Validation;

use CodeIgniter\Validation\Validation;

class UserValidation
{
    protected Validation $validation;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    /* =====================================================
     * VALIDASI CREATE USER
     * ===================================================== */
    public function validateCreate(array $data): bool
    {
        $rules = [
            'username' => [
                'rules'  => 'required|min_length[3]|is_unique[users.username]',
                'errors' => [
                    'required'  => 'Username wajib diisi',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique'   => 'Email sudah digunakan'
                ]
            ],
            'role_id' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Role wajib dipilih'
                ]
            ],
            'password' => [
                'rules' => [
                    'required',
                    'min_length[5]',
                    'regex_match[/[a-z]/]',
                    'regex_match[/[A-Z]/]',
                    'regex_match[/[0-9]/]',
                    'regex_match[/[^a-zA-Z0-9]/]'
                ],
                'errors' => [
                    'required'    => 'Password wajib diisi',
                    'min_length'  => 'Password minimal 5 karakter',
                    'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus'
                ]
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak sama'
                ]
            ],
        ];

        return $this->validation->setRules($rules)->run($data);
    }

    /* =====================================================
     * VALIDASI UPDATE USER
     * ===================================================== */
    public function validateUpdate(array $data, string $id): bool
    {
        $rules = [
            'username' => [
                'rules'  => "required|min_length[3]|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'is_unique'  => 'Username sudah digunakan.'
                ]
            ],
            'email' => [
                'rules'  => "required|valid_email|is_unique[users.email,id,{$id}]",
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar dan tidak bisa digunakan.'
                ]
            ],
            'role_id' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Role wajib dipilih.'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status wajib dipilih.'
                ]
            ],
        ];

        if (!empty($data['password'])) {

            $rules['password'] = [
                'rules' => [
                    'min_length[5]',
                    'regex_match[/[a-z]/]',
                    'regex_match[/[A-Z]/]',
                    'regex_match[/[0-9]/]',
                    'regex_match[/[^a-zA-Z0-9]/]'
                ],
                'errors' => [
                    'min_length'  => 'Password minimal 5 karakter.',
                    'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.'
                ]
            ];

            $rules['password_confirm'] = [
                'rules'  => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak sama.'
                ]
            ];
        }

        return $this->validation->setRules($rules)->run($data);
    }

    public function getErrors(): array
    {
        return $this->validation->getErrors();
    }
}
