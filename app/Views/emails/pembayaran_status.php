<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.5; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 8px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #f5f5f5; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: bold; color: white; text-transform: uppercase; font-size: 12px; }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .invoice-details { margin-top: 20px; width: 100%; border-collapse: collapse; }
        .invoice-details td { padding: 8px 0; border-bottom: 1px solid #f9f9f9; }
        .label { color: #888; width: 40%; }
        .footer { margin-top: 30px; font-size: 12px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><?= setting('app_name') ?></h2>
            <div class="status-badge <?= $status == 'A' ? 'bg-success' : 'bg-danger' ?>">
                <?= $status == 'A' ? 'Pembayaran Disetujui' : 'Pembayaran Ditolak' ?>
            </div>
        </div>

        <table class="invoice-details">
            <tr>
                <td class="label">Jenis Pembayaran</td>
                <td><strong><?= $tipe ?? 'Iuran Anggota' ?></strong></td>
            </tr>
            <tr>
                <td class="label">No. Invoice</td>
                <td><strong><?= $invoice_no ?? '-' ?></strong></td>
            </tr>
            <tr>
                <td class="label">Nama Anggota</td>
                <td><?= $nama_lengkap ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Verifikasi</td>
                <td><?= date('d M Y H:i') ?></td>
            </tr>
            <tr>
                <td class="label">Total Bayar</td>
                <td><strong>Rp <?= number_format($total_bayar, 0, ',', '.') ?></strong></td>
            </tr>
            <?php if ($catatan): ?>
            <tr>
                <td class="label">Catatan Admin</td>
                <td style="color: #dc3545;"><?= $catatan ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
            <p style="margin: 0; font-size: 14px;">
                <?= $status == 'A' 
                    ? 'Terima kasih atas pembayaran Anda. Saldo atau iuran Anda telah kami perbarui dalam sistem.' 
                    : 'Mohon maaf, pembayaran Anda tidak dapat kami proses. Silakan periksa catatan di atas atau hubungi admin.' ?>
            </p>
        </div>

        <div class="footer">
            &copy; <?= date('Y') ?> Koperasi Kita. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>