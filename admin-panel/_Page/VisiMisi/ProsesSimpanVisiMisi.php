<?php
    include "../../_Config/Connection.php";

    header('Content-Type: application/json');

    try {
        $title = $_POST['visi_misi_title'] ?? '';
        $visi = $_POST['visi'] ?? '';
        $misi = $_POST['misi'] ?? '';

        $cek = $Conn->query("SELECT id_visi_misi FROM visi_misi LIMIT 1");
        $row = $cek->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stmt = $Conn->prepare("
                UPDATE visi_misi 
                SET visi_misi_title=?, visi=?, misi=?
                WHERE id_visi_misi=?
            ");
            $stmt->execute([$title, $visi, $misi, $row['id_visi_misi']]);
        } else {
            $stmt = $Conn->prepare("
                INSERT INTO visi_misi (visi_misi_title, visi, misi)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$title, $visi, $misi]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Visi misi berhasil disimpan'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }