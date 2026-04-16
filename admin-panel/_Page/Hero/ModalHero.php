<div class="modal fade" id="ModalTambahHero" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahHero">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Hero (Slider)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-3"><label for="hero_title">Judul</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="hero_title" id="hero_title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="hero_description">Deskripsi</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="hero_description" id="hero_description" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="hero_image">Gambar</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="file" name="hero_image" id="hero_image" class="form-control" required>
                            <small class="text text-secondary">
                                File Gambar Maksimal 2 Mb (Filtype : JPG, PNG, GIF)
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="tombol_hero">Buat Tombol</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <select name="tombol_hero" id="tombol_hero" class="form-control">
                                <option value="1">Sediakan</option>
                                <option value="0">Tidak Ada</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="hero_link">URL Tombol</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="url" name="hero_link" id="hero_link" class="form-control" placeholder="https://">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="hero_link_label">Label Tombol</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="hero_link_label" id="hero_link_label" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahHero">
                            <!-- Notifikasi Tambah Hero -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonTambahHero">
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
<div class="modal fade" id="ModalEditHero" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditHero">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Hero (Slider)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="FormEditHero">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="NotifikasiEditHero">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-rounded" id="ButtonEditHero">
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
<div class="modal fade" id="ModalHapusHero" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusHero">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash"></i> Hapus Hero
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_hero" id="hapus_id_hero">

                    <div class="alert alert-warning mb-3">
                        Anda yakin ingin menghapus data hero ini?
                    </div>

                    <div id="NotifikasiHapusHero"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="ButtonHapusHero">
                        <i class="bi bi-trash"></i> Ya, Hapus
                    </button>

                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>