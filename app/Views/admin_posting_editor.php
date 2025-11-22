<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php

use function App\Helpers\capitalize_first_letter;

helper('form');

if ($mode == "tambah") {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueJudul = (old('judul'));
    $valueKonten = (old('konten'));
    $valueRingkasan = (old('ringkasan'));
    $valueKategori = (old('kategori'));
    $valuePostingJenisId = (old('posting_jenis'));
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
    $valueIdKategori = (old('id_kategori')) ? old('id_kategori') : $posting['id_kategori'];
    $valuePostingJenisId = (old('posting_jenis')) ? old('posting_jenis') : $posting['id_jenis'];
    $valueStatus = (old('status')) ? old('status') : $posting['status'];
    $valueTglTerbit = (old('tanggal_terbit')) ? old('tanggal_terbit') : $posting['tanggal_terbit'];
}
?>
<?php if (session()->getFlashdata('sukses')) : ?>
    <!-- Pesan sukses -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <a href="<?= base_url("admin/posting") ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
        <?= session()->getFlashdata('sukses') ?>
    </div>
<?php elseif (session()->getFlashdata('gagal')) : ?>
    <!-- Pesan gagal -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <a href="<?= base_url("admin/posting") ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
        <?= session()->getFlashdata('gagal') ?>
    </div>
