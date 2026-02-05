<style>
    /* 1. Base Wrapper & Background */
    .org-main-wrapper {
        min-height: 850px;
        background-color: #000b1e;
        position: relative;
        overflow: hidden;
    }

    .org-bg-image {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
        filter: brightness(0.3) contrast(1.2);
        transform: scale(1.05);
        z-index: 1;
        transition: transform 0.5s ease;
    }

    .org-bg-gradient {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at center, rgba(0, 158, 247, 0.2) 0%, rgba(0, 11, 30, 0.95) 85%);
        z-index: 1;
    }

    /* 2. Particle System */
    .org-particles span {
        position: absolute;
        width: 3px; height: 3px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        z-index: 1;
        animation: floatParticles 15s infinite linear;
    }

    @keyframes floatParticles {
        0% { transform: translateY(0); opacity: 0; }
        50% { opacity: 0.8; }
        100% { transform: translateY(-100vh); opacity: 0; }
    }

    /* 3. Typography & Glow */
    .text-glow {
        text-shadow: 0 0 15px rgba(0, 158, 247, 0.8);
        letter-spacing: 3px;
    }

    .line-glow {
        height: 2px; width: 80px;
        background: linear-gradient(to right, transparent, #ffc700, transparent);
        box-shadow: 0 0 15px #ffc700;
    }

    /* 4. Node & Line Styles */
    .org-node {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 5;
    }

    .node-glass {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 158, 247, 0.4);
        box-shadow: inset 0 0 15px rgba(255, 255, 255, 0.05);
        padding: 12px 25px;
        border-radius: 50px;
    }

    .org-node:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 158, 247, 0.4);
    }

    /* Garis Hidup (Animated Flow) */
    .main-line {
        width: 3px; height: 60px;
        background: rgba(255, 255, 255, 0.15);
        position: relative;
        overflow: hidden;
    }

    .main-line::after {
        content: "";
        position: absolute;
        top: -100%; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, transparent, #009ef7, #ffc700, transparent);
        animation: flowEffect 2s infinite linear;
    }

    @keyframes flowEffect {
        0% { top: -100%; }
        100% { top: 100%; }
    }

    /* 5. Layout Per-Level */
    .pengurus-container {
        display: flex; gap: 40px;
        border-top: 3px solid rgba(0, 158, 247, 0.3);
        padding-top: 30px;
        position: relative;
    }

    .sidebar-pengawas {
        border-left: 3px dashed rgba(255, 199, 0, 0.4);
        padding-left: 35px;
        margin-top: -30px; /* Posisi lebih tinggi */
    }

    .node-label-custom {
        background: #ffc700;
        color: #000;
        font-weight: 800;
        border-radius: 20px;
        padding: 2px 15px;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    /* Responsivitas */
    @media (max-width: 991.98px) {
        .pengurus-container { flex-direction: column; border-top: none; align-items: center; }
        .sidebar-pengawas { border-left: none; border-top: 3px dashed #ffc700; margin-top: 50px; padding-left: 0; padding-top: 30px; width: 100%; }
        .org-main-wrapper { min-height: auto; }
    }
</style>

<div class="card org-main-wrapper border-0 shadow-lg" id="struktur-organisasi"  data-aos="fade-up">
    <div class="org-bg-image" id="parallax-bg"></div>
    <div class="org-bg-gradient"></div>
    
    <div class="org-particles">
        <span style="top:20%; left:10%"></span>
        <span style="top:50%; left:85%"></span>
        <span style="top:80%; left:15%"></span>
        <span style="top:30%; left:70%"></span>
        <span style="top:70%; left:40%"></span>
    </div>

    <div class="card-body p-10 position-relative z-index-2">
        <div class="text-center mb-15">
            <h1 class="text-white fw-bolder fs-2qx mb-2 text-glow animate__animated animate__fadeInDown">STRUKTUR ORGANISASI</h1>
            <div class="d-flex justify-content-center align-items-center animate__animated animate__fadeInUp">
                <span class="line-glow"></span>
                <p class="text-white opacity-75 fw-bold fs-4 mx-4 mb-0">KOPERASI KONSUMEN EKA CITRA MANDIRI</p>
                <span class="line-glow"></span>
            </div>
        </div>

        <div class="row g-10 justify-content-center">
            <div class="col-lg-8 d-flex flex-column align-items-center">
                
                <div class="org-node animate__animated animate__zoomIn" data-aos="fade-up">
                    <div class="node-glass d-flex align-items-center">
                        <div class="symbol symbol-80px symbol-circle border border-4 border-info shadow">
                            <?= img_lazy('uploads/pengurus/ketua.jpeg', 'Ketua') ?>
                        </div>
                        <div class="ms-5">
                            <div class="text-white fw-bold fs-4">Rismando Surya</div>
                            <div class="node-label-custom mt-1">Ketua</div>
                        </div>
                    </div>
                </div>

                <div class="main-line my-5"></div>

                <div class="pengurus-container">
                    <div class="org-node animate__animated animate__fadeInLeft" style="animation-delay: 0.3s" data-aos="fade-up">
                        <div class="node-glass d-flex align-items-center">
                            <div class="symbol symbol-60px symbol-circle border border-2 border-white shadow">
                                <?= img_lazy('uploads/pengurus/bendahara.jpeg', 'Bendahara') ?>    
                            </div>
                            <div class="ms-4">
                                <div class="text-white fw-bold fs-7">Nidi Firas Huda</div>
                                <div class="badge badge-warning fw-bold rounded-pill mt-1">Bendahara</div>
                            </div>
                        </div>
                    </div>

                    <div class="org-node animate__animated animate__fadeInUp" style="animation-delay: 0.5s" data-aos="fade-up">
                        <div class="node-glass d-flex align-items-center">
                            <div class="symbol symbol-60px symbol-circle border border-2 border-white shadow">
                                <?= img_lazy('uploads/pengurus/sekretaris.jpeg', 'Sekretaris') ?>  
                            </div>
                            <div class="ms-4">
                                <div class="text-white fw-bold fs-7">Ikhwan Adiwira</div>
                                <div class="badge badge-warning fw-bold rounded-pill mt-1">Sekretaris</div>
                            </div>
                        </div>
                    </div>

                    <div class="org-node animate__animated animate__fadeInUp" style="animation-delay: 0.5s" data-aos="fade-up">
                        <div class="node-glass d-flex align-items-center">
                            <div class="symbol symbol-60px symbol-circle border border-2 border-white shadow">
                                <?= img_lazy('uploads/pengurus/koordinator.jpeg', 'Keanggotaan & Usaha') ?>  
                            </div>
                            <div class="ms-4">
                                <div class="text-white fw-bold fs-7">Wahyu Mardhiyan</div>
                                <div class="badge badge-warning fw-bold rounded-pill mt-1">Keanggotaan & Usaha</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-15 animate__animated animate__fadeInUp" style="animation-delay: 0.8s" data-aos="fade-up">
                    <div class="org-node bg-primary p-5 rounded-4 border border-4 border-white text-center shadow-lg" style="width:250px">
                         <div class="fw-bolder fs-3 text-white mb-1">ANGGOTA</div>
                         <div class="bg-warning text-dark fw-bold rounded-pill px-5">KOP. ECM</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="sidebar-pengawas">
                    <div class="d-flex align-items-center mb-7 animate__animated animate__fadeInRight">
                        <span class="bullet bullet-vertical h-40px bg-warning me-5"></span>
                        <h3 class="text-white fw-bolder m-0">DEWAN PENGAWAS</h3>
                    </div>

                    <div class="d-flex flex-column gap-5">
                        <?php 
                        $pengawas = [
                            ['nama' => 'Elia Fitria', 'img' => '300-6.jpg'],
                            ['nama' => 'Endang Dwi Suparmiati', 'img' => '300-12.jpg'],
                            ['nama' => 'Pandit Hidayat', 'img' => '300-11.jpg'],
                            ['nama' => 'Ade Sumaryadi', 'img' => '300-13.jpg'],
                            ['nama' => 'Rahman Mukhlis', 'img' => '300-15.jpg'],
                        ]; 
                        ?>
                        <?php foreach($pengawas as $idx => $p): ?>
                        <div class="org-node node-glass d-flex align-items-center p-3 animate__animated animate__fadeInRight" style="animation-delay: <?= 0.1 * ($idx+1) ?>s" data-aos="fade-up">
                            <div class="symbol symbol-45px symbol-circle border border-2 border-info me-4">
                                <img src="https://preview.keenthemes.com/metronic8/demo1/assets/media/avatars/<?= $p['img'] ?>" alt="Avatar">
                            </div>
                            <div>
                                <div class="text-white fw-bold fs-14"><?= $p['nama'] ?></div>
                                <div class="text-warning fw-semibold fs-16">Pengawas</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('mousemove', function(e) {
        const bg = document.getElementById('parallax-bg');
        const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
        const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
        
        // Menggerakkan background sedikit berlawanan arah mouse
        bg.style.transform = `scale(1.1) translate(${moveX}px, ${moveY}px)`;
    });
</script>