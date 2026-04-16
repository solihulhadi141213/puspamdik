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

    $judul   = htmlspecialchars($row['judul_buku']);
    $penulis = htmlspecialchars($row['penulis_buku']);
    $isbn    = htmlspecialchars($row['isbn_buku']);
    $harga   = (int)$row['harga_buku'];
    $rating  = htmlspecialchars($row['reting_buku']);
    $terjual = (int)$row['terjual'];
    $cover   = htmlspecialchars($row['cover_buku']);

    $imagePath = "assets/img/Content/Buku/" . $cover;

    echo '
    <input type="hidden" name="id_buku" value="' . $id_buku . '">

    <div class="row mb-3">
        <div class="col-12">
            <label>Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" value="' . $judul . '" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label>Penulis</label>
            <input type="text" name="penulis_buku" class="form-control" value="' . $penulis . '" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label>ISBN</label>
            <input type="text" name="isbn_buku" class="form-control" value="' . $isbn . '" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label>Harga</label>
            <input type="number" name="harga_buku" class="form-control" value="' . $harga . '">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label>Rating</label>
            <select name="reting_buku" class="form-control">';

                for ($i = 0; $i <= 5; $i++) {
                    $selected = ($rating == $i) ? 'selected' : '';
                    echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                }

    echo '</select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <label>Terjual</label>
            <input type="number" name="terjual" class="form-control" value="' . $terjual . '">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 text-center">
            <img src="' . $imagePath . '" 
                 class="img-fluid rounded shadow-sm mb-2"
                 style="max-height:150px; object-fit:cover;"
                 onerror="this.src=\'assets/img/no-image.png\'">
            <small class="text-muted d-block">Cover saat ini</small>
        </div>

        <div class="col-md-8">
            <label>Ganti Cover (opsional)</label>
            <input type="file" name="cover_buku" class="form-control">
            <small class="text-secondary">Kosongkan jika tidak ingin mengganti</small>
        </div>
    </div>
    ';

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>