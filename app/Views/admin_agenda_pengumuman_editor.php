<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>
    .card-gallery {
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        border: 2px solid transparent;
        /* Default border */
    }

    .card-gallery:hover {
        transform: scale(1.05);
        /* Scale up on hover */
    }

    .card-gallery.selected {
        border: 2px solid var(--mdb-primary);
        /* Blue border when selected */
        box-shadow: 0 0 10px rgba(var(--mdb-primary-rgb) 0.5);
        /* Add shadow for emphasis */
        transform: scale(1.1);
        /* Slightly larger when selected */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('form');


if ($mode == "tambah") {
    // Apabila mode tambah, bawa nilai lama form agar setelah validasi tidak hilang
    $valueAgenda = (old('judul'));
    $valueDeskripsi = (old('konten'));
    $valueWaktuMulai = (old('waktu_mulai'));
    $valueWaktuSelesai = (old('waktu_selesai'));
    $valueStatus = (old('status'));
    $valueGaleri = (old('galeri'));
    $valueIdGaleri = (old('id_galeri'));
    $valueUploadImage = (old('uploadimage'));
    $item['uri'] = null;
} else {
    $waktuMulai = strtotime($item['waktu_mulai']);
    $waktuMulaiFormat = date("Y-m-d H:i", $waktuMulai);
    $waktuSelesai = $item['waktu_selesai'] ? strtotime($item['waktu_selesai']) : null;
    $waktuSelesaiFormat = $waktuSelesai ? date("Y-m-d H:i", $waktuSelesai) : '';
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueAgenda = (old('judul')) ? old('judul') : $item['judul'];
    $valueDeskripsi = (old('konten')) ? old('konten') : $item['konten'];
    $valueWaktuMulai = (old('waktu_mulai')) ? old('waktu_mulai') : $waktuMulaiFormat;
    $valueWaktuSelesai = (old('waktu_selesai')) ? old('waktu_selesai') : $waktuSelesaiFormat;
    $valueStatus = (old('status')) ? old('status') : $item['status'];
    $valueGaleri = $item['uri'];
    $valueIdGaleri = (old('id_galeri')) ? old('id_galeri') : $item['id_galeri'];
    $valueUploadImage = (old('uploadimage')) ? old('uploadimage') : $item['uri'];
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

<form method="post" action="<?= ($mode == "tambah") ? base_url("/admin/$rute/tambah/simpan") : base_url("/admin/$rute/sunting/simpan/" . $item['id']) ?>" class="form-container needs-validation" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="row mb-3">
        <div class="col-12 mb-3">

            <!-- Agenda -->
            <div class="form-floating mb-3">
                <input id="judul" name="judul" class="form-control <?= (validation_show_error('judul')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueAgenda ?>" placeholder="<?= lang('Admin.judul') ?>" required />
                <label for="judul"><?= lang('Admin.judul') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('judul'); ?>
                </div>
            </div>
        </div>
        <div class="col-12">

            <!-- Deskripsi -->
            <div class="form-floating mb-3">
                <textarea id="konten" name="konten" class="form-control tinymce <?= (validation_show_error('konten')) ? 'is-invalid' : ''; ?>" type="text" rows="5" placeholder="<?= lang('Admin.konten') ?>"><?= $valueDeskripsi ?></textarea>
                <!-- <label for="konten"><?= lang('Admin.konten') ?></label> -->
            </div>

        </div>
        <div class="col-md-6">

            <!-- Waktu mulai picker -->
            <div class="form mb-3">
                <label for="waktu-mulai"><?= lang('Admin.waktuMulai') ?></label>
                <input id="waktu-mulai" name="waktu_mulai" class="form-control <?= (validation_show_error('waktu-mulai')) ? 'is-invalid' : ''; ?>" required value="<?= $valueWaktuMulai ?>" />
                <div class="invalid-feedback">
                    <?= validation_show_error('waktu-mulai'); ?>
                </div>
            </div>

        </div>
        <div class="col-md-6">

            <!-- Waktu selesai picker -->
            <div class="form mb-3">
                <label for="waktu-selesai"><?= lang('Admin.waktuSelesai') ?></label>
                <input id="waktu-selesai" name="waktu_selesai" class="form-control <?= (validation_show_error('waktu-selesai')) ? 'is-invalid' : ''; ?>" value="<?= $valueWaktuSelesai ?>" />
            </div>

        </div>
        <div class="col-md-6">

            <!-- Status -->
            <div class="form-floating mb-4">
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

            <!-- Pre-selected or newly selected Image Section -->
            <div id="section-gambar-terpilih" class="mb-3" <?= !$valueIdGaleri ? 'style="display:none;"' : '' ?>>

                <img id="gambar-terpilih" class="rounded-5 me-2" src="<?= $valueGaleri ? $valueGaleri : null ?>" alt="Selected Image" style="max-width: 200px; max-height: 200px" />

                <button type="button" id="hapus-gambar-terpilih" class="btn btn-danger btn-floating btn-sm" data-mdb-ripple-init>
                    <i class="bi bi-trash"></i>
                </button>

                <input type="hidden" name="galeri" value="<?= $valueIdGaleri ? $valueIdGaleri : null ?>" id="selected-image-id">

            </div>

            <!-- Radio sumber gambar -->
            <p><?= $mode == "tambah" ? lang('Admin.tambahGambar') : lang('Admin.ubahGambar') ?></p>
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" id="radioUnggah" type="radio" name="image_source" value="unggah" />
                <label class="form-check-label" for="radioUnggah"><?= lang('Admin.unggah') ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="radioGaleri" name="image_source" value="galeri">
                <label class="form-check-label" for="radioGaleri"><?= lang('Admin.galeri') ?></label>
            </div>

            <!-- Gambar -->
            <div id="upload-section" style="display: none;">
                <div class="mb-3">
                    <label class="form-label" for="gambar"><?= lang('Admin.unggah') ?></label>
                    <input type="file" class="form-control" id="gambar" name="file_gambar" accept="image/*" />
                    <button type="button" class="btn btn-warning mt-1" id="reset-gambar" style="display: none;" onclick="resetGambar()">Reset <?= lang('Admin.gambar') ?></button>
                    <div class="invalid-feedback">
                        <?= validation_show_error('uploadimage'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="judul_gambar" class="form-label"><?= lang('Admin.judulGambar') ?></label>
                    <input type="text" class="form-control" name="judul_gambar" id="judul_gambar" placeholder="<?= lang('Admin.judulGambar') ?>">
                </div>
                <div class="mb-3">
                    <label for="alt_gambar" class="form-label">Alt Text</label>
                    <input type="text" class="form-control" name="alt_gambar" id="alt_gambar" placeholder="Alt Text">
                </div>
                <div class="mb-3">
                    <label for="deskripsi_gambar" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                    <textarea class="form-control" name="deskripsi_gambar" id="deskripsi_gambar" placeholder="<?= lang('Admin.deskripsi') ?>"></textarea>
                </div>
            </div>
        </div>

    </div>

    <!-- Agenda/pengumuman -->
    <input type="hidden" name="id_jenis" value="<?= $idJenis ?>">

    <!-- Tombol simpan -->
    <button id="btn-submit" name="submit" type="submit" class="btn btn-primary mb-5" data-mdb-ripple-init><i class="bi bi-floppy me-2"></i><?= lang('Admin.simpan') ?></button>

</form>

<!-- Modal -->
<div class="modal fade modal-xl" id="galeriModal" tabindex="-1" aria-labelledby="galeriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">
                    <span id="galeriModalLabel"><?= lang('Admin.galeri') ?></span>

                    <!-- Spinner -->
                    <div class="spinner-border spinner-border-sm ms-2" id="galeriModalSpinner" role="status">
                        <span class="visually-hidden"><?= lang('Admin.memuat') ?></span>
                    </div>

                </h5>

                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">

                <!-- Search input -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="galeriModalSearchInput" placeholder="<?= lang('Admin.cari') ?>">
                    <button class="btn btn-primary" id="galeriModalSearchButton" type="button" data-mdb-ripple-init><i class="bi bi-search me-2"></i><?= lang('Admin.cari') ?></button>
                    <button class="btn btn-secondary" id="galeriModalClearButton" type="button" data-mdb-ripple-init><i class="bi bi-x-lg"></i></button>
                </div>

                <div class="col-md-12">
                    <!-- Select from Gallery Section -->
                    <div id="gallery-section" class="galeri-grid" style="display:none;">
                        <div id="loading-spinner" class="text-center" style="display:none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="row" id="gallery-thumbnails"></div>
                        <div id="pagination"></div>
                    </div>
                </div>

                <button id="saveKomponenMetaButton" type="submit" class="btn btn-success" data-mdb-dismiss="modal" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.tutup') ?></button>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

<!-- Tinymce -->
<script src="<?= base_url('assets/vendor/tinymce/tinymce/tinymce.min.js'); ?>"></script>

<!-- DSM Gallery -->
<script src="<?= base_url('assets/js/tinymce/dsmgallery-plugin.js'); ?>"></script>

<!-- DSM File Insert -->
<script src="<?= base_url('assets/js/tinymce/dsmfileinsert-plugin.js'); ?>"></script>

<!-- Images Loaded Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>

<script>
    tinymce.init({
        selector: '#konten',
        license_key: 'gpl',
        plugins: [
            'advlist', 'autolink', 'image',
            'lists', 'link', 'charmap', 'preview', 'anchor', 'searchreplace',
            'fullscreen', 'insertdatetime', 'table', 'help',
            'wordcount', 'dsmgallery', 'dsmfileinsert', 'code'
        ],
        toolbar: 'fullscreen | dsmgallery dsmfileinsert | undo redo | casechange blocks | bold italic backcolor | image | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | code table help',
        image_title: true,
        automatic_uploads: true,
        dsmgallery_api_endpoint: '<?= base_url('/api/galeri') ?>',
        dsmgallery_gallery_url: '<?= base_url('/admin/galeri') ?>',
        dsmfileinsert_api_endpoint: '<?= base_url('/api/file') ?>',
        dsmfileinsert_file_manager_url: '<?= base_url('/admin/file') ?>',
        images_upload_url: '<?= base_url('/admin/berita/unggah-gambar') ?>',
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

<!-- Datetime picker -->
<script>
    $('#waktu-mulai').datetimepicker({
        datepicker: {
            showOtherMonths: true,
            maxDate: function() {
                return $('#waktu-selesai').val();
            },
            keyboardNavigation: false,
        },
        footer: true,
        modal: true,
        format: 'yyyy-mm-dd HH:MM',
        uiLibrary: 'materialdesign',
    });
    $('#waktu-selesai').datetimepicker({
        datepicker: {
            showOtherMonths: true,
            keyboardNavigation: false,
            minDate: function() {
                var waktuMulai = $('#waktu-mulai').val();
                if (waktuMulai) {
                    // Parse the date and subtract one day
                    var date = new Date(waktuMulai);
                    date.setDate(date.getDate() - 1);
                    return date;
                }
                return 0; // Default to current date if waktu-mulai is not set
            },
        },
        footer: true,
        modal: true,
        format: 'yyyy-mm-dd HH:MM',
        uiLibrary: 'materialdesign',
    });
</script>

<!-- Handle gambar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Upload and gallery section
        const uploadSection = document.getElementById('upload-section');
        const gallerySection = document.getElementById('gallery-section');

        // Modal
        const galeriModal = document.getElementById('galeriModal');
        const galeriModalInstance = new mdb.Modal(galeriModal);

        document.querySelectorAll('input[name="image_source"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'unggah') {
                    uploadSection.style.display = 'block';
                    gallerySection.style.display = 'none';
                    // document.getElementById('section-gambar-terpilih').style.display = 'none';
                } else {
                    uploadSection.style.display = 'none';
                    gallerySection.style.display = 'block';
                    // loadGallery(1); // Load the first page of the gallery

                    // Load the gallery only if it's the first time opening this section
                    if ($('#gallery-thumbnails').is(':empty')) {

                        loadGallery(1);

                        // Show galeri modal
                        galeriModalInstance.show();
                    }
                }
            });
            radio.addEventListener('click', function() {
                if (this.value === 'galeri') {

                    // If not first time loading the gallery, open the modal
                    if (!$('#gallery-thumbnails').is(':empty')) {
                        galeriModalInstance.show(); // SHow galeri modal
                    }

                }
            });
        });

        function resetGambar() {
            $('#gambar').val('');
            $('#reset-gambar').hide();
        };

        // Search button
        $('#galeriModalSearchButton').click(function() {
            const searchValue = $('#galeriModalSearchInput').val(); // Get the input value
            loadGallery(1, searchValue); // Call loadGallery with page: 1 and search: input value
            console.log(searchValue);
        });

        // Clear search button
        $('#galeriModalClearButton').click(function() {
            $('#galeriModalSearchInput').val(''); // Clear the input value
            loadGallery(1, ''); // Call loadGallery with page: 1 and empty search
        });

        function loadGallery(page, search) {

            // Show the spinner
            $('#galeriModalSpinner').show();

            $.ajax({
                url: '<?= base_url('/api/galeri') ?>',
                data: {
                    page: page,
                    per_page: 12,
                    search: search
                },
                success: function(response) {
                    const thumbnailsContainer = $('#gallery-thumbnails');
                    const paginationContainer = $('#pagination');
                    thumbnailsContainer.empty();
                    paginationContainer.empty();

                    // Destroy existing Masonry instance if it exists
                    if (thumbnailsContainer.data('masonry')) {
                        thumbnailsContainer.masonry('destroy');
                    }

                    response.data.forEach(function(item) {
                        const thumbnail = `
                <div class="col-md-3 mb-4 gallery-item">
                    <div class="card card-gallery" data-id="${item.id}">
                        <img src="${item.uri}" class="thumbnail">
                        <div class="card-body">
                            <h6 class="card-title">${item.judul}</h6>
                        </div>
                    </div>
                </div>`;
                        thumbnailsContainer.append(thumbnail);
                    });

                    // Wait until all images are loaded before reinitializing Masonry
                    thumbnailsContainer.imagesLoaded(function() {

                        // Reinitialize Masonry
                        thumbnailsContainer.masonry({
                            itemSelector: '.gallery-item',
                            columnWidth: '.gallery-item',
                            percentPosition: true
                        });

                    });

                    // Pagination
                    let paginationHtml = '<nav aria-label="Page navigation" class="justify-content-center">';
                    paginationHtml += '<ul class="pagination justify-content-center">';

                    const totalPages = Math.ceil(response.total / response.perPage);
                    const currentPage = page;
                    const maxPagesToShow = 3;

                    // Add "Previous" button
                    if (currentPage > 1) {
                        paginationHtml += `
        <li class="page-item">
            <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
        </li>`;
                    }

                    // Determine start and end page numbers to display
                    let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
                    let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

                    // Adjust if we're at the end of the list
                    if (endPage - startPage + 1 < maxPagesToShow) {
                        startPage = Math.max(1, endPage - maxPagesToShow + 1);
                    }

                    // Add ellipsis if needed
                    if (startPage > 1) {
                        paginationHtml += `
        <li class="page-item">
            <a class="page-link" href="#" data-page="1">1</a>
        </li>
        <li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }

                    // Page number links
                    for (let i = startPage; i <= endPage; i++) {
                        paginationHtml += `
        <li class="page-item ${currentPage == i ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">
                ${i}
            </a>
        </li>`;
                    }

                    // Add ellipsis if needed
                    if (endPage < totalPages) {
                        paginationHtml += `
        <li class="page-item disabled"><span class="page-link">...</span></li>
        <li class="page-item">
            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
        </li>`;
                    }

                    // Add "Next" button
                    if (currentPage < totalPages) {
                        paginationHtml += `
        <li class="page-item">
            <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
        </li>`;
                    }

                    paginationHtml += '</ul></nav>';

                    paginationContainer.html(paginationHtml);

                    // Handle card-gallery click
                    $('.card-gallery').click(function() {
                        $('.card-gallery').removeClass('selected');
                        $(this).addClass('selected');
                        $('#selected-image-id').val($(this).data('id')); // Store the selected image ID

                        const imageUrl = $(this).find('img').attr('src');

                        $('#gambar-terpilih').attr('src', imageUrl); // Update the preview image
                        $('#section-gambar-terpilih').show(); // Show the selected image section
                    });

                    // Handle pagination click
                    $('.page-link').click(function(e) {
                        e.preventDefault();
                        thumbnailsContainer.empty();
                        loadGallery($(this).data('page'), search);
                    });
                },

                complete: function() {
                    // Hide the spinner when the request completes
                    $('#galeriModalSpinner').hide();
                }
            });


        }
    });

    const gambarTerpilihSection = document.getElementById('section-gambar-terpilih');
    const resetGambarButton = document.getElementById('reset-gambar');
    const gambarInputFile = document.getElementById('gambar');

    gambarInputFile.addEventListener("change", () => {
        if (gambarInputFile.value != "") {
            gambarTerpilihSection.style.display = 'none';
            resetGambarButton.style.display = 'block';
            document.getElementsByClassName('card-gallery').classList.remove('selected');
        };
    })

    $(document).ready(function() {
        // Initial check: if there's a pre-selected image, show it
        if ($('#selected-image-id').val() !== '') {
            $('#section-gambar-terpilih').show();
        }

        // Handle the removal of the selected image
        $('#hapus-gambar-terpilih').click(function() {
            $('#section-gambar-terpilih').hide(); // Hide the section
            $('#gambar-terpilih').attr('src', ''); // Clear the image
            $('#selected-image-id').val(''); // Clear the hidden input value
            $('.card-gallery').removeClass('selected');
            // $('input[name="image_source"][value="upload"]').prop('checked', true); // Switch to upload radio
            // $('#upload-section').show(); // Show the upload section
        });
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
        const radioLainnya = document.getElementById('kategoriRadioLainnya');
        const inputKategoriLainnya = document.getElementById('inputKategoriLainnya');
        const form = document.querySelector('form');

        // Event listener for radio buttons
        document.querySelectorAll('input[name="kategori"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (radioLainnya.checked) {
                    inputKategoriLainnya.disabled = false;
                    inputKategoriLainnya.required = true;
                } else {
                    inputKategoriLainnya.disabled = true;
                    inputKategoriLainnya.required = false;
                    inputKategoriLainnya.value = ''; // Clear the input if another option is selected
                }
            });
        });

        // Form submission handler
        // form.addEventListener('submit', function(event) {
        //     if (radioLainnya.checked && inputKategoriLainnya.value.trim() === '') {
        //         inputKategoriLainnya.classList.add('is-invalid');
        //         event.preventDefault(); // Prevent form submission if the input is empty
        //     } else {
        //         inputKategoriLainnya.classList.remove('is-invalid');
        //     }
        // });
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

<?= $this->endSection() ?>