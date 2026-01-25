<?= $this->extend('pdf/layout') ?>

<?= $this->section('content') ?>

<!-- ================= WATERMARK ================= -->
<?php if ($pembayaran['status'] === 'A'): ?>
<div style="
    position: fixed;
    top: 40%;
    left: 10%;
    width: 80%;
    text-align: center;
    font-size: 90px;
    color: #28a745;
    opacity: 0.12;
    transform: rotate(-20deg);
    z-index: -1;
    font-weight: bold;
">
    LUNAS
</div>
<?php endif; ?>

<!-- ================= HEADER INFO ================= -->
<table width="100%" style="margin-bottom:20px;">
    <tr>
        <td>
            <h3 style="margin:0;">INVOICE PEMBAYARAN</h3>
            <small>Sistem Iuran Bulanan</small>
        </td>
        <td style="text-align:right;">
            <strong>Tanggal</strong><br>
            <?= tglIndo($pembayaran['validated_at']) ?>
        </td>
    </tr>
</table>

<!-- ================= CUSTOMER INFO ================= -->
<table width="100%" style="margin-bottom:20px;">
    <tr>
        <td width="20%"><strong>Nama</strong></td>
        <td width="80%">: <?= esc($pembayaran['nama_pegawai']) ?></td>
    </tr>
    <tr>
        <td><strong>No Invoice</strong></td>
        <td>: <?= esc($pembayaran['invoice_no']) ?></td>
    </tr>
    <tr>
        <td><strong>Status</strong></td>
        <td>
            :
            <?php if ($pembayaran['status'] === 'A'): ?>
                <span style="color:#28a745;font-weight:bold;">LUNAS</span>
            <?php elseif ($pembayaran['status'] === 'V'): ?>
                <span style="color:#0dcaf0;font-weight:bold;">MENUNGGU VERIFIKASI</span>
            <?php else: ?>
                <span style="color:#ffc107;font-weight:bold;">MENUNGGU PEMBAYARAN</span>
            <?php endif; ?>
        </td>
    </tr>
</table>

<!-- ================= DETAIL TABLE ================= -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <thead>
        <tr style="background:#f5f5f5;">
            <th style="padding:8px;border-bottom:1px solid #ccc;">Periode Iuran</th>
            <th style="padding:8px;border-bottom:1px solid #ccc;text-align:right;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail as $row): ?>
        <tr>
            <td style="padding:8px;border-bottom:1px solid #eee;">
                <?= bulanIndo($row['bulan']) ?> <?= $row['tahun'] ?>
            </td>
            <td style="padding:8px;border-bottom:1px solid #eee;text-align:right;">
                Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- ================= TOTAL ================= -->
<table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td width="40%">
            <table width="100%">
                <tr>
                    <td style="padding:8px;font-weight:bold;">TOTAL</td>
                    <td style="padding:8px;text-align:right;font-weight:bold;font-size:14px;">
                        Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- ================= NOTE ================= -->
<p style="margin-top:25px;font-size:11px;color:#555;">
    Invoice ini dihasilkan secara otomatis oleh sistem.<br>
    Tidak memerlukan tanda tangan basah.
</p>

<?= $this->endSection() ?>
