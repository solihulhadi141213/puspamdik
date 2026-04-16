<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-layers"></i> Blog</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Blog</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman untuk mengelola daftar konten blog. 
                    Mulai posting artikel/berita anda di halaman ini.
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 mb-3 text-end">
                            <button type="button" class="btn btn-md btn-outline-dark btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilter">
                                <i class="bi bi-funnel"></i>
                            </button>
                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalTambah">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="table table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th align="center"><b>No</b></th>
                                    <th align="center"><b>Tanggal</b></th>
                                    <th align="center"><b>Judul</b></th>
                                    <th align="center"><b>Penulis</b></th>
                                    <th align="center"><b>Status</b></th>
                                    <th align="center"><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelBlog">
                                <tr>
                                    <td colspan="6" align="center">
                                        <small class="text-danger">Tidak Ada Data Fitur Yang Ditampilkan!</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>