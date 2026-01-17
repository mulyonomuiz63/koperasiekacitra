<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Koperasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1d976c, #93f9b9);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 15px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card login-card shadow">
                <div class="card-body p-4">

                    <h4 class="text-center mb-3">
                        🔐 Login Koperasi
                    </h4>

                    <p class="text-center text-muted mb-4">
                        Silakan login untuk melanjutkan
                    </p>

                    <!-- ALERT -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <!-- FORM LOGIN -->
                    <form action="<?= base_url('/login') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="email@koperasi.com"
                                required
                                autofocus
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="********"
                                required
                            >
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-success">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small>
                            <a href="<?= base_url('/forgot-password') ?>" class="text-decoration-none">
                                Lupa password?
                            </a>
                        </small>
                    </div>

                </div>
            </div>

            <p class="text-center text-white mt-3 small">
                © <?= date('Y') ?> Sistem Koperasi
            </p>

        </div>
    </div>
</div>

</body>
</html>
