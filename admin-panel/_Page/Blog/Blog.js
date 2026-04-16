// ==========================================
// GLOBAL QUILL INSTANCE
// ==========================================
let quillTambahBlog = null;
let quillEditBlog = null;

// ==========================================
// LOAD LIST BLOG
// ==========================================
function ListBlog() {
    let container = $('#TabelBlog');

    $.ajax({
        type: 'POST',
        url: '_Page/Blog/TabelBlog.php',

        beforeSend: function () {
            container.html(`
                <div class="text-center p-5">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                    <div class="small mt-2">Memuat data blog...</div>
                </div>
            `);
        },

        success: function (response) {
            container.html(response);
        },

        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat data blog
                </div>
            `);
        }
    });
}

// Load pertama
$(document).ready(function () {
    ListBlog();
});


// ==========================================
// MODAL TAMBAH BLOG
// ==========================================
$('#ModalTambahBlog').on('shown.bs.modal', function () {
    if (!quillTambahBlog) {
        quillTambahBlog = new Quill('#content_blog', {
            theme: 'snow',
            placeholder: 'Tulis konten blog...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });
    }

    if (!$('#blog_date').val()) {
        let today = new Date().toISOString().split('T')[0];
        $('#blog_date').val(today);
    }
});


// ==========================================
// SUBMIT TAMBAH BLOG
// ==========================================
$(document).on('submit', '#ProsesTambahBlog', function (e) {
    e.preventDefault();

    let notif = $('#NotifikasiTambahBlog');
    let button = $('#ButtonTambahBlog');
    let originalButton = button.html();
    let modalEl = document.getElementById('ModalTambahBlog');

    notif.html('');

    if (quillTambahBlog) {
        $('#content_blog_input').val(
            quillTambahBlog.root.innerHTML
        );
    }

    let formData = new FormData(this);

    button.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
        Menyimpan...
    `);

    $.ajax({
        url: '_Page/Blog/ProsesTambahBlog.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function (response) {
            button.prop('disabled', false).html(originalButton);

            if (response.status) {
                $('#ProsesTambahBlog')[0].reset();

                if (quillTambahBlog) {
                    quillTambahBlog.root.innerHTML = '';
                }

                bootstrap.Modal.getInstance(modalEl).hide();

                ListBlog();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    timer: 2000,
                    showConfirmButton: false
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


// ==========================================
// DETAIL BLOG
// ==========================================
$('#ModalDetailBlog').on('show.bs.modal', function (event) {
    let id = $(event.relatedTarget).data('id');
    let container = $('#FormDetailBlog');

    container.html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary"></div>
            <div class="small mt-2">Memuat detail blog...</div>
        </div>
    `);

    $.ajax({
        url: '_Page/Blog/FormDetailBlog.php',
        type: 'POST',
        data: { id_blog: id },

        success: function (response) {
            container.html(response);
        },

        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat detail blog
                </div>
            `);
        }
    });
});


// ==========================================
// MODAL EDIT BLOG
// ==========================================
$('#ModalEditBlog').on('show.bs.modal', function (event) {
    let id = $(event.relatedTarget).data('id');
    let container = $('#FormEditBlog');
    let notif = $('#NotifikasiEditBlog');

    notif.html('');

    container.html(`
        <div class="text-center py-5">
            <div class="spinner-border spinner-border-sm text-primary"></div>
            <div class="small mt-2">Memuat data blog...</div>
        </div>
    `);

    $.ajax({
        url: '_Page/Blog/FormEditBlog.php',
        type: 'POST',
        data: { id_blog: id },

        success: function (response) {
            container.html(response);

            setTimeout(function () {
                let editor = document.querySelector('#content_blog_edit');

                if (editor) {
                    editor.innerHTML = '';

                    quillEditBlog = new Quill('#content_blog_edit', {
                        theme: 'snow',
                        placeholder: 'Tulis konten blog...',
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['link', 'image'],
                                ['clean']
                            ]
                        }
                    });

                    let oldContent = $('#content_blog_input_edit').val() || '';
                    quillEditBlog.root.innerHTML = oldContent;
                }
            }, 200);
        },

        error: function () {
            container.html(`
                <div class="alert alert-danger">
                    Gagal memuat form edit
                </div>
            `);
        }
    });
});


// ==========================================
// SUBMIT EDIT BLOG
// ==========================================
$(document).on('submit', '#ProsesEditBlog', function (e) {
    e.preventDefault();

    let notif = $('#NotifikasiEditBlog');
    let button = $('#ButtonEditBlog');
    let originalButton = button.html();
    let modalEl = document.getElementById('ModalEditBlog');

    notif.html('');

    if (quillEditBlog) {
        $('#content_blog_input_edit').val(
            quillEditBlog.root.innerHTML
        );
    }

    let formData = new FormData(this);

    button.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
        Menyimpan...
    `);

    $.ajax({
        url: '_Page/Blog/ProsesEditBlog.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function (response) {
            button.prop('disabled', false).html(originalButton);

            if (response.status) {
                bootstrap.Modal.getInstance(modalEl).hide();

                ListBlog();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    timer: 2000,
                    showConfirmButton: false
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


// ==========================================
// HAPUS BLOG
// ==========================================
$('#ModalHapusBlog').on('show.bs.modal', function (event) {
    let id = $(event.relatedTarget).data('id');

    $('#hapus_id_Blog').val(id);
    $('#NotifikasiHapusBlog').html('');

    $('#FormHapusBlog').html(`
        <div class="text-center">
            <i class="bi bi-exclamation-triangle text-danger fs-1"></i>
            <div class="fw-bold mt-3">Apakah Anda yakin?</div>
            <small class="text-muted">
                Data blog akan dihapus permanen
            </small>
        </div>
    `);
});


// ==========================================
// SUBMIT HAPUS BLOG
// ==========================================
$(document).on('submit', '#ProsesHapusBlog', function (e) {
    e.preventDefault();

    let button = $('#ButtonHapusBlog');
    let notif = $('#NotifikasiHapusBlog');
    let originalButton = button.html();
    let modalEl = document.getElementById('ModalHapusBlog');

    notif.html('');

    let formData = new FormData(this);

    button.prop('disabled', true).html(`
        <span class="spinner-border spinner-border-sm"></span>
        Menghapus...
    `);

    $.ajax({
        url: '_Page/Blog/ProsesHapusBlog.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function (response) {
            button.prop('disabled', false).html(originalButton);

            if (response.status) {
                bootstrap.Modal.getInstance(modalEl).hide();

                ListBlog();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    timer: 2000,
                    showConfirmButton: false
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