<?php
helper('form');
helper('setting'); // Must be declared to use setting helper function

$valueJudulSitus = old('judulSitus') ?: setting()->get('App.judulSitus');
$valueDeskripsiSitus = old('deskripsiSitus') ?: setting()->get('App.deskripsiSitus');
$valueKataKunciSitus = old('kataKunciSitus') ?: setting()->get('App.kataKunciSitus');
$valueSEOSitus = old('seoSitus') ?: setting()->get('App.seoSitus');
$valueTemaSitus = old('temaSitus') ?: setting()->get('App.temaSitus');
$valueHalamanUtamaSitus = old('halamanUtamaSitus') ?: setting()->get('App.halamanUtamaSitus');

// Pengaturan personal
$context = 'user:' . user_id(); //  Context untuk pengguna
$valueTemaDasborAdmin = old('temaDasborAdmin') ?: setting()->get('App.temaDasborAdmin', $context);
$valueBarisPerHalaman = old('barisPerHalaman') ?: setting()->get('App.barisPerHalaman', $context);
?>

<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 col-lg-6">
        <form action="" method="post" enctype="multipart/form-data">

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

            <h2 class="mt-4 mb-3"><?= lang('Admin.personalisasiAdmin') ?></h2>

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

            <!-- Tombol simpan -->
            <button class="btn btn-primary mb-4 me-2" type="submit" data-mdb-ripple-init>
                <i class="bi bi-check-lg me-2"></i><?= lang('Admin.simpan') ?>
            </button>

        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>