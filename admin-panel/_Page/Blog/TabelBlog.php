<?php
include "../../_Config/Connection.php";

try {
    $query = $Conn->prepare("
        SELECT 
            id_blog,
            blog_title,
            blog_cover,
            blog_date,
            blog_author
        FROM blog
        ORDER BY blog_date DESC, id_blog DESC
    ");
    $query->execute();

    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo '
        <div class="text-center p-5 border border-4 border-secondary rounded-4 bg-white">
            <h1 class="text-secondary mb-3">
                <i class="bi bi-newspaper"></i>
            </h1>
            <div class="fw-semibold">Belum ada data blog</div>
            <small class="text-muted">Silakan tambahkan blog baru</small>
        </div>';
        exit;
    }

    echo '<div class="row g-4">';

    foreach ($rows as $row) {
        $id_blog = (int)$row['id_blog'];
        $blog_title = htmlspecialchars($row['blog_title'] ?? '');
        $blog_cover = htmlspecialchars($row['blog_cover'] ?? '');
        $blog_author = htmlspecialchars($row['blog_author'] ?? '');
        $blog_date = !empty($row['blog_date']) 
            ? date('d M Y', strtotime($row['blog_date'])) 
            : '-';

        // path cover
        $imagePath = "assets/img/Content/Blog/" . $blog_cover;

        echo '
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden gallery-card">

                <!-- Cover -->
                <div class="position-relative">
                    <a href="javascript:void(0)" 
                       data-bs-toggle="modal" 
                       data-bs-target="#ModalDetailBlog" 
                       data-id="' . $id_blog . '">
                        <img
                            src="' . $imagePath . '"
                            class="card-img-top"
                            alt="' . $blog_title . '"
                            style="height:220px; width:100%; object-fit:cover;"
                            onerror="this.src=\'assets/img/no-image.png\'"
                        >
                    </a>

                    <!-- Dropdown -->
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
                                        data-bs-target="#ModalEditBlog"
                                        data-id="' . $id_blog . '"
                                    >
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item text-danger"
                                        href="javascript:void(0);"
                                        data-bs-toggle="modal"
                                        data-bs-target="#ModalHapusBlog"
                                        data-id="' . $id_blog . '"
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
                    <h6 class="fw-bold mb-2 text-dark" style="
                        display:-webkit-box;
                        -webkit-line-clamp:2;
                        -webkit-box-orient:vertical;
                        overflow:hidden;
                        min-height:48px;
                    ">
                        ' . $blog_title . '
                    </h6>

                    <div class="small text-muted mb-2">
                        <i class="bi bi-person-circle me-1"></i>
                        ' . $blog_author . '
                    </div>

                    <div class="mt-auto small text-secondary">
                        <i class="bi bi-calendar3 me-1"></i>
                        ' . $blog_date . '
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