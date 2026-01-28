<?php 
namespace App\Models;


class NewsModel extends BaseModel
{
    protected $table      = 'news';
    protected $allowedFields = ['category_id', 'title', 'slug', 'keyword', 'content', 'image', 'author', 'views', 'status'];

    // Aktifkan event model
    protected $beforeInsert = ['setUUID', 'generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        // tidak ada title → lewati
        if (!isset($data['data']['title'])) {
            return $data;
        }

        // ========================
        // INSERT
        // ========================
        if (empty($data['id'])) {
            $slug = $this->slugify($data['data']['title']);
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

        // title tidak berubah → jangan update slug
        if ($oldData['title'] === $data['data']['title']) {
            return $data;
        }

        // title berubah → update slug
        $slug = $this->slugify($data['data']['title']);
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

    public function getDatatable($request)
    {
        $builder = $this->db->table($this->table);

        // Search
        if ($request['search']['value']) {
            $builder->groupStart()
                ->like('title', $request['search']['value'])
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
    // Ambil berita dengan join kategori (Untuk Daftar & Detail Berita)
    public function getNewsWithCategory($slug = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('news.*, categories.title, categories.slug');
        $builder->join('categories', 'categories.id = news.category_id');
        $builder->where('news.status', 'publish');

        if ($slug === false) {
            return $builder->orderBy('news.created_at', 'DESC'); 
            // Return builder untuk pagination CI4: $model->getNewsWithCategory()->paginate(10)
        }

        return $builder->where('news.slug', $slug)->get()->getRow();
    }

    // Ambil Berita Berdasarkan Kategori
    public function getByCategory($slug)
    {
        return $this->select('news.*, categories.title')
                    ->join('categories', 'categories.id = news.category_id')
                    ->where('categories.slug', $slug)
                    ->where('news.status', 'publish');
    }

    // Ambil Berita Berdasarkan Tag
    public function getByTag($tag_slug)
    {
        return $this->select('news.*, categories.title')
                    ->join('news_tags', 'news_tags.news_id = news.id')
                    ->join('tags', 'tags.id = news_tags.tag_id')
                    ->join('categories', 'categories.id = news.category_id')
                    ->where('tags.tag_slug', $tag_slug)
                    ->where('news.status', 'publish');
    }

    // Update Jumlah Baca (Views)
    public function incrementView($id)
    {
        return $this->where('id', $id)->set('views', 'views+1', FALSE)->update();
    }
}