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
    $valueWebsite = (old('website'));
    $valueAlamat = (old('alamat'));
    $valueTelepon = (old('telepon'));
    $valueFax = (old('fax'));
    $valueEmail = (old('email'));
    $valueDeskripsi = (old('deskripsi'));
    $valueParentId = (old('parent_id'));
    $valueGambarSampul = (old('gambar_sampul_file'));
    $valueGrupId = (old('grup_id'));
    $valueId = 0;

    $errorGambarSampul = validation_show_error('gambar_sampul_file');
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari variabel
    $valueNama = (old('nama')) ? old('nama') : $entitas['nama'];
    $valueWebsite = (old('website')) ? old('website') : $entitas['website'];
    $valueAlamat = (old('alamat')) ? old('alamat') : $entitas['alamat'];
    $valueTelepon = (old('telepon')) ? old('telepon') : $entitas['telepon'];
    $valueFax = (old('fax')) ? old('fax') : $entitas['fax'];
    $valueEmail = (old('email')) ? old('email') : $entitas['email'];
    $valueDeskripsi = (old('deskripsi')) ? old('deskripsi') : $entitas['deskripsi'];
    $valueParentId = (old('parent_id')) ? old('parent_id') : $entitas['parent_id'];
    $valueGambarSampul = old('gambar_sampul_file') ?: $entitas['gambar_sampul'];
    $valueGrupId = old('grup_id') ?: $entitas['grup_id'];
    $valueId = $entitas['id'];

    $errorGambarSampul = validation_show_error('gambar_sampul_file');
}

?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <!-- Pesan sukses -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <a href="<?= base_url("admin/entitas") ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
        <?= session()->getFlashdata('sukses') ?>
    </div>
