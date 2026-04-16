<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        $id = isset($_POST['id_galeri']) ? (int)$_POST['id_galeri'] : 0;

        if ($id <= 0) {
            echo json_encode([
                'status' => false,
                'message' => 'ID galeri tidak valid'
            ]);
            exit;
        }

        // ambil data file
        $stmt = $Conn->prepare("
            SELECT galeri_file_name
            FROM galeri
            WHERE id_galeri = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode([
                'status' => false,
                'message' => 'Data galeri tidak ditemukan'
            ]);
            exit;
        }

        $fileName = $row['galeri_file_name'] ?? '';
        $filePath = "../../assets/img/Content/Galeri/" . $fileName;

        // hapus dari database
        $delete = $Conn->prepare("
            DELETE FROM galeri
            WHERE id_galeri = :id
        ");
        $delete->execute([':id' => $id]);

        // hapus file
        if (!empty($fileName) && file_exists($filePath)) {
            unlink($filePath);
        }

        echo json_encode([
            'status' => true,
            'message' => 'Galeri berhasil dihapus'
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
?>