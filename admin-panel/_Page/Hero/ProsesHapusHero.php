<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    function response($status, $message)
    {
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit;
    }

    $id_hero = $_POST['id_hero'] ?? '';

    if (empty($id_hero)) {
        response(false, 'ID hero tidak valid');
    }

    try {
        // Ambil data hero
        $stmt = $Conn->prepare("
            SELECT hero_image 
            FROM hero 
            WHERE id_hero = :id
        ");
        $stmt->execute([
            ':id' => $id_hero
        ]);

        $hero = $stmt->fetch();

        if (!$hero) {
            response(false, 'Data hero tidak ditemukan');
        }

        // Hapus file gambar
        $imagePath = "../../_assets/img/Content/Hero/" . $hero['hero_image'];

        if (!empty($hero['hero_image']) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Hapus database
        $delete = $Conn->prepare("
            DELETE FROM hero 
            WHERE id_hero = :id
        ");

        $delete->execute([
            ':id' => $id_hero
        ]);

        response(true, 'Hero berhasil dihapus');

    } catch (PDOException $e) {
        response(false, 'Database error: ' . $e->getMessage());
    }
?>