<?php elseif (session()->getFlashdata('peringatan')) : ?>
    <!-- Pesan peringatan -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('peringatan') ?>
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
                <div class="invalid-tooltip">
                    <?= validation_show_error('judul') ?: lang('Admin.harusDiinput'); ?>
                </div>
            </div>

            <!-- Konten editor -->
            <div class="form mb-3" data-mdb-input-init>
                <textarea id="konten" name="konten" class="form-control tinymce <?= (validation_show_error('konten')) ? 'is-invalid' : ''; ?>" rows="20" type="text" required><?= $valueKonten ?></textarea>
                <div class="invalid-tooltip">
                    <?= validation_show_error('konten') ?: lang('Admin.harusDiinput'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <!-- Ringkasan -->
            <div class="form-floating mb-3">
                <textarea id="ringkasan" name="ringkasan" class="form-control overlayscollbar" rows="5" type="text" placeholder="<?= lang('Admin.ringkasan') ?>"><?= $valueRingkasan ?></textarea>
                <label class="control-label mb-2"><?= lang('Admin.ringkasan') ?></label>
            </div>

            <!-- Jenis Posting -->
            <div class="form-floating mb-3">
                <select class="form-select" id="postingJenisSelect" name="posting_jenis">
                    <?php foreach ($postingJenis as $x): ?>
                        <option value="<?= $x['id'] ?>" <?= $x['id'] == $valuePostingJenisId ? 'selected' : '' ?>>
                            <?= capitalize_first_letter($x['nama']) ?>
                        </option>
                    <?php endforeach ?>
                    <option value=""><?= '(' . lang('Admin.tambahBaru') . ')' ?></option>
                </select>
                <label for="posting_jenis" class="form-label"><?= lang('Admin.jenisPosting') ?></label>
            </div>

            <!-- Input field for adding a new posting_jenis -->
            <div class="form-floating mb-3" id="inputPostingJenisLainnyaContainer">
                <input type="text" class="form-control mt-2 mb-3" id="inputPostingJenisLainnya" name="posting_jenis_lainnya" placeholder="<?= lang('Admin.nama') ?>" disabled>
                <label for="inputPostingJenisLainnya" class="form-label"><?= lang('Admin.jenisBaru') ?></label>
            </div>

            <!-- Kategori -->
            <div class="accordion mb-3" id="accordionFlushKategori">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-kategori">
                        <button data-mdb-collapse-init class="accordion-button" type="button"
                            data-mdb-target="#flush-collapseKategori" aria-expanded="true" aria-controls="flush-collapseKategori">
                            <?= lang('Admin.kategori') ?>
                        </button>
                    </h2>
                    <div id="flush-collapseKategori" class="accordion-collapse collapse show"
                        aria-labelledby="flush-kategori" data-mdb-parent="#accordionFlushKategori">
                        <div class="accordion-body">
                            <div class="mb-3" id="kategoriContainer">
                                <?php foreach ($kategori as $key): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="kategori_<?= $key['id'] ?>" name="kategori[]" value="<?= $key['id'] ?>">
                                        <label class="form-check-label" for="kategori_<?= $key['id'] ?>"><?= $key['nama'] ?></label>
                                    </div>
                                <?php endforeach ?>
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-primary" id="tambahKategoriButton"><?= lang('Admin.tambahX', [0 => lang('Admin.kategori')]) ?></button>
                            </div>

                            <div class="form-floating" id="kategoriInputContainer" style="display: none;">
                                <input type="text" class="form-control mt-2 mb-3" id="inputKategoriLainnya" name="kategori_lainnya" placeholder="<?= lang("Admin.namaKategori") ?>">
                                <label for="kategori_lainnya" class="form-label"><?= lang('Admin.kategoriBaru') ?></label>
                                <button type="button" class="btn btn-success" id="buatKategoriButton"><?= lang('Admin.tambahBaru') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="invalid-tooltip">
                    <?= validation_show_error('status'); ?>
                </div>

            </div>
            <div class="form-floating mb-3">

                <!-- Tanggal terbit -->
                <div class="form mb-3">
                    <label for="terbit"><?= lang('Admin.tanggalTerbit') ?></label>
                    <input id="terbit" type="datetime-local" name="tanggal_terbit" class="form-control <?= (validation_show_error('terbit')) ? 'is-invalid' : ''; ?>" required value="<?= $valueTglTerbit ?>" />
                    <div class="invalid-tooltip">
                        <?= validation_show_error('tanggal_terbit') ?: lang('Admin.harusDiinput'); ?>
                    </div>

                </div>
            </div>

            <!-- Tombol simpan -->
            <button id="btn-submit" name="submit" type="submit" class="btn btn-primary w-100" data-mdb-ripple-init><?= lang('Admin.simpan') ?></button>

        </div>
</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<!-- Tinymce -->
<script src="<?php echo base_url(); ?>assets/vendor/tinymce/tinymce/tinymce.min.js"></script>

<!-- DSM Gallery -->
<script src="<?= base_url('assets/js/tinymce/dsmgallery-plugin.js'); ?>"></script>

<!-- DSM File Insert -->
<script src="<?= base_url('assets/js/tinymce/dsmfileinsert-plugin.js'); ?>"></script>

<!-- CSV to HTML -->
<script src="<?= base_url('assets/js/tinymce/csvtohtml-plugin.js'); ?>"></script>

<script>
    tinymce.init({
        selector: '#konten',
        license_key: 'gpl',
        relative_urls: false,
        remove_script_host: false, // Important to keep the absolute url
        document_base_url: '<?= base_url() ?>', // Set the base URL for relative paths
        plugins: [
            'advlist', 'autolink', 'image',
            'lists', 'link', 'charmap', 'preview', 'anchor', 'searchreplace',
            'fullscreen', 'insertdatetime', 'table', 'help',
            'wordcount', 'dsmgallery', 'dsmfileinsert', 'csvtohtml', 'code'
        ],
        toolbar: 'fullscreen | dsmgallery dsmfileinsert | undo redo | casechange blocks | bold italic backcolor | image | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | code table csvtohtml help',
        image_title: true,
        automatic_uploads: true,
        dsmgallery_api_endpoint: '<?= base_url('/api/galeri') ?>',
        dsmgallery_gallery_url: '<?= base_url('/admin/galeri') ?>',
        dsmfileinsert_api_endpoint: '<?= base_url('/api/file') ?>',
        dsmfileinsert_file_manager_url: '<?= base_url('/admin/file') ?>',
        images_upload_url: '<?= base_url('/admin/posting/unggah-gambar') ?>',
        // images_delete_url: '<?= base_url('/admin/posting/hapus-gambar') ?>',
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
                    const id = file.name;
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

<!-- Handle kategori lainnya -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectPostingJenis = document.getElementById('postingJenisSelect');
        const inputPostingJenisLainnyaContainer = document.getElementById('inputPostingJenisLainnyaContainer');
        const inputPostingJenisLainnya = document.getElementById('inputPostingJenisLainnya');
        const tambahKategoriButton = document.getElementById('tambahKategoriButton');
        const kategoriInputContainer = document.getElementById('kategoriInputContainer');
        const buatKategoriButton = document.getElementById('buatKategoriButton');
        const inputKategoriLainnya = document.getElementById('inputKategoriLainnya');
        const kategoriContainer = document.getElementById('kategoriContainer');

        // Initialize the UI and fetch kategori on page load
        updateUiInputPostingJenis(); // Initialize the UI for the posting_jenis input

        // Fetch the kategori options based on the pre-selected posting_jenis when the document is ready
        const initialPostingJenisId = selectPostingJenis.value;
        if (initialPostingJenisId) {
            updateUiInputPostingJenis();
            fetchKategoriOptions(initialPostingJenisId);
        }

        // Handle the change event of posting_jenis select
        selectPostingJenis.addEventListener('change', function() {
            updateUiInputPostingJenis();

            const postingJenisId = this.value;
            fetchKategoriOptions(postingJenisId);
        });

        // Show or hide the input for adding new posting_jenis
        function updateUiInputPostingJenis() {
            if (selectPostingJenis.value === '') { // If "Tambah Baru" is selected for posting_jenis
                inputPostingJenisLainnyaContainer.style.display = 'block';
                inputPostingJenisLainnya.disabled = false;
                inputPostingJenisLainnya.required = true;
            } else {
                inputPostingJenisLainnyaContainer.style.display = 'none';
                inputPostingJenisLainnya.disabled = true;
                inputPostingJenisLainnya.required = false;
                inputPostingJenisLainnya.value = ''; // Clear the input if another option is selected
            }
        }

        // Handle the click event of "Tambah Kategori" button
        tambahKategoriButton.addEventListener('click', function() {
            kategoriInputContainer.style.display = 'block';
            tambahKategoriButton.style.display = 'none';
        });

        // Handle the click event of "Add Kategori" button
        buatKategoriButton.addEventListener('click', function() {
            const newKategori = inputKategoriLainnya.value.trim();
            if (newKategori) {
                // Create a new checkbox for the new kategori
                const newCheckbox = document.createElement('div');
                newCheckbox.className = 'form-check';

                // Create new checkbox kategori with its name is the value
                newCheckbox.innerHTML = `
                <input class="form-check-input" type="checkbox" id="kategori_${newKategori}" name="kategori[]" value="${newKategori}" checked>
                <label class="form-check-label" for="kategori_${newKategori}">${newKategori}</label>
            `;

                // Append the new checkbox to the form
                kategoriContainer.appendChild(newCheckbox);

                // Clear the input and hide the input container
                inputKategoriLainnya.value = '';
                kategoriInputContainer.style.display = 'none';
                tambahKategoriButton.style.display = 'block';
            }
        });

        // Assuming $valueIdKategori is passed as a JSON-encoded array from the server
        const valueIdKategori = <?= json_encode($valueIdKategori ?? []) ?>;

        function fetchKategoriOptions(postingJenisId) {
            // Clear current checkboxes in kategori container before fetching new ones
            kategoriContainer.innerHTML = ''; // This ensures that the previous checkboxes are cleared

            // If there's a valid posting_jenis selected, proceed with the AJAX call
            if (postingJenisId) {
                $.ajax({
                    url: '<?= base_url('api/posting/getKategoriByJenis') ?>',
                    type: 'POST',
                    data: {
                        id_jenis: postingJenisId
                    },
                    success: function(response) {
                        // Check if there are any kategori options returned
                        if (response.kategori && response.kategori.length > 0) {
                            // Populate with new checkboxes
                            response.kategori.forEach(function(kat) {
                                const isChecked = valueIdKategori.includes(kat.id);
                                const checkbox = document.createElement('div');
                                checkbox.className = 'form-check';
                                checkbox.innerHTML = `
                                <input class="form-check-input" type="checkbox" id="kategori_${kat.id}" name="kategori[]" value="${kat.id}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label" for="kategori_${kat.id}">${kat.nama}</label>
                            `;
                                kategoriContainer.appendChild(checkbox);
                            });
                        }
                    }
                });
            }
        }
    });
</script>

<!-- datetimepicker -->
<!-- <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
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
</script> -->

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