<?php
    include "../../_Config/Connection.php";

    try {
        // validasi id
        if (empty($_POST['id_pengurus'])) {
            echo '
            <div class="alert alert-danger rounded-4">
                ID pengurus tidak valid
            </div>';
            exit;
        }

        $id_pengurus = (int) $_POST['id_pengurus'];

        // ambil data
        $query = $Conn->prepare("
            SELECT * 
            FROM pengurus 
            WHERE id_pengurus = :id_pengurus
            LIMIT 1
        ");

        $query->execute([
            ':id_pengurus' => $id_pengurus
        ]);

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo '
            <div class="alert alert-warning rounded-4">
                Data pengurus tidak ditemukan
            </div>';
            exit;
        }

        $nama_pengurus = htmlspecialchars($row['nama_pengurus'] ?? '');
        $jabatan_pengurus = htmlspecialchars($row['jabatan_pengurus'] ?? '');
        $foto_pengurus = htmlspecialchars($row['foto_pengurus'] ?? '');

        // path gambar
        $foto_path = "assets/img/Pengurus/" . $foto_pengurus;

        echo '
        <div class="row">
            <div class="col-md-5 mb-3">
                <img 
                    src="' . $foto_path . '" 
                    alt="' . $nama_pengurus . '" 
                    class="img-fluid rounded-4 shadow-sm border"
                    style="width:100%; max-height:350px; object-fit:cover;"
                    onerror="this.src=\'assets/img/no-image.png\'"
                >
            </div>

            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Nama Pengurus</small>
                            <h5 class="fw-bold text-dark mb-0">
                                ' . $nama_pengurus . '
                            </h5>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Jabatan</small>
                            <div class="fs-6 text-dark">
                                ' . $jabatan_pengurus . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger rounded-4">
            <b>Database Error:</b> ' . $e->getMessage() . '
        </div>';
    }
?>