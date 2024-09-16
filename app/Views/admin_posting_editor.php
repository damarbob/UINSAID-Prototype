<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('form');

if ($mode == "tambah") {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueJudul = (old('judul'));
    $valueKonten = (old('konten'));
    $valueRingkasan = (old('ringkasan'));
    $valueKategori = (old('kategori'));
    $valueStatus = (old('status'));
    $valueTglTerbit = (old('tanggal_terbit'));
} else {
    $tglTerbit = strtotime($posting['tanggal_terbit']);
    $tglTerbitFormat = date("Y-m-d H:i", $tglTerbit);
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari variabel
    $valueJudul = (old('judul')) ? old('judul') : $posting['judul'];
    $valueKonten = (old('konten')) ? old('konten') : $posting['konten'];
    $valueRingkasan = (old('ringkasan')) ? old('ringkasan') : $posting['ringkasan'];
    $valueKategori = (old('kategori')) ? old('kategori') : $posting['kategori'];
    $valueStatus = (old('status')) ? old('status') : $posting['status'];
    $valueTglTerbit = (old('tanggal_terbit')) ? old('tanggal_terbit') : $posting['tanggal_terbit'];
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

<form method="post" action="<?= ($mode == "tambah") ? base_url('/admin/posting/tambah/simpan') : base_url('/admin/posting/sunting/simpan/') . $posting['id'] ?>" class="form-container needs-validation" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="row mb-3">
        <div class="col-md-9">

            <!-- Jenis postingan -->
            <!-- <input type="hidden" name="jenis" value="berita" /> -->

            <!-- Judul -->
            <div class="form-floating mb-3">
                <input id="judul" name="judul" class="form-control <?= (validation_show_error('judul')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueJudul ?>" placeholder="<?= lang('Admin.judul') ?>" required />
                <label for="judul"><?= lang('Admin.judul') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('judul'); ?>
                </div>
            </div>

            <!-- Konten editor -->
            <div class="form mb-3">
                <textarea id="konten" name="konten" class="form-control tinymce <?= (validation_show_error('konten')) ? 'is-invalid' : ''; ?>" rows="20" type="text" required><?= $valueKonten ?></textarea>
                <div class="invalid-feedback">
                    <?= validation_show_error('konten'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <!-- Ringkasan -->
            <div class="form-floating mb-3">
                <textarea id="ringkasan" name="ringkasan" class="form-control overlayscollbar" rows="5" type="text" placeholder="<?= lang('Admin.ringkasan') ?>"><?= $valueRingkasan ?></textarea>
                <label class="control-label mb-2"><?= lang('Admin.ringkasan') ?></label>
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="kategoriSelect" class="form-label"><?= lang('Admin.kategori') ?></label>
                <select class="form-select" id="kategoriSelect" name="kategori" required>
                    <?php foreach ($kategori as $key): ?>
                        <option value="<?= $key['nama'] ?>" <?= $key['nama'] == $valueKategori ? 'selected' : '' ?>><?= $key['nama'] ?></option>
                    <?php endforeach ?>
                    <option value=""><?= lang('Admin.tambahBaru') ?></option>
                </select>
                <!-- <div class="invalid-feedback">
                    <?= lang('Admin.pilihAtauInputKategori') ?>
                </div> -->
            </div>

            <div class="mb-3">
                <input type="text" class="form-control mt-2 mb-3" id="inputKategoriLainnya" name="kategori_lainnya" placeholder="<?= lang("Admin.namaKategori") ?>" disabled>
            </div>

            <!-- Status -->
            <div class="form-floating mb-3">
                <select id="status" name="status" class="form-select <?= (validation_show_error('status')) ? 'is-invalid' : ''; ?>" aria-label="Default select">
                    <?php if ($valueStatus == 'draf') : ?>
                        <option selected value="draf"><?= lang('Admin.draf') ?></option>
                        <option value="publikasi"><?= lang('Admin.publikasi') ?></option>
                    <?php elseif ($valueStatus == 'publikasi') : ?>
                        <option value="draf"><?= lang('Admin.draf') ?></option>
                        <option selected value="publikasi"><?= lang('Admin.publikasi') ?></option>
                    <?php else : ?>
                        <option value="draf"><?= lang('Admin.draf') ?></option>
                        <option selected value="publikasi"><?= lang('Admin.publikasi') ?></option>
                    <?php endif; ?>
                </select>
                <label for="status"><?= lang('Admin.status') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('status'); ?>
                </div>

            </div>
            <div class="form-floating mb-3">

                <!-- Tanggal terbit -->
                <div class="form mb-3">
                    <label for="terbit"><?= lang('Admin.tanggalTerbit') ?></label>
                    <input id="terbit" name="tanggal_terbit" class="form-control <?= (validation_show_error('terbit')) ? 'is-invalid' : ''; ?>" required value="<?= $valueTglTerbit ?>" />
                    <div class="invalid-feedback">
                        <?= lang('Admin.harusDiinput'); ?>
                    </div>
                    <div class="invalid-feedback">
                        <?= validation_show_error('tanggal_terbit'); ?>
                    </div>

                </div>
            </div>

            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="btn btn-primary w-100"><?= lang('Admin.simpan') ?></button>

        </div>
</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<!-- Tinymce -->
<script src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#konten',
        license_key: 'gpl',
        plugins: [
            'advlist', 'autolink', 'image',
            'lists', 'link', 'charmap', 'preview', 'anchor', 'searchreplace',
            'fullscreen', 'insertdatetime', 'table', 'help',
            'wordcount', 'deleteimage', 'dsmgallery'
        ],
        toolbar: 'fullscreen | dsmgallery | undo redo | casechange blocks | bold italic backcolor | image | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | code table help',
        image_title: true,
        automatic_uploads: true,
        image_gallery_api_endpoint: '/api/galeri',
        dsmgallery_api_endpoint: '/api/galeri',
        images_upload_url: '/admin/posting/unggah-gambar',
        images_delete_url: '/admin/posting/hapus-gambar',
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
<script src="<?php echo base_url(); ?>assets/js/tinymce/deleteimage-plugin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tinymce/dsmgallery-plugin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tinymce/imagegallery-plugin.js"></script>

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

<!-- Handle kategori lainnya -->
<script>
    // Select
    document.addEventListener('DOMContentLoaded', function() {
        const selectKategori = document.getElementById('kategoriSelect');
        const inputKategoriLainnya = document.getElementById('inputKategoriLainnya');

        selectKategori.addEventListener('change', function() {
            if (selectKategori.value === '') { // If "Lainnya" is selected
                inputKategoriLainnya.disabled = false;
                inputKategoriLainnya.required = true;
            } else {
                inputKategoriLainnya.disabled = true;
                inputKategoriLainnya.required = false;
                inputKategoriLainnya.value = ''; // Clear the input if another option is selected
            }
        });
    });
</script>

<!-- datetimepicker -->
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<script>
    $('#terbit').datetimepicker({
        datepicker: {
            showOtherMonths: true,
        },
        footer: true,
        modal: true,
        format: 'yyyy-mm-dd HH:MM',
        uiLibrary: 'materialdesign',
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

<!-- Auto complete kategori -->
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

<?= $this->endSection() ?>