<?php
    // Default value (antisipasi jika data tidak ada)
    $SessionNama           = "";
    $SessionKontakAkses    = "";
    $SessionEmailAkses     = "";
    $SessionGambar         = "No-Image.png";
    $SessionLevelAkses     = "";
    $SessionDatetimeDaftar = "";
    $SessionDatetimeUpdate = "";

    // Query ambil semua data sekaligus
    $query = "SELECT * FROM akses WHERE id_akses = :id LIMIT 1";
    $stmt  = $Conn->prepare($query);
    $stmt->execute([':id' => $SessionIdAkses]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $SessionNama           = $data['nama_akses'] ?? "";
        $SessionKontakAkses    = $data['kontak_akses'] ?? "";
        $SessionEmailAkses     = $data['email_akses'] ?? "";
        $SessionGambar         = !empty($data['image_akses']) ? $data['image_akses'] : "No-Image.png";
        $SessionLevelAkses     = $data['akses'] ?? "";
        $SessionDatetimeDaftar = $data['datetime_daftar'] ?? "";
        $SessionDatetimeUpdate = $data['datetime_update'] ?? "";
    }
?>