<?php
include "../../_Config/Connection.php";

if (empty($_POST['id_buku'])) {
    echo '<div class="alert alert-danger">ID Buku tidak ditemukan</div>';
    exit;
}

$id_buku = (int)$_POST['id_buku'];

try {
    $query = $Conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
    $query->execute([$id_buku]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo '<div class="alert alert-warning">Data tidak ditemukan</div>';
        exit;
    }

    $judul = htmlspecialchars($row['judul_buku']);
    $penulis = htmlspecialchars($row['penulis_buku']);
    $cover = htmlspecialchars($row['cover_buku']);
    $imagePath = "assets/img/Content/Buku/" . $cover;

    echo '
    <input type="hidden" name="id_buku" value="' . $id_buku . '">

    <div class="text-center mb-3">
        <img src="' . $imagePath . '" 
             class="img-fluid rounded shadow-sm"
             style="max-height:180px; object-fit:cover;"
             onerror="this.src=\'assets/img/no-image.png\'">
    </div>

    <div class="alert alert-warning text-center">
        <b>Apakah Anda yakin ingin menghapus buku ini?</b>
    </div>

    <table class="table table-sm">
        <tr>
            <td width="30%">Judul</td>
            <td><b>' . $judul . '</b></td>
        </tr>
        <tr>
            <td>Penulis</td>
            <td>' . $penulis . '</td>
        </tr>
    </table>

    <div class="alert alert-danger text-center">
        <small>Data yang sudah dihapus tidak dapat dikembalikan!</small>
    </div>
    ';

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>