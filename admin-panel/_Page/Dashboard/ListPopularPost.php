<?php
require_once '../../_Config/Connection.php';

try {
    $db = new Database();
    $Conn = $db->getConnection();

    // =========================
    // QUERY POPULAR POST
    // =========================
    $query = "
        SELECT 
            b.id_blog,
            b.blog_title,
            b.blog_cover,
            b.blog_date,
            COUNT(v.id_blog) AS total_view
        FROM blog b
        LEFT JOIN blog_viewer v ON b.id_blog = v.id_blog
        GROUP BY b.id_blog
        ORDER BY total_view DESC
        LIMIT 5
    ";

    $stmt = $Conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {

            $title = htmlspecialchars($row['blog_title']);
            $cover = $row['blog_cover'];
            $date  = date('d M Y', strtotime($row['blog_date']));
            $view  = $row['total_view'];

            // path cover
            $coverPath = "assets/img/Content/Blog/" . $cover;

            echo '
            <div class="d-flex mb-3">
                <div style="width:80px; height:60px; overflow:hidden; margin-right:10px;">
                    <img src="'.$coverPath.'" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div>
                    <div style="font-weight:bold; font-size:14px;">'.$title.'</div>
                    <small>'.$date.'</small><br>
                    <small><i class="fa fa-eye"></i> '.$view.' views</small>
                </div>
            </div>
            <hr>';
        }
    } else {
        echo '<div class="text-center text-muted">Belum ada data popular post</div>';
    }

} catch (Exception $e) {
    echo '<div class="text-danger">Error: '.$e->getMessage().'</div>';
}
?>