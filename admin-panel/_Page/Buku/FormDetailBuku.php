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

    $harga_format = $harga > 0 ? 'Rp ' . number_format($harga, 0, ',', '.') : '-';
    $imagePath = "assets/img/Content/Buku/" . $cover;

    echo '
    <div class="row">
        <div class="col-md-4 text-center mb-3">
            <img src="' . $imagePath . '" 
                 class="img-fluid rounded shadow-sm"
                 style="max-height:250px; object-fit:cover;"
                 onerror="this.src=\'assets/img/no-image.png\'">
        </div>

        <div class="col-md-8">
            <table class="table table-bordered table-sm">
                <tr>
                    <td width="30%">Judul</td>
                    <td><b>' . $judul . '</b></td>
                </tr>
                <tr>
                    <td>Penulis</td>
                    <td>' . $penulis . '</td>
                </tr>
                <tr>
                    <td>ISBN</td>
                    <td>' . $isbn . '</td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td>' . $harga_format . '</td>
                </tr>
                <tr>
                    <td>Rating</td>
                    <td>' . $rating . '</td>
                </tr>
                <tr>
                    <td>Terjual</td>
                    <td>' . number_format($terjual) . '</td>
                </tr>
            </table>
        </div>
    </div>';

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>