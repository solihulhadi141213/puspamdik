<?php
header('Content-Type: application/json');
include "../../_Config/Connection.php";

try {

    // =========================
    // VALIDASI ID
    // =========================
    if (empty($_POST['id_buku'])) {
        echo json_encode([
            "status" => "error",
            "message" => "ID buku tidak valid"
        ]);
        exit;
    }

    $id_buku = (int)$_POST['id_buku'];

    // =========================
    // AMBIL DATA
    // =========================
    $get = $Conn->prepare("SELECT cover_buku FROM buku WHERE id_buku = ?");
    $get->execute([$id_buku]);
    $row = $get->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode([
            "status" => "error",
            "message" => "Data tidak ditemukan"
        ]);
        exit;
    }

    $cover = $row['cover_buku'];
    $filePath = "../../assets/img/Content/Buku/" . $cover;

    // =========================
    // HAPUS DATA
    // =========================
    $delete = $Conn->prepare("DELETE FROM buku WHERE id_buku = ?");
    $delete->execute([$id_buku]);

    // =========================
    // HAPUS FILE
    // =========================
    if (!empty($cover) && file_exists($filePath)) {
        unlink($filePath);
    }

    echo json_encode([
        "status" => "success",
        "message" => "Data buku berhasil dihapus"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>