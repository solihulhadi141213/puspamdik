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

    // Validasi mandatory
    $hero_title = trim($_POST['hero_title'] ?? '');
    $hero_description = trim($_POST['hero_description'] ?? '');
    $tombol_hero = $_POST['tombol_hero'] ?? '0';
    $hero_link = trim($_POST['hero_link'] ?? '');
    $hero_link_label = trim($_POST['hero_link_label'] ?? '');

    if (empty($hero_title)) {
        response(false, 'Judul hero wajib diisi');
    }

    if (empty($hero_description)) {
        response(false, 'Deskripsi hero wajib diisi');
    }

    if (!isset($_FILES['hero_image']) || $_FILES['hero_image']['error'] !== 0) {
        response(false, 'Gambar hero wajib diupload');
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

    // Validasi file
    $file = $_FILES['hero_image'];

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif'
    ];

    $maxSize = 2 * 1024 * 1024; // 2 MB

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

    // Generate nama file
    $randomName = bin2hex(random_bytes(10)) . '.' . $extension;

    $uploadDir = "../../_assets/img/Content/Hero/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $destination = $uploadDir . $randomName;

    // Upload file
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        response(false, 'Gagal upload gambar');
    }

    try {
        $query = "
            INSERT INTO hero (
                hero_title,
                hero_description,
                hero_image,
                hero_link,
                hero_link_label
            ) VALUES (
                :hero_title,
                :hero_description,
                :hero_image,
                :hero_link,
                :hero_link_label
            )
        ";

        $stmt = $Conn->prepare($query);

        $stmt->execute([
            ':hero_title' => $hero_title,
            ':hero_description' => $hero_description,
            ':hero_image' => $randomName,
            ':hero_link' => $tombol_hero == '1' ? $hero_link : null,
            ':hero_link_label' => $tombol_hero == '1' ? $hero_link_label : null
        ]);

        response(true, 'Data hero berhasil disimpan');

    } catch (PDOException $e) {
        response(false, 'Database error: ' . $e->getMessage());
    }
?>