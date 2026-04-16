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

        $stmt = $Conn->prepare("SELECT * FROM event WHERE id_event = :id LIMIT 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo '<div class="alert alert-warning text-center">Data tidak ditemukan</div>';
            exit;
        }

        $nama      = htmlspecialchars($data['nama_event']);
        $tanggal   = date('d M Y', strtotime($data['tanggal_event']));
        $pemateri  = htmlspecialchars($data['nama_pemateri']);
        $cover     = $data['cover_event'];

        $coverPath = !empty($cover)
            ? "assets/img/Content/Event/".$cover
            : "assets/img/Content/Event/No-Image.png";

        echo '
        <div class="text-center">

            <img src="'.$coverPath.'" 
                style="width:100%; max-height:200px; object-fit:cover; border-radius:10px;">

            <h5 class="mt-3 text-dark">'.$nama.'</h5>

            <div class="text-muted small">
                <i class="bi bi-calendar"></i> '.$tanggal.'
            </div>

            <div class="text-muted small">
                <i class="bi bi-person"></i> '.$pemateri.'
            </div>

            <hr>

            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i><br>
                Apakah Anda yakin ingin menghapus event ini?
            </div>

        </div>
        ';

    } catch (Exception $e) {
        echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
    }
?>