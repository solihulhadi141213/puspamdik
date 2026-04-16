<?php
include "../../_Config/Connection.php";

try {
    $query = $Conn->prepare("
        SELECT 
            id_buku,
            judul_buku,
            penulis_buku,
            isbn_buku,
            harga_buku,
            reting_buku,
            terjual,
            cover_buku
        FROM buku
        ORDER BY id_buku DESC
    ");
    $query->execute();

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo '
        <div class="text-center p-5 border border-4 border-secondary rounded-4 bg-white">
            <h1 class="text-secondary mb-3">
                <i class="bi bi-book"></i>
            </h1>
            <div class="fw-semibold">Belum ada data buku</div>
            <small class="text-muted">Silakan tambahkan buku baru</small>
        </div>';
        exit;
    }

    echo '<div class="row g-4">';

    foreach ($rows as $row) {
        $id_buku = (int)$row['id_buku'];
        $judul_buku = htmlspecialchars($row['judul_buku'] ?? '');
        $penulis_buku = htmlspecialchars($row['penulis_buku'] ?? '');
        $isbn_buku = htmlspecialchars($row['isbn_buku'] ?? '');
        $harga_buku = (int)($row['harga_buku'] ?? 0);
        $reting_buku = htmlspecialchars($row['reting_buku'] ?? '0');
        $terjual = (int)($row['terjual'] ?? 0);
        $cover_buku = htmlspecialchars($row['cover_buku'] ?? '');

        // format harga
        $harga_format = $harga_buku > 0 
            ? 'Rp ' . number_format($harga_buku, 0, ',', '.') 
            : '-';

        // path cover
        $imagePath = "assets/img/Content/Buku/" . $cover_buku;

        echo '
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                <!-- Cover -->
                <div class="position-relative">
                    <a href="javascript:void(0)" 
                       class="BtnDetailBuku"
                       data-bs-toggle="modal" 
                       data-bs-target="#ModalDetailBuku" 
                       data-id="' . $id_buku . '">
                        <img
                            src="' . $imagePath . '"
                            class="card-img-top"
                            alt="' . $judul_buku . '"
                            style="height:220px; width:100%; object-fit:cover;"
                            onerror="this.src=\'assets/img/no-image.png\'"
                        >
                    </a>

                    <!-- Dropdown -->
                    <div class="position-absolute top-0 end-0 p-3">
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-light btn-floating shadow-sm"
                                data-bs-toggle="dropdown"
                                type="button"
                            >
                                <i class="bi bi-three-dots-vertical text-secondary"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4">
                                <li>
                                    <a
                                        class="dropdown-item BtnEditBuku"
                                        href="javascript:void(0);"
                                        data-bs-toggle="modal"
                                        data-bs-target="#ModalEditBuku"
                                        data-id="' . $id_buku . '"
                                    >
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item text-danger BtnHapusBuku"
                                        href="javascript:void(0);"
                                        data-bs-toggle="modal"
                                        data-bs-target="#ModalHapusBuku"
                                        data-id="' . $id_buku . '"
                                    >
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body d-flex flex-column">

                    <!-- Judul (FIX: tidak dipotong lagi) -->
                    <h6 class="fw-bold mb-2 text-dark">
                        ' . $judul_buku . '
                    </h6>

                    <div class="small text-muted mb-1">
                        <i class="bi bi-person-circle me-1"></i>
                        ' . $penulis_buku . '
                    </div>

                    <div class="small text-muted mb-1">
                        <i class="bi bi-upc-scan me-1"></i>
                        ISBN: ' . $isbn_buku . '
                    </div>

                    <div class="small text-primary mb-1">
                        <i class="bi bi-cash-stack me-1"></i>
                        ' . $harga_format . '
                    </div>

                    <div class="small text-warning mb-1">
                        <i class="bi bi-star-fill me-1"></i>
                        Rating: ' . $reting_buku . '
                    </div>

                    <div class="mt-auto small text-success">
                        <i class="bi bi-cart-check me-1"></i>
                        Terjual: ' . number_format($terjual) . '
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