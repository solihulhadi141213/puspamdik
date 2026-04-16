<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-gear"></i> Pengaturan Umum</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Pengaturan Umum</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <?php
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '  <small>';
                echo '      Berikut ini adalah halaman pengaturan umum aplikasi.';
                echo '      Pada halaman ini anda bisa mengatur properti aplikasi sesuai yang anda inginkan dari mulai judul, deskripsi, informasi kontak dan logo.';
                echo '      Periksa kembali pengaturan yang anda gunakan agar aplikasi berjalan dengan baik.';
                echo '      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '  </small>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="javascript:void(0);" id="ProsesSettingGeneral" enctype="multipart/form-data">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-gear text-primary me-2"></i>
                            Pengaturan Website
                        </h5>
                        <small class="text-muted">
                            Kelola identitas website, kontak, media sosial dan branding
                        </small>
                    </div>

                    <div class="card-body p-4">

                        <!-- INFORMASI WEBSITE -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Informasi Website</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Website</label>
                                    <input type="text" name="title_page" id="title_page"
                                        class="form-control rounded-3"
                                        maxlength="20"
                                        value="<?= htmlspecialchars($title_page ?? '') ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Author</label>
                                    <input type="text" name="author" id="author"
                                        class="form-control rounded-3"
                                        value="<?= htmlspecialchars($AuthorAplikasi ?? '') ?>">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Kata Kunci</label>
                                    <input type="text" name="kata_kunci" id="kata_kunci"
                                        class="form-control rounded-3"
                                        value="<?= htmlspecialchars($kata_kunci ?? '') ?>">
                                    <small class="text-muted">Pisahkan dengan tanda koma</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi"
                                        class="form-control rounded-3"
                                        rows="3"><?= htmlspecialchars($deskripsi ?? '') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- KONTAK -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Kontak Perusahaan</h6>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat_bisnis" id="alamat_bisnis"
                                        class="form-control rounded-3"
                                        rows="3"><?= htmlspecialchars($alamat_bisnis ?? '') ?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email_bisnis" id="email_bisnis"
                                        class="form-control rounded-3"
                                        value="<?= htmlspecialchars($email_bisnis ?? '') ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" name="telepon_bisnis" id="telepon_bisnis"
                                        class="form-control rounded-3"
                                        value="<?= htmlspecialchars($telepon_bisnis ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- MEDIA SOSIAL -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Media Sosial</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="medsos_wa" class="form-control rounded-3" placeholder="Whatsapp" value="<?= htmlspecialchars($medsos_wa ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="medsos_ig" class="form-control rounded-3" placeholder="Instagram URL" value="<?= htmlspecialchars($medsos_ig ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="medsos_fb" class="form-control rounded-3" placeholder="Facebook URL" value="<?= htmlspecialchars($medsos_fb ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="medsos_x" class="form-control rounded-3" placeholder="X / Twitter URL" value="<?= htmlspecialchars($medsos_x ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">Google Map</label>
                            <textarea name="google_map" id="google_map"
                                class="form-control rounded-3"
                                rows="3"><?= htmlspecialchars($google_map ?? '') ?></textarea>
                        </div>

                        <!-- BRANDING -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">Branding</h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>Favicon</label>
                                    <input type="file" name="favicon" class="form-control rounded-3">
                                </div>

                                <div class="col-md-6">
                                    <label>Logo</label>
                                    <input type="file" name="logo" class="form-control rounded-3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="base_url" class="form-label">Base URL</label>
                            <input 
                                type="url" 
                                name="base_url" 
                                id="base_url"
                                class="form-control rounded-3"
                                placeholder="https://example.com"
                                value="<?= htmlspecialchars($base_url ?? '') ?>"
                                required
                            >
                            <small class="text-muted">
                                Contoh: https://domainanda.com
                            </small>
                        </div>

                        <div id="NotifikasiSimpanSettingGeneral"></div>
                    </div>

                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-primary rounded-pill px-4" id="ButtonSettingGeneral">
                            <i class="bi bi-save me-2"></i>Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>