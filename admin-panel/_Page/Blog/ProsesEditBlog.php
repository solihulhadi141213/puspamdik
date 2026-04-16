<?php
header('Content-Type: application/json');

include "../../_Config/Connection.php";

try {
    $id_blog      = (int) ($_POST['id_blog'] ?? 0);
    $blog_title   = trim($_POST['blog_title'] ?? '');
    $blog_date    = trim($_POST['blog_date'] ?? '');
    $blog_author  = trim($_POST['blog_author'] ?? '');
    $content_blog = trim($_POST['content_blog_input'] ?? '');
    $old_cover    = trim($_POST['old_blog_cover'] ?? '');

    if (empty($id_blog)) {
        throw new Exception("ID Blog tidak valid");
    }

    if (empty($blog_title)) {
        throw new Exception("Judul blog wajib diisi");
    }

    if (empty($blog_date)) {
        throw new Exception("Tanggal wajib diisi");
    }

    if (empty($blog_author)) {
        throw new Exception("Penulis wajib diisi");
    }

    if (empty($content_blog)) {
        throw new Exception("Konten blog wajib diisi");
    }

    $folder = "../../assets/img/Content/Blog/";
    $blog_cover = $old_cover;

    // ==========================
    // JIKA ADA COVER BARU
    // ==========================
    if (!empty($_FILES['blog_cover']['name'])) {
        $file = $_FILES['blog_cover'];

        if ($file['error'] !== 0) {
            throw new Exception("Gagal upload cover baru");
        }

        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            throw new Exception("Format cover harus JPG, PNG, atau GIF");
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran cover maksimal 2 MB");
        }

        $blog_cover = 'blog_' . time() . '_' . rand(1000,9999) . '.' . $ext;
        $upload_path = $folder . $blog_cover;

        if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
            throw new Exception("Gagal menyimpan cover baru");
        }

        // hapus cover lama
        $old_path = $folder . $old_cover;
        if (!empty($old_cover) && file_exists($old_path)) {
            unlink($old_path);
        }
    }

    // ==========================
    // UPDATE DATABASE
    // ==========================
    $stmt = $Conn->prepare("
        UPDATE blog SET
            blog_title = :blog_title,
            blog_cover = :blog_cover,
            blog_date = :blog_date,
            blog_author = :blog_author,
            content_blog = :content_blog
        WHERE id_blog = :id_blog
    ");

    $stmt->execute([
        ':blog_title'   => $blog_title,
        ':blog_cover'   => $blog_cover,
        ':blog_date'    => $blog_date,
        ':blog_author'  => $blog_author,
        ':content_blog' => $content_blog,
        ':id_blog'      => $id_blog
    ]);

    echo json_encode([
        'status' => true,
        'message' => 'Blog berhasil diperbarui'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
?>