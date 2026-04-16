<div class="modal fade" id="ModalTambahPengurus" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahPengurus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Pengurus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <div class="row mb-3">
                        <div class="col-3"><label for="nama_pengurus">Nama Pengurus</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="nama_pengurus" id="nama_pengurus" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="jabatan_pengurus">Jabatan Pengurus</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="text" name="jabatan_pengurus" id="jabatan_pengurus" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3"><label for="foto_pengurus">Upload Foto</label></div>
                        <div class="col-1">:</div>
                        <div class="col-8">
                            <input type="file" name="foto_pengurus" id="foto_pengurus" class="form-control" required>
                            <small class="text text-secondary">
                                File Gambar Maksimal 2 Mb (Filtype : JPG, PNG, GIF)
                            </small>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahPengurus">
                            <!-- Notifikasi Tambah Pengurus -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahPengurus">
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

<div class="modal fade" id="ModalDetailPengurus" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Pengurus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 mb-2" id="FormDetailPengurus">
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

<div class="modal fade" id="ModalEditPengurus" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditPengurus">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Pengurus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="FormEditPengurus">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="NotifikasiEditPengurus">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditPengurus">
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

<div class="modal fade" id="ModalHapusPengurus" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusPengurus">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash"></i> Hapus Pengurus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_pengurus" id="hapus_id_pengurus">

                    <div id="FormHapusPengurus">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-danger"></div>
                            <div class="small mt-2 text-secondary">
                                Memuat data...
                            </div>
                        </div>
                    </div>

                    <div id="NotifikasiHapusPengurus" class="mt-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="ButtonHapusPengurus">
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