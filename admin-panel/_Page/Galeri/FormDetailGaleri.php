<?php
    include "../../_Config/Connection.php";

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
        $desc = nl2br(htmlspecialchars($row['galeri_description'] ?? ''));
        $date = htmlspecialchars($row['galeri_date'] ?? '');
        $file = htmlspecialchars($row['galeri_file_name'] ?? '');
        $mime = htmlspecialchars($row['galeri_file_mimetype'] ?? '');
        $size = htmlspecialchars($row['galeri_file_size'] ?? '');

        $imagePath = "assets/img/Content/Galeri/" . $file;

        echo '
            <div class="row mb-3">
                <div class="col-12">
                    <img src="' . $imagePath . '" class="w-100" alt="' . $title . '">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                   <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-calendar3"></i> Tanggal
                        </div>
                        <div class="col-md-8">
                            ' . $date . '
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-file-earmark-image"></i> Format
                        </div>
                        <div class="col-md-8">
                            ' . $mime . '
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">
                            <i class="bi bi-hdd"></i> Ukuran
                        </div>
                        <div class="col-md-8">
                            ' . $size . ' MB
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="text-muted mb-2">
                            <i class="bi bi-card-text"></i> Deskripsi
                        </div>
                        <div class="lh-lg">
                            ' . $desc . '
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ';
        
    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger rounded-4">
            Error: ' . $e->getMessage() . '
        </div>';
}
?>