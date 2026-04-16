<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        // validasi input
        $id_laman = trim($_POST['id_laman'] ?? '');

        if (empty($id_laman)) {
            throw new Exception("ID laman tidak valid");
        }

        // cek data laman
        $stmt = $Conn->prepare("
            SELECT cover_laman 
            FROM laman 
            WHERE id_laman = :id_laman
        ");
        $stmt->execute([
            ':id_laman' => $id_laman
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("Data laman tidak ditemukan");
        }

        // path file cover
        $file_path = "../../assets/img/Content/Laman/" . $data['cover_laman'];

        // hapus file jika ada
        if (!empty($data['cover_laman']) && file_exists($file_path)) {
            unlink($file_path);
        }

        // hapus data database
        $delete = $Conn->prepare("
            DELETE FROM laman 
            WHERE id_laman = :id_laman
        ");

        $delete->execute([
            ':id_laman' => $id_laman
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Data laman berhasil dihapus'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>