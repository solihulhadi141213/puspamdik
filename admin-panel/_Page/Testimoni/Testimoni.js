//Fungsi Menampilkan List Testimoni
function ListTestimoni() {
    let container = $('#TabelTestimoni');

    container.addClass('Testimoni-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Testimoni/TabelTestimoni.php',
        beforeSend: function () {
            container.html(`
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4 text-center">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span class="ms-2">Memuat data Testimoni...</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        },
        success: function (data) {
            setTimeout(() => {
                container.html(data);
                container.removeClass('Testimoni-loading');
            }, 200);
        },
        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat data Testimoni
                </div>
            `);
            container.removeClass('Testimoni-loading');
        }
    });
}

$(document).ready(function () {
    
    // Load Data Pertama Kali
    ListTestimoni();

    // Validasi Saat Uplaod
    $(document).on('change', '#foto_responsen', function () {
        let file = this.files[0];
        let notif = $('#NotifikasiTambahTestimoni');

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

    // Handle submit tambah Testimoni
    $(document).on('submit', '#ProsesTambahTestimoni', function (e) {
        e.preventDefault();

        let form = $('#ProsesTambahTestimoni')[0];
        let formData = new FormData(form);

        let button = $('#ButtonTambahTestimoni');
        let notif = $('#NotifikasiTambahTestimoni');
        let modalEl = document.getElementById('ModalTambahTestimoni');

        let defaultButton = button.html();

        notif.html('');

        // loading button
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Testimoni/ProsesTambahTestimoni.php',
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
                    $('#ProsesTambahTestimoni')[0].reset();

                    // clear notif
                    notif.html('');

                    // close modal
                    bootstrap.Modal.getInstance(modalEl).hide();

                    // reload Testimoni
                    ListTestimoni();

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
    // DETAIL Testimoni
    // =======================================================
    $('#ModalDetailTestimoni').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let container = $('#FormDetailTestimoni');

        // loading skeleton
        container.html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3"></div>
                <div class="text-muted">Memuat detail Testimoni...</div>
            </div>
        `);

        $.ajax({
            url: '_Page/Testimoni/FormDetailTestimoni.php',
            type: 'POST',
            data: {
                id_testimoni: id
            },

            success: function (response) {
                container.html(response);
            },

            error: function () {
                container.html(`
                    <div class="alert alert-danger rounded-4">
                        Gagal memuat detail Testimoni
                    </div>
                `);
            }
        });
    });

    // =======================================================
    // EDIT Testimoni
    // =======================================================
    $('#ModalEditTestimoni').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let modal = $(this);
        let formContainer = modal.find('#FormEditTestimoni');
        let notifikasi = modal.find('#NotifikasiEditTestimoni');

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading form
        formContainer.html(`
            <div class="p-4 text-center">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <div class="small mt-2 text-secondary">Memuat data Testimoni...</div>
            </div>
        `);

        $.ajax({
            type: 'POST',
            url: '_Page/Testimoni/FormEditTestimoni.php',
            data: {
                id_testimoni: id
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
    
    
    // Submit Edit Testimoni
    $(document).on('submit', '#ProsesEditTestimoni', function (e) {
        e.preventDefault();

        let form = $('#ProsesEditTestimoni')[0];
        let formData = new FormData(form);

        let button = $('#ButtonEditTestimoni');
        let notifikasi = $('#NotifikasiEditTestimoni');
        let modalEl = document.getElementById('ModalEditTestimoni');

        let originalButton = button.html();

        // Reset notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Testimoni/ProsesEditTestimoni.php',
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

                    // Refresh list Testimoni
                    ListTestimoni();

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
    // HAPUS Testimoni
    // ==========================================
    $('#ModalHapusTestimoni').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        $('#hapus_id_testimoni').val(id);
        $('#NotifikasiHapusTestimoni').html('');

        $('#FormHapusTestimoni').html(`
            <div class="text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
                </div>
                <div class="fw-bold mb-2">
                    Apakah Anda yakin?
                </div>
                <div class="text-muted small">
                    Data Testimoni beserta file gambar akan dihapus permanen.
                </div>
            </div>
        `);
    });

    // Submit Hapus
    $(document).on('submit', '#ProsesHapusTestimoni', function (e) {
        e.preventDefault();

        let form = $('#ProsesHapusTestimoni')[0];
        let formData = new FormData(form);

        let button = $('#ButtonHapusTestimoni');
        let notif = $('#NotifikasiHapusTestimoni');
        let modalEl = document.getElementById('ModalHapusTestimoni');

        let originalButton = button.html();

        notif.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menghapus...
        `);

        $.ajax({
            url: '_Page/Testimoni/ProsesHapusTestimoni.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    bootstrap.Modal.getInstance(modalEl).hide();

                    ListTestimoni();

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