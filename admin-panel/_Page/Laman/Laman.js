//Fungsi Menampilkan List Laman
function ListLaman() {
    let container = $('#TabelLaman');

    container.addClass('Laman-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Laman/TabelLaman.php',
        beforeSend: function () {
            container.html(`
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4 text-center">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span class="ms-2">Memuat data Laman...</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        },
        success: function (data) {
            setTimeout(() => {
                container.html(data);
                container.removeClass('Laman-loading');
            }, 200);
        },
        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat data Laman
                </div>
            `);
            container.removeClass('Laman-loading');
        }
    });
}

$(document).ready(function () {
    
    // Load Data Pertama Kali
    ListLaman();

    // ==================================================
    // TAMBAH LAMAN
    // ==================================================
    // Inisialisasi Quill
    let quillKontenLaman = new Quill('#konten_laman', {
        theme: 'snow',
        placeholder: 'Tulis konten laman di sini...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Set tanggal hari ini default
    if (!$('#date_laman').val()) {
        let today = new Date().toISOString().split('T')[0];
        $('#date_laman').val(today);
    }

    // Validasi file cover saat dipilih
    $('#cover_laman').on('change', function () {
        let file = this.files[0];
        let notif = $('#NotifikasiTambahLaman');

        notif.html('');

        if (!file) {
            return;
        }

        let maxSize = 2 * 1024 * 1024; // 2MB
        let allowedMime = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        let allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        let fileName = file.name.toLowerCase();
        let ext = fileName.split('.').pop();

        let errors = [];

        // validasi size
        if (file.size > maxSize) {
            errors.push('Ukuran file maksimal 2 MB');
        }

        // validasi mime type
        if (!allowedMime.includes(file.type)) {
            errors.push('Format file harus JPG, PNG, atau GIF');
        }

        // fallback validasi extension
        if (!allowedExt.includes(ext)) {
            errors.push('Ekstensi file tidak valid');
        }

        // tampilkan hasil validasi
        if (errors.length > 0) {
            notif.html(`
                <div class="alert alert-danger alert-dismissible fade show">
                    <b>File tidak valid:</b>
                    <ul class="mb-0 mt-2">
                        ${errors.map(err => `<li>${err}</li>`).join('')}
                    </ul>
                </div>
            `);

            // reset input file
            $(this).val('');
        } else {
            let sizeMB = (file.size / 1024 / 1024).toFixed(2);

            notif.html(`
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-1"></i>
                    File valid: <b>${file.name}</b> (${sizeMB} MB)
                </div>
            `);
        }
    });

    // Sinkronisasi isi Quill saat submit
    $('#ProsesTambahLaman').on('submit', function () {
        let kontenHTML = quillKontenLaman.root.innerHTML;

        // simpan isi editor ke textarea
        $('#konten_laman_input').val(kontenHTML);
    });

    // Submit Tambah Laman
    $(document).on('submit', '#ProsesTambahLaman', function (e) {
        e.preventDefault();

        // sinkronisasi Quill ke hidden input
        $('#konten_laman_input').val(
            quillKontenLaman.root.innerHTML
        );

        let form = $('#ProsesTambahLaman')[0];
        let formData = new FormData(form);

        let button = $('#ButtonTambahLaman');
        let notif = $('#NotifikasiTambahLaman');
        let modalEl = document.getElementById('ModalTambahLaman');

        let originalButton = button.html();

        notif.html('');

        // loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Laman/ProsesTambahLaman.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    // reset form
                    $('#ProsesTambahLaman')[0].reset();

                    // reset quill
                    quillKontenLaman.root.innerHTML = '';

                    // reset notif
                    notif.html('');

                    // tutup modal
                    bootstrap.Modal.getInstance(modalEl).hide();

                    // refresh data laman
                    ListLaman();

                    // toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });

                } else {
                    notif.html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(originalButton);

                notif.html(`
                    <div class="alert alert-danger alert-dismissible fade show">
                        Terjadi kesalahan server
                    </div>
                `);
            }
        });
    });

    // =======================================================
    // DETAIL Laman
    // =======================================================
    $('#ModalDetailLaman').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let container = $('#FormDetailLaman');

        // loading skeleton
        container.html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3"></div>
                <div class="text-muted">Memuat detail Laman...</div>
            </div>
        `);

        $.ajax({
            url: '_Page/Laman/FormDetailLaman.php',
            type: 'POST',
            data: {
                id_laman: id
            },

            success: function (response) {
                container.html(response);
            },

            error: function () {
                container.html(`
                    <div class="alert alert-danger rounded-4">
                        Gagal memuat detail Laman
                    </div>
                `);
            }
        });
    });

    // =======================================================
    // EDIT Laman
    // =======================================================
    let quillEditLaman = null;

    $('#ModalEditLaman').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let modal = $(this);
        let formContainer = modal.find('#FormEditLaman');
        let notifikasi = modal.find('#NotifikasiEditLaman');

        // reset notif
        notifikasi.html('');

        // loading
        formContainer.html(`
            <div class="p-4 text-center">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <div class="small mt-2 text-secondary">
                    Memuat data Laman...
                </div>
            </div>
        `);

        $.ajax({
            type: 'POST',
            url: '_Page/Laman/FormEditLaman.php',
            data: {
                id_laman: id
            },

            success: function (response) {
                formContainer.html(response);

                // destroy quill lama jika ada
                if (quillEditLaman) {
                    quillEditLaman = null;
                }

                // delay kecil agar DOM siap
                setTimeout(function () {
                    let editorEl = document.querySelector('#konten_laman_edit');

                    if (editorEl) {
                        quillEditLaman = new Quill('#konten_laman_edit', {
                            theme: 'snow',
                            placeholder: 'Edit konten laman...',
                            modules: {
                                toolbar: [
                                    [{ header: [1, 2, 3, false] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ list: 'ordered' }, { list: 'bullet' }],
                                    [{ align: [] }],
                                    ['link', 'image'],
                                    ['clean']
                                ]
                            }
                        });

                        // load konten lama dari hidden input
                        let oldContent = $('#konten_laman_old').val();
                        quillEditLaman.root.innerHTML = oldContent;
                    }
                }, 100);
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
    
    
    // Submit Edit Laman
    $(document).on('submit', '#ProsesEditLaman', function (e) {
        e.preventDefault();

        // sinkronisasi quill ke hidden input
        if (quillEditLaman) {
            $('#konten_laman_input_edit').val(
                quillEditLaman.root.innerHTML
            );
        }

        let form = $('#ProsesEditLaman')[0];
        let formData = new FormData(form);

        let button = $('#ButtonEditLaman');
        let notif = $('#NotifikasiEditLaman');
        let modalEl = document.getElementById('ModalEditLaman');

        let originalButton = button.html();

        // reset notif
        notif.html('');

        // loading button
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Laman/ProsesEditLaman.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    // tutup modal
                    bootstrap.Modal.getInstance(modalEl).hide();

                    // refresh list
                    ListLaman();

                    // toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });

                } else {
                    notif.html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(originalButton);

                notif.html(`
                    <div class="alert alert-danger alert-dismissible fade show">
                        Terjadi kesalahan server
                    </div>
                `);
            }
        });
    });

    // ==========================================
    // HAPUS Laman
    // ==========================================
    $('#ModalHapusLaman').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        $('#hapus_id_laman').val(id);
        $('#NotifikasiHapusLaman').html('');

        $('#FormHapusLaman').html(`
            <div class="text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
                </div>
                <div class="fw-bold mb-2">
                    Apakah Anda yakin?
                </div>
                <div class="text-muted small">
                    Data Laman beserta file gambar akan dihapus permanen.
                </div>
            </div>
        `);
    });

    // Submit Hapus
    $(document).on('submit', '#ProsesHapusLaman', function (e) {
        e.preventDefault();

        let form = $('#ProsesHapusLaman')[0];
        let formData = new FormData(form);

        let button = $('#ButtonHapusLaman');
        let notif = $('#NotifikasiHapusLaman');
        let modalEl = document.getElementById('ModalHapusLaman');

        let originalButton = button.html();

        notif.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menghapus...
        `);

        $.ajax({
            url: '_Page/Laman/ProsesHapusLaman.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    let modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }

                    ListLaman();

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