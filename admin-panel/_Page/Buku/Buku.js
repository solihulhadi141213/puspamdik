$(document).ready(function () {

    // =========================
    // LOAD DATA BUKU
    // =========================
    function LoadTabelBuku() {
        $("#TabelBuku").html('<div class="text-center p-5">Loading...</div>');

        $.ajax({
            url: "_Page/Buku/TabelBuku.php",
            method: "GET",
            success: function (data) {
                $("#TabelBuku").html(data);
            },
            error: function () {
                $("#TabelBuku").html('<div class="text-danger text-center">Gagal memuat data</div>');
            }
        });
    }

    // pertama kali load
    LoadTabelBuku();



    // =========================
    // VALIDASI FILE COVER
    // =========================
    $("#cover_buku").on("change", function () {
        let file = this.files[0];

        if (file) {
            let ext = file.name.split('.').pop().toLowerCase();
            let allowed = ['jpg', 'jpeg', 'png', 'gif'];
            let size = file.size / 1024 / 1024; // MB

            if (!allowed.includes(ext)) {
                alert("Format file harus JPG, PNG, atau GIF");
                $(this).val('');
                return;
            }

            if (size > 2) {
                alert("Ukuran file maksimal 2 MB");
                $(this).val('');
                return;
            }
        }
    });



    // =========================
    // SUBMIT TAMBAH BUKU
    // =========================
    $("#ProsesTambahBuku").submit(function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let btn = $("#ButtonTambahBuku");

        // SIMPAN TEXT ASLI
        let originalText = btn.html();

        // LOADING
        btn.prop("disabled", true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...');

        $.ajax({
            url: "_Page/Buku/ProsesTambahBuku.php",
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
                    $("#ModalTambahBuku").modal("hide");

                    // RESET FORM
                    form.reset();

                    // TOAST SUCCESS
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // RELOAD TABEL
                    LoadTabelBuku();

                } else {

                    // ERROR DI FORM
                    $("#NotifikasiTambahBuku").html(
                        '<div class="alert alert-danger">' + res.message + '</div>'
                    );
                }
            },

            error: function () {

                btn.prop("disabled", false);
                btn.html(originalText);

                $("#NotifikasiTambahBuku").html(
                    '<div class="alert alert-danger">Terjadi kesalahan server</div>'
                );
            }
        });
    });



    // =========================
    // MODAL DETAIL BUKU
    // =========================
    $(document).on("click", ".BtnDetailBuku", function () {
        let id = $(this).data("id");

        $("#FormDetailBuku").html("Loading...");

        $.ajax({
            url: "_Page/Buku/FormDetailBuku.php",
            method: "POST",
            data: { id_buku: id },
            success: function (data) {
                $("#FormDetailBuku").html(data);
            }
        });
    });



    // =========================
    // MODAL EDIT BUKU
    // =========================
    $(document).on("click", ".BtnEditBuku", function () {
        let id = $(this).data("id");

        $("#FormEditBuku").html("Loading...");

        $.ajax({
            url: "_Page/Buku/FormEditBuku.php",
            method: "POST",
            data: { id_buku: id },
            success: function (data) {
                $("#FormEditBuku").html(data);
            }
        });
    });



    // =========================
    // SUBMIT EDIT BUKU (JSON)
    // =========================
    $("#ProsesEditBuku").submit(function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let btn = $("#ButtonEditBuku");

        // SIMPAN TEXT ASLI
        let originalText = btn.html();

        // LOADING STATE
        btn.prop("disabled", true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...');

        $.ajax({
            url: "_Page/Buku/ProsesEditBuku.php",
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
                    $("#ModalEditBuku").modal("hide");

                    // TOAST SUCCESS
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // RELOAD TABEL
                    LoadTabelBuku();

                } else {

                    // ERROR NOTIF DI FORM
                    $("#NotifikasiEditBuku").html(
                        '<div class="alert alert-danger">' + res.message + '</div>'
                    );
                }
            },

            error: function () {

                btn.prop("disabled", false);
                btn.html(originalText);

                $("#NotifikasiEditBuku").html(
                    '<div class="alert alert-danger">Terjadi kesalahan server</div>'
                );
            }
        });
    });


    // =========================
    // MODAL HAPUS BUKU
    // =========================
    $(document).on("click", ".BtnHapusBuku", function () {
        let id = $(this).data("id");

        $("#hapus_id_buku").val(id);

        $("#FormHapusBuku").html("Loading...");

        $.ajax({
            url: "_Page/Buku/FormHapusBuku.php",
            method: "POST",
            data: { id_buku: id },
            success: function (data) {
                $("#FormHapusBuku").html(data);
            }
        });
    });



    // =========================
    // SUBMIT HAPUS BUKU (JSON)
    // =========================
    $("#ProsesHapusBuku").submit(function (e) {
        e.preventDefault();

        let form = this;
        let formData = $(form).serialize();
        let btn = $("#ButtonHapusBuku");

        // SIMPAN TEXT ASLI
        let originalText = btn.html();

        // LOADING
        btn.prop("disabled", true);
        btn.html('<span class="spinner-border spinner-border-sm"></span> Loading...');

        $.ajax({
            url: "_Page/Buku/ProsesHapusBuku.php",
            method: "POST",
            data: formData,
            dataType: "json",

            success: function (res) {

                // KEMBALIKAN BUTTON
                btn.prop("disabled", false);
                btn.html(originalText);

                if (res.status === "success") {

                    // TUTUP MODAL
                    $("#ModalHapusBuku").modal("hide");

                    // TOAST SUCCESS
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // RELOAD TABEL
                    LoadTabelBuku();

                } else {

                    // ERROR DI FORM
                    $("#NotifikasiHapusBuku").html(
                        '<div class="alert alert-danger">' + res.message + '</div>'
                    );
                }
            },

            error: function () {

                btn.prop("disabled", false);
                btn.html(originalText);

                $("#NotifikasiHapusBuku").html(
                    '<div class="alert alert-danger">Terjadi kesalahan server</div>'
                );
            }
        });
    });

});