<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    try {

        // =========================
        // VALIDASI INPUT
        // =========================
        if (
            empty($_POST['judul_buku']) ||
            empty($_POST['penulis_buku']) ||
            empty($_POST['isbn_buku'])
        ) {
            echo json_encode([
                "status" => "error",
                "message" => "Judul, Penulis, dan ISBN wajib diisi"
            ]);
            exit;
        }

        $judul   = trim($_POST['judul_buku']);
        $penulis = trim($_POST['penulis_buku']);
        $isbn    = trim($_POST['isbn_buku']);

        // =========================
        // VALIDASI ANGKA
        // =========================
        $harga = isset($_POST['harga_buku']) && is_numeric($_POST['harga_buku'])
            ? (int)$_POST['harga_buku']
            : 0;

        $rating = isset($_POST['reting_buku']) && is_numeric($_POST['reting_buku'])
            ? (int)$_POST['reting_buku']
            : 0;

        $terjual = isset($_POST['terjual']) && is_numeric($_POST['terjual'])
            ? (int)$_POST['terjual']
            : 0;

        // =========================
        // VALIDASI ISBN
        // =========================
        $cek = $Conn->prepare("SELECT COUNT(*) FROM buku WHERE isbn_buku = ?");
        $cek->execute([$isbn]);

        if ($cek->fetchColumn() > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "ISBN sudah terdaftar"
            ]);
            exit;
        }

        // =========================
        // VALIDASI FILE
        // =========================
        if (!isset($_FILES['cover_buku']) || $_FILES['cover_buku']['error'] !== 0) {
            echo json_encode([
                "status" => "error",
                "message" => "Cover buku wajib diupload"
            ]);
            exit;
        }

        $file = $_FILES['cover_buku'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            echo json_encode([
                "status" => "error",
                "message" => "Format file harus JPG, PNG, GIF"
            ]);
            exit;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            echo json_encode([
                "status" => "error",
                "message" => "Ukuran file maksimal 2MB"
            ]);
            exit;
        }

        // =========================
        // UPLOAD FILE
        // =========================
        $newFileName = 'BUKU_' . time() . '_' . rand(100,999) . '.' . $ext;
        $uploadPath = "../../assets/img/Content/Buku/" . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal upload file"
            ]);
            exit;
        }

        // =========================
        // INSERT
        // =========================
        $insert = $Conn->prepare("
            INSERT INTO buku (
                judul_buku,
                penulis_buku,
                isbn_buku,
                harga_buku,
                reting_buku,
                terjual,
                cover_buku
            ) VALUES (
                :judul,
                :penulis,
                :isbn,
                :harga,
                :rating,
                :terjual,
                :cover
            )
        ");

        $insert->execute([
            ':judul'   => $judul,
            ':penulis' => $penulis,
            ':isbn'    => $isbn,
            ':harga'   => $harga,
            ':rating'  => $rating,
            ':terjual' => $terjual,
            ':cover'   => $newFileName
        ]);

        echo json_encode([
            "status" => "success",
            "message" => "Data buku berhasil ditambahkan"
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $e->getMessage()
        ]);
    }
?>