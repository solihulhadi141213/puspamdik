<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    try {
        $stmt = $Conn->prepare("
            SELECT * FROM opening
            ORDER BY id_opening DESC
            LIMIT 1
        ");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode([
                'status' => false,
                'message' => 'Data opening belum tersedia'
            ]);
            exit;
        }

        $imageUrl = '';

        if (!empty($row['opening_image'])) {
            $imageUrl = 'assets/img/Content/Opening/' . $row['opening_image'];
        }

        echo json_encode([
            'status' => true,
            'data' => [
                'id_opening' => $row['id_opening'],
                'opening_title' => $row['opening_title'] ?? '',
                'opening_content' => $row['opening_content'] ?? '',
                'opening_image' => $imageUrl
            ]
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>