<?php
    include "../../_Config/Connection.php";

    try {
        $query = "
            SELECT 
                id_laman,
                judul_laman,
                kategori_laman,
                date_laman,
                cover_laman
            FROM laman
            ORDER BY date_laman DESC
        ";

        $stmt = $Conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo '
            <div class="text-center p-5 border border-4 border-secondary rounded-4 bg-white">
                <h1 class="text-secondary mb-3">
                    <i class="bi bi-journal-x"></i>
                </h1>
                <div class="fw-semibold">Belum ada data laman</div>
                <small class="text-muted">Silakan tambahkan laman baru</small>
            </div>';
            exit;
        }

        echo '<div class="row g-4">';

        foreach ($rows as $row) {
            $id_laman       = htmlspecialchars($row['id_laman'] ?? '');
            $judul_laman    = htmlspecialchars($row['judul_laman'] ?? '');
            $kategori_laman = htmlspecialchars($row['kategori_laman'] ?? '');
            $cover_laman    = htmlspecialchars($row['cover_laman'] ?? '');
            $tanggal        = date('d M Y', strtotime($row['date_laman']));

            // PATH COVER SESUAI FOLDER BARU
            $coverPath = "assets/img/Content/Laman/" . $cover_laman;

            echo '
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden gallery-card">

                    <!-- Cover -->
                    <div class="position-relative">
                        <a href="javascript:void(0)"
                           data-bs-toggle="modal"
                           data-bs-target="#ModalDetailLaman"
                           data-id="' . $id_laman . '">
                            <img
                                src="' . $coverPath . '"
                                class="card-img-top"
                                alt="' . $judul_laman . '"
                                style="height:220px; width:100%; object-fit:cover;"
                                onerror="this.src=\'assets/img/no-image.png\'"
                            >
                        </a>

                        <!-- Option Button -->
                        <div class="position-absolute top-0 end-0 p-3">
                            <div class="dropdown">
                                <button
                                    class="btn btn-md btn-floating btn-light shadow-sm rounded-circle"
                                    data-bs-toggle="dropdown"
                                    type="button"
                                >
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4">
                                    <li>
                                        <a
                                            class="dropdown-item"
                                            href="javascript:void(0);"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ModalEditLaman"
                                            data-id="' . $id_laman . '"
                                        >
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item text-danger"
                                            href="javascript:void(0);"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ModalHapusLaman"
                                            data-id="' . $id_laman . '"
                                        >
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                ' . $kategori_laman . '
                            </span>
                        </div>

                        <h6 class="fw-bold mb-2 text-dark" style="
                            display:-webkit-box;
                            -webkit-line-clamp:2;
                            -webkit-box-orient:vertical;
                            overflow:hidden;
                            min-height:48px;
                        ">
                            ' . $judul_laman . '
                        </h6>

                        <div class="d-flex justify-content-between small text-secondary mt-3">
                            <span>
                                <i class="bi bi-calendar3"></i> ' . $tanggal . '
                            </span>
                        </div>
                    </div>
                </div>
            </div>';
        }

        echo '</div>';

    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger rounded-4">
            <b>Database Error:</b> ' . htmlspecialchars($e->getMessage()) . '
        </div>';
    }
?>