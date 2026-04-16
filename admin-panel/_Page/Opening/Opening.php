<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-text-center"></i> Pengantar (Opening)</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Pengantar (Opening)</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman untuk mengatur isi konten kata pembuka pada website.
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="javascript:void(0);" id="ProsesSimpanOpening" enctype="multipart/form-data">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-bottom">
                        <b class="card-title text-dark">
                            <i class="bi bi-window-sidebar me-2"></i>
                            Pengantar (Opening)
                        </b>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">

                            <!-- Upload Gambar -->
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold">Gambar Pembuka</label>

                                <label for="opening_image" class="upload-box w-100" id="opening_preview_box">
                                    <div class="text-center" id="opening_upload_placeholder">
                                        <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
                                        <div class="mt-2 fw-semibold">Upload disini</div>
                                        <small class="text-muted">
                                            Maks 2 MB (JPG, PNG, GIF)
                                        </small>
                                    </div>

                                    <img
                                        id="opening_preview"
                                        src=""
                                        class="img-fluid rounded-4 d-none"
                                        style="max-height:220px; object-fit:cover;"
                                        alt="Preview"
                                    >
                                </label>

                                <input type="file" name="opening_image" id="opening_image" class="d-none">
                            </div>

                            <!-- Konten -->
                            <div class="col-12 col-md-8">

                                <!-- Judul -->
                                <div class="mb-3">
                                    <label for="opening_title" class="form-label fw-semibold">
                                        Judul
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-type-h1"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="opening_title"
                                            id="opening_title"
                                            class="form-control"
                                            maxlength="250"
                                            placeholder="Masukkan judul pembuka"
                                        >
                                    </div>

                                    <small class="text-muted">
                                        Maksimal 250 karakter
                                    </small>
                                </div>

                                <!-- Rich Text -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Isi Kata Pembuka
                                    </label>

                                    <div id="opening_editor" style="height: 250px;"></div>

                                    <textarea
                                        name="opening_content"
                                        id="opening_content"
                                        class="d-none"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Notifikasi -->
                        <div class="row mt-3">
                            <div class="col-12" id="NotifikasiSimpanOpening"></div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top">
                        <button
                            type="submit"
                            class="btn btn-primary rounded-pill px-4"
                            id="ButtonSimpanOpening"
                        >
                            <i class="bi bi-save me-1"></i>
                            Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>