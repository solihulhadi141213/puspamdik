<?php
    include "../../_Config/Connection.php";

    // validasi id
    if (empty($_POST['id_galeri'])) {
        echo '
        <div class="alert alert-danger rounded-4">
            ID galeri tidak valid
        </div>';
        exit;
    }

    $id = (int)$_POST['id_galeri'];

    try {
        $query = "SELECT * FROM galeri WHERE id_galeri = :id LIMIT 1";
        $stmt = $Conn->prepare($query);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo '
            <div class="alert alert-warning rounded-4">
                Data galeri tidak ditemukan
            </div>';
            exit;
        }

        $title = htmlspecialchars($row['galeri_title'] ?? '');
        $description = htmlspecialchars($row['galeri_description'] ?? '');
        $date = htmlspecialchars($row['galeri_date'] ?? date('Y-m-d'));
        $fileName = htmlspecialchars($row['galeri_file_name'] ?? '');
        $fileSize = htmlspecialchars($row['galeri_file_size'] ?? '0');
        $mime = htmlspecialchars($row['galeri_file_mimetype'] ?? '');

        echo '
        <input type="hidden" name="id_galeri" value="' . $id . '">

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="edit_galeri_title" class="form-label">
                    Judul Galeri
                </label>
            </div>
            <div class="col-md-9">
                <input
                    type="text"
                    name="galeri_title"
                    id="edit_galeri_title"
                    class="form-control"
                    value="' . $title . '"
                    required
                >
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="edit_galeri_date" class="form-label">
                    Tanggal
                </label>
            </div>
            <div class="col-md-9">
                <input
                    type="date"
                    name="galeri_date"
                    id="edit_galeri_date"
                    class="form-control"
                    value="' . $date . '"
                    required
                >
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="edit_galeri_description" class="form-label">
                    Deskripsi
                </label>
            </div>
            <div class="col-md-9">
                <textarea
                    name="galeri_description"
                    id="edit_galeri_description"
                    class="form-control"
                    rows="4"
                    required
                >' . $description . '</textarea>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3">
                File Saat Ini
            </div>
            <div class="col-md-9">
                <div class="alert alert-light border rounded-4 mb-0">
                    <div class="fw-semibold text-dark mb-1">
                        <i class="bi bi-image me-2"></i>' . $fileName . '
                    </div>
                    <small class="text-muted">
                        ' . $mime . ' | ' . $fileSize . ' MB
                    </small>
                    <div class="small text-danger mt-2">
                        File gambar tidak dapat diubah. Untuk mengganti file, hapus galeri lalu upload ulang.
                    </div>
                </div>
            </div>
        </div>';
        
    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger rounded-4">
            Error: ' . $e->getMessage() . '
        </div>';
    }
?>