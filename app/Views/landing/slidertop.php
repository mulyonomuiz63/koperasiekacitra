<?php if (!empty($sliders)): ?>
<div class="py-5 py-lg-10" data-aos="fade-up">
    <div id="landingHeroSlider" class="container carousel slide custom-slider-container" data-bs-ride="carousel">
        
        <div class="carousel-indicators mb-5">
            <?php foreach ($sliders as $key => $s) : ?>
                <button type="button" data-bs-target="#landingHeroSlider" data-bs-slide-to="<?= $key ?>" class="<?= $key === 0 ? 'active' : '' ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <?php foreach ($sliders as $key => $s) : ?>
                <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                    <div class="position-relative">
                        <?= img_lazy('uploads/slider/' . $s['filename'], $s['title'], ['class' => 'd-block w-100 img-fluid']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($sliders) > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#landingHeroSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#landingHeroSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        <?php endif; ?>

    </div>
</div>
<?php endif; ?>