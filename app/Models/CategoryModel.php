<?php

namespace App\Models;

class CategoryModel extends BaseModel
{
    protected $table            = 'categories';
    
    protected $allowedFields = [
        'category_name',
        'category_slug',
    ];

    // Aktifkan event model
    protected $beforeInsert = ['setUUID', 'generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        // tidak ada category_name → lewati
        if (!isset($data['data']['category_name'])) {
            return $data;
        }

        // ========================
        // INSERT
        // ========================
        if (empty($data['id'])) {
            $slug = $this->slugify($data['data']['category_name']);
            $data['data']['category_slug'] = $this->uniqueSlug($slug);
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

        // category_name tidak berubah → jangan update slug
        if ($oldData['category_name'] === $data['data']['category_name']) {
            return $data;
        }

        // category_name berubah → update slug
        $slug = $this->slugify($data['data']['category_name']);
        $data['data']['category_slug'] = $this->uniqueSlug($slug, $id);

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
            $builder = $this->where('category_slug', $slug);

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
    /* =========================
     * JOIN UNTUK LIST
     * ========================= */
    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table);

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('category_name', $request['search']['value'])
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);

        $builder->limit($request['length'], $request['start']);

        return [
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $builder->get()->getResultArray(),
        ];
    }


    public function getCategoryCounts()
    {
        // Menghitung jumlah berita per kategori (Sesuai tampilan sidebar)
        return $this->db->table('categories')
                    ->select('categories.*, COUNT(news.id) as total')
                    ->join('news', 'news.category_id = categories.id', 'left')
                    ->groupBy('categories.id')
                    ->get()->getResult();
    }
}
