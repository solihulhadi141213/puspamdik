<?php
    header('Content-Type: application/json');

    include "../../_Config/Connection.php";

    try {
        // validasi input
        $judul_laman = trim($_POST['judul_laman'] ?? '');
        $kategori_laman = trim($_POST['kategori_laman'] ?? '');
        $date_laman = trim($_POST['date_laman'] ?? '');
        $konten_laman = trim($_POST['konten_laman_input'] ?? '');

        if (empty($judul_laman)) {
            throw new Exception("Judul laman wajib diisi");
        }

        if (empty($kategori_laman)) {
            throw new Exception("Kategori laman wajib diisi");
        }

        if (empty($date_laman)) {
            throw new Exception("Tanggal laman wajib diisi");
        }

        if (empty($konten_laman)) {
            throw new Exception("Konten laman wajib diisi");
        }

        if (!isset($_FILES['cover_laman'])) {
            throw new Exception("Cover laman wajib diupload");
        }

        $file = $_FILES['cover_laman'];

        if ($file['error'] !== 0) {
            throw new Exception("Gagal upload file cover");
        }

        // validasi file
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            throw new Exception("Format cover harus JPG, PNG, atau GIF");
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran cover maksimal 2 MB");
        }

        // generate UUID
        $id_laman = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        // nama file cover
        $cover_laman = 'cover_' . time() . '_' . rand(1000,9999) . '.' . $ext;

        $upload_path = "../../assets/img/Content/Laman/" . $cover_laman;

        // buat folder jika belum ada
        if (!is_dir("../../assets/img/Content/Laman/")) {
            mkdir("../../assets/img/Content/Laman/", 0777, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
            throw new Exception("Gagal menyimpan file cover");
        }

        // insert database
        $stmt = $Conn->prepare("
            INSERT INTO laman (
                id_laman,
                judul_laman,
                kategori_laman,
                date_laman,
                cover_laman,
                konten_laman
            ) VALUES (
                :id_laman,
                :judul_laman,
                :kategori_laman,
                :date_laman,
                :cover_laman,
                :konten_laman
            )
        ");

        $stmt->execute([
            ':id_laman' => $id_laman,
            ':judul_laman' => $judul_laman,
            ':kategori_laman' => $kategori_laman,
            ':date_laman' => $date_laman,
            ':cover_laman' => $cover_laman,
            ':konten_laman' => $konten_laman
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Laman berhasil ditambahkan'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>