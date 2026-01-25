<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">

    <title><?= esc($title ?? 'Dokumen') ?></title>

    <style>
        /* ===== PAGE ===== */
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
        }

        /* ===== HEADER ===== */
        .pdf-header {
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .pdf-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .pdf-header small {
            color: #555;
        }

        /* ===== CONTENT ===== */
        .pdf-content {
            min-height: 600px;
        }

        /* ===== FOOTER ===== */
        .pdf-footer {
            position: fixed;
            bottom: 10mm;
            left: 15mm;
            right: 15mm;
            font-size: 10px;
            color: #555;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        /* ===== UTIL ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="pdf-header">
        <h2><?= esc($header ?? 'Dokumen Resmi') ?></h2>
        <small><?= esc($subheader ?? '') ?></small>
    </div>

    <!-- CONTENT -->
    <div class="pdf-content">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- FOOTER -->
    <div class="pdf-footer">
        <?= esc($footer ?? 'Dicetak oleh sistem • ' . date('d/m/Y H:i')) ?>
    </div>

</body>
</html>
