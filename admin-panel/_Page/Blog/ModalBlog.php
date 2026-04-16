<div class="modal fade" id="ModalTambahBlog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahBlog">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Blog 
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="blog_title">Judul Blog</label>
                            <input type="text" name="blog_title" id="blog_title" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="blog_date">Tanggal Terbiit</label>
                            <input type="date" name="blog_date" id="blog_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="blog_author">Penulis</label>
                            <input type="text" name="blog_author" id="blog_author" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="blog_cover">Blog Cover</label>
                            <input type="file" name="blog_cover" id="blog_cover" class="form-control" required>
                            <small class="text-secondary">
                                File maksimal 2 MB (JPG, PNG, GIF)
                            </small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="content_blog">Konten Blog</label>
                            <div id="content_blog" style="height:300px;"></div>
                            <input type="hidden" name="content_blog_input" id="content_blog_input">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahBlog">
                            <!-- Notifikasi Tambah Blog -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahBlog">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetailBlog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Blog
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 mb-2" id="FormDetailBlog">
                        <!-- Form Detail Akan Muncul Disini -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalEditBlog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditBlog">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Blog 
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="FormEditBlog">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="NotifikasiEditBlog">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditBlog">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalHapusBlog" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusBlog">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash"></i> Hapus Blog
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_Blog" id="hapus_id_Blog">

                    <div id="FormHapusBlog">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-danger"></div>
                            <div class="small mt-2 text-secondary">
                                Memuat data...
                            </div>
                        </div>
                    </div>

                    <div id="NotifikasiHapusBlog" class="mt-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="ButtonHapusBlog">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>

                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>