<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        $id_laman = trim($_POST['id_laman'] ?? '');
        $judul_laman = trim($_POST['judul_laman'] ?? '');
        $kategori_laman = trim($_POST['kategori_laman'] ?? '');
        $date_laman = trim($_POST['date_laman'] ?? '');
        $konten_laman = trim($_POST['konten_laman_input'] ?? '');

        if (empty($id_laman)) {
            throw new Exception("ID laman tidak valid");
        }

        if (empty($judul_laman)) {
            throw new Exception("Judul laman wajib diisi");
        }

        if (empty($kategori_laman)) {
            throw new Exception("Kategori laman wajib diisi");
        }

        if (empty($date_laman)) {
            throw new Exception("Tanggal wajib diisi");
        }

        if (empty($konten_laman)) {
            throw new Exception("Konten laman wajib diisi");
        }

        // ambil data lama
        $stmtOld = $Conn->prepare("
            SELECT cover_laman
            FROM laman
            WHERE id_laman = :id_laman
            LIMIT 1
        ");

        $stmtOld->execute([
            ':id_laman' => $id_laman
        ]);

        $oldData = $stmtOld->fetch(PDO::FETCH_ASSOC);

        if (!$oldData) {
            throw new Exception("Data laman tidak ditemukan");
        }

        $cover_lama = $oldData['cover_laman'];

        // default gunakan cover lama
        $cover_laman = $cover_lama;

        // jika upload cover baru
        if (isset($_FILES['cover_laman']) && $_FILES['cover_laman']['error'] === 0) {
            $file = $_FILES['cover_laman'];

            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExt)) {
                throw new Exception("Format cover harus JPG, PNG, atau GIF");
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                throw new Exception("Ukuran cover maksimal 2 MB");
            }

            // nama file baru
            $cover_laman = 'cover_' . time() . '_' . rand(1000,9999) . '.' . $ext;

            $upload_path = "../../assets/img/Content/Laman/" . $cover_laman;

            if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                throw new Exception("Gagal upload cover baru");
            }

            // hapus cover lama
            $oldPath = "../../assets/img/Content/Laman/" . $cover_lama;

            if (!empty($cover_lama) && file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // update database
        $stmt = $Conn->prepare("
            UPDATE laman
            SET
                judul_laman = :judul_laman,
                kategori_laman = :kategori_laman,
                date_laman = :date_laman,
                cover_laman = :cover_laman,
                konten_laman = :konten_laman
            WHERE id_laman = :id_laman
        ");

        $stmt->execute([
            ':judul_laman' => $judul_laman,
            ':kategori_laman' => $kategori_laman,
            ':date_laman' => $date_laman,
            ':cover_laman' => $cover_laman,
            ':konten_laman' => $konten_laman,
            ':id_laman' => $id_laman
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Laman berhasil diperbarui'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>