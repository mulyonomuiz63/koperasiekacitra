<style>
    /* Sembunyikan tombol Kembali jika dalam keadaan disabled (khusus step 1) */
    .introjs-prevbutton.introjs-disabled {
        display: none !important;
    }

    /* Merapikan posisi tombol Lanjutkan agar ke kanan saat tombol kembali hilang */
    .introjs-tooltipbuttons {
        border-top: 1px solid #eff2f5;
        /* Garis tipis khas Metronic */
        padding-top: 10px;
        margin-top: 10px;
        text-align: right;
        display: block !important;
    }

    /* Style Tombol Lanjutkan (Primary Metronic) */
    .introjs-nextbutton {
        background-color: #009ef7 !important;
        background-image: none !important;
        border: none !important;
        color: #ffffff !important;
        padding: 8px 16px !important;
        font-weight: 500 !important;
        border-radius: 0.475rem !important;
        box-shadow: none !important;
    }

    /* Style Tombol Kembali (Light Metronic) */
    .introjs-prevbutton {
        background-color: #f5f8fa !important;
        background-image: none !important;
        border: none !important;
        color: #7e8299 !important;
        padding: 8px 16px !important;
        border-radius: 0.475rem !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }
</style>