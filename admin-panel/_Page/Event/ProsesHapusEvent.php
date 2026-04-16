<?php
require_once '../../_Config/Connection.php';

header('Content-Type: application/json');

try {

    if (empty($_POST['id_event'])) {
        echo json_encode([
            'status' => 'warning',
            'message' => 'ID tidak ditemukan'
        ]);
        exit;
    }

    $id = $_POST['id_event'];

    $db = new Database();
    $Conn = $db->getConnection();

    // =========================
    // AMBIL DATA FILE
    // =========================
    $stmt = $Conn->prepare("SELECT cover_event, foto_pemateri FROM event WHERE id_event = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode([
            'status' => 'warning',
            'message' => 'Data tidak ditemukan'
        ]);
        exit;
    }

    $cover = $data['cover_event'];
    $foto  = $data['foto_pemateri'];

    $path = '../../assets/img/Content/Event/';

    // =========================
    // HAPUS FILE COVER
    // =========================
    if (!empty($cover) && file_exists($path.$cover)) {
        unlink($path.$cover);
    }

    // =========================
    // HAPUS FOTO PEMATERI
    // =========================
    if (!empty($foto) && file_exists($path.$foto)) {
        unlink($path.$foto);
    }

    // =========================
    // HAPUS DATABASE
    // =========================
    $delete = $Conn->prepare("DELETE FROM event WHERE id_event = :id");
    $delete->bindParam(':id', $id);
    $delete->execute();

    echo json_encode([
        'status' => 'success',
        'message' => 'Event berhasil dihapus'
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => 'danger',
        'message' => $e->getMessage()
    ]);

}
?>