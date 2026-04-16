<?php
include "../../_Config/Connection.php";

try {
    // Validasi ID
    if (empty($_POST['id_blog'])) {
        throw new Exception("ID Blog tidak boleh kosong");
    }

    $id_blog = (int) $_POST['id_blog'];

    // Ambil data blog
    $stmt = $Conn->prepare("
        SELECT 
            id_blog,
            blog_title,
            blog_cover,
            blog_date,
            blog_author,
            content_blog
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

    // Escape text
    $judul   = htmlspecialchars($row['blog_title'] ?? '');
    $author  = htmlspecialchars($row['blog_author'] ?? '');
    $tanggal = date('d M Y', strtotime($row['blog_date']));
    $cover   = htmlspecialchars($row['blog_cover'] ?? '');

    // Konten blog sengaja TIDAK di htmlspecialchars
    // karena berasal dari Quill (HTML)
    $konten  = $row['content_blog'] ?? '';

    // Path cover
    $cover_path = "assets/img/Content/Blog/" . $cover;

    echo '
    <div class="container-fluid">

        <!-- JUDUL -->
        <div class="mb-3">
            <h2 class="fw-bold text-dark mb-0">
                ' . $judul . '
            </h2>
        </div>

        <!-- AUTHOR + TANGGAL -->
        <div class="d-flex justify-content-between mb-4">
            <small class="text-muted fst-italic">
                <i class="bi bi-person me-1"></i>' . $author . '
            </small>

            <small class="text-muted fst-italic">
                <i class="bi bi-calendar3 me-1"></i>' . $tanggal . '
            </small>
        </div>

        <!-- COVER -->
        <div class="mb-4">
            <img 
                src="' . $cover_path . '" 
                alt="' . $judul . '"
                class="img-fluid rounded-4 shadow-sm w-100"
                style="max-height:420px; object-fit:cover;"
                onerror="this.src=\'assets/img/no-image.png\'"
            >
        </div>

        <!-- KONTEN -->
        <div class="blog-content">
            ' . $konten . '
        </div>

    </div>
    ';

} catch (Exception $e) {
    echo '
    <div class="alert alert-danger rounded-4">
        <b>Error:</b> ' . htmlspecialchars($e->getMessage()) . '
    </div>';
}
?>