<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('form');
date_default_timezone_set("Asia/Jakarta");

if ($mode == "tambah") {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueNama = (old('nama'));
    $valueUri = (old('uri'));
    $valueLinkEksternal = (old('link_eksternal'));
    $valueUrutan = (old('urutan'));
    $valueParentId = (old('parent_id'));
    $valueId = 0;
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari variabel
    $valueNama = (old('nama')) ? old('nama') : $menu['nama'];
    $valueUri = (old('uri')) ? old('uri') : $menu['uri'];
    $valueLinkEksternal = (old('link_eksternal')) ? old('link_eksternal') : $menu['link_eksternal'];
    $valueUrutan = (old('urutan')) ? old('urutan') : $menu['urutan'];
    $valueParentId = (old('parent_id')) ? old('parent_id') : $menu['parent_id'];
    $valueId = $menu['id'];
}

?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <!-- Pesan sukses -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('sukses') ?>
        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (session()->getFlashdata('gagal')) : ?>
    <!-- Pesan gagal -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('gagal') ?>
        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form method="post" action="<?= ($mode == "tambah") ? base_url('/admin/menu/simpan') : base_url('/admin/menu/simpan/') . $menu['id'] ?>" class="form-container needs-validation" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="row mb-3">
        <div class="col-md-9">

            <!-- Nama -->
            <div class="form-floating mb-3">
                <input id="nama" name="nama" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueNama ?>" placeholder="<?= lang('Admin.nama') ?>" required />
                <label for="nama"><?= lang('Admin.nama') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('nama'); ?>
                </div>
            </div>

            <!-- Uri editor -->
            <div class="form-floating mb-3">
                <input id="uri" name="uri" class="form-control <?= (validation_show_error('uri')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueUri ?>" placeholder="<?= lang('Admin.uri') ?>" />
                <label for="uri"><?= lang('Admin.uri') ?></label>
                <div class="invalid-tooltip end-0 mt-2">
                    <?= validation_show_error('uri'); ?>
                </div>
            </div>

            <!-- Link Eksternal -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="link_eksternal" id="link_eksternal" <?= $valueLinkEksternal == 0 ? '' : 'checked' ?> />
                <label class="form-check-label" for="link_eksternal"><?= lang('Admin.linkEksternal') ?></label>
            </div>

            <!-- ParentId -->
            <div class="form-floating mb-3">
                <select id="parent_id" name="parent_id" class="form-select <?= (validation_show_error('parent_id')) ? 'is-invalid' : ''; ?>" aria-label="Default select">
                    <option value="<?= 0 ?>"><?= lang('Admin.menuUtama') ?></option>
                    <?php foreach ($parents as $x): ?>
                        <?php if ($x['id'] != $valueId): ?>
                            <option value="<?= $x['id'] ?>" <?= isset($valueParentId) && $valueParentId == $x['id'] ? 'selected' : '' ?>><?= $x['nama'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <label for="parent_id"><?= lang('Admin.induk') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('parent_id'); ?>
                </div>
            </div>

            <!-- Urutan -->
            <div class="form-floating mb-3">
                <select class="form-select" id="urutan" name="urutan">
                    <?php foreach ($urutanOptions['options'] as $x): ?>
                        <option value="<?= $x ?>" <?= $urutanOptions['current'] == $x ? 'selected' : '' ?>><?= $x ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="urutan"><?= lang('Admin.urutan') ?></label>
                <!-- <div class="invalid-tooltip end-0">
                    <?= lang('Admin.pilihAtauInputUrutan') ?>
                </div> -->
            </div>

            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="btn btn-primary w-100" data-mdb-ripple-init><i class="bi bi-floppy me-2"></i><?= lang('Admin.simpan') ?></button>

        </div>
</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<!-- Handle urutan -->
<script>
    $(document).ready(function() {
        $('#parent_id').on('change', function() {
            var parentId = $(this).val();
            var menuId = <?= $valueId ?>; // Get the menu ID if editing

            // AJAX call to get new urutan options
            $.ajax({
                url: '<?= base_url('api/menu/getUrutanOptions') ?>',
                type: 'POST',
                data: {
                    parent_id: parentId,
                    menu_id: menuId
                },
                success: function(response) {
                    $('#urutan').empty(); // Clear existing options
                    console.log(response.data);

                    $.each(response.data.options, function(index, value) {
                        $('#urutan').append(new Option(value, value));
                        // $('#urutan').append($('<option>', {
                        //     value: value,
                        //     text: value
                        // }));
                        // var o = new Option(value, value);
                        // $(o).html(value);
                        // $("#urutan").append(o);
                    });

                    // Preselect the current urutan
                    $('#urutan').val(response.data.current);
                }
            });
        });
    });
</script>

<!-- Client side validation -->
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