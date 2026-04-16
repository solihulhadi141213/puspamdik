<div class="modal fade" id="ModalTambahBuku" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahBuku">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Buku 
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="judul_buku">Judul Buku</label>
                            <input type="text" name="judul_buku" id="judul_buku" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="penulis_buku">Nama Penulis</label>
                            <input type="text" name="penulis_buku" id="penulis_buku" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="isbn_buku">ISBN</label>
                            <input type="text" name="isbn_buku" id="isbn_buku" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="harga_buku">Harga</label>
                            <input type="number" name="harga_buku" id="harga_buku" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="reting_buku">Rating Buku</label>
                            <select name="reting_buku" id="reting_buku" class="form-control">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="terjual">Terjual</label>
                            <input type="number" min="0" step="1" name="terjual" id="terjual" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="cover_buku">Cover Buku</label>
                            <input type="file" name="cover_buku" id="cover_buku" class="form-control" required>
                            <small class="text-secondary">
                                File maksimal 2 MB (JPG, PNG, GIF)
                            </small>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahBuku">
                            <!-- Notifikasi Tambah Buku -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahBuku">
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

<div class="modal fade" id="ModalDetailBuku" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Buku
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 mb-2" id="FormDetailBuku">
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

<div class="modal fade" id="ModalEditBuku" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditBuku">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Buku 
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="FormEditBuku">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="NotifikasiEditBuku">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditBuku">
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

<div class="modal fade" id="ModalHapusBuku" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusBuku">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash"></i> Hapus Buku
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_buku" id="hapus_id_buku">

                    <div id="FormHapusBuku">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-danger"></div>
                            <div class="small mt-2 text-secondary">
                                Memuat data...
                            </div>
                        </div>
                    </div>

                    <div id="NotifikasiHapusBuku" class="mt-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="ButtonHapusBuku">
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