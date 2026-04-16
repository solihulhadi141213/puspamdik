<?php
include "../../_Config/Connection.php";

$id_testimoni = $_POST['id_testimoni'] ?? '';

if (empty($id_testimoni)) {
    echo '<div class="alert alert-danger">ID tidak valid</div>';
    exit;
}

$stmt = $Conn->prepare("SELECT * FROM testimoni WHERE id_testimoni = :id LIMIT 1");
$stmt->bindParam(':id', $id_testimoni);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo '<div class="alert alert-warning">Data tidak ditemukan</div>';
    exit;
}
?>

<input type="hidden" name="id_testimoni" value="<?= $data['id_testimoni']; ?>">

<div class="row mb-3">
    <div class="col-12">
        <label>Nama Responden</label>
        <input type="text" name="nama_responden" class="form-control"
               value="<?= htmlspecialchars($data['nama_responden']); ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label>Tanggal Testimoni</label>
        <input type="date" name="tanggal_testimoni" class="form-control"
               value="<?= $data['tanggal_testimoni']; ?>" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label>Foto Responden</label>

        <?php if (!empty($data['foto_responden'])) { ?>
            <div class="mb-2">
                <img src="assets/img/Content/Testimoni/<?= $data['foto_responden']; ?>"
                     width="80" height="80"
                     style="object-fit:cover"
                     class="rounded-circle border">
            </div>
        <?php } ?>

        <input type="file" name="foto_responden" class="form-control">
        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label>Isi Testimoni</label>
        <textarea name="isi_testimoni" class="form-control" rows="4" required><?= htmlspecialchars($data['isi_testimoni']); ?></textarea>
    </div>
</div>