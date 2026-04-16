<?php
include "../../_Config/Connection.php";

try {
    // validasi ID
    if (empty($_POST['id_blog'])) {
        throw new Exception("ID Blog tidak valid");
    }

    $id_blog = (int) $_POST['id_blog'];

    // ambil data blog
    $stmt = $Conn->prepare("
        SELECT *
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

    $judul   = htmlspecialchars($row['blog_title'] ?? '');
    $tanggal = htmlspecialchars($row['blog_date'] ?? '');
    $author  = htmlspecialchars($row['blog_author'] ?? '');
    $cover   = htmlspecialchars($row['blog_cover'] ?? '');
    $konten  = htmlspecialchars($row['content_blog'] ?? '');

    // path cover
    $cover_path = "assets/img/Content/Blog/" . $cover;

    echo '
    <input type="hidden" name="id_blog" value="' . $id_blog . '">
    <input type="hidden" name="old_blog_cover" value="' . $cover . '">

    <div class="row mb-3">
        <div class="col-12">
            <label class="form-label">Judul Blog</label>
            <input type="text"
                   name="blog_title"
                   class="form-control"
                   value="' . $judul . '"
                   required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Tanggal Terbit</label>
            <input type="date"
                   name="blog_date"
                   class="form-control"
                   value="' . $tanggal . '"
                   required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Penulis</label>
            <input type="text"
                   name="blog_author"
                   class="form-control"
                   value="' . $author . '"
                   required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label class="form-label">Cover Lama</label>
            <img src="' . $cover_path . '"
                 class="img-fluid rounded-3 border mb-2"
                 style="max-height:220px; width:100%; object-fit:cover;"
                 onerror="this.src=\'assets/img/no-image.png\'">

            <label class="form-label">Ganti Cover (Opsional)</label>
            <input type="file"
                   name="blog_cover"
                   class="form-control">

            <small class="text-muted">
                Kosongkan jika tidak ingin mengganti cover
            </small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label class="form-label">Konten Blog</label>
            <div id="content_blog_edit" style="height:300px;"></div>

            <input type="hidden"
                   name="content_blog_input"
                   id="content_blog_input_edit"
                   value=\'' . $konten . '\'>
        </div>
    </div>
    ';

} catch (Exception $e) {
    echo '
    <div class="alert alert-danger">
        ' . htmlspecialchars($e->getMessage()) . '
    </div>';
}
?>