<?php
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAkses,'pBB9mGcl7DBaSkynA75');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-layers"></i> Hero (Slider)</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Hero (Slider)</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small>
                        Berikut ini adalah halaman untuk mengelola tampilan Hero (Slider). 
                        Pada halaman ini anda bisa menambahkan daftar slider secara dinamis.
                    </small>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-md btn-floating btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahHero">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <div id="TabelHero" class="hero-container">
                    <div class="text-center p-5 border border-4 border-secondary rounded-4">
                        <h1 class="text-dark">
                            <i class="bi bi-exclamation-circle"></i>
                        </h1>
                        Tidak Ada Data Yang Ditemukan
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>