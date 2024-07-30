<?= $this->extend('layout/admin/admin_template') ?>

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
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueJudul = (old('judul')) ? old('judul') : $berita['judul'];
    $valueKonten = (old('konten')) ? old('konten') : $berita['konten'];
    $valueRingkasan = (old('ringkasan')) ? old('ringkasan') : $berita['ringkasan'];
    $valueKategori = (old('kategori')) ? old('kategori') : $berita['kategori'];
    $valueStatus = (old('status')) ? old('status') : $berita['status'];
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

<form method="post" action="<?= ($mode == "tambah") ? base_url('/admin/berita/tambah/simpan') : base_url('/admin/berita/sunting/simpan/') . $berita['id'] ?>" class="form-container" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-9">
            <!-- Judul -->
            <div class="form-floating mb-3">
                <input id="judul" name="judul" class="form-control <?= (validation_show_error('judul')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueJudul ?>" placeholder="<?= lang('Admin.judul') ?>" required />
                <div class="invalid-feedback">
                    <?= validation_show_error('judul'); ?>
                </div>
                <label for="judul"><?= lang('Admin.judul') ?></label>
            </div>
            <!-- Konten editor -->
            <div class="mb-3">
                <textarea id="konten" name="konten" class="form-control tinymce <?= (validation_show_error('konten')) ? 'is-invalid' : ''; ?>" rows="20" type="text"><?= $valueKonten ?></textarea>
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
            <div class="form-floating mb-3">
                <input id="kategori" name="kategori" class="form-control" type="text" value="<?= $valueKategori ?>" placeholder="<?= lang('Admin.kategori') ?>" />
                <label for="kategori"><?= lang('Admin.kategori') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('kategori'); ?>
                </div>
            </div>
            <!-- Status -->
            <div class="form-floating mb-3">
                <select id="status" name="status" class="form-select <?= (validation_show_error('status')) ? 'is-invalid' : ''; ?>" aria-label="Default select">
                    <?php if ($valueStatus == 'draft') : ?>
                        <option selected value="draft"><?= lang('Admin.draf') ?></option>
                        <option value="published"><?= lang('Admin.dipublikasikan') ?></option>
                    <?php elseif ($valueStatus == 'published') : ?>
                        <option value="draft"><?= lang('Admin.draf') ?></option>
                        <option selected value="published"><?= lang('Admin.dipublikasikan') ?></option>
                    <?php else : ?>
                        <option value="draft"><?= lang('Admin.draf') ?></option>
                        <option selected value="published"><?= lang('Admin.dipublikasikan') ?></option>
                    <?php endif; ?>
                </select>
                <label for="status"><?= lang('Admin.status') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('status'); ?>
                </div>
            </div>
            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="w-100 btn btn-primary"><?= lang('Admin.simpan') ?></button>
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
        images_upload_url: '/admin/berita/unggah-gambar',
        images_delete_url: '/admin/berita/hapus-gambar',
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
<?= $this->endSection() ?>