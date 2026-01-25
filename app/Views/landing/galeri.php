<?= $this->section('styles') ?>
<style>
    .marquee-wrapper {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .marquee-track {
        display: flex;
        width: max-content;
    }

    .marquee-item-group {
        display: flex;
        flex-shrink: 0;
    }

    .marquee-item {
        padding: 0 12px;
    }

    /* Animasi Ke Kiri (Atas) */
    .marquee-left {
        animation: scroll-to-left 50s linear infinite;
    }

    /* Animasi Ke Kanan (Bawah) */
    .marquee-right {
        animation: scroll-to-right 50s linear infinite;
    }

    /* Hover: Berhenti pelan-pelan */
    .marquee-track:hover {
        animation-play-state: paused;
    }

    /* Styling Gambar ala Metronic */
    .overlay-wrapper {
        border-radius: 12px;
        transition: transform 0.4s ease;
    }

    .overlay:hover .overlay-wrapper {
        transform: scale(1.04);
    }

    /* Logic Keyframes */
    @keyframes scroll-to-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-33.333%); }
    }

    @keyframes scroll-to-right {
        0% { transform: translateX(-33.333%); }
        100% { transform: translateX(0); }
    }

    /* Responsif Mobile */
    @media (max-width: 768px) {
        .overlay-wrapper {
            width: 240px !important;
            height: 160px !important;
        }
        .marquee-left, .marquee-right {
            animation-duration: 30s; /* Lebih cepat di mobile agar dinamis */
        }
    }
</style>
<?= $this->endSection() ?>
<div class="py-20 overflow-hidden" id="galeri" style="background-color: #004b55;">
    <div class="container-fluid px-0">
        <div class="text-center mb-15">
            <h2 class="text-white fw-bolder fs-2qx">Galeri Kegiatan</h2>
            <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: #ffffff; opacity: 0.5;"></div>
        </div>

        <div class="marquee-wrapper mb-10">
            <div class="marquee-track marquee-left">
                <?php for ($i = 0; $i < 3; $i++): // Triple Loop ?>
                <div class="marquee-item-group">
                    <?php foreach ($galeri as $rows): ?>
                        <?php if ($rows['jenis_galeri'] == 'atas'): ?>
                            <div class="marquee-item">
                                <a class="d-block overlay" data-fslightbox="lightbox-galeri" href="<?= base_url('uploads/galeri/' . $rows['filename']) ?>">
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded shadow" 
                                         style="background-image:url('<?= base_url('uploads/galeri/' . $rows['filename']) ?>'); width: 320px; height: 210px;">
                                    </div>
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                        <i class="ki-outline ki-eye fs-2x text-white"></i>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <div class="marquee-wrapper">
            <div class="marquee-track marquee-right">
                <?php for ($i = 0; $i < 3; $i++): // Triple Loop ?>
                <div class="marquee-item-group">
                    <?php foreach ($galeri as $rows): ?>
                        <?php if ($rows['jenis_galeri'] == 'bawah'): ?>
                            <div class="marquee-item">
                                <a class="d-block overlay" data-fslightbox="lightbox-galeri" href="<?= base_url('uploads/galeri/' . $rows['filename']) ?>">
                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded shadow" 
                                         style="background-image:url('<?= base_url('uploads/galeri/' . $rows['filename']) ?>'); width: 320px; height: 210px;">
                                    </div>
                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                        <i class="ki-outline ki-eye fs-2x text-white"></i>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>