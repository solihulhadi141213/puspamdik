<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-text-center"></i> Visi Misi</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Visi Misi</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman untuk mengatur isi konten visi san miisi pada website.
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="javascript:void(0);" id="ProsesSimpanVisiMisi" enctype="multipart/form-data">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom">
                        <b class="card-title text-dark">
                            <i class="bi bi-window-sidebar me-2"></i>
                            Form Kelola Konten Visi - Misi
                        </b>
                    </div>

                    <div class="card-body p-4">
                        <!-- Judul Halaman -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="visi_misi_title">Judul Halaman</label>
                                <input type="text" name="visi_misi_title" id="visi_misi_title" class="form-control">
                            </div>
                        </div>

                        <!-- Visi -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="visi_editor">Visi</label>
                                <div id="visi_editor" style="height: 200px;"></div>
                            </div>
                        </div>

                        <!-- Misi -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="misi_editor">Misi</label>
                                <div id="misi_editor" style="height: 200px;"></div>
                            </div>
                        </div>

                        <!-- Notifikasi -->
                        <div class="row mt-3">
                            <div class="col-12" id="NotifikasiSimpanVisiMisi"></div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top">
                        <button type="submit" class="btn btn-primary rounded-pill px-4" id="ButtonSimpanVisiMisi">
                            <i class="bi bi-save me-1"></i> Simpan Visi Misi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>