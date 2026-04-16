<?php
    include "../../_Config/Connection.php";

    try {
        $query = "SELECT * FROM pengurus ORDER BY id_pengurus DESC";
        $stmt = $Conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo '
            <div class="text-center p-5 border border-4 border-secondary rounded-4 bg-white">
                <h1 class="text-secondary mb-3">
                    <i class="bi bi-images"></i>
                </h1>
                <div class="fw-semibold">Belum ada data pengurus</div>
                <small class="text-muted">Silakan tambahkan pengurus baru</small>
            </div>';
            exit;
        }

        echo '<div class="row g-4">';

        foreach ($rows as $row) {
            $id = (int)$row['id_pengurus'];
            $nama_pengurus = htmlspecialchars($row['nama_pengurus'] ?? '');
            $jabatan_pengurus = htmlspecialchars($row['jabatan_pengurus'] ?? '');
            $foto_pengurus = htmlspecialchars($row['foto_pengurus'] ?? '');

            $imagePath = "assets/img/pengurus/" . $foto_pengurus;

            echo '
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden gallery-card">

                    <!-- Image -->
                    <div class="position-relative">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailPengurus" data-id="' . $id . '">
                            <img src="' . $imagePath . '" class="card-img-top" alt="' . $foto_pengurus . '" style="height:220px; width:100%; object-fit:cover;">
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
                                            data-bs-target="#ModalEditPengurus"
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
                                            data-bs-target="#ModalHapusPengurus"
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
                        <h6 class="fw-bold mb-2 text-dark">' . $nama_pengurus . '</h6>

                        <p class="text-muted small mb-3" style=" display:-webkit-box;
                            -webkit-line-clamp:2;
                            -webkit-box-orient:vertical;
                            overflow:hidden;
                        ">
                            ' . $jabatan_pengurus . '
                        </p>
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