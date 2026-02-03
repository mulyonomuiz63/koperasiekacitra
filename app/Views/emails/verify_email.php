<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f4f7f9; -webkit-font-smoothing: antialiased;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="padding: 40px 40px 20px 40px; text-align: center;">
                            <h2 style="margin: 0; color: #181c32; font-size: 24px; font-weight: 700;">Verifikasi Akun Anda</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 40px 30px 40px; text-align: left; color: #3f4254; font-size: 16px; line-height: 1.6;">
                            <p>Halo,</p>
                            <p>Selamat bergabung di <strong>Koperasi Kami</strong>! Kami sangat senang Anda menjadi bagian dari komunitas kami. Satu langkah lagi untuk mulai menggunakan aplikasi ini.</p>
                            <p>Silakan tekan tombol di bawah ini untuk mengonfirmasi email Anda:</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 0 40px 30px 40px;">
                            <a href="<?= $link ?>" style="display: inline-block; padding: 15px 30px; background-color: #009ef7; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 11px rgba(0, 158, 247, 0.35);">
                                Aktifkan Akun Sekarang
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <p style="font-size: 13px; color: #a1a5b7; margin-bottom: 5px;">Jika tombol tidak berfungsi, salin tautan berikut:</p>
                            <p style="font-size: 12px; color: #009ef7; word-break: break-all; margin: 0;">
                                <a href="<?= $link ?>" style="color: #009ef7; text-decoration: none;"><?= $link ?></a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9f9f9; text-align: center; border-top: 1px solid #f1f1f2;">
                            <p style="margin: 0; font-size: 12px; color: #7e8299;">&copy; <?= setting('tahun_berdiri') ?> <?= setting('app_name') ?>. Seluruh hak cipta dilindungi.</p>
                            <p style="margin: 5px 0 0 0; font-size: 11px; color: #b5b5c3;">Ini adalah email otomatis, mohon tidak membalas email ini.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>