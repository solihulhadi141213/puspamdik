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

    // Ambil data
    $id_hero = $_POST['id_hero'] ?? '';
    $hero_title = trim($_POST['hero_title'] ?? '');
    $hero_description = trim($_POST['hero_description'] ?? '');
    $tombol_hero = $_POST['tombol_hero'] ?? '0';
    $hero_link = trim($_POST['hero_link'] ?? '');
    $hero_link_label = trim($_POST['hero_link_label'] ?? '');

    // Validasi mandatory
    if (empty($id_hero)) {
        response(false, 'ID hero tidak valid');
    }

    if (empty($hero_title)) {
        response(false, 'Judul hero wajib diisi');
    }

    if (empty($hero_description)) {
        response(false, 'Deskripsi hero wajib diisi');
    }

    // Validasi tombol
    if ($tombol_hero == '1') {
        if (empty($hero_link)) {
            response(false, 'URL tombol wajib diisi');
        }

        if (empty($hero_link_label)) {
            response(false, 'Label tombol wajib diisi');
        }
    }

    // Ambil data lama
    $stmtOld = $Conn->prepare("SELECT hero_image FROM hero WHERE id_hero = :id");
    $stmtOld->execute([':id' => $id_hero]);
    $oldData = $stmtOld->fetch();

    if (!$oldData) {
        response(false, 'Data hero tidak ditemukan');
    }

    $hero_image_name = $oldData['hero_image'];

    // Handle upload file baru (optional)
    if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] === 0) {

        $file = $_FILES['hero_image'];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        $maxSize = 2 * 1024 * 1024;

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mimeType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];

        if (!in_array($extension, $allowedExtensions)) {
            response(false, 'Format file harus JPG, PNG, atau GIF');
        }

        if (!in_array($mimeType, $allowedMimeTypes)) {
            response(false, 'Mime type file tidak valid');
        }

        if ($fileSize > $maxSize) {
            response(false, 'Ukuran file maksimal 2 MB');
        }

        $newFileName = bin2hex(random_bytes(10)) . '.' . $extension;
        $uploadDir = "../../_assets/img/Content/Hero/";
        $destination = $uploadDir . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            response(false, 'Gagal upload gambar baru');
        }

        // Hapus gambar lama
        $oldFile = $uploadDir . $hero_image_name;
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        $hero_image_name = $newFileName;
    }

    // Update database
    try {
        $query = "
            UPDATE hero
            SET
                hero_title = :hero_title,
                hero_description = :hero_description,
                hero_image = :hero_image,
                hero_link = :hero_link,
                hero_link_label = :hero_link_label
            WHERE id_hero = :id_hero
        ";

        $stmt = $Conn->prepare($query);

        $stmt->execute([
            ':hero_title' => $hero_title,
            ':hero_description' => $hero_description,
            ':hero_image' => $hero_image_name,
            ':hero_link' => $tombol_hero == '1' ? $hero_link : null,
            ':hero_link_label' => $tombol_hero == '1' ? $hero_link_label : null,
            ':id_hero' => $id_hero
        ]);

        response(true, 'Proses update hero berhasil');

    } catch (PDOException $e) {
        response(false, 'Database error: ' . $e->getMessage());
    }
?>