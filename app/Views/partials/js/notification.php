<!-- //untuk notif -->
<script>
    function updateNotification() {
        fetch('<?= base_url("notif/get-data") ?>', {
            referrerPolicy: 'no-referrer',
        })
            .then(response => response.json())
            .then(res => {
                const listContainer = document.getElementById('notification-list');
                const countBadge = document.getElementById('main-notif-badge');
                const loader = document.getElementById('notif-loader');

                // Konversi ke angka untuk memastikan validitas
                const unreadCount = parseInt(res.unread_count) || 0;

                // LOGIKA BADGE ANGKA DI POJOK ICON
                if (unreadCount > 0) {
                    countBadge.innerText = unreadCount > 99 ? '99+' : unreadCount;
                    // Paksa tampil dengan flex agar angka presisi di tengah lingkaran
                    countBadge.style.setProperty('display', 'flex', 'important');
                    countBadge.classList.add('animate__animated', 'animate__bounceIn');
                } else {
                    countBadge.style.display = 'none';
                }

                // Sembunyikan loader
                if (loader) loader.style.display = 'none';

                // RENDER ISI LIST NOTIFIKASI
                if (res.data && res.data.length > 0) {
                    let html = '';
                    res.data.forEach(item => {
                        const isUnread = item.is_read == 0 ? 'bg-light-success' : '';
                        html += `
									<div class="d-flex flex-stack py-4 border-bottom border-gray-200 ${isUnread} px-3 rounded mb-1">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-35px me-4">
												<span class="symbol-label bg-light-primary">
													<i class="ki-outline ki-wallet fs-2 text-primary"></i>
												</span>
											</div>
											<div class="mb-0 me-2">
												<a href="<?= base_url() ?>${item.link}" 
												class="btn-mark-read fs-7 text-gray-800 text-hover-primary fw-bold text-break"
												data-id="${item.id}" 
												data-link="${item.link}">
												${item.title}
												</a>
												<div class="text-gray-400 fs-8">${item.message}</div>
											</div>
										</div>
									</div>`;
                    });
                    listContainer.innerHTML = html;

                    // Tambahkan event listener untuk link yang baru dibuat
                    attachClickEvents();
                } else {
                    listContainer.innerHTML = '<div class="text-center py-10 text-muted fs-7">Tidak ada notifikasi baru</div>';
                }
            })
            .catch(err => console.error("Error fetching notifications:", err));
    }

    async function attachClickEvents() {
        document.querySelectorAll('.btn-mark-read').forEach(element => {
            element.onclick = async function(e) {
                e.preventDefault();

                const uuid = this.getAttribute('data-id');
                const fullUrl = this.getAttribute('href');

                // URL sekarang bersih, tidak membawa UUID di belakangnya
                const targetUrl = '<?= base_url("notif/mark-read") ?>';

                this.style.opacity = '0.5';

                try {
                    // Bungkus UUID ke dalam FormData
                    const formData = new FormData();
                    formData.append('uuid', uuid);

                    const response = await fetch(targetUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        referrerPolicy: 'no-referrer',
                        body: formData // UUID dikirim di sini (Data Body)
                    });
                } catch (err) {
                    console.error("Fetch error:", err);
                } finally {
                    // Pindah halaman
                    window.location.href = fullUrl;
                }
            };
        });
    }
    

    document.getElementById('btn-read-all').onclick = async function() {
        const targetUrl = '<?= base_url("notif/mark-all-read") ?>';
        const btn = this;

        // Loading state
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm align-middle ms-2"></span> Memproses...';
        btn.disabled = true;

        try {
            const response = await fetch(targetUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    // Tetap sertakan jika sewaktu-waktu filter CSRF aktif kembali
                }
            });

            if (response.ok) {
                // 1. Reset Badge di UI langsung tanpa nunggu polling
                const countBadge = document.getElementById('main-notif-badge');
                if (countBadge) countBadge.style.display = 'none';

                // 2. Refresh list notifikasi agar warna background berubah
                updateNotification();
            }
        } catch (err) {
            console.error("Error mark all read:", err);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    };

    // Jalankan otomatis
    updateNotification();
    const notifInterval = setInterval(updateNotification, 30000);
    $(document).on('submit', 'form', function() {
        clearInterval(notifInterval);
    });
</script>