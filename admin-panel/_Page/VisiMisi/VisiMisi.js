$(document).ready(function () {
    // ================================
    // Inisialisasi Quill Editor
    // ================================
    const quillVisi = new Quill('#visi_editor', {
        theme: 'snow',
        placeholder: 'Tulis visi...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    const quillMisi = new Quill('#misi_editor', {
        theme: 'snow',
        placeholder: 'Tulis misi...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    // ================================
    // Function tampil data
    // ================================
    function loadVisiMisi() {
        $.ajax({
            url: '_Page/VisiMisi/GetVisiMisi.php',
            type: 'GET',
            dataType: 'JSON',
            success: function (response) {
                if (response.success) {
                    $('#visi_misi_title').val(response.data.visi_misi_title);

                    quillVisi.root.innerHTML = response.data.visi || '';
                    quillMisi.root.innerHTML = response.data.misi || '';
                }
            },
            error: function () {
                $('#NotifikasiSimpanVisiMisi').html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan saat memuat data visi misi.
                    </div>
                `);
            }
        });
    }

    // Load pertama kali
    loadVisiMisi();

    // ================================
    // Submit form
    // ================================
    $('#ProsesSimpanVisiMisi').on('submit', function () {
        let button = $('#ButtonSimpanVisiMisi');
        let notif = $('#NotifikasiSimpanVisiMisi');

        notif.html('');

        // Loading button
        button.prop('disabled', true);
        button.html(`
            <span class="spinner-border spinner-border-sm me-2"></span>
            Menyimpan...
        `);

        let formData = {
            visi_misi_title: $('#visi_misi_title').val(),
            visi: quillVisi.root.innerHTML,
            misi: quillMisi.root.innerHTML
        };

        $.ajax({
            url: '_Page/VisiMisi/ProsesSimpanVisiMisi.php',
            type: 'POST',
            data: formData,
            dataType: 'JSON',

            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message || 'Data berhasil disimpan',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    loadVisiMisi();
                } else {
                    notif.html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function (xhr) {
                let errorMessage = 'Terjadi kesalahan pada server';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                notif.html(`
                    <div class="alert alert-danger">
                        ${errorMessage}
                    </div>
                `);
            },

            complete: function () {
                button.prop('disabled', false);
                button.html(`
                    <i class="bi bi-save me-1"></i> Simpan Visi Misi
                `);
            }
        });
    });
});