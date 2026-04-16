function showToast(type, message) {

    let bg = 'bg-primary';

    if (type === 'success') bg = 'bg-success';
    if (type === 'danger') bg = 'bg-danger';
    if (type === 'warning') bg = 'bg-warning';

    let html = `
    <div class="toast align-items-center text-white ${bg} border-0 mb-2" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    `;

    $('#ToastContainer').append(html);

    let toastEl = $('#ToastContainer .toast').last()[0];
    let toast = new bootstrap.Toast(toastEl, { delay: 3000 });

    toast.show();

    $(toastEl).on('hidden.bs.toast', function () {
        $(this).remove();
    });
}
function LoadTabelEvent() {
    let container = $("#TabelEvent");

    container.addClass("loading-blur");

    $.ajax({
        url: "_Page/Event/TabelEvent.php",
        method: "GET",
        success: function (data) {
            container.html(data);

            // Delay kecil biar smooth
            setTimeout(() => {
                container.removeClass("loading-blur");
            }, 200);
        },
        error: function () {
            container.html('<div class="text-danger text-center">Gagal memuat data</div>');
            container.removeClass("loading-blur");
        }
    });
}

$(document).ready(function () {
    LoadTabelEvent();

    //============================
    // TAMBAH EVENT
    //============================
    $("#ProsesTambahEvent").submit(function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let btn = $("#ButtonTambahEvent");

        // SIMPAN TEXT ASLI
        let originalText = btn.html();

        // LOADING BUTTON
        btn.prop("disabled", true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...');

        // CLEAR NOTIFIKASI
        $("#NotifikasiTambahEvent").html("");

        $.ajax({
            url: "_Page/Event/ProsesTambahEvent.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",

            success: function (res) {

                // KEMBALIKAN BUTTON
                btn.prop("disabled", false);
                btn.html(originalText);

                if (res.status === "success") {

                    // TUTUP MODAL
                    $("#ModalTambahEvent").modal("hide");

                    // RESET FORM
                    form.reset();

                    // TOAST SUCCESS
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // RELOAD DATA EVENT
                    LoadTabelEvent();

                } else {

                    // TAMPILKAN ERROR DI FORM
                    $("#NotifikasiTambahEvent").html(
                        '<div class="alert alert-danger">' + res.message + '</div>'
                    );
                }
            },

            error: function () {

                // KEMBALIKAN BUTTON
                btn.prop("disabled", false);
                btn.html(originalText);

                $("#NotifikasiTambahEvent").html(
                    '<div class="alert alert-danger">Terjadi kesalahan server</div>'
                );
            }
        });
    });

    //============================
    // DETAIL EVENT
    //============================
    $('#ModalDetailEvent').on('show.bs.modal', function (e) {

        let button = $(e.relatedTarget); // element yang diklik
        let id = button.data('id');

        // loading dulu
        $('#FormDetailEvent').html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary"></div>
                <div class="mt-2">Memuat data...</div>
            </div>
        `);

        $.ajax({
            url: '_Page/Event/FormDetailEvent.php',
            type: 'POST',
            data: { id: id },
            success: function(res) {
                $('#FormDetailEvent').hide().html(res).fadeIn(300);
            },
            error: function() {
                $('#FormDetailEvent').html(`
                    <div class="alert alert-danger text-center">
                        Gagal memuat data
                    </div>
                `);
            }
        });

    });

    //============================
    // EDIT EVENT
    //============================
    $('#ModalEditEvent').on('show.bs.modal', function (e) {

        let button = $(e.relatedTarget);
        let id = button.data('id');

        // loading UI
        $('#FormEditEvent').html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary"></div>
                <div class="mt-2">Memuat data...</div>
            </div>
        `);

        $.ajax({
            url: '_Page/Event/FormEditEvent.php',
            type: 'POST',
            data: { id: id },
            success: function(res) {
                $('#FormEditEvent').hide().html(res).fadeIn(300);
            },
            error: function() {
                $('#FormEditEvent').html(`
                    <div class="alert alert-danger text-center">
                        Gagal memuat form edit
                    </div>
                `);
            }
        });

    });

    $(document).on('submit', '#ProsesEditEvent', function(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: '_Page/Event/ProsesEditEvent.php',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {

                $('#ButtonEditEvent').prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm"></span> Menyimpan...
                `);

            },
            success: function(res) {

                $('#ButtonEditEvent').prop('disabled', false).html(`
                    <i class="bi bi-save"></i> Simpan
                `);

                if (res.status == 'success') {

                    // tutup modal
                    $('#ModalEditEvent').modal('hide');

                    // reload tabel event
                    $('#TabelEvent').load('_Page/Event/TabelEvent.php');

                    // toast sukses
                    showToast('success', res.message);

                } else {

                    showToast('warning', res.message);

                }

            },
            error: function() {

                $('#ButtonEditEvent').prop('disabled', false).html(`
                    <i class="bi bi-save"></i> Simpan
                `);

                showToast('danger', 'Terjadi kesalahan sistem');

            }
        });
    });

    //============================
    // HAPUS EVENT
    //============================
    $('#ModalHapusEvent').on('show.bs.modal', function (e) {

        let button = $(e.relatedTarget);
        let id = button.data('id');

        // set ke input hidden
        $('#hapus_id_event').val(id);

        // tampilkan loading
        $('#FormHapusEvent').html(`
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-danger"></div>
                <div class="small mt-2 text-secondary">
                    Memuat data...
                </div>
            </div>
        `);

        // kosongkan notifikasi
        $('#NotifikasiHapusEvent').html('');

        // ambil data (preview)
        $.ajax({
            url: '_Page/Event/FormHapusEvent.php',
            type: 'POST',
            data: { id: id },
            success: function(res) {
                $('#FormHapusEvent').hide().html(res).fadeIn(200);
            },
            error: function() {
                $('#FormHapusEvent').html(`
                    <div class="alert alert-danger text-center">
                        Gagal memuat data
                    </div>
                `);
            }
        });

    });

    $('#ProsesHapusEvent').on('submit', function(e) {
        e.preventDefault();

        let id = $('#hapus_id_event').val();

        $.ajax({
            url: '_Page/Event/ProsesHapusEvent.php',
            type: 'POST',
            data: { id_event: id },
            dataType: 'JSON',

            beforeSend: function() {
                $('#ButtonHapusEvent')
                    .prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm"></span> Menghapus...');
            },

            success: function(res) {

                $('#ButtonHapusEvent')
                    .prop('disabled', false)
                    .html('<i class="bi bi-trash"></i> Ya, Hapus');

                if (res.status === 'success') {

                    // tutup modal
                    $('#ModalHapusEvent').modal('hide');

                    // reload tabel
                    $('#TabelEvent').load('_Page/Event/TabelEvent.php');

                    // notifikasi (pakai alert atau toast kamu)
                    showToast('success', res.message);

                } else {

                    $('#NotifikasiHapusEvent').html(`
                        <div class="alert alert-warning">${res.message}</div>
                    `);

                }
            },

            error: function() {

                $('#ButtonHapusEvent')
                    .prop('disabled', false)
                    .html('<i class="bi bi-trash"></i> Ya, Hapus');

                $('#NotifikasiHapusEvent').html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan sistem
                    </div>
                `);

            }
        });

    });
});