<?php
    header('Content-Type: application/json');

    // Koneksi database
    include "../../_Config/Connection.php";

    try {
        // =========================
        // Validasi input text
        // =========================
        if (empty($_POST['nama_pengurus'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Nama pengurus wajib diisi'
            ]);
            exit;
        }

        if (empty($_POST['jabatan_pengurus'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Jabatan pengurus wajib diisi'
            ]);
            exit;
        }

        if (!isset($_FILES['foto_pengurus']) || $_FILES['foto_pengurus']['error'] !== 0) {
            echo json_encode([
                'status' => false,
                'message' => 'File foto wajib diupload'
            ]);
            exit;
        }

        $nama_pengurus = trim($_POST['nama_pengurus']);
        $jabatan_pengurus = trim($_POST['jabatan_pengurus']);

        // =========================
        // Upload file
        // =========================
        $file = $_FILES['foto_pengurus'];

        $fileName = $file['name'];
        $fileTmp  = $file['tmp_name'];
        $fileSize = $file['size'];

        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validasi ekstensi
        if (!in_array($ext, $allowedExt)) {
            echo json_encode([
                'status' => false,
                'message' => 'Format file harus JPG, PNG, atau GIF'
            ]);
            exit;
        }

        // Validasi ukuran max 2MB
        if ($fileSize > 2 * 1024 * 1024) {
            echo json_encode([
                'status' => false,
                'message' => 'Ukuran file maksimal 2 MB'
            ]);
            exit;
        }

        // =========================
        // Generate nama file unik
        // =========================
        $newFileName = 'pengurus_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;

        // folder upload
        $uploadDir = '../../assets/img/Pengurus/';

        // buat folder jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadPath = $uploadDir . $newFileName;

        // pindahkan file
        if (!move_uploaded_file($fileTmp, $uploadPath)) {
            echo json_encode([
                'status' => false,
                'message' => 'Gagal upload file'
            ]);
            exit;
        }

        // =========================
        // Simpan database
        // =========================
        $query = $Conn->prepare("
            INSERT INTO pengurus (
                nama_pengurus,
                jabatan_pengurus,
                foto_pengurus
            ) VALUES (
                :nama_pengurus,
                :jabatan_pengurus,
                :foto_pengurus
            )
        ");

        $query->execute([
            ':nama_pengurus' => $nama_pengurus,
            ':jabatan_pengurus' => $jabatan_pengurus,
            ':foto_pengurus' => $newFileName
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Data pengurus berhasil disimpan'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>