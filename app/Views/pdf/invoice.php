<?= $this->extend('pdf/layout') ?>

<?= $this->section('content') ?>

<style>
    body {
        font-family: sans-serif;
        color: #333;
        line-height: 1.5;
    }

    .header-table {
        border-bottom: 2px solid #28a745;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .invoice-title {
        font-size: 24px;
        color: #28a745;
        font-weight: bold;
        margin: 0;
    }

    .info-table td {
        font-size: 12px;
        padding: 3px 0;
    }

    .items-table {
        border-collapse: collapse;
        margin-top: 20px;
    }

    .items-table th {
        background-color: #f8f9fa;
        color: #555;
        font-size: 11px;
        text-transform: uppercase;
        border-bottom: 1px solid #dee2e6;
        padding: 10px;
    }

    .items-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 12px;
    }

    .total-box {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .watermark {
        position: fixed;
        top: 35%;
        left: 15%;
        width: 70%;
        text-align: center;
        font-size: 100px;
        color: #28a745;
        opacity: 0.1;
        transform: rotate(-30deg);
        z-index: -1000;
        font-weight: bold;
        border: 15px solid #28a745;
        border-radius: 20px;
        padding: 20px;
    }
</style>

<?php if ($pembayaran['status'] === 'A'): ?>
    <div class="watermark">LUNAS</div>
<?php endif; ?>

<table width="100%" class="header-table">
    <tr>
        <td width="50%">
            <h1 class="invoice-title">KOPERASI EKA CITRA</h1>
            <div style="font-size: 10px; color: #666;">
                <?= setting('alamat_perusahaan') ?><br>
                        Email: <?= setting('app_email') ?> | Telp: <?= setting('app_phone') ?>
            </div>
        </td>
        <td width="50%" style="text-align: right; vertical-align: bottom;">
            <div style="font-size: 18px; font-weight: bold; color: #444;">INVOICE PEMBAYARAN</div>
            <div style="font-size: 12px; color: #28a745; font-weight: bold;">#<?= esc($pembayaran['invoice_no']) ?></div>
        </td>
    </tr>
</table>

<table width="100%" class="info-table" style="margin-bottom: 30px;">
    <tr>
        <td width="50%" style="vertical-align: top;">
            <div style="color: #888; text-transform: uppercase; font-size: 10px; font-weight: bold; margin-bottom: 5px;">Ditagihkan Kepada:</div>
            <div style="font-size: 14px; font-weight: bold;"><?= esc($pembayaran['nama_pegawai']) ?></div>
            <div style="color: #555;">Anggota Koperasi Eka Citra</div>
        </td>
        <td width="50%" style="text-align: right; vertical-align: top;">
            <table width="100%" class="info-table">
                <tr>
                    <td style="text-align: right; color: #888;">Tanggal Terbit:</td>
                    <td style="text-align: right; width: 100px; font-weight: bold;"><?= tglIndo($pembayaran['validated_at']) ?></td>
                </tr>
                <tr>
                    <td style="text-align: right; color: #888;">Metode:</td>
                    <td style="text-align: right; font-weight: bold;">Transfer Bank</td>
                </tr>
                <tr>
                    <td style="text-align: right; color: #888;">Status:</td>
                    <td style="text-align: right;">
                        <?php if ($pembayaran['status'] === 'A'): ?>
                            <span style="color:#28a745; font-weight:bold;">TERBAYAR</span>
                        <?php else: ?>
                            <span style="color:#ffc107; font-weight:bold;">PENDING</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" class="items-table">
    <thead>
        <tr>
            <th align="left" width="5%">No</th>
            <th align="left">Deskripsi Layanan / Iuran</th>
            <th align="center" width="20%">Periode</th>
            <th align="right" width="25%">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($detail as $row): ?>
            <tr>
                <td align="left"><?= $no++ ?></td>
                <td align="left">
                    <div style="font-weight: bold;">Iuran Bulanan Anggota</div>
                    <div style="font-size: 10px; color: #777;">Kontribusi iuran wajib anggota koperasi</div>
                </td>
                <td align="center"><?= bulanIndo($row['bulan']) ?> <?= $row['tahun'] ?></td>
                <td align="right" style="font-weight: bold;">Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<table width="100%" style="margin-top: 10px;">
    <tr>
        <td width="60%">
            <div style="font-size: 10px; color: #888; margin-top: 20px;">
                <strong>Catatan:</strong><br>
                Terima kasih atas partisipasi Anda. Simpan invoice ini sebagai bukti pembayaran yang sah.
            </div>
        </td>
        <td width="40%">
            <div class="total-box">
                <table width="100%">
                    <tr>
                        <td style="font-size: 11px; color: #666;">Subtotal</td>
                        <td align="right" style="font-size: 11px;">Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 11px; color: #666; padding-bottom: 5px;">Pajak (0%)</td>
                        <td align="right" style="font-size: 11px; padding-bottom: 5px;">Rp 0</td>
                    </tr>
                    <tr style="border-top: 1px solid #ccc;">
                        <td style="font-size: 14px; font-weight: bold; padding-top: 5px; color: #28a745;">GRAND TOTAL</td>
                        <td align="right" style="font-size: 14px; font-weight: bold; padding-top: 5px; color: #28a745;">
                            Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<div style="text-align: center; margin-top: 50px; border-top: 1px solid #eee; padding-top: 10px;">
    <p style="font-size: 10px; color: #999;">
        Invoice digital ini diterbitkan secara resmi oleh <strong>Sistem Informasi Koperasi Eka Citra</strong>.<br>
        Dicetak otomatis pada <?= date('d/m/Y H:i') ?> WIB.
    </p>
</div>

<?= $this->endSection() ?>