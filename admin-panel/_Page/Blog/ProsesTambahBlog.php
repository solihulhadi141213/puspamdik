<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";

try {
    // ===============================
    // VALIDASI INPUT
    // ===============================
    $blog_title   = trim($_POST['blog_title'] ?? '');
    $blog_date    = trim($_POST['blog_date'] ?? '');
    $blog_author  = trim($_POST['blog_author'] ?? '');
    $content_blog = trim($_POST['content_blog_input'] ?? '');

    if (empty($blog_title)) {
        throw new Exception("Judul blog wajib diisi");
    }

    if (empty($blog_date)) {
        throw new Exception("Tanggal terbit wajib diisi");
    }

    if (empty($blog_author)) {
        throw new Exception("Nama penulis wajib diisi");
    }

    if (empty($content_blog)) {
        throw new Exception("Konten blog wajib diisi");
    }

    // ===============================
    // VALIDASI FILE COVER
    // ===============================
    if (!isset($_FILES['blog_cover'])) {
        throw new Exception("Cover blog wajib diupload");
    }

    $file = $_FILES['blog_cover'];

    if ($file['error'] !== 0) {
        throw new Exception("Gagal upload file cover");
    }

    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
    $allowedMime = ['image/jpeg', 'image/png', 'image/gif'];

    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($file['tmp_name']);

    if (!in_array($ext, $allowedExt)) {
        throw new Exception("Format file harus JPG, PNG, atau GIF");
    }

    if (!in_array($mime, $allowedMime)) {
        throw new Exception("Mime type file tidak valid");
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new Exception("Ukuran file maksimal 2 MB");
    }

    // ===============================
    // FOLDER UPLOAD
    // ===============================
    $folder = "../../assets/img/Content/Blog/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // ===============================
    // NAMA FILE
    // ===============================
    $blog_cover = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $upload_path = $folder . $blog_cover;

    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        throw new Exception("Gagal menyimpan file cover");
    }

    // ===============================
    // INSERT DATABASE
    // ===============================
    $stmt = $Conn->prepare("
        INSERT INTO blog (
            blog_title,
            blog_cover,
            blog_date,
            blog_author,
            content_blog
        ) VALUES (
            :blog_title,
            :blog_cover,
            :blog_date,
            :blog_author,
            :content_blog
        )
    ");

    $stmt->execute([
        ':blog_title'   => $blog_title,
        ':blog_cover'   => $blog_cover,
        ':blog_date'    => $blog_date,
        ':blog_author'  => $blog_author,
        ':content_blog' => $content_blog
    ]);

    echo json_encode([
        'status' => true,
        'message' => 'Blog berhasil ditambahkan'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
?>