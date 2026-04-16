<?php
require_once '../../_Config/Connection.php';

header('Content-Type: application/json');

try {

    $db = new Database();
    $Conn = $db->getConnection();

    // =========================
    // AMBIL DATA
    // =========================
    $id         = $_POST['id_event'];
    $nama       = $_POST['nama_event'];
    $mode       = $_POST['mode_event'];
    $tanggal    = $_POST['tanggal_event'];
    $biaya      = $_POST['biiaya_event'];
    $pemateri   = $_POST['nama_pemateri'];
    $deskripsi  = $_POST['deskripsi_event'];

    $cover_lama = $_POST['cover_lama'];
    $foto_lama  = $_POST['foto_lama'];

    // =========================
    // VALIDASI
    // =========================
    if (empty($nama) || empty($mode) || empty($tanggal) || empty($pemateri) || empty($deskripsi)) {
        echo json_encode(['status'=>'warning','message'=>'Data wajib tidak boleh kosong']);
        exit;
    }

    if ($tanggal < date('Y-m-d')) {
        echo json_encode(['status'=>'warning','message'=>'Tanggal tidak boleh kurang dari hari ini']);
        exit;
    }

    $uploadDir = '../../assets/img/Content/Event/';

    // =========================
    // COVER
    // =========================
    if (!empty($_FILES['cover_event']['name'])) {

        $ext = pathinfo($_FILES['cover_event']['name'], PATHINFO_EXTENSION);
        $cover_baru = 'cover_'.time().'.'.$ext;

        move_uploaded_file($_FILES['cover_event']['tmp_name'], $uploadDir.$cover_baru);

        if (!empty($cover_lama) && file_exists($uploadDir.$cover_lama)) {
            unlink($uploadDir.$cover_lama);
        }

    } else {
        $cover_baru = $cover_lama;
    }

    // =========================
    // FOTO PEMATERI
    // =========================
    if (!empty($_FILES['foto_pemateri']['name'])) {

        $ext = pathinfo($_FILES['foto_pemateri']['name'], PATHINFO_EXTENSION);
        $foto_baru = 'pemateri_'.time().'.'.$ext;

        move_uploaded_file($_FILES['foto_pemateri']['tmp_name'], $uploadDir.$foto_baru);

        if (!empty($foto_lama) && file_exists($uploadDir.$foto_lama)) {
            unlink($uploadDir.$foto_lama);
        }

    } else {
        $foto_baru = $foto_lama;
    }

    // =========================
    // UPDATE DB
    // =========================
    $stmt = $Conn->prepare("
        UPDATE event SET
            nama_event = :nama,
            mode_event = :mode,
            tanggal_event = :tanggal,
            biiaya_event = :biaya,
            nama_pemateri = :pemateri,
            foto_pemateri = :foto,
            cover_event = :cover,
            deskripsi_event = :deskripsi
        WHERE id_event = :id
    ");

    $stmt->execute([
        ':nama' => $nama,
        ':mode' => $mode,
        ':tanggal' => $tanggal,
        ':biaya' => $biaya,
        ':pemateri' => $pemateri,
        ':foto' => $foto_baru,
        ':cover' => $cover_baru,
        ':deskripsi' => $deskripsi,
        ':id' => $id
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Data event berhasil diperbarui'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'danger',
        'message' => $e->getMessage()
    ]);
}
?>