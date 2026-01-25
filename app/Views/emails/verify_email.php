<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Akun</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h3 style="color: #009ef7;">Halo!</h3>
        <p>Terima kasih telah mendaftar di <strong>Koperasi Kami</strong>. Silakan klik tombol di bawah ini untuk mengaktifkan akun Anda:</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="<?= $link ?>" style="padding: 12px 25px; background: #009ef7; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                Verifikasi Email
            </a>
        </p>
        
        <p>Jika tombol di atas tidak berfungsi, silakan salin dan tempel tautan berikut ke browser Anda:</p>
        <p style="word-break: break-all; color: #009ef7;"><?= $link ?></p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888;">Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
    </div>
</body>
</html>