<?php
    include "../../_Config/Connection.php";

    try {
        $query = "SELECT * FROM hero ORDER BY id_hero DESC";
        $stmt = $Conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            echo '
            <div class="text-center p-5 border border-4 border-secondary rounded-4">
                <h1 class="text-dark">
                    <i class="bi bi-exclamation-circle"></i>
                </h1>
                Tidak Ada Data Hero
            </div>';
            exit;
        }

        echo '<div class="row g-3">';

        foreach ($rows as $row) {
            $id = $row['id_hero'];
            $title = htmlspecialchars($row['hero_title'] ?? '');
            $desc = htmlspecialchars($row['hero_description'] ?? '');
            $image = htmlspecialchars($row['hero_image'] ?? '');
            $link = htmlspecialchars($row['hero_link'] ?? '');
            $label = htmlspecialchars($row['hero_link_label'] ?? '');

            $imagePath = "_assets/img/Content/Hero/" . $image;

            echo '
            <div class="col-12 col-md-6 col-xl-4">
                <div class="hero-card">

                    <div class="hero-image-wrapper">
                        <img 
                            src="' . $imagePath . '" 
                            class="hero-image"
                            alt="' . $title . '"
                        >

                        <div class="hero-overlay"></div>

                        <div class="hero-action">
                            <div class="dropdown">
                                <button class="btn btn-md btn-floating btn-secondary" data-bs-toggle="dropdown" type="button">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditHero" data-id="' . $id . '">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalHapusHero" data-id="' . $id . '">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="hero-body">
                        <div class="hero-title">' . $title . '</div>
                        <div class="hero-desc">' . $desc . '</div>';

            if (!empty($link) && !empty($label)) {
                echo '
                    <a href="' . $link . '" target="_blank" class="btn btn-primary hero-link-btn">
                        ' . $label . '
                    </a>';
            }

            echo '
                    </div>
                </div>
            </div>';
        }

        echo '</div>';

    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
?>