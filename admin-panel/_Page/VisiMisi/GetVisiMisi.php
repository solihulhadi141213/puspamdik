<?php
    include "../../_Config/Connection.php";

    header('Content-Type: application/json');

    try {
        $query = $Conn->prepare("SELECT * FROM visi_misi LIMIT 1");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }