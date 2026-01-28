<?php

/**
 * Fungsi utama untuk render meta tags
 */
function render_meta($title = '', $description = '', $image = '', $keywords = '')
{
    $description = generate_desc_seo($description);
    
    $siteName   = setting('app_name') ?? '-';
    $type       = 'website';
    $finalTitle = ($title) ? $title . " | " . $siteName : $siteName;
    
    $finalDesc  = ($description) ?: (setting('site_description') ?? '-');
    $finalImg   = ($image) ? $image : base_url('uploads/app-icon/' . (setting('logo_perusahaan') ?? 'default.png'));
    $currentUrl = current_url();
    $finalKeywords = $keywords ?: (setting('site_keywords') ?? 'berita');

    $html = "\n";
    // <base href> DIHAPUS agar tidak merusak link aset CSS/JS
    $html .= "    <title>{$finalTitle}</title>\n";
    $html .= "    <meta name=\"description\" content=\"{$finalDesc}\" />\n";
    $html .= "    <meta name=\"keywords\" content=\"{$finalKeywords}\" />\n";
    $html .= "    <link rel=\"canonical\" href=\"{$currentUrl}\" />\n";
    
    $html .= "    <meta property=\"og:locale\" content=\"id_ID\" />\n";
    $html .= "    <meta property=\"og:type\" content=\"{$type}\" />\n";
    $html .= "    <meta property=\"og:title\" content=\"{$finalTitle}\" />\n";
    $html .= "    <meta property=\"og:description\" content=\"{$finalDesc}\" />\n";
    $html .= "    <meta property=\"og:url\" content=\"{$currentUrl}\" />\n";
    $html .= "    <meta property=\"og:site_name\" content=\"{$siteName}\" />\n";
    $html .= "    <meta property=\"og:image\" content=\"{$finalImg}\" />\n";
    $html .= "    <meta property=\"og:image:width\" content=\"1200\" />\n"; // Standar resolusi tinggi
    $html .= "    <meta property=\"og:image:height\" content=\"630\" />\n";
    
    $html .= "    <meta name=\"twitter:card\" content=\"summary_large_image\" />\n";
    $html .= "    <meta name=\"twitter:title\" content=\"{$finalTitle}\" />\n";
    $html .= "    <meta name=\"twitter:description\" content=\"{$finalDesc}\" />\n";
    $html .= "    <meta name=\"twitter:image\" content=\"{$finalImg}\" />\n";

    return $html;
}

function render_schema_news($news)
{
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "News & Blog",
        "headline" => $news['title'],
        "image" => [base_url('uploads/news/' . $news['image'])],
        "datePublished" => date('c', strtotime($news['created_at'])),
        "dateModified" => date('c', strtotime($news['updated_at'])),
        "author" => [
            "@type" => "Person",
            "name" => $news['author'] // Atau ambil dari database
        ]
    ];

    return "\n    <script type=\"application/ld+json\">" . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "</script>\n";
}

/**
 * Fungsi pendukung (Hilangkan 'private')
 * Nama diganti sedikit agar tidak bentrok dengan fungsi bawaan lain
 */
function generate_desc_seo($content)
{
    if (empty($content)) return '';

    // 1. Buang tag HTML
    $cleanContent = strip_tags($content);
    
    // 2. Bersihkan karakter aneh, spasi berlebih, dan entitas HTML
    $cleanContent = html_entity_decode($cleanContent);
    $cleanContent = str_replace(["\r", "\n", "\t"], ' ', $cleanContent);
    $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
    
    // 3. Potong 160 karakter
    if (mb_strlen($cleanContent) > 160) {
        $cleanContent = mb_substr($cleanContent, 0, 157) . '...';
    }
    
    return trim($cleanContent);
}


/**
 * Lazy Image Helper
 * Menghasilkan tag img dengan loading native dan placeholder
 */
function img_lazy(string $src, string $alt = '', array $attrs = []): string
{
    $filePath = FCPATH . ltrim($src, '/');

        $width = $attrs['width'] ?? null;
        $height = $attrs['height'] ?? null;

        // deteksi ukuran asli jika ada di server
        if (file_exists($filePath) && (empty($width) || empty($height))) {
            $size = @getimagesize($filePath);
            if ($size) {
                $width = $width ?? $size[0];
                $height = $height ?? $size[1];
            }
        }

        // fallback jika ukuran tidak ketemu
        $width = $width ?: 200;
        $height = $height ?: 150;

        // placeholder shimmer animasi (SVG)
        $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode('
            <svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" preserveAspectRatio="none">
              <rect width="100%" height="100%" fill="#eeeeee"/>
              <rect width="100%" height="100%" fill="url(#g)">
                <animate attributeName="x" from="-'.$width.'" to="'.$width.'" dur="1.2s" repeatCount="indefinite" />
              </rect>
              <defs>
                <linearGradient id="g">
                  <stop stop-color="#eeeeee" offset="20%" />
                  <stop stop-color="#dddddd" offset="50%" />
                  <stop stop-color="#eeeeee" offset="70%" />
                </linearGradient>
              </defs>
            </svg>');
            
    $default = [
        'src'      => $placeholder, // placeholder
        'data-src' => base_url($src),
        'alt'      => $alt,
        'class'    => 'lazy',
        'loading'  => 'lazy'
    ];

    // jika user kasih class tambahan → gabungkan dengan default
    if (isset($attrs['class'])) {
        $attrs['class'] = $default['class'] . ' ' . $attrs['class'];
        unset($default['class']);
    }

    $allAttrs = array_merge($default, $attrs);

    $attrString = '';
    foreach ($allAttrs as $key => $val) {
        $attrString .= ' ' . htmlspecialchars($key) . '="' . htmlspecialchars($val) . '"';
    }

    return '<img' . $attrString . '>';
}