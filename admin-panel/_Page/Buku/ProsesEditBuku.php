<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";

    try {

        // =========================
        // VALIDASI ID
        // =========================
        if (empty($_POST['id_buku'])) {
            echo json_encode([
                "status" => "error",
                "message" => "ID buku tidak valid"
            ]);
            exit;
        }

        $id_buku = (int)$_POST['id_buku'];

        // =========================
        // AMBIL DATA LAMA
        // =========================
        $old = $Conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
        $old->execute([$id_buku]);
        $data_lama = $old->fetch(PDO::FETCH_ASSOC);

        if (!$data_lama) {
            echo json_encode([
                "status" => "error",
                "message" => "Data tidak ditemukan"
            ]);
            exit;
        }

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
        // VALIDASI ISBN DUPLIKAT
        // =========================
        $cek = $Conn->prepare("SELECT COUNT(*) FROM buku WHERE isbn_buku = ? AND id_buku != ?");
        $cek->execute([$isbn, $id_buku]);

        if ($cek->fetchColumn() > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "ISBN sudah digunakan buku lain"
            ]);
            exit;
        }

        // =========================
        // HANDLE FILE
        // =========================
        $cover_baru = $data_lama['cover_buku'];

        if (isset($_FILES['cover_buku']) && $_FILES['cover_buku']['error'] === 0) {

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

            $newFileName = 'BUKU_' . time() . '_' . rand(100,999) . '.' . $ext;
            $uploadPath = "../../assets/img/Content/Buku/" . $newFileName;

            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Gagal upload file"
                ]);
                exit;
            }

            // hapus lama
            $oldPath = "../../assets/img/Content/Buku/" . $data_lama['cover_buku'];
            if (!empty($data_lama['cover_buku']) && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $cover_baru = $newFileName;
        }

        // =========================
        // UPDATE
        // =========================
        $update = $Conn->prepare("
            UPDATE buku SET
                judul_buku   = :judul,
                penulis_buku = :penulis,
                isbn_buku    = :isbn,
                harga_buku   = :harga,
                reting_buku  = :rating,
                terjual      = :terjual,
                cover_buku   = :cover
            WHERE id_buku = :id
        ");

        $update->execute([
            ':judul'   => $judul,
            ':penulis' => $penulis,
            ':isbn'    => $isbn,
            ':harga'   => $harga,
            ':rating'  => $rating,
            ':terjual' => $terjual,
            ':cover'   => $cover_baru,
            ':id'      => $id_buku
        ]);

        echo json_encode([
            "status" => "success",
            "message" => "Data buku berhasil diperbarui"
        ]);

    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $e->getMessage()
        ]);
    }
?>