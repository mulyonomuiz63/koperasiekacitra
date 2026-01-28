<?php

namespace App\Controllers\LandingPage;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Models\NewsModel;
use App\Models\PegawaiModel;
use App\Models\SliderModel;
use App\Models\TagModel;

class LandingPageController extends BaseController
{
    protected $newsModel;
    protected $tagModel;
    protected $galeriModel;
    protected $sliderModel;
    protected $pegawaiModel;
    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->tagModel = new TagModel();
        $this->galeriModel = new GaleriModel();
        $this->sliderModel = new SliderModel();
        $this->pegawaiModel = new PegawaiModel();
    }
    public function index()
    {

        // Mengambil 15 berita terbaru dengan join kategori
        $data['latest_news'] = $this->newsModel->select('news.*, categories.category_name')
            ->join('categories', 'categories.id = news.category_id')
            ->orderBy('news.created_at', 'DESC')
            ->limit(15)
            ->findAll();

        $data['sliders'] = $this->sliderModel->select('title, filename')->where('jenis_slider','top')->where('status','A')->findAll();
        $data['galeri'] = $this->galeriModel->select('title, filename, jenis_galeri')->where('status','A')->findAll();
        $data['pegawai'] = $this->pegawaiModel
            ->select('pegawai.nama as nama_lengkap, jabatan.nama_jabatan')
            ->join('jabatan', 'jabatan.id=pegawai.jabatan_id')
            ->where('pegawai.status','A')
            ->findAll();
        return view('landing/index', $data);
    }
    

    public function detail($slug)
    {
        $newsModel = new NewsModel();
        $db = \Config\Database::connect();

        // 1. Ambil data berita utama beserta kategori
        $news = $newsModel->select('news.*, categories.category_name')
            ->join('categories', 'categories.id = news.category_id')
            ->where('news.slug', $slug)
            ->first();

        // Jika berita tidak ditemukan
        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan.");
        }

        // 2. Update Jumlah Baca (Views) +1
        $newsModel->update($news['id'], [
            'views' => $news['views'] + 1
        ]);

        // 3. Ambil data untuk Sidebar: Kategori & Jumlah Postingan
        // Query ini menghitung berapa banyak berita di setiap kategori
        $categories = $db->table('categories')
            ->select('categories.category_name, categories.category_slug, COUNT(news.id) as total')
            ->join('news', 'news.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->get()->getResult();

        // 4. Ambil data untuk Sidebar: Postingan Populer (Berdasarkan Views Terbanyak)
        $popular_posts = $newsModel->orderBy('views', 'DESC')
            ->limit(5)
            ->findAll();

        // 5. Ambil data untuk Sidebar: Tag Terpopuler (Berdasarkan pemakaian di news_tags)
        $popular_tags = $db->table('tags')
            ->select('tags.tag_name, tags.tag_slug')
            ->join('news_tags', 'news_tags.tag_id = tags.id')
            ->selectCount('news_tags.tag_id', 'count')
            ->groupBy('tags.id')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->get()->getResult();

        // Update View Count (Opsional tapi disarankan)
        $newsModel->update($news['id'], ['views' => $news['views'] + 1]);

        // AMBIL TAG KHUSUS BERITA INI
        $news_tags = $db->table('news_tags')
            ->select('tags.tag_name, tags.tag_slug')
            ->join('tags', 'tags.id = news_tags.tag_id')
            ->where('news_tags.news_id', $news['id'])
            ->get()->getResult();

        $news = $newsModel->where('slug', $slug)->first();

    
        $data = [
            'title'         => $news['title'],
            'news'          => $news,
            'news_tags'     => $news_tags,
            'categories'    => $categories,
            'popular_posts' => $popular_posts,
            'popular_tags'  => $popular_tags,
            'news_detail'   => $news
        ];

        return view('landing/detail', $data);
    }

    public function categoryTag()
{
    $newsModel = new \App\Models\NewsModel();
    $db = \Config\Database::connect();

    // Ambil semua parameter dari URL
    $categoryFilter = $this->request->getVar('category'); // slug kategori
    $tagFilter      = $this->request->getVar('tag');      // slug tag
    $keyword        = $this->request->getVar('search');   // keyword pencarian

    $builder = $newsModel->select('news.*, categories.category_name, categories.category_slug')
                         ->join('categories', 'categories.id = news.category_id');

    // --- LOGIKA FILTER ---
    
    // 1. Filter Kategori
    if ($categoryFilter) {
        $builder->where('categories.category_slug', $categoryFilter);
        $data = [
            'category_name'  => $categoryFilter, // Kirim nama tag
        ];
    }

    // 2. Filter Tag (Join ke tabel news_tags)
    if ($tagFilter) {
        $builder->join('news_tags', 'news_tags.news_id = news.id')
                ->join('tags', 'tags.id = news_tags.tag_id')
                ->where('tags.tag_slug', $tagFilter);

        $tagData = $this->tagModel->where('tag_slug', $tagFilter)->first();
        $data = [
            'tag_name'  => $tagData ? $tagData['tag_name'] : ucfirst($tagFilter), // Kirim nama tag
        ];
    }

    // 3. Fitur Pencarian
    if ($keyword) {
        $builder->groupStart()
                ->like('news.title', $keyword)
                ->orLike('news.content', $keyword)
                ->groupEnd();
    }

    $data_news = $builder->orderBy('news.created_at', 'DESC')
                         ->paginate(10, 'news_group');

    // --- DATA SIDEBAR ---

    $categories = $db->table('categories')
        ->select('categories.category_name, categories.category_slug, COUNT(news.id) as total')
        ->join('news', 'news.category_id = categories.id', 'left')
        ->groupBy('categories.id')
        ->get()->getResult();

    $popular_posts = $newsModel->orderBy('views', 'DESC')->limit(5)->findAll();

    $popular_tags = $db->table('tags')
        ->select('tags.tag_name, tags.tag_slug')
        ->join('news_tags', 'news_tags.tag_id = tags.id')
        ->selectCount('news_tags.tag_id', 'count')
        ->groupBy('tags.id')
        ->orderBy('count', 'DESC')
        ->limit(10)
        ->get()->getResult();

    // Menentukan Label Judul Halaman
    $pageTitle = 'Berita Terbaru';
    if ($categoryFilter) {
        $pageTitle = 'Kategori: ' . ($categoryFilter); // Bisa di-query lagi untuk ambil nama asli
    } elseif ($tagFilter) {
        $pageTitle = 'Tag: ' . ($tagFilter);
    } elseif ($keyword) {
        $pageTitle = 'Cari: ' . $keyword;
    }

    $data = [
        'title'         => $pageTitle,
        'latest_news'   => $data_news,
        'pager'         => $newsModel->pager,
        'categories'    => $categories,
        'keyword'       => $keyword,
        'current_cat'   => $categoryFilter,
        'current_tag'   => $tagFilter,
        'popular_posts' => $popular_posts,
        'popular_tags'  => $popular_tags
    ];

    return view('landing/kategoritag', $data);
}
}
