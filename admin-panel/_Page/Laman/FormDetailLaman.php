<?php
    include "../../_Config/Connection.php";

    try {
        // validasi id
        if (empty($_POST['id_laman'])) {
            echo '
            <div class="alert alert-danger rounded-4">
                ID laman tidak valid
            </div>';
            exit;
        }

        $id_laman = trim($_POST['id_laman']);

        $query = $Conn->prepare("
            SELECT 
                id_laman,
                judul_laman,
                kategori_laman,
                date_laman,
                cover_laman,
                konten_laman
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
            <div class="alert alert-warning rounded-4">
                Data laman tidak ditemukan
            </div>';
            exit;
        }

        $judul_laman    = htmlspecialchars($row['judul_laman'] ?? '');
        $kategori_laman = htmlspecialchars($row['kategori_laman'] ?? '');
        $tanggal        = date('d F Y', strtotime($row['date_laman']));
        $cover_laman    = htmlspecialchars($row['cover_laman'] ?? '');
        
        // konten jangan htmlspecialchars agar HTML Quill bisa dirender
        $konten_laman   = $row['konten_laman'] ?? '';

        // path cover
        $coverPath = "assets/img/Content/Laman/" . $cover_laman;

        echo '
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        ' . $kategori_laman . '
                    </span>
                </div>

                <h3 class="fw-bold text-dark mb-3">
                    ' . $judul_laman . '
                </h3>

                <div class="text-muted mb-4">
                    <i class="bi bi-calendar3 me-1"></i>
                    ' . $tanggal . '
                </div>

                <hr>
                <img 
                    src="' . $coverPath . '" 
                    class="img-fluid rounded-4 shadow-sm w-100 mb-3"
                    style="max-height:420px; object-fit:cover;"
                    alt="' . $judul_laman . '"
                    onerror="this.src=\'assets/img/no-image.png\'"
                >
                <div class="konten-laman" style="
                    line-height:1.8;
                    font-size:15px;
                ">
                    ' . $konten_laman . '
                </div>
            </div>
        </div>';
        
    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger rounded-4">
            <b>Database Error:</b> ' . htmlspecialchars($e->getMessage()) . '
        </div>';
    }
?>