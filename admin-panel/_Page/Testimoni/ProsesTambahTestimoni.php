<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";

// =====================================
// INPUT
// =====================================
$nama_responden   = trim($_POST['nama_responden'] ?? '');
$tanggal_testimoni = trim($_POST['tanggal_testimoni'] ?? '');
$isi_testimoni    = trim($_POST['isi_testimoni'] ?? '');

// =====================================
// VALIDASI
// =====================================
if ($nama_responden == '') {
    echo json_encode(["status" => false, "message" => "Nama wajib diisi"]);
    exit;
}

if (strlen($nama_responden) > 255) {
    echo json_encode(["status" => false, "message" => "Nama maksimal 255 karakter"]);
    exit;
}

if ($tanggal_testimoni == '') {
    echo json_encode(["status" => false, "message" => "Tanggal wajib diisi"]);
    exit;
}

if ($isi_testimoni == '') {
    echo json_encode(["status" => false, "message" => "Isi testimoni wajib diisi"]);
    exit;
}

if (strlen($isi_testimoni) > 1000) {
    echo json_encode(["status" => false, "message" => "Maksimal 1000 karakter"]);
    exit;
}

// =====================================
// UPLOAD FOTO
// =====================================
$foto_name = null;

if (!empty($_FILES['foto_responden']['name'])) {

    $file = $_FILES['foto_responden'];

    $allowed_ext = ['jpg','jpeg','png','gif'];
    $max_size = 2 * 1024 * 1024;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo json_encode(["status" => false, "message" => "Format gambar tidak valid"]);
        exit;
    }

    if ($file['size'] > $max_size) {
        echo json_encode(["status" => false, "message" => "Maksimal 2MB"]);
        exit;
    }

    $folder = "../../assets/img/Content/Testimoni/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $foto_name = "testimoni_" . date('YmdHis') . "_" . rand(1000,9999) . "." . $ext;

    if (!move_uploaded_file($file['tmp_name'], $folder . $foto_name)) {
        echo json_encode(["status" => false, "message" => "Upload gagal"]);
        exit;
    }
}

// =====================================
// INSERT PDO
// =====================================
try {

    $sql = "INSERT INTO testimoni 
            (nama_responden, foto_responden, tanggal_testimoni, isi_testimoni)
            VALUES (:nama, :foto, :tanggal, :isi)";

    $stmt = $Conn->prepare($sql);

    $stmt->bindParam(':nama', $nama_responden);
    $stmt->bindParam(':foto', $foto_name);
    $stmt->bindParam(':tanggal', $tanggal_testimoni);
    $stmt->bindParam(':isi', $isi_testimoni);

    $stmt->execute();

    echo json_encode([
        "status" => true,
        "message" => "Testimoni berhasil ditambahkan"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "status" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}