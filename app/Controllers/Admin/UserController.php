<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->menuId = $this->setMenu('users');
    }

    public function index()
    {
        $this->setMenu('users');
        return $this->view('admin/users/index');
    }
    public function datatable()
    {
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(403);
        }


        $request = $this->request->getPost();
        $result  = $this->userModel->getDatatable($request);

        $data = [];

        foreach ($result['data'] as $row) {

            $data[] = [
                'id'         => $row['id'],
                'username'   => $row['username'],
                'email'      => $row['email'],
                'role_name'  => $row['role_name'],
                'status'     => $row['status'],

                // 🔐 PERMISSION (INTI)
                'can_edit'   => can($this->menuId, 'update'),
                'can_delete' => can($this->menuId, 'delete'),
            ];
        }


        return $this->response->setJSON([
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $result['recordsTotal'],
            'recordsFiltered' => $result['recordsFiltered'],
            'data'            => $data,
        ]);
    }
    public function create()
    {
        return view('admin/users/create', [
            'roles' => db_connect()->table('roles')->get()->getResult()
        ]);
    }

    public function store()
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
            'role_id' => 'required',
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
                    'required'   => 'Password wajib diisi',
                    'min_length' => 'Password minimal 5 karakter',
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

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role_id'  => $this->request->getPost('role_id'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan');
    }


    public function edit($id)
    {

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error','User tidak ditemukan');
        }

        return view('admin/users/edit', [
            'user'  => $user,
            'roles' => db_connect()->table('roles')->get()->getResult()
        ]);
    }

    public function update($id)
    {
        $rules = [
            // username readonly → boleh divalidasi atau dihapus sekalian
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

        // Password hanya divalidasi jika diisi
        if ($this->request->getPost('password')) {

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

        // 🔴 WAJIB VALIDASI
        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // ✅ DATA VALID → UPDATE
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role_id'  => $this->request->getPost('role_id'),
            'status'   => $this->request->getPost('status'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/users')
            ->with('success', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error','User tidak ditemukan');
        }

        $this->userModel->delete($id);

        return redirect()->to('/users')
            ->with('success','User berhasil dihapus');
    }


}
