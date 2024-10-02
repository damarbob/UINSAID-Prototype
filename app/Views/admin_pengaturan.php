<?php
helper('form');
helper('setting'); // Must be declared to use setting helper function

// Pengaturan umum
$valueJudulSitus = old('judulSitus') ?: setting()->get('App.judulSitus');
$valueDeskripsiSitus = old('deskripsiSitus') ?: setting()->get('App.deskripsiSitus');
$valueKataKunciSitus = old('kataKunciSitus') ?: setting()->get('App.kataKunciSitus');
$valueSEOSitus = old('seoSitus') ?: setting()->get('App.seoSitus');

// Pengaturan tampilan
$valueLogo = old('logoSitus') ?: setting()->get('App.logoSitus');
$valueIkon = old('ikonSitus') ?: setting()->get('App.ikonSitus');
$valueTemaSitus = old('temaSitus') ?: setting()->get('App.temaSitus');
$valueHalamanUtamaSitus = old('halamanUtamaSitus') ?: setting()->get('App.halamanUtamaSitus');

// Pengaturan personal
$context = 'user:' . user_id(); //  Context untuk pengguna
$valueTemaDasborAdmin = old('temaDasborAdmin') ?: setting()->get('App.temaDasborAdmin', $context);
$valueBarisPerHalaman = old('barisPerHalaman') ?: setting()->get('App.barisPerHalaman', $context);

// Validasi
$errorLogo = validation_show_error('logo_file');
$errorIkon = validation_show_error('ikon_file');
?>

<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form action="" method="post" enctype="multipart/form-data">
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

            <!-- Tombol simpan -->
            <button class="btn btn-primary mb-4 me-2" type="submit" data-mdb-ripple-init>
                <i class="bi bi-check-lg me-2"></i><?= lang('Admin.simpan') ?>
            </button>

        </div>

        <div class="col-lg-6">

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

        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<?= $this->endSection() ?>