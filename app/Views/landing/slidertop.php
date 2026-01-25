<div class="py-5 py-lg-10" data-aos="fade-up">
    <div id="landingHeroSlider" class="container carousel slide custom-slider-container" data-bs-ride="carousel">
        <div class="carousel-inner shadow-lg" style="border-radius: 20px; overflow: hidden;">

            <div class="carousel-item active">
                <div class="position-relative">
                    <img src="<?= base_url('uploads/slider/landing.png') ?>"
                        class="d-block w-100 img-fluid"
                        alt="Slider 1"
                        style="height: auto;">

                    <div class="carousel-caption d-none d-md-flex flex-column justify-content-center align-items-start text-start px-15">
                        <a href="<?= base_url('register') ?>" class="btn btn-success fw-bold px-10 py-3">Daftar Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="<?= base_url('uploads/slider/landing.png') ?>" class="d-block w-100 img-fluid" alt="Slider 2">
            </div>

        </div>

        <div class="carousel-indicators mb-5">
            <button type="button" data-bs-target="#landingHeroSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#landingHeroSlider" data-bs-slide-to="1"></button>
        </div>
    </div>
</div>