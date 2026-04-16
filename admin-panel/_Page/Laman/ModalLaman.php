<div class="modal fade" id="ModalTambahLaman" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahLaman">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Laman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-3"><label for="judul_laman">Judul Laman</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="judul_laman" id="judul_laman" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="kategori_laman">Kategori Laman</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="kategori_laman" id="kategori_laman" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="date_laman">Tanggal</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="date" name="date_laman" id="date_laman" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="cover_laman">Upload Cover</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="file" name="cover_laman" id="cover_laman" class="form-control" required>
                            <small class="text text-secondary">
                                File Gambar Maksimal 2 Mb (Filtype : JPG, PNG, GIF)
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="konten_laman">Konten Laman</label>
                            <div id="konten_laman" style="height:300px;"></div>
                            <input type="hidden" name="konten_laman_input" id="konten_laman_input">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahLaman">
                            <!-- Notifikasi Tambah Laman -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahLaman">
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

<div class="modal fade" id="ModalDetailLaman" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Laman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 mb-2" id="FormDetailLaman">
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

<div class="modal fade" id="ModalEditLaman" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditLaman">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Laman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="FormEditLaman">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="NotifikasiEditLaman">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditLaman">
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

<div class="modal fade" id="ModalHapusLaman" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusLaman">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash"></i> Hapus Laman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_laman" id="hapus_id_laman">

                    <div id="FormHapusLaman">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-danger"></div>
                            <div class="small mt-2 text-secondary">
                                Memuat data...
                            </div>
                        </div>
                    </div>

                    <div id="NotifikasiHapusLaman" class="mt-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="ButtonHapusLaman">
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