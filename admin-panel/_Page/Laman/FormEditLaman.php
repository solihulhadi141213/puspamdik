<?php
    include "../../_Config/Connection.php";

    try {
        if (empty($_POST['id_laman'])) {
            echo '
            <div class="alert alert-danger">
                ID laman tidak valid
            </div>';
            exit;
        }

        $id_laman = trim($_POST['id_laman']);

        $query = $Conn->prepare("
            SELECT *
            FROM laman
            WHERE id_laman = :id_laman
            LIMIT 1
        ");

        $query->execute([
            ':id_laman' => $id_laman
        ]);

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo '
            <div class="alert alert-warning">
                Data laman tidak ditemukan
            </div>';
            exit;
        }

        $judul_laman = htmlspecialchars($row['judul_laman'] ?? '');
        $kategori_laman = htmlspecialchars($row['kategori_laman'] ?? '');
        $date_laman = htmlspecialchars($row['date_laman'] ?? '');
        $cover_laman = htmlspecialchars($row['cover_laman'] ?? '');
        $konten_laman = $row['konten_laman'] ?? '';

        $coverPath = "assets/img/Content/Laman/" . $cover_laman;

        echo '
        <input type="hidden" name="id_laman" value="' . $id_laman . '">

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Judul Laman</label>
            </div>
            <div class="col-md-9">
                <input type="text"
                       name="judul_laman"
                       class="form-control"
                       value="' . $judul_laman . '"
                       required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Kategori</label>
            </div>
            <div class="col-md-9">
                <input type="text"
                       name="kategori_laman"
                       class="form-control"
                       value="' . $kategori_laman . '"
                       required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Tanggal</label>
            </div>
            <div class="col-md-9">
                <input type="date"
                       name="date_laman"
                       class="form-control"
                       value="' . $date_laman . '"
                       required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Cover Baru</label>
            </div>
            <div class="col-md-9">
                <input type="file"
                       name="cover_laman"
                       class="form-control">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti cover
                </small>

                <div class="mt-2">
                    <img src="' . $coverPath . '"
                         class="img-fluid rounded-3"
                         style="max-height:200px;"
                         onerror="this.src=\'assets/img/no-image.png\'">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label>Konten Laman</label>
                <div id="konten_laman_edit" style="height:300px;"></div>

                <input type="hidden"
                       id="konten_laman_old"
                       value="' . htmlspecialchars($konten_laman, ENT_QUOTES) . '">

                <input type="hidden"
                       name="konten_laman_input"
                       id="konten_laman_input_edit">
            </div>
        </div>';
        
    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger">
            Database Error: ' . htmlspecialchars($e->getMessage()) . '
        </div>';
    }
?>