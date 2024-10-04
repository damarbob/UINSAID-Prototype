<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('form');


if ($mode == "tambah") {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueNama = (old('nama'));
    $valueURL = (old('url'));
    $valueIkon = (old('ikon'));
} else {
    $valueNama = old('nama') ?: $item['nama'];
    $valueURL = old('url') ?: $item['url'];
    $valueIkon = old('ikon') ?: $item['ikon'];
}

// Validasi
$errorIkon = validation_show_error('ikon_file');
?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <!-- Pesan sukses -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <a href="<?= base_url('admin/media-sosial') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
        <?= session()->getFlashdata('sukses') ?>
    </div>
<?php elseif (session()->getFlashdata('galat')) : ?>
    <!-- Pesan galat -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <a href="<?= base_url('admin/media-sosial') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
        <?= session()->getFlashdata('galat') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= ($mode == "tambah") ? base_url('admin/media-sosial/tambah/simpan') : base_url('admin/media-sosial/sunting/simpan/') . $item['id'] ?>" class="form-container" enctype="multipart/form-data" novalidate>

    <?= csrf_field() ?>

    <div class="row">

        <div class="col-lg-6">

            <!-- Nama -->
            <div class="form-floating mb-3">

                <input id="nama"
                    name="nama"
                    class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>"
                    type="text"
                    value="<?= $valueNama ?>"
                    placeholder="<?= lang('Admin.nama') ?>" required />

                <label for="nama"><?= lang('Admin.nama') ?></label>

                <div class="invalid-feedback">
                    <?= lang('Admin.harusDiinput'); ?>
                </div>

            </div>

            <!-- URL -->
            <div class="form-floating mb-3">

                <input id="url"
                    name="url"
                    class="form-control <?= (validation_show_error('url')) ? 'is-invalid' : ''; ?>"
                    type="text"
                    value="<?= $valueURL ?>"
                    placeholder="<?= lang('Admin.url') ?>" required />

                <label for="url"><?= lang('Admin.alamatSitus') ?></label>

                <div class="invalid-feedback">
                    <?= (validation_show_error('url')); ?>
                </div>

            </div>

            <!-- Ikon file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="ikon" name="ikon_file">
                <label for="ikon"><?= lang('Admin.ikon') ?></label>

                <?php if (isset($item['ikon']) && $item['ikon'] != ''): ?>

                    <!-- Ikon lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueIkon) ?>" id="ikonOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
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
                                getFilenameAndExtension('<?= ($item['ikon']) ?>') +
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

            <!-- Urutan -->
            <div class="form-floating mb-3">
                <select class="form-select" id="urutan" name="urutan">
                    <?php foreach ($urutan['options'] as $x): ?>
                        <option value="<?= $x ?>" <?= $urutan['current'] == $x ? 'selected' : '' ?>><?= $x ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="urutan"><?= lang('Admin.urutan') ?></label>

                <div class="invalid-feedback">
                    <?= (validation_show_error('urutan')); ?>
                </div>

            </div>

            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="btn btn-primary mb-5" data-mdb-ripple-init><i class='bi bi-check-lg me-2'></i><?= lang('Admin.simpan') ?></button>

        </div>

    </div>

</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>

<?= $this->endSection() ?>