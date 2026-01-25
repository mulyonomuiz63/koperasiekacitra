<?php

if (!function_exists('get_pegawai')) {
    /**
     * Mengambil nama anggota berdasarkan ID
     * @param int $id
     * @return string
     */
    function get_pegawai($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pegawai')
        ->join('users', 'users.id=pegawai.user_id'); 
        
        // Ambil kolom 'nama' atau 'nama_pegawai'
        $user = $builder->select('pegawai.nama, pegawai.status') 
                    // Pastikan id mana yang dipakai, saya asumsikan users.id
                    ->where('users.id', $id) 
                    ->get()
                    ->getRow();

        // Kembalikan dalam bentuk ARRAY murni
        if (!$user) {
            return [
                'nama_anggota' => $id,
                'status'       => ''
            ];
        }

        return [
            'nama_anggota' => $user->nama,
            'status'       => ($user->status == 'A') ? 'Pro' : ''
        ];
    }
}