<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('form');


if ($mode == "tambah") {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueNama = (old('nama_situs'));
    $valueAlamat = (old('alamat_situs'));
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueNama = (old('nama_situs')) ? old('nama_situs') : $situs['nama'];
    $valueAlamat = (old('alamat_situs')) ? old('alamat_situs') : $situs['alamat'];
}
?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <!-- Pesan sukses -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('sukses') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->getFlashdata('gagal')) : ?>
    <!-- Pesan gagal -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('gagal') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="post" action="<?= ($mode == "tambah") ? base_url('/admin/situs/tambah/simpan') : base_url('/admin/situs/sunting/simpan/') . $situs['id'] ?>" class="form-container needs-validation" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="row mb-3">
        <div class="col-12">
            <!-- Nama Situs -->
            <div class="form-floating mb-3">
                <input id="nama_situs" name="nama_situs" class="form-control <?= (validation_show_error('nama_situs')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueNama ?>" placeholder="Nama Situs" required />
                <label for="nama_situs">Nama Situs</label>
                <div class="invalid-feedback">
                    <?= lang('Admin.harusDiinput'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Alamat Situs -->
            <div class="form-floating mb-3">
                <input id="alamat_situs" name="alamat_situs" class="form-control <?= (validation_show_error('alamat_situs')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueAlamat ?>" placeholder="Alamat Situs" required />
                <label for="alamat_situs">Alamat Situs</label>
                <div class="invalid-feedback">
                    <?= lang('Admin.harusDiinput'); ?>
                </div>
            </div>
        </div>
        <div class="col-12">
            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="btn btn-primary mb-5"><?= lang('Admin.simpan') ?></button>
        </div>
    </div>
</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

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