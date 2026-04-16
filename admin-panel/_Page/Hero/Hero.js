//Fungsi Menampilkan List Hero
function ListHero() {
    let container = $('#TabelHero');

    container.addClass('hero-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Hero/TabelHero.php',
        beforeSend: function () {
            container.html(`
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4 text-center">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span class="ms-2">Memuat data hero...</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        },
        success: function (data) {
            setTimeout(() => {
                container.html(data);
                container.removeClass('hero-loading');
            }, 200);
        },
        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat data hero
                </div>
            `);
            container.removeClass('hero-loading');
        }
    });
}

$(document).ready(function () {
    
    // Load Data Pertama Kali
    ListHero();

    // Handle enable / disable tombol link
    function ToggleTombolHero() {
        let value = $('#tombol_hero').val();

        if (value === '0') {
            $('#hero_link, #hero_link_label')
                .prop('disabled', true)
                .val('');
        } else {
            $('#hero_link, #hero_link_label')
                .prop('disabled', false);
        }
    }

    ToggleTombolHero();

    $(document).on('change', '#tombol_hero', function () {
        ToggleTombolHero();
    });


    // Handle submit tambah hero
    $(document).on('submit', '#ProsesTambahHero', function (e) {
        e.preventDefault();

        let form = $('#ProsesTambahHero')[0];
        let formData = new FormData(form);

        let button = $('#ButtonTambahHero');
        let notifikasi = $('#NotifikasiTambahHero');
        let modal = $('#ModalTambahHero');

        let originalButton = button.html();

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Hero/ProsesTambahHero.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {

                if (response.status) {

                    $('#ProsesTambahHero')[0].reset();
                    ToggleTombolHero();

                    button.prop('disabled', false).html(originalButton);

                    bootstrap.Modal.getInstance(
                        document.getElementById('ModalTambahHero')
                    ).hide();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                    ListHero();

                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${response.message}
                        </div>
                    `);

                    button.prop('disabled', false).html(originalButton);
                }
            },

            error: function () {
                notifikasi.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan server
                    </div>
                `);

                button.prop('disabled', false).html(originalButton);
            }
        });
    });
    // =======================================================
    // EDIT HERO
    // =======================================================
     $('#ModalEditHero').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        let modal = $(this);
        let formContainer = modal.find('#FormEditHero');
        let notifikasi = modal.find('#NotifikasiEditHero');

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading form
        formContainer.html(`
            <div class="p-4 text-center">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <div class="small mt-2 text-secondary">Memuat data hero...</div>
            </div>
        `);

        $.ajax({
            type: 'POST',
            url: '_Page/Hero/FormEditHero.php',
            data: {
                id_hero: id
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
    $(document).on('change', '#edit_tombol_hero', function () {
        let value = $(this).val();

        if (value === '0') {
            $('#edit_hero_link, #edit_hero_link_label')
                .prop('disabled', true)
                .val('');
        } else {
            $('#edit_hero_link, #edit_hero_link_label')
                .prop('disabled', false);
        }
    });

    $(document).on('shown.bs.modal', '#ModalEditHero', function () {
        $('#edit_tombol_hero').trigger('change');
    });

    // Submit Edit Hero
    $(document).on('submit', '#ProsesEditHero', function (e) {
        e.preventDefault();

        let form = $('#ProsesEditHero')[0];
        let formData = new FormData(form);

        let button = $('#ButtonEditHero');
        let notifikasi = $('#NotifikasiEditHero');
        let modalEl = document.getElementById('ModalEditHero');

        let originalButton = button.html();

        // Reset notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Hero/ProsesEditHero.php',
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

                    // Refresh list hero
                    ListHero();

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
    // HAPUS HERO
    // ==========================================
    $('#ModalHapusHero').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');

        $('#hapus_id_hero').val(id);
        $('#NotifikasiHapusHero').html('');
    });

    // Submit Hapus
    $(document).on('submit', '#ProsesHapusHero', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonHapusHero');
        let notifikasi = $('#NotifikasiHapusHero');
        let modalEl = document.getElementById('ModalHapusHero');

        let originalButton = button.html();

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menghapus...
        `);

        $.ajax({
            url: '_Page/Hero/ProsesHapusHero.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(originalButton);

                if (response.status) {
                    bootstrap.Modal.getInstance(modalEl).hide();

                    ListHero();

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
                        <div class="alert alert-danger">
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
    
});