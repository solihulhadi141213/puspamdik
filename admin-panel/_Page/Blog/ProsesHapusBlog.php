<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        // Validasi ID
        if (empty($_POST['id_Blog'])) {
            throw new Exception("ID blog tidak valid");
        }

        $id_blog = (int) $_POST['id_Blog'];

        // Ambil data blog terlebih dahulu
        $stmt = $Conn->prepare("
            SELECT blog_cover
            FROM blog
            WHERE id_blog = :id_blog
            LIMIT 1
        ");
        $stmt->execute([
            ':id_blog' => $id_blog
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception("Data blog tidak ditemukan");
        }

        $blog_cover = $row['blog_cover'] ?? '';

        // Hapus file cover jika ada
        if (!empty($blog_cover)) {
            $file_path = "../../assets/img/Content/Blog/" . $blog_cover;

            if (file_exists($file_path) && is_file($file_path)) {
                unlink($file_path);
            }
        }

        // Hapus data database
        $delete = $Conn->prepare("
            DELETE FROM blog
            WHERE id_blog = :id_blog
        ");

        $delete->execute([
            ':id_blog' => $id_blog
        ]);

        if ($delete->rowCount() <= 0) {
            throw new Exception("Gagal menghapus data blog");
        }

        echo json_encode([
            'status' => true,
            'message' => 'Blog berhasil dihapus'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>