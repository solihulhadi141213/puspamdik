<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        // =========================
        // AMBIL DATA
        // =========================
        $id = isset($_POST['id_galeri']) ? (int) $_POST['id_galeri'] : 0;
        $title = trim($_POST['galeri_title'] ?? '');
        $description = trim($_POST['galeri_description'] ?? '');
        $date = trim($_POST['galeri_date'] ?? '');

        // =========================
        // VALIDASI
        // =========================
        if ($id <= 0) {
            echo json_encode([
                'status' => false,
                'message' => 'ID galeri tidak valid'
            ]);
            exit;
        }

        if ($title === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Judul galeri wajib diisi'
            ]);
            exit;
        }

        if ($description === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Deskripsi wajib diisi'
            ]);
            exit;
        }

        if ($date === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Tanggal wajib diisi'
            ]);
            exit;
        }

        // validasi format tanggal sederhana
        $dateCheck = DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateCheck || $dateCheck->format('Y-m-d') !== $date) {
            echo json_encode([
                'status' => false,
                'message' => 'Format tanggal tidak valid'
            ]);
            exit;
        }

        // =========================
        // CEK DATA ADA / TIDAK
        // =========================
        $check = $Conn->prepare("
            SELECT id_galeri 
            FROM galeri 
            WHERE id_galeri = :id
            LIMIT 1
        ");
        $check->execute([':id' => $id]);

        if (!$check->fetch()) {
            echo json_encode([
                'status' => false,
                'message' => 'Data galeri tidak ditemukan'
            ]);
            exit;
        }

        // =========================
        // UPDATE DATA
        // =========================
        $query = "
            UPDATE galeri
            SET
                galeri_title = :title,
                galeri_description = :description,
                galeri_date = :date
            WHERE id_galeri = :id
        ";

        $stmt = $Conn->prepare($query);

        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':date' => $date,
            ':id' => $id
        ]);

        // =========================
        // SUCCESS RESPONSE
        // =========================
        echo json_encode([
            'status' => true,
            'message' => 'Galeri berhasil diperbarui'
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>