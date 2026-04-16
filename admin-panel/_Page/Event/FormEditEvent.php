<?php
require_once '../../_Config/Connection.php';

if (empty($_POST['id'])) {
    echo '<div class="alert alert-danger">ID tidak valid</div>';
    exit;
}

$id = $_POST['id'];

try {
    $db = new Database();
    $Conn = $db->getConnection();

    $stmt = $Conn->prepare("SELECT * FROM event WHERE id_event = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo '<div class="alert alert-warning">Data tidak ditemukan</div>';
        exit;
    }

    // DATA
    $nama       = htmlspecialchars($data['nama_event']);
    $mode       = $data['mode_event'];
    $tanggal    = $data['tanggal_event'];
    $biaya      = $data['biiaya_event'];
    $pemateri   = htmlspecialchars($data['nama_pemateri']);
    $deskripsi  = htmlspecialchars($data['deskripsi_event']);
    $cover      = $data['cover_event'];
    $foto       = $data['foto_pemateri'];

    // PATH
    $coverPath = !empty($cover)
        ? "assets/img/Content/Event/".$cover
        : "assets/img/Content/Event/No-Image.png";

    $fotoPath = !empty($foto)
        ? "assets/img/Content/Event/".$foto
        : "assets/img/Content/Event/No-Image.png";

?>
<input type="hidden" name="id_event" value="<?= $id ?>">
    <input type="hidden" name="cover_lama" value="<?= $cover ?>">
    <input type="hidden" name="foto_lama" value="<?= $foto ?>">

    <div class="row">

        <!-- NAMA -->
        <div class="col-md-12 mb-3">
            <label>Nama Event *</label>
            <input type="text" name="nama_event" class="form-control" value="<?= $nama ?>" required>
        </div>

        <!-- MODE -->
        <div class="col-md-12 mb-3">
            <label>Mode Event *</label>
            <select name="mode_event" class="form-control" required>
                <option <?= $mode=='Online'?'selected':'' ?>>Online</option>
                <option <?= $mode=='Offline'?'selected':'' ?>>Offline</option>
                <option <?= $mode=='Hybrid'?'selected':'' ?>>Hybrid</option>
            </select>
        </div>

        <!-- TANGGAL -->
        <div class="col-md-12 mb-3">
            <label>Tanggal Event *</label>
            <input type="date" name="tanggal_event" class="form-control" value="<?= $tanggal ?>" required>
        </div>

        <!-- BIAYA -->
        <div class="col-md-12 mb-3">
            <label>Biaya</label>
            <input type="number" name="biiaya_event" class="form-control" value="<?= $biaya ?>">
        </div>

        <!-- PEMATERI -->
        <div class="col-md-12 mb-3">
            <label>Nama Pemateri *</label>
            <input type="text" name="nama_pemateri" class="form-control" value="<?= $pemateri ?>" required>
        </div>

        <!-- FOTO PEMATERI -->
        <div class="col-md-12 mb-3">
            <label>Foto Pemateri</label>
            <input type="file" name="foto_pemateri" class="form-control">
            <img src="<?= $fotoPath ?>" style="width:80px; margin-top:5px;">
        </div>

        <!-- COVER -->
        <div class="col-md-12 mb-3">
            <label>Cover Event *</label>
            <input type="file" name="cover_event" class="form-control">
            <img src="<?= $coverPath ?>" style="width:120px; margin-top:5px;">
        </div>

        <!-- DESKRIPSI -->
        <div class="col-12 mb-3">
            <label>Deskripsi *</label>
            <textarea name="deskripsi_event" class="form-control" rows="4" required><?= $deskripsi ?></textarea>
        </div>

    </div>

<?php

} catch (Exception $e) {
    echo '<div class="alert alert-danger">'.$e->getMessage().'</div>';
}
?>