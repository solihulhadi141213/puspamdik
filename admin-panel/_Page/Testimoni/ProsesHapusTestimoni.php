<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";

// =====================================
// INPUT
// =====================================
$id_testimoni = $_POST['id_testimoni'] ?? '';

if (empty($id_testimoni)) {
    echo json_encode([
        "status" => false,
        "message" => "ID Testimoni tidak valid"
    ]);
    exit;
}

// =====================================
// CEK DATA
// =====================================
try {

    $stmt = $Conn->prepare("SELECT foto_responden FROM testimoni WHERE id_testimoni = :id");
    $stmt->bindParam(':id', $id_testimoni);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode([
            "status" => false,
            "message" => "Data tidak ditemukan"
        ]);
        exit;
    }

    $foto = $data['foto_responden'];

    // =====================================
    // HAPUS FILE FOTO (JIKA ADA)
    // =====================================
    if (!empty($foto)) {

        $path = "../../assets/img/Content/Testimoni/" . $foto;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    // =====================================
    // DELETE DATABASE
    // =====================================
    $delete = $Conn->prepare("DELETE FROM testimoni WHERE id_testimoni = :id");
    $delete->bindParam(':id', $id_testimoni);
    $delete->execute();

    echo json_encode([
        "status" => true,
        "message" => "Testimoni berhasil dihapus"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "status" => false,
        "message" => "Terjadi kesalahan: " . $e->getMessage()
    ]);
}