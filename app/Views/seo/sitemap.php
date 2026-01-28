<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <?php foreach($manualPages as $page): ?>
    <url>
        <loc><?= $page['url'] ?></loc>
        <priority><?= $page['priority'] ?></priority>
        <changefreq><?= $page['freq'] ?></changefreq>
    </url>
    <?php endforeach; ?>

    <?php foreach($news as $n): ?>
    <url>
        <loc><?= base_url('blog/read/' . $n['slug']) ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($n['updated_at'] ?? $n['created_at'])) ?></lastmod>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <?php foreach($categories as $cat): ?>
    <url>
        <loc><?= base_url('blog?category=' . $cat['category_slug']) ?></loc>
        <priority>0.7</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>

    <?php foreach($tags as $t): ?>
    <url>
        <loc><?= base_url('blog?tag=' . $t['tag_slug']) ?></loc>
        <priority>0.5</priority>
        <changefreq>weekly</changefreq>
    </url>
    <?php endforeach; ?>

</urlset>