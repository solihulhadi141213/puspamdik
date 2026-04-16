<?php
include "../../_Config/Connection.php";

try {
    if (empty($_POST['id_pengurus'])) {
        echo '<div class="alert alert-danger">ID Pengurus tidak valid</div>';
        exit;
    }

    $id_pengurus = (int) $_POST['id_pengurus'];

    $stmt = $Conn->prepare("
        SELECT * FROM pengurus 
        WHERE id_pengurus = :id_pengurus
        LIMIT 1
    ");
    $stmt->execute([
        ':id_pengurus' => $id_pengurus
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo '<div class="alert alert-warning">Data pengurus tidak ditemukan</div>';
        exit;
    }

    $nama_pengurus = htmlspecialchars($row['nama_pengurus']);
    $jabatan_pengurus = htmlspecialchars($row['jabatan_pengurus']);
    $foto_pengurus = htmlspecialchars($row['foto_pengurus']);

    $foto_path = "assets/img/Pengurus/" . $foto_pengurus;

    echo '
        <input type="hidden" name="id_pengurus" value="' . $id_pengurus . '">
        <input type="hidden" name="foto_lama" value="' . $foto_pengurus . '">

        <div class="row mb-3">
            <div class="col-3">Nama</div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="text" 
                       name="nama_pengurus" 
                       class="form-control"
                       value="' . $nama_pengurus . '"
                       required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3">Jabatan</div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="text" 
                       name="jabatan_pengurus" 
                       class="form-control"
                       value="' . $jabatan_pengurus . '"
                       required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3">Foto Saat Ini</div>
            <div class="col-1">:</div>
            <div class="col-8">
                <img src="' . $foto_path . '" 
                     class="img-fluid rounded border mb-2"
                     style="max-height:200px;">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3">Ganti Foto</div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="file" accept=".jpg,.jpeg,.png,.gif"
                       name="foto_pengurus" 
                       class="form-control">
                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto
                </small>
            </div>
        </div>
    ';

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
}
?>