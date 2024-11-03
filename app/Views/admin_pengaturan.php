<?php
helper('form');
helper('setting'); // Must be declared to use setting helper function

// Pengaturan umum
$valueEntitasSitus = old('entitasSitus') ?: setting()->get('App.entitasSitus');
$valueJudulSitus = old('judulSitus') ?: setting()->get('App.judulSitus');
$valueDeskripsiSitus = old('deskripsiSitus') ?: setting()->get('App.deskripsiSitus');
$valueKataKunciSitus = old('kataKunciSitus') ?: setting()->get('App.kataKunciSitus');
$valueSEOSitus = old('seoSitus') ?: setting()->get('App.seoSitus');

// Pengaturan tampilan
$valueLogo = old('logoSitus') ?: setting()->get('App.logoSitus');
$valueLogoMobile = old('logoMobileSitus') ?: setting()->get('App.logoMobileSitus');
$valueLogoFooter = old('logoFooterSitus') ?: setting()->get('App.logoFooterSitus');
$valueIkon = old('ikonSitus') ?: setting()->get('App.ikonSitus');
$valueTemaSitus = old('temaSitus') ?: setting()->get('App.temaSitus');
$valueHalamanUtamaSitus = old('halamanUtamaSitus') ?: setting()->get('App.halamanUtamaSitus');
$valueAlamat = old('alamat') ?: setting()->get('App.alamat');
$valueTelepon = old('telepon') ?: setting()->get('App.telepon');
$valueEmail = old('email') ?: setting()->get('App.email');

// Pengaturan personal
$context = 'user:' . user_id(); //  Context untuk pengguna
$valueTemaDasborAdmin = old('temaDasborAdmin') ?: setting()->get('App.temaDasborAdmin', $context);
$valueBarisPerHalaman = old('barisPerHalaman') ?: setting()->get('App.barisPerHalaman', $context);

// Pengaturan lainnya
$valueSharingCaption = old('sharingCaption') ?: setting()->get('App.sharingCaption');
$valueTargetUkuranThumbnail = old('targetUkuranThumbnail') ?: setting()->get('App.targetUkuranThumbnail');
$valueBufferFactorThumbnail = old('bufferFactorThumbnail') ?: setting()->get('App.bufferFactorThumbnail');

// Validasi
$errorLogo = validation_show_error('logo_file');
$errorLogoMobile = validation_show_error('logo_mobile_file');
$errorLogoFooter = validation_show_error('logo_footer_file');
$errorIkon = validation_show_error('ikon_file');
?>

