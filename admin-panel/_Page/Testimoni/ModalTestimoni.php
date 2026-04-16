<div class="modal fade" id="ModalTambahTestimoni" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahTestimoni">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-plus"></i> Tambah Testimoni (Slider)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" >
                    <!-- Nama Responsen -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="nama_responden">Nama Responden</label>
                            <input type="text" name="nama_responden" id="nama_responden" class="form-control" required>
                        </div>
                    </div>

                    <!-- Tanggal Testimoni -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="tanggal_testimoni">Tanggal Testimoni</label>
                            <input type="date" name="tanggal_testimoni" id="tanggal_testimoni" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <!-- Foto Responden -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="foto_responden">Foto Responsen</label>
                            <input type="file" name="foto_responden" id="foto_responden" class="form-control">
                            <small class="text text-secondary">
                                File Gambar Maksimal 2 Mb (Filtype : JPG, PNG, GIF)
                            </small>
                        </div>
                    </div>
                    
                    <!-- Isi Testimoni -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="isi_testimoni">Isi Testimoni</label>
                            <textarea name="isi_testimoni" id="isi_testimoni" class="form-control"></textarea>
                            <small class="text text-secondary">
                                Isi Testimoni Maksimal 1.000 Karakter termasuk spasi
                            </small>
                        </div>
                    </div>

                    <!-- Notifikasi -->
                    <div class="row mb-2">
                        <div class="col-md-12" id="NotifikasiTambahTestimoni">
                            <!-- Notifikasi Tambah Testimoni -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahTestimoni">
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


<div class="modal fade" id="ModalDetailTestimoni" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">
                    <i class="bi bi-info-circle"></i> Detail Testimoni
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-12 mb-2" id="FormDetailTestimoni">
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

<div class="modal fade" id="ModalEditTestimoni" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditTestimoni">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-pencil"></i> Edit Testimoni (Slider)
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="FormEditTestimoni">
                           <!-- Form Edit Akan Muncul Disini -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 mb-2" id="NotifikasiEditTestimoni">
                           <!-- Notifikasi Edit Akan Muncul Disini -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonEditTestimoni">
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

<div class="modal fade" id="ModalHapusTestimoni" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusTestimoni">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-trash"></i> Hapus Testimoni
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_testimoni" id="hapus_id_testimoni">

                    <div id="FormHapusTestimoni">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-danger"></div>
                            <div class="small mt-2 text-secondary">
                                Memuat data...
                            </div>
                        </div>
                    </div>

                    <div id="NotifikasiHapusTestimoni" class="mt-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="ButtonHapusTestimoni">
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