<?php elseif (session()->getFlashdata('gagal')) : ?>
    <!-- Pesan gagal -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <a href="<?= base_url("admin/entitas") ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
        <?= session()->getFlashdata('gagal') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= ($mode == "tambah") ? base_url('/admin/entitas/simpan') : base_url('/admin/entitas/simpan/') . $entitas['id'] ?>" class="form-container needs-validation" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="row mb-3">
        <div class="col-lg-8">

            <!-- Nama -->
            <div class="form-floating mb-3">
                <input id="nama" name="nama" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueNama ?>" placeholder="<?= lang('Admin.nama') ?>" required />
                <label for="nama"><?= lang('Admin.nama') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('nama'); ?>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="form mb-3">
                <textarea class="form-control tinymce" type="text" rows="20" name="deskripsi" id="deskripsi"><?= $valueDeskripsi ?></textarea>
            </div>
        </div>

        <div class="col-lg-4">

            <!-- Grup -->
            <div class="form-floating mb-3">
                <select class="form-select" id="grup_id" name="grup_id">
                    <?php foreach ($grup as $x): ?>
                        <option value="<?= $x['id'] ?>" <?= $valueGrupId == $x['id'] ? 'selected' : '' ?>><?= $x['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="grup_id"><?= lang('Admin.grup') ?></label>
                <!-- <div class="invalid-tooltip end-0">
                    <?= lang('Admin.pilihAtauInputGrup') ?>
                </div> -->
            </div>

            <!-- ParentId -->
            <div class="form-floating mb-3">
                <select id="parent_id" name="parent_id" class="form-select <?= (validation_show_error('parent_id')) ? 'is-invalid' : ''; ?>" aria-label="Default select">
                    <option value="<?= $universitas['id'] ?>" <?= isset($valueParentId) && $valueParentId == $x['id'] ? 'selected' : '' ?>>UIN Raden Mas Said Surakarta (utama)</option>
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

            <!-- Alamat editor -->
            <div class="form-floating mb-3">
                <input id="alamat" name="alamat" class="form-control <?= (validation_show_error('alamat')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueAlamat ?>" placeholder="<?= lang('Admin.alamat') ?>" />
                <label for="alamat"><?= lang('Admin.alamat') ?></label>
                <div class="invalid-tooltip end-0 mt-2">
                    <?= validation_show_error('alamat'); ?>
                </div>
            </div>

            <!-- Telepon editor -->
            <div class="form-floating mb-3">
                <input id="telepon" name="telepon" class="form-control <?= (validation_show_error('telepon')) ? 'is-invalid' : ''; ?>" type="tel" value="<?= $valueTelepon ?>" placeholder="<?= lang('Admin.telepon') ?>" />
                <label for="telepon"><?= lang('Admin.telepon') ?></label>
                <div class="invalid-tooltip end-0 mt-2">
                    <?= validation_show_error('telepon'); ?>
                </div>
            </div>
            <!-- Fax editor -->
            <div class="form-floating mb-3">
                <input id="fax" name="fax" class="form-control <?= (validation_show_error('fax')) ? 'is-invalid' : ''; ?>" type="tel" value="<?= $valueFax ?>" placeholder="<?= lang('Admin.fax') ?>" />
                <label for="fax"><?= lang('Admin.fax') ?></label>
                <div class="invalid-tooltip end-0 mt-2">
                    <?= validation_show_error('fax'); ?>
                </div>
            </div>
            <!-- Email editor -->
            <div class="form-floating mb-3">
                <input id="email" name="email" class="form-control <?= (validation_show_error('email')) ? 'is-invalid' : ''; ?>" type="email" value="<?= $valueEmail ?>" placeholder="<?= lang('Admin.email') ?>" />
                <label for="email"><?= lang('Admin.email') ?></label>
                <div class="invalid-tooltip end-0 mt-2">
                    <?= validation_show_error('email'); ?>
                </div>
            </div>
            <!-- Website editor -->
            <div class="form-floating mb-3">
                <input id="website" name="website" class="form-control <?= (validation_show_error('website')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueWebsite ?>" placeholder="<?= lang('Admin.website') ?>" />
                <label for="website"><?= lang('Admin.website') ?></label>
                <div class="invalid-tooltip end-0 mt-2">
                    <?= validation_show_error('website'); ?>
                </div>
            </div>

            <!-- Gambar Sampul file input -->
            <div class="form-floating mb-3">
                <input type="file" class="form-control" id="gambar_sampul" name="gambar_sampul_file">
                <label for="gambar_sampul">Gambar Sampul</label>

                <?php if (isset($valueGambarSampul) && $valueGambarSampul != ''): ?>

                    <!-- GambarSampul lama -->
                    <div class="form-helper">
                        <small>
                            <a href="<?= base_url($valueGambarSampul) ?>" id="gambarSampulOldLabel" target="_blank">
                                <!-- Filled dynamically by script -->
                            </a>
                        </small>
                    </div>

                    <!-- Button delete GambarSampul -->
                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusGambarSampul" data-mdb-ripple-init="">
                        <i class="bi bi-trash"></i>
                    </button>

                    <script>
                        // Add old gambar_sampul label and handle deletion
                        document.addEventListener('DOMContentLoaded', function() {
                            let gambarSampulOldLabel = document.getElementById("gambarSampulOldLabel");
                            let buttonHapusGambarSampul = document.getElementById('buttonHapusGambarSampul');

                            gambarSampulOldLabel.innerHTML =
                                getFilenameAndExtension('<?= $valueGambarSampul ?>') +
                                '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                            buttonHapusGambarSampul.addEventListener("click", function() {
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
                                        // Set input gambarSampulOld value to empty and hide hapus button
                                        document.getElementById('gambarSampulOld').value = '';
                                        buttonHapusGambarSampul.style.display = 'none';
                                        gambarSampulOldLabel.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>

                <?php endif; ?>

                <!-- Galat validasi -->
                <div class="alert alert-danger mt-2 <?= (!$errorGambarSampul) ? 'd-none' : ''; ?>" role="alert">
                    <?= $errorGambarSampul; ?>
                </div>

            </div>

            <!-- GambarSampul old input -->
            <input type="hidden" class="form-control" id="gambarSampulOld" name="gambar_sampul_old" value="<?= $valueGambarSampul ?>">

            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="btn btn-primary" data-mdb-ripple-init><i class="bi bi-floppy me-2"></i><?= lang('Admin.simpan') ?></button>

        </div>
    </div>
</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>

<!-- Tinymce -->
<script src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce/tinymce.min.js"></script>

<!-- DSM Gallery -->
<script src="<?= base_url('assets/js/tinymce/dsmgallery-plugin.js'); ?>"></script>

<!-- DSM File Insert -->
<script src="<?= base_url('assets/js/tinymce/dsmfileinsert-plugin.js'); ?>"></script>

<script>
    tinymce.init({
        selector: '#deskripsi',
        license_key: 'gpl',
        document_base_url: '<?= base_url() ?>', // Set the base URL for relative paths
        plugins: [
            'advlist', 'autolink', 'image',
            'lists', 'link', 'charmap', 'preview', 'anchor', 'searchreplace',
            'fullscreen', 'insertdatetime', 'table', 'help',
            'wordcount', 'dsmgallery'
        ],
        toolbar: 'fullscreen | dsmgallery | undo redo | casechange blocks | bold italic backcolor | image | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | code table help',
        image_title: true,
        automatic_uploads: true,
        dsmgallery_api_endpoint: '<?= base_url('/api/galeri') ?>',
        dsmgallery_gallery_url: '<?= base_url('/admin/galeri') ?>',
        dsmfileinsert_api_endpoint: '<?= base_url('/api/file') ?>',
        dsmfileinsert_file_manager_url: '<?= base_url('/admin/file') ?>',
        images_upload_url: '<?= base_url('/admin/posting/unggah-gambar') ?>',
        file_picker_types: 'image',
        file_picker_callback: (cb, value, meta) => {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.addEventListener('change', (e) => {
                const file = e.target.files[0];

                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    /*
                      Note: Now we need to register the blob in TinyMCEs image blob
                      registry. In the next release this part hopefully won't be
                      necessary, as we are looking to handle it internally.
                    */
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                });
                reader.readAsDataURL(file);
            });

            input.click();
        },
        // contextmenu: "image",
        paste_preprocess: (editor, args) => {
            // console.log(args.content);
            // args.content += ' preprocess';
        },
        promotion: false

    });
</script>

<!-- Preview foto -->
<script>
    function onFileUpload(input) {

        const preview = document.querySelector("#preview");
        const files = document.querySelector("input[type=file]").files;

        function readAndPreview(file) {
            // Make sure `file.name` matches our extensions criteria
            if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const image = new Image();
                    // image.height = 100;
                    image.width = 100;
                    image.title = file.name;
                    image.src = this.result;
                    preview.appendChild(image);
                };

                reader.readAsDataURL(file);
            }
        }

        if (files) {
            while (preview.lastElementChild) {
                preview.removeChild(preview.lastElementChild);
            }
            Array.prototype.forEach.call(files, readAndPreview);
        }
    }
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

<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>

<?= $this->endSection() ?>