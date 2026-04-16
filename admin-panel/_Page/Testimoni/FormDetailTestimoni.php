<?php
include "../../_Config/Connection.php";

// =====================================
// VALIDASI ID
// =====================================
$id_testimoni = $_POST['id_testimoni'] ?? '';

if (empty($id_testimoni)) {
    echo '
        <div class="alert alert-danger rounded-4">
            ID Testimoni tidak valid
        </div>
    ';
    exit;
}

// =====================================
// AMBIL DATA
// =====================================
$sql = "SELECT * FROM testimoni WHERE id_testimoni = :id LIMIT 1";
$stmt = $Conn->prepare($sql);
$stmt->bindParam(':id', $id_testimoni);
$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo '
        <div class="alert alert-warning rounded-4">
            Data testimoni tidak ditemukan
        </div>
    ';
    exit;
}

// =====================================
// SET DATA
// =====================================
$nama     = htmlspecialchars($data['nama_responden']);
$tanggal  = htmlspecialchars($data['tanggal_testimoni']);
$isi      = nl2br(htmlspecialchars($data['isi_testimoni']));
$foto     = $data['foto_responden'];
?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <!-- Foto + Nama -->
        <div class="text-center mb-3">

            <?php if (!empty($foto)) { ?>
                <img src="assets/img/Content/Testimoni/<?php echo $foto; ?>"
                     class="rounded-circle shadow"
                     width="100"
                     height="100"
                     style="object-fit: cover;">
            <?php } else { ?>
                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white"
                     style="width:100px;height:100px;">
                    <i class="bi bi-person fs-2"></i>
                </div>
            <?php } ?>

            <h5 class="mt-3 mb-0"><?php echo $nama; ?></h5>
            <small class="text-muted">
                <i class="bi bi-calendar"></i>
                <?php echo date('d-m-Y', strtotime($tanggal)); ?>
            </small>
        </div>

        <hr>

        <!-- Isi Testimoni -->
        <div class="px-2">
            <h6 class="text-muted mb-2">Isi Testimoni:</h6>
            <div class="p-3 bg-light rounded-3">
                <?php echo $isi; ?>
            </div>
        </div>

    </div>
</div>