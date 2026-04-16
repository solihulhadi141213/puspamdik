<?php
    include "../../_Config/Connection.php";

    try {
        $query = "SELECT * FROM testimoni ORDER BY id_testimoni DESC";
        $stmt = $Conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo '
            <div class="text-center p-5 border border-4 border-secondary rounded-4 bg-white">
                <h1 class="text-secondary mb-3">
                    <i class="bi bi-images"></i>
                </h1>
                <div class="fw-semibold">Belum ada data testimoni</div>
                <small class="text-muted">Silakan tambahkan testimoni baru</small>
            </div>';
            exit;
        }

        echo '<div class="row g-4">';

        foreach ($rows as $row) {
            $id = (int)$row['id_testimoni'];
            $nama_responden = htmlspecialchars($row['nama_responden'] ?? '');
            $tanggal_testimoni = htmlspecialchars($row['tanggal_testimoni'] ?? '');
            $isi_testimoni = htmlspecialchars($row['isi_testimoni'] ?? '');
            $foto_responden = htmlspecialchars($row['foto_responden'] ?? 'No-Image.png');

            $imagePath = "assets/img/Content/Testimoni/" . $foto_responden;

            echo '
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden gallery-card">

                    <!-- Image -->
                    <div class="position-relative">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailTestimoni" data-id="' . $id . '">
                            <img
                                src="' . $imagePath . '"
                                class="card-img-top"
                                alt="' . $imagePath . '"
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
                                            data-bs-target="#ModalEditTestimoni"
                                            data-id="' . $id . '"
                                        >
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            class="dropdown-item text-danger"
                                            href="javascript:void(0);"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ModalHapusTestimoni"
                                            data-id="' . $id . '"
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
                        <h6 class="fw-bold mb-2 text-dark">' . $nama_responden . '</h6>

                        <p class="text-muted small mb-3" style="
                            display:-webkit-box;
                            -webkit-line-clamp:2;
                            -webkit-box-orient:vertical;
                            overflow:hidden;
                        ">
                            ' . $isi_testimoni . '
                        </p>

                        <div class="d-flex justify-content-between small text-secondary">
                            <span>
                                <i class="bi bi-calendar3"></i> ' . $tanggal_testimoni . '
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
            <b>Database Error:</b> ' . $e->getMessage() . '
        </div>';
    }
?>