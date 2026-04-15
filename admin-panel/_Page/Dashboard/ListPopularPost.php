<?php
    require_once '../../_Config/Connection.php';

    try {
        // Ambil koneksi
        $db = new Database();
        $Conn = $db->getConnection();

        // Query popular post berdasarkan jumlah viewer
        $query = "
            SELECT 
                b.id_blog,
                b.title_blog,
                b.cover,
                b.datetime_creat,
                COUNT(v.id_blog) as total_view
            FROM blog b
            LEFT JOIN blog_viewer v ON b.id_blog = v.id_blog
            WHERE b.publish = 1
            GROUP BY b.id_blog
            ORDER BY total_view DESC
            LIMIT 5
        ";

        $stmt = $Conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result) {
            foreach ($result as $row) {
                $title  = htmlspecialchars($row['title_blog']);
                $cover  = $row['cover'];
                $date   = date('d M Y', strtotime($row['datetime_creat']));
                $view   = $row['total_view'];

                // Path cover (sesuaikan dengan folder kamu)
                $coverPath = "assets/img/Content/Blog/".$cover;

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