<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<?php
helper('form');

if (!isset($komponen)) {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueNama = (old('nama'));
    $valueGrup = (old('grup'));
    $valueKonten = (old('konten'));
    $valueCSS = (old('css'));
    $valueJS = (old('js'));
} else {
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueNama = (old('nama')) ? old('nama') : $komponen['nama'];
    $valueGrup = (old('grup')) ? old('grup') : $komponen['grup'];
    $valueKonten = (old('konten')) ? old('konten') : $komponen['konten'];
    $valueCSS = (old('css')) ? old('css') : $komponen['css'];
    $valueJS = (old('js')) ? old('js') : $komponen['js'];
}
?>

<form action="<?= isset($komponen) ? base_url('/admin/komponen/simpan/') . $komponen['id'] : base_url('/admin/komponen/simpan'); ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-9">
            <!-- <div class="mb-3">
                <label for="nama" class="form-label"><?= lang('Admin.nama') ?></label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= isset($komponen) ? $komponen['nama'] : ''; ?>" required>
            </div> -->

            <!-- Nama komponen -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= isset($komponen) ? $komponen['nama'] : ''; ?>" required>
                <label for="nama"><?= lang('Admin.nama') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('nama'); ?>
                </div>
            </div>

            <div class="mb-3">
                <textarea class="form-control tinymce" id="konten" name="konten" rows="5" required><?= isset($komponen) ? $komponen['konten'] : ''; ?></textarea>
            </div>
        </div>
        <div class="col-md-3">

            <!-- CSS file input -->
            <div class="form-group mb-3">
                <label for="css">CSS</label>
                <input type="file" class="form-control" id="css" name="css_file">
                <div class="form-helper">
                    <small>
                        <a href="<?= $valueCSS ?>" target="_blank">
                            <?php if (isset($komponen['css']) && $komponen['css'] != ''): ?>
                                <?= $komponen_css_file ?>
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </small>
                </div>
            </div>

            <!-- JS file input -->
            <div class="form-group mb-3">
                <label for="js">JS</label>
                <input type="file" class="form-control" id="js" name="js_file">
                <div class="form-helper">
                    <small>
                        <a href="<?= $valueJS ?>" target="_blank">
                            <?php if (isset($komponen['js']) && $komponen['js'] != ''): ?>
                                <?= $komponen_js_file ?>
                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </small>
                </div>
            </div>

            <div class="mb-3">
                <label for="grup" class="form-label"><?= lang('Admin.grup') ?></label>
                <select class="form-select" id="grup" name="grup">
                    <?php foreach ($komponen_grup as $k): ?>
                        <option value="<?= $k['nama'] ?>" <?= $k['nama'] == $valueGrup ? 'selected' : '' ?>><?= $k['nama'] ?></option>
                    <?php endforeach ?>
                    <option value=""><?= lang('Admin.tambahBaru') ?></option>
                </select>
                <!-- <div class="invalid-feedback">
                    <?= lang('Admin.pilihAtauInputKategori') ?>
                </div> -->
            </div>
            <div class="mb-3">
                <input type="text" class="form-control mt-2 mb-3" id="inputGrupLainnya" name="grup_lainnya" placeholder="<?= lang("Admin.namaGrup") ?>" disabled>
            </div>
            <!-- <div class="mb-3">
                <label for="grup" class="form-label"><?= lang('Admin.grup') ?></label>
                <input type="number" class="form-control" id="grup" name="grup" value="<?= isset($komponen) ? $komponen['grup'] : ''; ?>">
            </div> -->
            <button type="submit" class="btn btn-primary w-100" data-mdb-ripple-init><i class="bi bi-floppy me-2"></i><?= lang('Admin.simpan') ?></button>

        </div>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Tinymce -->
<script src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tinymce/dsmgallery-plugin.js"></script>
<script>
    // tinymce.init({
    //     selector: '#konten',
    //     plugins: [
    //         'advlist', 'autolink', 'image',
    //         'lists', 'link', 'charmap', 'preview', 'anchor', 'searchreplace',
    //         'fullscreen', 'insertdatetime', 'table', 'help',
    //         'wordcount', 'deleteimage', 'dsmgallery', 'code'
    //     ],
    //     toolbar: 'fullscreen | code | dsmgallery | undo redo | casechange blocks | bold italic backcolor | image | ' +
    //         'alignleft aligncenter alignright alignjustify | ' +
    //         'bullist numlist checklist outdent indent | removeformat | code table help',
    //     image_title: true,
    //     automatic_uploads: true,
    //     image_gallery_api_endpoint: '/api/galeri',
    //     dsmgallery_api_endpoint: '/api/galeri',
    //     images_upload_url: '/admin/berita/unggah-gambar',
    //     images_delete_url: '/admin/berita/hapus-gambar',
    //     file_picker_types: 'image',
    //     file_picker_callback: (cb, value, meta) => {
    //         const input = document.createElement('input');
    //         input.setAttribute('type', 'file');
    //         input.setAttribute('accept', 'image/*');

    //         input.addEventListener('change', (e) => {
    //             const file = e.target.files[0];

    //             const reader = new FileReader();
    //             reader.addEventListener('load', () => {
    //                 /*
    //                   Note: Now we need to register the blob in TinyMCEs image blob
    //                   registry. In the next release this part hopefully won't be
    //                   necessary, as we are looking to handle it internally.
    //                 */
    //                 const id = 'blobid' + (new Date()).getTime();
    //                 const blobCache = tinymce.activeEditor.editorUpload.blobCache;
    //                 const base64 = reader.result.split(',')[1];
    //                 const blobInfo = blobCache.create(id, file, base64);
    //                 blobCache.add(blobInfo);

    //                 /* call the callback and populate the Title field with the file name */
    //                 cb(blobInfo.blobUri(), {
    //                     title: file.name
    //                 });
    //             });
    //             reader.readAsDataURL(file);
    //         });

    //         input.click();
    //     },
    //     // contextmenu: "image",
    //     paste_preprocess: (editor, args) => {
    //         // console.log(args.content);
    //         // args.content += ' preprocess';
    //     },
    //     promotion: false

    // });
</script>
<script>
    $(document).ready(function() {
        const $selectGrup = $('#grup');
        const $inputGrupLainnya = $('#inputGrupLainnya');

        refreshInputGrup() // Initial refresh

        $selectGrup.on('change', function() {
            refreshInputGrup()
        });

        function refreshInputGrup() {
            if ($selectGrup.val() === '') { // If "Lainnya" is selected
                $inputGrupLainnya.prop('disabled', false).prop('required', true);
            } else {
                $inputGrupLainnya.prop('disabled', true).prop('required', false).val(''); // Clear the input if another option is selected
            }
        }
    });
</script>
<?= $this->endSection() ?>