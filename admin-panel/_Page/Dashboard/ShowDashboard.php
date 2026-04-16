<?php
    // Format JSON
    header('Content-Type: application/json');

    // Koneksi
    include "../../_Config/Connection.php";

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Fungsi bantu untuk kirim response dengan status code
    function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    try {
        // Hitung total data menggunakan PDO
        $total_hit = $Conn->query("SELECT COUNT(*) FROM visitor_logs")->fetchColumn();
        $total_blog = $Conn->query("SELECT COUNT(*) FROM blog")->fetchColumn();
        $total_laman = $Conn->query("SELECT COUNT(*) FROM laman")->fetchColumn();
        $total_newslater = $Conn->query("SELECT COUNT(*) FROM buku")->fetchColumn();

        sendResponse([
            'status' => 'success',
            'total_hit' => (int)$total_hit,
            'total_blog' => (int)$total_blog,
            'total_laman' => (int)$total_laman,
            'total_newslater' => (int)$total_newslater
        ], 200);

    } catch (PDOException $e) {
        sendResponse([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
?>