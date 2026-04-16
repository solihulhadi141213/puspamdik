<?php
    require_once '../../_Config/Connection.php';

    try {
        $db = new Database();
        $Conn = $db->getConnection();

        $query = "SELECT * FROM event ORDER BY tanggal_event DESC";
        $stmt = $Conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {

            echo '<div class="row">';

            foreach ($result as $row) {

                $id       = $row['id_event'];
                $nama     = htmlspecialchars($row['nama_event']);
                $mode     = $row['mode_event'];
                $tanggal  = date('d M Y', strtotime($row['tanggal_event']));
                $biaya    = $row['biiaya_event'];
                $pemateri = htmlspecialchars($row['nama_pemateri']);
                $foto     = $row['foto_pemateri'];
                $cover    = $row['cover_event'];
                $deskripsi= substr(strip_tags($row['deskripsi_event']), 0, 100) . '...';

                // =========================
                // PATH COVER EVENT
                // =========================
                $coverPath = !empty($cover)
                    ? "assets/img/Content/Event/" . $cover
                    : "assets/img/Content/Event/No-Image.png";

                // =========================
                // PATH FOTO PEMATERI
                // =========================
                $fotoPemateri = !empty($foto)
                    ? "assets/img/Content/Event/" . $foto
                    : "assets/img/Content/Event/No-Image.png";

                // =========================
                // BADGE MODE
                // =========================
                $badge = "secondary";
                if ($mode == "Online") $badge = "success";
                if ($mode == "Offline") $badge = "danger";
                if ($mode == "Hybrid") $badge = "primary";

                // =========================
                // FORMAT BIAYA
                // =========================
                $biayaText = ($biaya > 0)
                    ? "Rp " . number_format($biaya, 0, ',', '.')
                    : "Gratis";

                echo '
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 position-relative">

                        <!-- OPTION BUTTON -->
                        <div class="dropdown position-absolute" style="top:10px; right:10px; z-index:10;">
                            <button class="btn btn-light btn-sm btn-floating" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ModalEditEvent"
                                    data-id="'.$id.'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ModalHapusEvent"
                                    data-id="'.$id.'">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- COVER EVENT -->
                        <div style="height:180px; overflow:hidden; cursor:pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#ModalDetailEvent"
                            data-id="'.$id.'"
                            class="btn-detail-event">

                            <img src="'.$coverPath.'" 
                                style="width:100%; height:100%; object-fit:cover; transition:0.3s;">
                        </div>

                        <!-- BODY -->
                        <div class="card-body">

                            <span class="badge bg-'.$badge.' mb-2">'.$mode.'</span>

                            <h5 class="card-title">'.$nama.'</h5>

                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> '.$tanggal.'
                            </small>

                            <p class="mt-2 mb-2">'.$deskripsi.'</p>

                            <div class="d-flex align-items-center mt-3">

                                <img src="'.$fotoPemateri.'" 
                                    style="width:40px; height:40px; object-fit:cover; border-radius:50%; margin-right:10px;">

                                <div>
                                    <small class="d-block fw-bold">'.$pemateri.'</small>
                                    <small class="text-muted">'.$biayaText.'</small>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                ';
            }

            echo '</div>';

        } else {
            echo '
            <div class="text-center p-5 border border-4 border-secondary rounded-4">
                <h1 class="text-muted">
                    <i class="bi bi-calendar-x"></i>
                </h1>
                Tidak ada data event
            </div>';
        }

    } catch (Exception $e) {
        echo '<div class="text-danger text-center">Error: '.$e->getMessage().'</div>';
    }
?>