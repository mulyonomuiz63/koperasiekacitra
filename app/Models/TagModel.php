<?php

namespace App\Models;

class TagModel extends BaseModel
{
    protected $table            = 'tags';
    
    protected $allowedFields = [
        'tag_name',
        'tag_slug',
    ];


    public function getTagsByNews($news_id)
    {
        // Mengambil semua tag milik satu berita tertentu
        return $this->db->table('tags')
                    ->join('news_tags', 'news_tags.tag_id = tags.id')
                    ->where('news_tags.news_id', $news_id)
                    ->get()->getResult();
    }
}
