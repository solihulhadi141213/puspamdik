<?php
    if(empty($_GET['id'])){
        include "_Page/Error/PageNotFound.php";
        exit;
    }
?>
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Artikel</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="index.html">Home</a></li>
                <li class="current">Artikel</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->

<!-- Blog Details Section -->
<section id="blog-details" class="blog-details section">
    <div class="container aos-init aos-animate" data-aos="fade-up">
        <article class="article">
            <div class="article-header">
                <div class="meta-categories aos-init aos-animate" data-aos="fade-up">
                    <a href="index.php?Page=artikel" class="category">
                        Kembali Ke Daftar Artikel
                    </a>
                </div>
                <h1 class="title aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <?php
                        if($_GET['id']=="1"){
                            echo "Pentingnya Pelatihan Berkelanjutan dalam Meningkatkan Kompetensi SDM";
                        }
                        if($_GET['id']=="2"){
                            echo "Strategi Pengembangan Kapasitas Tenaga Pendidik di Era Digital";
                        }
                        if($_GET['id']=="3"){
                            echo "Metode Pelatihan Efektif untuk Meningkatkan Produktivitas Organisasi";
                        }
                        if($_GET['id']=="4"){
                            echo "Transformasi Pembelajaran melalui Pelatihan Berbasis Teknologi";
                        }
                        if($_GET['id']=="5"){
                            echo "Peran Pelatihan dalam Membangun Profesionalisme Tenaga Kerja";
                        }
                        if($_GET['id']=="6"){
                            echo "Langkah-Langkah Menyusun Artikel Ilmiah yang Berkualitas";
                        }
                        if($_GET['id']=="7"){
                            echo "Tips Menulis Naskah Akademik yang Sistematis dan Mudah Dipahami";
                        }
                        if($_GET['id']=="8"){
                            echo "Pentingnya Publikasi Ilmiah bagi Akademisi dan Profesional";
                        }
                        if($_GET['id']=="9"){
                            echo "Metode Penelitian Kuantitatif dan Kualitatif: Mana yang Tepat?";
                        }
                    ?>
                    
                </h1>
                <div class="article-meta aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <div class="author">
                        <div class="author-info">
                            <h4>Penulis</h4>
                            <span>Assoc.Prof. Dr. Iman Subasman, M.Si</span>
                        </div>
                    </div>
                    <div class="post-info">
                        <span>
                            <i class="bi bi-calendar4-week"></i> 
                            <?php
                                if($_GET['id']=="1"){
                                    echo "01 Maret 2026";
                                }
                                if($_GET['id']=="2"){
                                    echo "02 Maret 2026";
                                }
                                if($_GET['id']=="3"){
                                   echo "03 Maret 2026";
                                }
                                if($_GET['id']=="4"){
                                    echo "04 Maret 2026";
                                }
                                if($_GET['id']=="5"){
                                    echo "05 Maret 2026";
                                }
                                if($_GET['id']=="6"){
                                    echo "06 Maret 2026";
                                }
                                if($_GET['id']=="7"){
                                    echo "07 Maret 2026";
                                }
                                if($_GET['id']=="8"){
                                    echo "08 Maret 2026";
                                }
                                if($_GET['id']=="9"){
                                    echo "09 Maret 2026";
                                }
                            ?>
                            
                        </span>
                    </div>
                </div>
            </div>
            <div class="article-featured-image aos-init aos-animate" data-aos="zoom-in">
                <?php
                    if($_GET['id']=="1"){
                        echo '<img src="assets\img\artikel\artikel-1.webp?v=1" alt="Artikel-1" class="img-fluid">';
                    }
                    if($_GET['id']=="2"){
                        echo '<img src="assets\img\artikel\artikel-2.png?v=1" alt="Artikel-2" class="img-fluid">';
                    }
                    if($_GET['id']=="3"){
                        echo '<img src="assets\img\artikel\artikel-3.jpg?v=1" alt="Artikel-3" class="img-fluid">';
                    }
                    if($_GET['id']=="4"){
                        echo '<img src="assets\img\artikel\artikel-4.jpg?v=1" alt="Artikel-4" class="img-fluid">';
                    }
                    if($_GET['id']=="5"){
                        echo '<img src="assets\img\artikel\artikel-5.jpg?v=1" alt="Artikel-5" class="img-fluid">';
                    }
                    if($_GET['id']=="6"){
                        echo '<img src="assets\img\artikel\artikel-6.jpg?v=1" alt="Artikel-6" class="img-fluid">';
                    }
                    if($_GET['id']=="7"){
                        echo '<img src="assets\img\artikel\artikel-7.jpg?v=1" alt="Artikel-7" class="img-fluid">';
                    }
                    if($_GET['id']=="8"){
                        echo '<img src="assets\img\artikel\artikel-8.jpg?v=1" alt="Artikel-8" class="img-fluid">';
                    }
                    if($_GET['id']=="9"){
                        echo '<img src="assets\img\artikel\artikel-9.jpg?v=1" alt="Artikel-9" class="img-fluid">';
                    }
                ?>
            </div>

            <div class="article-content">
                <?php
                    if($_GET['id']=="1"){
                        include "_Page/artikel/artikel-1.php";
                    }
                    if($_GET['id']=="2"){
                        include "_Page/artikel/artikel-2.php";
                    }
                    if($_GET['id']=="3"){
                        include "_Page/artikel/artikel-3.php";
                    }
                    if($_GET['id']=="4"){
                        include "_Page/artikel/artikel-4.php";
                    }
                    if($_GET['id']=="5"){
                        include "_Page/artikel/artikel-5.php";
                    }
                    if($_GET['id']=="6"){
                        include "_Page/artikel/artikel-6.php";
                    }
                    if($_GET['id']=="7"){
                        include "_Page/artikel/artikel-7.php";
                    }
                    if($_GET['id']=="8"){
                        include "_Page/artikel/artikel-8.php";
                    }
                    if($_GET['id']=="9"){
                        include "_Page/artikel/artikel-9.php";
                    }
                ?>
            </div>

            <div class="article-footer aos-init" data-aos="fade-up">
                <div class="share-article">
                    <h4>Share this article</h4>
                    <div class="share-buttons">
                        <a href="#" class="share-button twitter">
                            <i class="bi bi-twitter-x"></i>
                            <span>Share on X</span>
                        </a>
                        <a href="#" class="share-button facebook">
                            <i class="bi bi-facebook"></i>
                            <span>Share on Facebook</span>
                        </a>
                        <a href="#" class="share-button linkedin">
                            <i class="bi bi-linkedin"></i>
                            <span>Share on LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<!-- /Blog Details Section -->
