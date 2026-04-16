<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        // =========================
        // VALIDASI FIELD MANDATORY
        // =========================
        $galeri_title = trim($_POST['galeri_title'] ?? '');
        $galeri_description = trim($_POST['galeri_description'] ?? '');
        $galeri_date = trim($_POST['galeri_date'] ?? '');

        if ($galeri_title === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Judul galeri wajib diisi'
            ]);
            exit;
        }

        if ($galeri_description === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Deskripsi wajib diisi'
            ]);
            exit;
        }

        if ($galeri_date === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Tanggal wajib diisi'
            ]);
            exit;
        }

        if (!isset($_FILES['galeri_file']) || $_FILES['galeri_file']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode([
                'status' => false,
                'message' => 'File gambar wajib diupload'
            ]);
            exit;
        }

        // =========================
        // VALIDASI FILE
        // =========================
        $file = $_FILES['galeri_file'];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        $maxSize = 2 * 1024 * 1024; // 2MB

        $originalName = $file['name'];
        $tmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $mimeType = mime_content_type($tmpName);

        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // validasi extension
        if (!in_array($extension, $allowedExtensions)) {
            echo json_encode([
                'status' => false,
                'message' => 'Format file harus JPG, JPEG, PNG, atau GIF'
            ]);
            exit;
        }

        // validasi mime
        if (!in_array($mimeType, $allowedMimeTypes)) {
            echo json_encode([
                'status' => false,
                'message' => 'Mime type file tidak valid'
            ]);
            exit;
        }

        // validasi size
        if ($fileSize > $maxSize) {
            echo json_encode([
                'status' => false,
                'message' => 'Ukuran file maksimal 2 MB'
            ]);
            exit;
        }

        // =========================
        // GENERATE NAMA FILE BARU
        // =========================
        $newFileName = bin2hex(random_bytes(16)) . '.' . $extension;

        // =========================
        // PATH UPLOAD
        // =========================
        $uploadDir = "../../assets/img/Content/Galeri/";

        // buat folder jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . $newFileName;

        // =========================
        // UPLOAD FILE
        // =========================
        if (!move_uploaded_file($tmpName, $destination)) {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal menyimpan file gambar'
            ]);
            exit;
        }

        // ukuran dalam MB
        $sizeMb = round($fileSize / 1024 / 1024, 2);

        // =========================
        // INSERT DATABASE
        // =========================
        $query = "
            INSERT INTO galeri (
                galeri_title,
                galeri_description,
                galeri_date,
                galeri_file_name,
                galeri_file_mimetype,
                galeri_file_size
            ) VALUES (
                :title,
                :description,
                :date,
                :file_name,
                :mime,
                :size
            )
        ";

        $stmt = $Conn->prepare($query);

        $stmt->execute([
            ':title' => $galeri_title,
            ':description' => $galeri_description,
            ':date' => $galeri_date,
            ':file_name' => $newFileName,
            ':mime' => $mimeType,
            ':size' => $sizeMb
        ]);

        // =========================
        // RESPONSE SUCCESS
        // =========================
        echo json_encode([
            'status' => true,
            'message' => 'Galeri berhasil ditambahkan'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>