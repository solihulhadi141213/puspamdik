<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        // Validasi input
        if (empty($_POST['id_pengurus'])) {
            echo json_encode([
                'status' => false,
                'message' => 'ID pengurus tidak valid'
            ]);
            exit;
        }

        $id_pengurus = (int) $_POST['id_pengurus'];

        // Ambil data pengurus
        $stmt = $Conn->prepare("
            SELECT foto_pengurus 
            FROM pengurus 
            WHERE id_pengurus = :id_pengurus
            LIMIT 1
        ");

        $stmt->execute([
            ':id_pengurus' => $id_pengurus
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode([
                'status' => false,
                'message' => 'Data pengurus tidak ditemukan'
            ]);
            exit;
        }

        $foto_pengurus = $row['foto_pengurus'];

        // Hapus file foto jika ada
        if (!empty($foto_pengurus)) {
            $file_path = "../../assets/img/Pengurus/" . $foto_pengurus;

            if (file_exists($file_path) && is_file($file_path)) {
                unlink($file_path);
            }
        }

        // Hapus data database
        $delete = $Conn->prepare("
            DELETE FROM pengurus 
            WHERE id_pengurus = :id_pengurus
        ");

        $delete->execute([
            ':id_pengurus' => $id_pengurus
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Data pengurus berhasil dihapus'
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>