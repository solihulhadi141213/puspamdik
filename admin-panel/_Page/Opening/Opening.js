let quill;

function LoadOpening() {
    $.ajax({
        url: '_Page/Opening/GetOpening.php',
        type: 'POST',
        dataType: 'json',

        success: function (response) {
            if (response.status) {

                // isi judul
                $('#opening_title').val(response.data.opening_title);

                // isi quill
                if (typeof quill !== 'undefined') {
                    quill.root.innerHTML = response.data.opening_content || '';
                }

                // isi hidden textarea
                $('#opening_content').val(response.data.opening_content || '');

                // preview gambar
                if (response.data.opening_image) {
                    $('#opening_upload_placeholder').addClass('d-none');

                    $('#opening_preview')
                        .removeClass('d-none')
                        .attr('src', response.data.opening_image);
                }
            }
        },

        error: function () {
            console.log('Gagal memuat data opening');
        }
    });
}

$(document).ready(function () {

    // Load data Pertama kali
    LoadOpening();

    // Tampilkan Quill
    quill = new Quill('#opening_editor', {
        theme: 'snow',
        placeholder: 'Tulis kata pembuka...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ header: [1, 2, false] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    // Sinkron ke textarea saat submit
    $('#ProsesSimpanOpening').on('submit', function () {
        $('#opening_content').val(
            quill.root.innerHTML
        );
    });

    // Menmap[ilkan Image Realtime
    $(document).on('change', '#opening_image', function () {
        const file = this.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            $('#opening_upload_placeholder').addClass('d-none');
            $('#opening_preview')
                .removeClass('d-none')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });

    // Handdle Submit
    $(document).on('submit', '#ProsesSimpanOpening', function (e) {
        e.preventDefault();

        let form = $('#ProsesSimpanOpening')[0];
        let formData = new FormData(form);

        let button = $('#ButtonSimpanOpening');
        let notifikasi = $('#NotifikasiSimpanOpening');
        let buttonDefault = button.html();

        // Ambil konten Quill
        if (typeof quill !== 'undefined') {
            $('#opening_content').val(quill.root.innerHTML);
            formData.set('opening_content', quill.root.innerHTML);
        }

        // Reset notifikasi
        notifikasi.html('');

        // Loading button
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        $.ajax({
            url: '_Page/Opening/ProsesUpdateOpening.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                button.prop('disabled', false).html(buttonDefault);

                if (response.status) {
                    notifikasi.html('');

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
                button.prop('disabled', false).html(buttonDefault);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan server
                    </div>
                `);
            }
        });
    });

});