<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-lg-6">

            <!-- Pesan sukses atau error -->
            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('sukses') ?>
                    <!-- <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php elseif (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('gagal') ?>
                    <!-- <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php endif; ?>

            <!-- Entitas situs -->
            <div class="form-floating mb-3">
                <select class="form-select <?= (validation_show_error('entitasSitus')) ? 'is-invalid' : ''; ?>" id="entitasSitus" name="entitasSitus">
                    <?php foreach ($entitas as $x) : ?>
                        <option value="<?= $x['id'] ?>" <?= $valueEntitasSitus == $x['id'] ? 'selected' : '' ?>><?= $x['nama'] ?></option>
                    <?php endforeach ?>
                </select>
                <label for="entitasSitus" class="form-label"><?= lang('Admin.entitasSitus') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('entitasSitus'); ?>
                </div>
            </div>

            <!-- Judul situs -->
            <div class="form-outline position-relative mb-3" data-mdb-input-init>
                <input type="text" class="form-control form-control-lg <?= (validation_show_error('judulSitus')) ? 'is-invalid' : ''; ?>" id="judulSitus" name="judulSitus" value="<?= $valueJudulSitus ?>">
                <label for="judulSitus" class="form-label"><?= lang('Admin.judulSitus') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('judulSitus'); ?>
                </div>
            </div>

            <!-- Deskripsi situs -->
            <div class="form-outline mb-3" data-mdb-input-init>
                <input type="text" class="form-control form-control-lg <?= (validation_show_error('deskripsiSitus')) ? 'is-invalid' : ''; ?>" id="deskripsiSitus" name="deskripsiSitus" value="<?= $valueDeskripsiSitus ?>">
                <label for="deskripsiSitus" class="form-label"><?= lang('Admin.deskripsiSitus') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('deskripsiSitus'); ?>
                </div>
            </div>

            <!-- Kata kunci (keywords) -->
            <div class="form-outline mb-3" data-mdb-input-init>
                <input type="text" class="form-control form-control-lg <?= (validation_show_error('kataKunciSitus')) ? 'is-invalid' : ''; ?>" id="kataKunciSitus" name="kataKunciSitus" value="<?= $valueKataKunciSitus ?>">
                <label for="kataKunciSitus" class="form-label"><?= lang('Admin.kataKunciSitus') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('kataKunciSitus'); ?>
                </div>
            </div>

            <!-- Default switch -->
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="seoSitus" value="off">
                <input class="form-check-input <?= (validation_show_error('seoSitus')) ? 'is-invalid' : ''; ?>" type="checkbox" role="switch" id="seoSitus" name="seoSitus" <?= ($valueSEOSitus === "on") ? 'checked' : '' ?> />
                <label class="form-check-label" for="seoSitus"><?= lang('Admin.optimasiMesinPencari') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('seoSitus'); ?>
                </div>
            </div>

            <!-- Ikon file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="ikon" name="ikon_file">
                <label for="ikon">Ikon</label>

                <?php if (isset($valueIkon) && $valueIkon != ''): ?>

                    <!-- Ikon lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueIkon) ?>" id="ikonOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                            </a>
                        </small>
                    </div>

                    <!-- Button delete Ikon -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusIkon" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old ikon label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let ikonOldLabel = document.getElementById("ikonOldLabel");
                            let buttonHapusIkon = document.getElementById('buttonHapusIkon');

                            ikonOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $valueIkon ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusIkon.addEventListener("click", function() {
                                // Confirm delete
                                Swal.fire({
                                    title: '<?= lang('Admin.hapusItem') ?>',
                                    text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: 'var(--mdb-danger)',
                                    confirmButtonText: '<?= lang('Admin.hapus') ?>',
                                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set input ikonOld value to empty and hide hapus button
                                        document.getElementById('ikonOld').value = '';
                                        buttonHapusIkon.style.display = 'none';
                                        ikonOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorIkon) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorIkon; ?>
                </div>

            </div>

            <!-- Ikon old input -->
            <input type="hidden" class="form-control" id="ikonOld" name="ikon_old" value="<?= $valueIkon ?>">

            <!-- Bagian tampilan -->
            <h2 class="mb-3"><?= lang('Admin.tampilan') ?></h2>

            <!-- Logo file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="logo" name="logo_file">
                <label for="logo">Logo</label>

                <?php if (isset($valueLogo) && $valueLogo != ''): ?>

                    <!-- Logo lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueLogo) ?>" id="logoOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                            </a>
                        </small>
                    </div>

                    <!-- Button delete Logo -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusLogo" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old logo label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let logoOldLabel = document.getElementById("logoOldLabel");
                            let buttonHapusLogo = document.getElementById('buttonHapusLogo');

                            logoOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $valueLogo ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusLogo.addEventListener("click", function() {
                                // Confirm delete
                                Swal.fire({
                                    title: '<?= lang('Admin.hapusItem') ?>',
                                    text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: 'var(--mdb-danger)',
                                    confirmButtonText: '<?= lang('Admin.hapus') ?>',
                                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set input logoOld value to empty and hide hapus button
                                        document.getElementById('logoOld').value = '';
                                        buttonHapusLogo.style.display = 'none';
                                        logoOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorLogo) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorLogo; ?>
                </div>

            </div>

            <!-- Logo old input -->
            <input type="hidden" class="form-control" id="logoOld" name="logo_old" value="<?= $valueLogo ?>">

            <!-- LogoMobile file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="logoMobile" name="logo_mobile_file">
                <label for="logoMobile">Logo Mobile</label>

                <?php if (isset($valueLogoMobile) && $valueLogoMobile != ''): ?>

                    <!-- LogoMobile lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueLogoMobile) ?>" id="logoMobileOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                            </a>
                        </small>
                    </div>

                    <!-- Button delete LogoMobile -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusLogoMobile" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old logoMobile label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let logoMobileOldLabel = document.getElementById("logoMobileOldLabel");
                            let buttonHapusLogoMobile = document.getElementById('buttonHapusLogoMobile');

                            logoMobileOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $valueLogoMobile ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusLogoMobile.addEventListener("click", function() {
                                // Confirm delete
                                Swal.fire({
                                    title: '<?= lang('Admin.hapusItem') ?>',
                                    text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: 'var(--mdb-danger)',
                                    confirmButtonText: '<?= lang('Admin.hapus') ?>',
                                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set input logoMobileOld value to empty and hide hapus button
                                        document.getElementById('logoMobileOld').value = '';
                                        buttonHapusLogoMobile.style.display = 'none';
                                        logoMobileOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorLogoMobile) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorLogoMobile; ?>
                </div>

            </div>

            <!-- LogoMobile old input -->
            <input type="hidden" class="form-control" id="logoMobileOld" name="logo_mobile_old" value="<?= $valueLogoMobile ?>">

            <!-- Logo Footer file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="logo_footer" name="logo_footer_file">
                <label for="logo_footer">Logo Footer</label>

                <?php if (isset($valueLogoFooter) && $valueLogoFooter != ''): ?>

                    <!-- LogoFooter lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueLogoFooter) ?>" id="logoFooterOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                            </a>
                        </small>
                    </div>

                    <!-- Button delete LogoFooter -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusLogoFooter" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old logo_footer label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let logoFooterOldLabel = document.getElementById("logoFooterOldLabel");
                            let buttonHapusLogoFooter = document.getElementById('buttonHapusLogoFooter');

                            logoFooterOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $valueLogoFooter ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusLogoFooter.addEventListener("click", function() {
                                // Confirm delete
                                Swal.fire({
                                    title: '<?= lang('Admin.hapusItem') ?>',
                                    text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: 'var(--mdb-danger)',
                                    confirmButtonText: '<?= lang('Admin.hapus') ?>',
                                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set input logoFooterOld value to empty and hide hapus button
                                        document.getElementById('logoFooterOld').value = '';
                                        buttonHapusLogoFooter.style.display = 'none';
                                        logoFooterOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorLogoFooter) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorLogoFooter; ?>
                </div>

            </div>

            <!-- LogoFooter old input -->
            <input type="hidden" class="form-control" id="logoFooterOld" name="logo_footer_old" value="<?= $valueLogoFooter ?>">

            <!-- Tema situs -->
            <div class="form-floating mb-3">
                <select class="form-select <?= (validation_show_error('temaSitus')) ? 'is-invalid' : ''; ?>" id="temaSitus" name="temaSitus">
                    <?php foreach ($tema as $x) : ?>
                        <option value="<?= $x['id'] ?>" <?= $valueTemaSitus == $x['id'] ? 'selected' : '' ?>><?= $x['nama'] ?></option>
                    <?php endforeach ?>
                </select>
                <label for="temaSitus" class="form-label"><?= lang('Admin.temaSitus') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('temaSitus'); ?>
                </div>
            </div>

            <?php if (auth()->user()->inGroup("superadmin")): ?>
                <!-- Halaman utama -->
                <div class="form-floating mb-3">
                    <select class="form-select <?= (validation_show_error('halamanUtamaSitus')) ? 'is-invalid' : ''; ?>" id="halamanUtamaSitus" name="halamanUtamaSitus">
                        <?php foreach ($halaman as $x): ?>
                            <option value="<?= $x['slug'] ?>" <?= $valueHalamanUtamaSitus == $x['slug'] ? 'selected' : '' ?>><?= $x['judul'] ?></option>
                        <?php endforeach; ?>
                        <option value="" <?= $valueHalamanUtamaSitus == '' ? 'selected' : '' ?>><?= lang('Admin.tidakAda') ?></option>
                    </select>
                    <label for="halamanUtamaSitus" class="form-label"><?= lang('Admin.halamanUtamaSitus') ?></label>
                    <div class="invalid-tooltip end-0">
                        <?= validation_show_error('halamanUtamaSitus'); ?>
                    </div>
                </div>
            <?php endif ?>

            <!-- Tombol simpan -->
            <button class="btn btn-primary mb-4 me-2" type="submit" data-mdb-ripple-init>
                <i class="bi bi-check-lg me-2"></i><?= lang('Admin.simpan') ?>
            </button>

        </div>

        <div class="col-lg-6">

            <!-- Kontak dan media sosial -->
            <h2 class="mb-3"><?= lang('Admin.kontakDanMediaSosial') ?></h2>

            <!-- Kontak dan media Sosial -->
            <div class="w-100 mb-3">

                <!-- Atur media sosial -->
                <a class="btn btn-secondary btn-sm mb-3" href="<?= base_url('admin/media-sosial') ?>" data-mdb-ripple-init="">
                    <?= lang('Admin.aturMediaSosial') ?><i class="bi bi-arrow-right ms-2"></i>
                </a>

                <!-- Alamat -->
                <div class="form-outline position-relative mb-3" data-mdb-input-init>
                    <input type="text" class="form-control form-control-lg <?= (validation_show_error('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" value="<?= $valueAlamat ?>">
                    <label for="alamat" class="form-label"><?= lang('Admin.alamatFooter') ?></label>
                    <div class="invalid-tooltip end-0">
                        <?= validation_show_error('alamat'); ?>
                    </div>
                </div>

                <!-- Telepon -->
                <div class="form-outline position-relative mb-3" data-mdb-input-init>
                    <input type="tel" class="form-control form-control-lg <?= (validation_show_error('telepon')) ? 'is-invalid' : ''; ?>" id="telepon" name="telepon" value="<?= $valueTelepon ?>">
                    <label for="telepon" class="form-label"><?= lang('Admin.teleponFooter') ?></label>
                    <div class="invalid-tooltip end-0">
                        <?= validation_show_error('telepon'); ?>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-outline position-relative mb-3" data-mdb-input-init>
                    <input type="email" class="form-control form-control-lg <?= (validation_show_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= $valueEmail ?>">
                    <label for="email" class="form-label"><?= lang('Admin.emailFooter') ?></label>
                    <div class="invalid-tooltip end-0">
                        <?= validation_show_error('email'); ?>
                    </div>
                </div>

            </div>

            <h2 class="mb-3"><?= lang('Admin.lainnya') ?></h2>

            <div class="form-outline mb-3" data-mdb-input-init>
                <textarea class="form-control" rows="10" name="sharingCaption" id="sharingCaption"><?= $valueSharingCaption ?></textarea>
                <label for="sharingCaption" class="form-label mb-2">Sharing Caption</label>
            </div>

            <div class="d-flex gap-2 mb-3 align-items-center">
                <!-- Target ukuran thumbnail -->
                <div class="form-outline position-relative" data-mdb-input-init>
                    <input type="number" id="targetUkuranThumbnail" class="form-control <?= (validation_show_error('targetUkuranThumbnail')) ? 'is-invalid' : ''; ?>" name="targetUkuranThumbnail" value="<?php echo $valueTargetUkuranThumbnail ?: 500 ?>" required />
                    <label class="form-label" for="targetUkuranThumbnail"><?php echo lang('Admin.targetUkuranThumbnail') . ' (KB)' ?></label>
                    <div class="invalid-tooltip">
                        <?= validation_show_error('targetUkuranThumbnail') ?: lang('Admin.harusDiinput') ?>
                    </div>

                </div>

                <!-- Buffer Factor thumbnail -->
                <div class="form-outline position-relative" data-mdb-input-init>
                    <input type="number" id="bufferFactorThumbnail" class="form-control <?= (validation_show_error('bufferFactorThumbnail')) ? 'is-invalid' : ''; ?>" name="bufferFactorThumbnail" value="<?php echo $valueBufferFactorThumbnail ?: 2 ?>" required />
                    <label class="form-label" for="bufferFactorThumbnail"><?php echo lang('Admin.bufferFactorThumbnail') ?></label>
                    <div class="invalid-tooltip">
                        <?= validation_show_error('bufferFactorThumbnail') ?: lang('Admin.harusDiinput') ?>
                    </div>
                </div>

                <i class="bi bi-exclamation-circle-fill" data-mdb-tooltip-init data-mdb-html="true" title="<?php echo nl2br(lang('Admin.penjelasanTargetUkuranThumbnail') . "\n\n" . lang('Admin.penjelasanBufferFactorThumbnail') . "\n\n" . lang('Admin.rumusKompresiThumbnail')) ?>"></i>

            </div>

            <h2 class="mb-3"><?= lang('Admin.personalisasiAdmin') ?></h2>

            <!-- Tema dasbor admin -->
            <div class="form-floating mb-3">
                <select class="form-select <?= (validation_show_error('temaDasborAdmin')) ? 'is-invalid' : ''; ?>" id="temaDasborAdmin" name="temaDasborAdmin">
                    <option value="terang" <?= $valueTemaDasborAdmin == 'terang' ? 'selected' : '' ?>>Terang</option>
                    <option value="gelap" <?= $valueTemaDasborAdmin == 'gelap' ? 'selected' : '' ?>>Gelap</option>
                </select>
                <label for="temaDasborAdmin" class="form-label"><?= lang('Admin.temaDasborAdmin') ?></label>
            </div>

            <!-- Baris per halaman -->
            <div class="form-floating mb-3">
                <select class="form-select <?= (validation_show_error('barisPerHalaman')) ? 'is-invalid' : ''; ?>" id="barisPerHalaman" name="barisPerHalaman">
                    <option value="10" <?= $valueBarisPerHalaman == '10' ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $valueBarisPerHalaman == '20' ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= $valueBarisPerHalaman == '50' ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= $valueBarisPerHalaman == '100' ? `selected` : '' ?>>100</option>
                </select>
                <label for="BarisPerHalaman" class="form-label"><?= lang('Admin.barisPerHalaman') ?></label>
                <div class="form-helper">
                    <?= lang('Admin.jumlahBarisPerHalamanPada') ?>
                </div>
            </div>

            <?php if (auth()->user()->inGroup("superadmin")): ?>

                <!-- Data dan Penyimpanan -->
                <h2 class="mb-3"><?= lang('Admin.dataDanPenyimpanan') ?></h2>

                <!-- Penjelajah File -->
                <p><?= lang('Admin.jelajahiFileSistem') ?></p>
                <button type="button" class="btn btn-primary mb-3" onclick="penjelajahFile()" data-mdb-ripple-init>
                    <i class="bi bi-folder2 me-2"></i>
                    <?= lang('Admin.penjelajahFile') ?>
                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                </button>

                <!-- Bersihkan Foto -->
                <p><?= lang('Admin.bersihkanFileYangTidakTerpakai') ?></p>
                <button id="clearUnusedFilesButton" type="button" class="btn btn-danger btn-sm mb-3" data-mdb-ripple-init="">
                    <i class="bi bi-trash3 me-2"></i><?= lang('Admin.bersihkanFile') ?>
                </button>

            <?php endif ?>

        </div>

    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<script>
    function penjelajahFile() {
        Swal.fire({
            title: "<?= lang('Admin.penjelajahFile') ?>",
            text: "<?= lang('Admin.andaAkanMembukaPenjelajahFile') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "var(--mdb-warning)",
            confirmButtonText: "<?= lang('Admin.setuju') ?>",
            cancelButtonText: "<?= lang('Admin.batal') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                window.open("<?= base_url('admin/file-manager') ?>", "_blank");
            }
        });
    }
    document.getElementById('clearUnusedFilesButton').addEventListener('click', function() {
        Swal.fire({
            title: "<?= lang('Admin.bersihkanFile') ?>",
            text: "<?= lang('Admin.fileYangTidakTerpakaiAkanDibersihkan') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "var(--mdb-danger)",
            confirmButtonText: "<?= lang('Admin.bersihkan') ?>",
            cancelButtonText: "<?= lang('Admin.batal') ?>"
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX POST request
                fetch('<?= base_url('admin/pengaturan/bersihkan-data') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest', // Ensure it's recognized as an AJAX request
                        },
                        body: JSON.stringify({}), // Send any required data, or empty if none
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('<?= lang('Admin.sukses') ?>', data.message, 'success');
                        } else {
                            Swal.fire('<?= lang('Admin.galat') ?>', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('<?= lang('Admin.galat') ?>', '<?= lang('Admin.terjadiGalatSaatMemproses') ?>', 'error');
                    });
            }
        });
    });
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }
            }, false);
        });
    })();
</script>
<?= $this->endSection() ?>