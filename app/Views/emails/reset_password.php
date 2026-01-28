<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Reset Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f4f7f9;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    
                    <tr>
                        <td style="padding: 40px 40px 20px 40px; text-align: center;">
                            <div style="background-color: #f1faff; width: 80px; height: 80px; line-height: 80px; border-radius: 50%; margin: 0 auto 20px auto;">
                                <img src="https://cdn-icons-png.flaticon.com/512/6195/6195699.png" alt="Lock Icon" style="width: 40px; vertical-align: middle;">
                            </div>
                            <h2 style="margin: 0; color: #181c32; font-size: 24px; font-weight: 700;">Lupa Password?</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 40px 30px 40px; text-align: center; color: #3f4254; font-size: 16px; line-height: 1.6;">
                            <p>Halo <strong><?= esc($name) ?></strong>,</p>
                            <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Jangan khawatir, hal ini biasa terjadi!</p>
                            <p>Klik tombol di bawah ini untuk melanjutkan:</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 0 40px 30px 40px;">
                            <a href="<?= $link ?>" style="display: inline-block; padding: 15px 30px; background-color: #f1416c; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 11px rgba(241, 65, 108, 0.35);">
                                Atur Ulang Password
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <div style="background-color: #fff8f1; border: 1px dashed #ffc700; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                                <p style="font-size: 13px; color: #d97706; margin: 0;">
                                    <strong>Penting:</strong> Tautan ini hanya berlaku selama <strong>15 menit</strong> demi keamanan akun Anda.
                                </p>
                            </div>
                            <p style="font-size: 12px; color: #a1a5b7; margin: 0;">
                                Jika Anda tidak meminta reset password, abaikan email ini atau hubungi tim dukungan kami jika Anda merasa ada aktivitas mencurigakan.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px 40px; background-color: #f9f9f9; text-align: center; border-top: 1px solid #f1f1f2;">
                            <p style="margin: 0; font-size: 12px; color: #7e8299;">&copy; <?= setting('tahun_berdiri') ?>  <?= setting('app_name') ?>.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>