<?php
    require_once '../../_Config/Connection.php';

    if (empty($_POST['id'])) {
        echo '<div class="alert alert-danger">ID tidak ditemukan</div>';
        exit;
    }

    $id = $_POST['id'];

    try {
        $db = new Database();
        $Conn = $db->getConnection();

        $query = "SELECT * FROM event WHERE id_event = :id LIMIT 1";
        $stmt = $Conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo '<div class="alert alert-warning">Data tidak ditemukan</div>';
            exit;
        }

        // =========================
        // AMBIL DATA
        // =========================
        $nama       = htmlspecialchars($data['nama_event']);
        $mode       = $data['mode_event'];
        $tanggal    = date('d M Y', strtotime($data['tanggal_event']));
        $biaya      = $data['biiaya_event'];
        $pemateri   = htmlspecialchars($data['nama_pemateri']);
        $foto       = $data['foto_pemateri'];
        $cover      = $data['cover_event'];
        $deskripsi  = nl2br($data['deskripsi_event']);

        // =========================
        // PATH GAMBAR
        // =========================
        $coverPath = !empty($cover)
            ? "assets/img/Content/Event/" . $cover
            : "assets/img/Content/Event/No-Image.png";

        $fotoPemateri = !empty($foto)
            ? "assets/img/Content/Event/" . $foto
            : "assets/img/Content/Event/No-Image.png";

        // =========================
        // FORMAT BIAYA
        // =========================
        $biayaText = ($biaya > 0)
            ? "Rp " . number_format($biaya, 0, ',', '.')
            : "Gratis";

        // =========================
        // BADGE MODE
        // =========================
        $badge = "secondary";
        if ($mode == "Online") $badge = "success";
        if ($mode == "Offline") $badge = "danger";
        if ($mode == "Hybrid") $badge = "primary";

        echo '
        <div class="card border-0">

            <!-- COVER -->
            <div style="height:250px; overflow:hidden;">
                <img src="'.$coverPath.'" 
                    style="width:100%; height:100%; object-fit:cover;">
            </div>

            <div class="card-body">

                <span class="badge bg-'.$badge.' mb-2">'.$mode.'</span>

                <h4>'.$nama.'</h4>

                <div class="mb-2 text-muted">
                    <i class="bi bi-calendar"></i> '.$tanggal.'
                </div>

                <div class="mb-3">
                    <strong>Biaya:</strong> '.$biayaText.'
                </div>

                <hr>

                <div class="d-flex align-items-center mb-3">
                    <img src="'.$fotoPemateri.'" 
                        style="width:60px; height:60px; object-fit:cover; border-radius:50%; margin-right:10px;">
                    <div>
                        <div class="fw-bold">'.$pemateri.'</div>
                        <small class="text-muted">Pemateri</small>
                    </div>
                </div>

                <hr>

                <div>
                    '.$deskripsi.'
                </div>

            </div>
        </div>
        ';

    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: '.$e->getMessage().'</div>';
    }
?>