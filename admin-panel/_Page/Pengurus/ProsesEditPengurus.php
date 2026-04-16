<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        if (empty($_POST['id_pengurus'])) {
            echo json_encode([
                'status' => false,
                'message' => 'ID pengurus tidak valid'
            ]);
            exit;
        }

        $id_pengurus = (int) $_POST['id_pengurus'];
        $nama_pengurus = trim($_POST['nama_pengurus']);
        $jabatan_pengurus = trim($_POST['jabatan_pengurus']);
        $foto_lama = $_POST['foto_lama'];

        $nama_file = $foto_lama;

        // Jika upload foto baru
        if (!empty($_FILES['foto_pengurus']['name'])) {
            $file = $_FILES['foto_pengurus'];

            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Format file harus JPG, PNG, atau GIF'
                ]);
                exit;
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Ukuran file maksimal 2 MB'
                ]);
                exit;
            }

            $nama_file = 'pengurus_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $upload_path = "../../assets/img/Pengurus/" . $nama_file;

            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'Gagal upload foto baru'
                ]);
                exit;
            }

            // Hapus file lama
            $old_path = "../../assets/img/Pengurus/" . $foto_lama;
            if (file_exists($old_path)) {
                unlink($old_path);
            }
        }

        // Update database
        $stmt = $Conn->prepare("
            UPDATE pengurus 
            SET 
                nama_pengurus = :nama_pengurus,
                jabatan_pengurus = :jabatan_pengurus,
                foto_pengurus = :foto_pengurus
            WHERE id_pengurus = :id_pengurus
        ");

        $stmt->execute([
            ':nama_pengurus' => $nama_pengurus,
            ':jabatan_pengurus' => $jabatan_pengurus,
            ':foto_pengurus' => $nama_file,
            ':id_pengurus' => $id_pengurus
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Data pengurus berhasil diperbarui'
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>