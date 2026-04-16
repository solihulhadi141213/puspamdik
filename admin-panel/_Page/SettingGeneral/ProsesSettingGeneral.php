<?php
    include "../../_Config/Connection.php";

    header('Content-Type: application/json');

    try {
        $required = [
            'title_page',
            'kata_kunci',
            'deskripsi',
            'alamat_bisnis',
            'email_bisnis',
            'telepon_bisnis',
            'base_url',
            'author'
        ];

        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                echo json_encode([
                    'status' => false,
                    'message' => "Field $field wajib diisi"
                ]);
                exit;
            }
        }

        $data = [
            'title_page'      => trim($_POST['title_page']),
            'kata_kunci'      => trim($_POST['kata_kunci']),
            'deskripsi'       => trim($_POST['deskripsi']),
            'alamat_bisnis'   => trim($_POST['alamat_bisnis']),
            'email_bisnis'    => trim($_POST['email_bisnis']),
            'telepon_bisnis'  => trim($_POST['telepon_bisnis']),
            'google_map'      => trim($_POST['google_map'] ?? ''),
            'medsos_wa'       => trim($_POST['medsos_wa'] ?? ''),
            'medsos_ig'       => trim($_POST['medsos_ig'] ?? ''),
            'medsos_fb'       => trim($_POST['medsos_fb'] ?? ''),
            'medsos_x'        => trim($_POST['medsos_x'] ?? ''),
            'medsos_tiktok'   => trim($_POST['medsos_tiktok'] ?? ''),
            'base_url'        => trim($_POST['base_url']),
            'author'          => trim($_POST['author'])
        ];

        function uploadImage($fileKey, $folder)
        {
            if (empty($_FILES[$fileKey]['name'])) {
                return null;
            }

            $allowedMime = ['image/jpeg','image/png','image/gif','image/webp'];
            $maxSize = 2 * 1024 * 1024;

            $file = $_FILES[$fileKey];

            if ($file['size'] > $maxSize) {
                throw new Exception("Ukuran $fileKey maksimal 2MB");
            }

            $mime = mime_content_type($file['tmp_name']);

            if (!in_array($mime, $allowedMime)) {
                throw new Exception("Format $fileKey tidak valid");
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newName = md5(uniqid()) . '.' . $ext;

            move_uploaded_file($file['tmp_name'], $folder . $newName);

            return $newName;
        }

        $favicon = uploadImage('favicon', '../../assets/img/');
        $logo = uploadImage('logo', '../../assets/img/');

        if ($favicon) $data['favicon'] = $favicon;
        if ($logo) $data['logo'] = $logo;

        $check = $Conn->query("SELECT COUNT(*) as total FROM setting_general")->fetch();

        if ($check['total'] > 0) {
            $sql = "UPDATE setting_general SET
                    title_page=:title_page,
                    kata_kunci=:kata_kunci,
                    deskripsi=:deskripsi,
                    alamat_bisnis=:alamat_bisnis,
                    email_bisnis=:email_bisnis,
                    telepon_bisnis=:telepon_bisnis,
                    google_map=:google_map,
                    medsos_wa=:medsos_wa,
                    medsos_ig=:medsos_ig,
                    medsos_fb=:medsos_fb,
                    medsos_x=:medsos_x,
                    medsos_tiktok=:medsos_tiktok,
                    base_url=:base_url,
                    author=:author";

            if ($favicon) $sql .= ", favicon=:favicon";
            if ($logo) $sql .= ", logo=:logo";

            $sql .= " WHERE id_setting_general=1";

        } else {
            $sql = "INSERT INTO setting_general (
                title_page,kata_kunci,deskripsi,alamat_bisnis,
                email_bisnis,telepon_bisnis,google_map,
                medsos_wa,medsos_ig,medsos_fb,medsos_x,
                medsos_tiktok,base_url,author,favicon,logo
            ) VALUES (
                :title_page,:kata_kunci,:deskripsi,:alamat_bisnis,
                :email_bisnis,:telepon_bisnis,:google_map,
                :medsos_wa,:medsos_ig,:medsos_fb,:medsos_x,
                :medsos_tiktok,:base_url,:author,:favicon,:logo
            )";
        }

        $stmt = $Conn->prepare($sql);
        $stmt->execute($data);

        echo json_encode([
            'status' => true,
            'message' => 'Pengaturan berhasil disimpan'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
?>