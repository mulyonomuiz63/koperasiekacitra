<?php

namespace App\Models;


class MenuModel extends BaseModel
{
    protected $table      = 'menus';

    protected $allowedFields = [
        'name',
        'slug',
        'url',
        'icon',
        'parent_id',
        'menu_order',
        'is_active',
    ];

    // Aktifkan event model
    protected $beforeInsert = ['setUUID', 'normalizeParent', 'generateSlug'];
    protected $beforeUpdate = ['normalizeParent'];

    /* =======================
     *  PUBLIC METHODS
     * ======================= */
    public function getMenuByUser($userId, $roleId)
    {
        $db = db_connect();

        return $db->query("
            SELECT DISTINCT m.*
            FROM menus m
            LEFT JOIN role_permissions rp 
                ON rp.menu_id = m.id 
                AND rp.role_id = ?
            LEFT JOIN user_permissions up 
                ON up.menu_id = m.id 
                AND up.user_id = ?
            WHERE m.is_active = 1
            AND (
                (up.can_view = 1)
                OR (up.id IS NULL AND rp.can_view = 1)
            )
            ORDER BY m.parent_id ASC, m.`menu_order` ASC
        ", [$roleId, $userId])->getResultArray();
    }

    /* =======================
     *  MODEL EVENTS
     * ======================= */

    protected function generateSlug(array $data)
    {
        // tidak ada name → lewati
        if (!isset($data['data']['name'])) {
            return $data;
        }

        // ========================
        // INSERT
        // ========================
        if (empty($data['id'])) {
            $slug = $this->slugify($data['data']['name']);
            $data['data']['slug'] = $this->uniqueSlug($slug);
            return $data;
        }

        // ========================
        // UPDATE
        // ========================
        $id = is_array($data['id'])
            ? $data['id'][0]   // batch update
            : $data['id'];     // single update (UUID)

        $oldData = $this->find($id);

        if (!$oldData) {
            return $data;
        }

        // name tidak berubah → jangan update slug
        if ($oldData['name'] === $data['data']['name']) {
            return $data;
        }

        // name berubah → update slug
        $slug = $this->slugify($data['data']['name']);
        $data['data']['slug'] = $this->uniqueSlug($slug, $id);

        return $data;
    }


    /* =======================
     *  HELPER METHODS
     * ======================= */

    protected function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }

    protected function uniqueSlug(string $slug, ?string $ignoreId = null): string
    {
        $baseSlug = $slug;
        $i = 1;

        while (true) {
            $builder = $this->where('slug', $slug);

            if ($ignoreId !== null) {
                $builder->where('id !=', $ignoreId);
            }

            if ($builder->countAllResults() === 0) {
                return $slug;
            }

            $slug = $baseSlug . '-' . $i;
            $i++;
        }
    }


    protected function normalizeParent(array $data)
    {
        // jika parent_id tidak dikirim
        if (! array_key_exists('parent_id', $data['data'])) {
            $data['data']['parent_id'] = null;
            return $data;
        }

        // jika kosong, 0, atau '0'
        if (
            $data['data']['parent_id'] === '' ||
            $data['data']['parent_id'] === 0 ||
            $data['data']['parent_id'] === '0'
        ) {
            $data['data']['parent_id'] = null;
        }

        return $data;
    }


    /* ======================
     * DATATABLE SERVER SIDE
     * ====================== */

    public function getDatatable($request)
    {
        $builder = $this->db->table('menus m');

        // HANYA PARENT
        $builder->where('m.parent_id', null);

        /* SEARCH */
        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $builder->like('m.name', $search);
        }

        /* TOTAL FILTERED */
        $filteredBuilder = clone $builder;
        $recordsFiltered = $filteredBuilder->countAllResults(false);

        /* HAS CHILD */
        $builder->select("
            m.*,
            EXISTS (
                SELECT 1 FROM menus c WHERE c.parent_id = m.id
            ) AS has_child
        ");

        $builder->orderBy('m.menu_order', 'ASC');

        if ($request['length'] != -1) {
            $builder->limit($request['length'], $request['start']);
        }

        return [
            'data'            => $builder->get()->getResultArray(),
            'recordsTotal'    => $this->where('parent_id', null)->countAllResults(),
            'recordsFiltered' => $recordsFiltered
        ];
    }





}
