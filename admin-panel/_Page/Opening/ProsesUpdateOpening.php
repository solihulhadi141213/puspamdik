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

    $title = trim($_POST['opening_title'] ?? '');
    $content = trim($_POST['opening_content'] ?? '');

    // Validasi mandatory
    if (empty($title)) {
        response(false, 'Judul wajib diisi');
    }

    if (empty($content) || $content === '<p><br></p>') {
        response(false, 'Isi kata pembuka wajib diisi');
    }

    // Default image lama
    $newFileName = null;

    // Handle upload file
    if (isset($_FILES['opening_image']) && $_FILES['opening_image']['error'] === 0) {

        $file = $_FILES['opening_image'];

        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        $maxSize = 2 * 1024 * 1024;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($file['tmp_name']);
        $size = $file['size'];

        // Extension
        if (!in_array($ext, $allowedExt)) {
            response(false, 'Format gambar harus JPG, JPEG, PNG atau GIF');
        }

        // Mime
        if (!in_array($mime, $allowedMime)) {
            response(false, 'Mime type file tidak valid');
        }

        // Size
        if ($size > $maxSize) {
            response(false, 'Ukuran file maksimal 2 MB');
        }

        // Nama random
        $newFileName = bin2hex(random_bytes(16)) . '.' . $ext;

        $uploadDir = "../../assets/img/Content/Opening/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            response(false, 'Gagal upload file');
        }
    }

    try {
        // cek apakah data sudah ada
        $cek = $Conn->query("SELECT * FROM opening LIMIT 1");
        $existing = $cek->fetch();

        if ($existing) {
            // update
            $sql = "
                UPDATE opening
                SET
                    opening_title = :title,
                    opening_content = :content
            ";

            $params = [
                ':title' => $title,
                ':content' => $content
            ];

            if ($newFileName) {
                $sql .= ", opening_image = :image";
                $params[':image'] = $newFileName;
            }

            $sql .= " WHERE id_opening = :id";
            $params[':id'] = $existing['id_opening'];

            $stmt = $Conn->prepare($sql);
            $stmt->execute($params);

            response(true, 'Opening berhasil diperbarui');

        } else {
            // insert
            $stmt = $Conn->prepare("
                INSERT INTO opening (
                    opening_title,
                    opening_image,
                    opening_content
                ) VALUES (
                    :title,
                    :image,
                    :content
                )
            ");

            $stmt->execute([
                ':title' => $title,
                ':image' => $newFileName,
                ':content' => $content
            ]);

            response(true, 'Opening berhasil disimpan');
        }

    } catch (PDOException $e) {
        response(false, 'Database error: ' . $e->getMessage());
    }
?>