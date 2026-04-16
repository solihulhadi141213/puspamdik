<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";

// =====================================
// INPUT
// =====================================
$id_testimoni   = $_POST['id_testimoni'] ?? '';
$nama_responden = trim($_POST['nama_responden'] ?? '');
$tanggal_testimoni = $_POST['tanggal_testimoni'] ?? '';
$isi_testimoni  = trim($_POST['isi_testimoni'] ?? '');

// =====================================
// VALIDASI
// =====================================
if (empty($id_testimoni)) {
    echo json_encode(["status" => false, "message" => "ID tidak valid"]);
    exit;
}

if ($nama_responden == '') {
    echo json_encode(["status" => false, "message" => "Nama wajib diisi"]);
    exit;
}

if ($isi_testimoni == '') {
    echo json_encode(["status" => false, "message" => "Isi testimoni wajib diisi"]);
    exit;
}

// =====================================
// CEK DATA LAMA
// =====================================
$stmt = $Conn->prepare("SELECT foto_responden FROM testimoni WHERE id_testimoni = :id");
$stmt->bindParam(':id', $id_testimoni);
$stmt->execute();
$old = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$old) {
    echo json_encode(["status" => false, "message" => "Data tidak ditemukan"]);
    exit;
}

$foto_lama = $old['foto_responden'];

// =====================================
// HANDLE UPLOAD FOTO BARU
// =====================================
$foto_baru = $foto_lama;

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

    $foto_baru = "testimoni_" . date('YmdHis') . "_" . rand(1000,9999) . "." . $ext;

    if (!move_uploaded_file($file['tmp_name'], $folder . $foto_baru)) {
        echo json_encode(["status" => false, "message" => "Upload gagal"]);
        exit;
    }

    // Hapus foto lama
    if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
        unlink($folder . $foto_lama);
    }
}

// =====================================
// UPDATE DATA
// =====================================
try {

    $sql = "UPDATE testimoni SET
                nama_responden = :nama,
                foto_responden = :foto,
                tanggal_testimoni = :tanggal,
                isi_testimoni = :isi
            WHERE id_testimoni = :id";

    $stmt = $Conn->prepare($sql);

    $stmt->bindParam(':nama', $nama_responden);
    $stmt->bindParam(':foto', $foto_baru);
    $stmt->bindParam(':tanggal', $tanggal_testimoni);
    $stmt->bindParam(':isi', $isi_testimoni);
    $stmt->bindParam(':id', $id_testimoni);

    $stmt->execute();

    echo json_encode([
        "status" => true,
        "message" => "Testimoni berhasil diperbarui"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "status" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}