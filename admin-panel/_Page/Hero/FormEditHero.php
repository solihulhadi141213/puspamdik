<?php
    include "../../_Config/Connection.php";

    if (empty($_POST['id_hero'])) {
        echo '<div class="alert alert-danger">ID Hero tidak ditemukan</div>';
        exit;
    }

    $id = $_POST['id_hero'];

    try {
        $query = "SELECT * FROM hero WHERE id_hero = :id LIMIT 1";
        $stmt = $Conn->prepare($query);
        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch();

        if (!$row) {
            echo '<div class="alert alert-danger">Data hero tidak ditemukan</div>';
            exit;
        }

        $title = htmlspecialchars($row['hero_title'] ?? '');
        $desc = htmlspecialchars($row['hero_description'] ?? '');
        $link = htmlspecialchars($row['hero_link'] ?? '');
        $label = htmlspecialchars($row['hero_link_label'] ?? '');

        $hasButton = (!empty($link) && !empty($label)) ? 1 : 0;

        echo '
        <input type="hidden" name="id_hero" value="' . $id . '">

        <div class="row mb-3">
            <div class="col-3"><label>Judul</label></div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="text" name="hero_title" class="form-control" value="' . $title . '" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3"><label>Deskripsi</label></div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="text" name="hero_description" class="form-control" value="' . $desc . '" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3"><label>Ganti Gambar</label></div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="file" name="hero_image" class="form-control">
                <small class="text-secondary">
                    Kosongkan jika tidak ingin mengganti gambar
                </small>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3"><label>Buat Tombol</label></div>
            <div class="col-1">:</div>
            <div class="col-8">
                <select name="tombol_hero" id="edit_tombol_hero" class="form-control">
                    <option value="1" ' . ($hasButton == 1 ? 'selected' : '') . '>Sediakan</option>
                    <option value="0" ' . ($hasButton == 0 ? 'selected' : '') . '>Tidak Ada</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3"><label>URL Tombol</label></div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="url" name="hero_link" id="edit_hero_link" class="form-control" value="' . $link . '">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-3"><label>Label Tombol</label></div>
            <div class="col-1">:</div>
            <div class="col-8">
                <input type="text" name="hero_link_label" id="edit_hero_link_label" class="form-control" value="' . $label . '">
            </div>
        </div>
        ';

    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
?>