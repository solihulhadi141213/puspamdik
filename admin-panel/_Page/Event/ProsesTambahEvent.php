<?php
header('Content-Type: application/json');
require_once '../../_Config/Connection.php';

try {
    $db = new Database();
    $Conn = $db->getConnection();

    // =========================
    // VALIDASI INPUT WAJIB
    // =========================
    if (
        empty($_POST['nama_event']) ||
        empty($_POST['mode_event']) ||
        empty($_POST['tanggal_event']) ||
        empty($_POST['nama_pemateri']) ||
        empty($_POST['deskripsi_event'])
    ) {
        echo json_encode([
            "status" => "error",
            "message" => "Semua field wajib harus diisi!"
        ]);
        exit;
    }

    $nama_event      = trim($_POST['nama_event']);
    $mode_event      = $_POST['mode_event'];
    $tanggal_event   = $_POST['tanggal_event'];
    $nama_pemateri   = trim($_POST['nama_pemateri']);
    $deskripsi_event = trim($_POST['deskripsi_event']);

    // =========================
    // VALIDASI MODE
    // =========================
    if (!in_array($mode_event, ['Online','Offline','Hybrid'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Mode event tidak valid"
        ]);
        exit;
    }

    // =========================
    // VALIDASI TANGGAL
    // =========================
    $today = date('Y-m-d');
    if ($tanggal_event < $today) {
        echo json_encode([
            "status" => "error",
            "message" => "Tanggal event tidak boleh lebih kecil dari hari ini"
        ]);
        exit;
    }

    // =========================
    // VALIDASI BIAYA
    // =========================
    $biaya_event = isset($_POST['biiaya_event']) && is_numeric($_POST['biiaya_event'])
        ? (int)$_POST['biiaya_event']
        : 0;

    // =========================
    // SETTING UPLOAD
    // =========================
    $uploadDir = "../../assets/img/Content/Event/";
    $allowed   = ['jpg','jpeg','png','gif'];
    $maxSize   = 2 * 1024 * 1024; // 2MB

    // =========================
    // VALIDASI COVER (WAJIB)
    // =========================
    if (!isset($_FILES['cover_event']) || $_FILES['cover_event']['error'] !== 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Cover event wajib diupload"
        ]);
        exit;
    }

    $coverFile   = $_FILES['cover_event'];
    $coverExt    = strtolower(pathinfo($coverFile['name'], PATHINFO_EXTENSION));
    $coverSize   = $coverFile['size'];
    $coverTmp    = $coverFile['tmp_name'];

    if (!in_array($coverExt, $allowed)) {
        echo json_encode([
            "status" => "error",
            "message" => "Format cover harus JPG, PNG, atau GIF"
        ]);
        exit;
    }

    if ($coverSize > $maxSize) {
        echo json_encode([
            "status" => "error",
            "message" => "Ukuran cover maksimal 2 MB"
        ]);
        exit;
    }

    // rename cover
    $coverName = "EVENT_" . time() . "_" . rand(100,999) . "." . $coverExt;
    $coverPath = $uploadDir . $coverName;

    if (!move_uploaded_file($coverTmp, $coverPath)) {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal upload cover event"
        ]);
        exit;
    }

    // =========================
    // VALIDASI FOTO PEMATERI (OPTIONAL)
    // =========================
    $fotoName = null;

    if (isset($_FILES['foto_pemateri']) && $_FILES['foto_pemateri']['error'] === 0) {

        $fotoFile = $_FILES['foto_pemateri'];
        $fotoExt  = strtolower(pathinfo($fotoFile['name'], PATHINFO_EXTENSION));
        $fotoSize = $fotoFile['size'];
        $fotoTmp  = $fotoFile['tmp_name'];

        if (!in_array($fotoExt, $allowed)) {
            echo json_encode([
                "status" => "error",
                "message" => "Format foto pemateri harus JPG, PNG, atau GIF"
            ]);
            exit;
        }

        if ($fotoSize > $maxSize) {
            echo json_encode([
                "status" => "error",
                "message" => "Ukuran foto pemateri maksimal 2 MB"
            ]);
            exit;
        }

        $fotoName = "PEMATERI_" . time() . "_" . rand(100,999) . "." . $fotoExt;
        $fotoPath = $uploadDir . $fotoName;

        if (!move_uploaded_file($fotoTmp, $fotoPath)) {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal upload foto pemateri"
            ]);
            exit;
        }
    }

    // =========================
    // INSERT DATABASE
    // =========================
    $insert = $Conn->prepare("
        INSERT INTO event (
            nama_event,
            mode_event,
            tanggal_event,
            biiaya_event,
            nama_pemateri,
            foto_pemateri,
            deskripsi_event,
            cover_event
        ) VALUES (
            :nama_event,
            :mode_event,
            :tanggal_event,
            :biiaya_event,
            :nama_pemateri,
            :foto_pemateri,
            :deskripsi_event,
            :cover_event
        )
    ");

    $insert->execute([
        ':nama_event'      => $nama_event,
        ':mode_event'      => $mode_event,
        ':tanggal_event'   => $tanggal_event,
        ':biiaya_event'    => $biaya_event,
        ':nama_pemateri'   => $nama_pemateri,
        ':foto_pemateri'   => $fotoName,
        ':deskripsi_event' => $deskripsi_event,
        ':cover_event'     => $coverName
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Event berhasil ditambahkan"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Terjadi kesalahan: " . $e->getMessage()
    ]);
}
?>