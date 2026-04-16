//Fungsi Menampilkan List Pengurus
function ListPengurus() {
    let container = $('#TabelPengurus');

    container.addClass('Pengurus-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Pengurus/TabelPengurus.php',
        beforeSend: function () {
            container.html(`
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4 text-center">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span class="ms-2">Memuat data Pengurus...</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        },
        success: function (data) {
            setTimeout(() => {
                container.html(data);
                container.removeClass('Pengurus-loading');
            }, 200);
        },
        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat data Pengurus
                </div>
            `);
            container.removeClass('Pengurus-loading');
        }
    });
}

$(document).ready(function () {
    
    // Load Data Pertama Kali
    ListPengurus();

    // Validasi Saat Uplaod
    $(document).on('change', '#foto_pengurus', function () {
        let file = this.files[0];
        let notif = $('#NotifikasiTambahPengurus');

        notif.html('');

        if (!file) return;

        let allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        let allowedMime = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        let maxSize = 2 * 1024 * 1024; // 2MB

        let fileName = file.name.toLowerCase();
        let extension = fileName.split('.').pop();
        let mimeType = file.type;
        let fileSize = file.size;

        // validasi extension
        if (!allowedExt.includes(extension)) {
            notif.html(`
                <div class="alert alert-danger py-2">
                    Format file harus JPG, JPEG, PNG, atau GIF
                </div>
            `);

            $(this).val('');
            return;
        }

        // validasi mimetype
        if (!allowedMime.includes(mimeType)) {
            notif.html(`
                <div class="alert alert-danger py-2">
                    Mime type file tidak valid
                </div>
            `);

            $(this).val('');
            return;
        }

        // validasi size
        if (fileSize > maxSize) {
            notif.html(`
                <div class="alert alert-danger py-2">
                    Ukuran file maksimal 2 MB
                </div>
            `);

            $(this).val('');
            return;
        }

        // success
        notif.html(`
            <div class="alert alert-success py-2">
                File valid: <b>${file.name}</b>
                (${(file.size / 1024 / 1024).toFixed(2)} MB)
            </div>
        `);
    });

    // Handle submit tambah Pengurus
    $(document).on('submit', '#ProsesTambahPengurus', function (e) {
        e.preventDefault();

        let form = $('#ProsesTambahPengurus')[0];
        let formData = new FormData(form);

        let button = $('#ButtonTambahPengurus');
        let notif = $('#NotifikasiTambahPengurus');
        let modalEl = document.getElementById('ModalTambahPengurus');

        let defaultButton = button.html();

        notif.html('');

        // loading button
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Pengurus/ProsesTambahPengurus.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                // restore button
                button.prop('disabled', false).html(defaultButton);

                if (response.status) {
                    // reset form
                    $('#ProsesTambahPengurus')[0].reset();

                    // clear notif
                    notif.html('');

                    // close modal
                    bootstrap.Modal.getInstance(modalEl).hide();

                    // reload Pengurus
                    ListPengurus();

                    // toast success
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                } else {
                    notif.html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(defaultButton);

                notif.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan server
                    </div>
                `);
            }
        });
    });

    // =======================================================
    // DETAIL Pengurus
    // =======================================================
    $('#ModalDetailPengurus').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let container = $('#FormDetailPengurus');

        // loading skeleton
        container.html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3"></div>
                <div class="text-muted">Memuat detail Pengurus...</div>
            </div>
        `);

        $.ajax({
            url: '_Page/Pengurus/FormDetailPengurus.php',
            type: 'POST',
            data: {
                id_pengurus: id
            },

            success: function (response) {
                container.html(response);
            },

            error: function () {
                container.html(`
                    <div class="alert alert-danger rounded-4">
                        Gagal memuat detail Pengurus
                    </div>
                `);
            }
        });
    });

    // =======================================================
    // EDIT Pengurus
    // =======================================================
    $('#ModalEditPengurus').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let modal = $(this);
        let formContainer = modal.find('#FormEditPengurus');
        let notifikasi = modal.find('#NotifikasiEditPengurus');

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading form
        formContainer.html(`
            <div class="p-4 text-center">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <div class="small mt-2 text-secondary">Memuat data Pengurus...</div>
            </div>
        `);

        $.ajax({
            type: 'POST',
            url: '_Page/Pengurus/FormEditPengurus.php',
            data: {
                id_pengurus: id
            },
            success: function (response) {
                formContainer.html(response);
            },
            error: function () {
                formContainer.html(`
                    <div class="alert alert-danger">
                        Gagal memuat form edit
                    </div>
                `);
            }
        });
    });
    
    
    // Submit Edit Pengurus
    $(document).on('submit', '#ProsesEditPengurus', function (e) {
        e.preventDefault();

        let form = $('#ProsesEditPengurus')[0];
        let formData = new FormData(form);

        let button = $('#ButtonEditPengurus');
        let notifikasi = $('#NotifikasiEditPengurus');
        let modalEl = document.getElementById('ModalEditPengurus');

        let originalButton = button.html();

        // Reset notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Pengurus/ProsesEditPengurus.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                // Kembalikan tombol
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    // Tutup modal
                    bootstrap.Modal.getInstance(modalEl).hide();

                    // Refresh list Pengurus
                    ListPengurus();

                    // Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(originalButton);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan server
                    </div>
                `);
            }
        });
    });

    // ==========================================
    // HAPUS Pengurus
    // ==========================================
    $('#ModalHapusPengurus').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        $('#hapus_id_pengurus').val(id);
        $('#NotifikasiHapusPengurus').html('');

        $('#FormHapusPengurus').html(`
            <div class="text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
                </div>
                <div class="fw-bold mb-2">
                    Apakah Anda yakin?
                </div>
                <div class="text-muted small">
                    Data Pengurus beserta file gambar akan dihapus permanen.
                </div>
            </div>
        `);
    });

    // Submit Hapus
    $(document).on('submit', '#ProsesHapusPengurus', function (e) {
        e.preventDefault();

        let form = $('#ProsesHapusPengurus')[0];
        let formData = new FormData(form);

        let button = $('#ButtonHapusPengurus');
        let notif = $('#NotifikasiHapusPengurus');
        let modalEl = document.getElementById('ModalHapusPengurus');

        let originalButton = button.html();

        notif.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menghapus...
        `);

        $.ajax({
            url: '_Page/Pengurus/ProsesHapusPengurus.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    bootstrap.Modal.getInstance(modalEl).hide();

                    ListPengurus();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                } else {
                    notif.html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(originalButton);

                notif.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan server
                    </div>
                `);
            }
        });
    });
    
});