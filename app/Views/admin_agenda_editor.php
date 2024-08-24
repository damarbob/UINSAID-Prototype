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
    $valueAgenda = (old('agenda'));
    $valueWaktu = (old('waktu'));
    $valueStatus = (old('status'));
    $valueGaleri = (old('galeri'));
    $valueUploadImage = (old('uploadimage'));
} else {
    $waktu = strtotime($agenda['waktu']);
    $waktuFormat = date("Y-m-d H:i");
    // Apabila mode edit, apabila ada nilai lama (old), gunakan nilai lama. Apabila tidak ada nilai lama (old), gunakan nilai dari rilis media
    $valueAgenda = (old('agenda')) ? old('agenda') : $agenda['agenda'];
    $valueWaktu = (old('waktu')) ? old('waktu') : $waktuFormat;
    $valueStatus = (old('status')) ? old('status') : $agenda['status'];
    $valueGaleri = (old('galeri')) ? old('galeri') : $agenda['uri'];
    $valueUploadImage = (old('uploadimage')) ? old('uploadimage') : $agenda['uri'];
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

<form method="post" action="<?= ($mode == "tambah") ? base_url('/admin/agenda/tambah/simpan') : base_url('/admin/agenda/sunting/simpan/') . $agenda['id'] ?>" class="form-container needs-validation" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="row mb-3">
        <div class="col-12">
            <!-- Agenda -->
            <div class="form-floating mb-3">
                <input id="agenda" name="agenda" class="form-control <?= (validation_show_error('agenda')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $valueAgenda ?>" placeholder="<?= lang('Admin.agenda') ?>" required />
                <label for="agenda"><?= lang('Admin.agenda') ?></label>
                <div class="invalid-feedback">
                    <?= lang('Admin.harusDiinput'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Waktu picker -->
            <div class="form mb-3">
                <label for="waktu"><?= lang('Admin.waktu') ?></label>
                <input id="waktu" name="waktu" class="form-control <?= (validation_show_error('waktu')) ? 'is-invalid' : ''; ?>" required value="<?= $valueWaktu ?>" />
                <div class="invalid-feedback">
                    <?= lang('Admin.harusDiinput'); ?>
                </div>
            </div>
            <!-- Status -->
            <div class="form-floating mb-4">
                <select id="status" name="status" class="form-select <?= (validation_show_error('status')) ? 'is-invalid' : ''; ?>" aria-label="Default select">
                    <?php if ($valueStatus == 'draf') : ?>
                        <option selected value="draf"><?= lang('Admin.draf') ?></option>
                        <option value="dipublikasikan"><?= lang('Admin.dipublikasikan') ?></option>
                    <?php elseif ($valueStatus == 'dipublikasikan') : ?>
                        <option value="draf"><?= lang('Admin.draf') ?></option>
                        <option selected value="dipublikasikan"><?= lang('Admin.dipublikasikan') ?></option>
                    <?php else : ?>
                        <option value="draf"><?= lang('Admin.draf') ?></option>
                        <option selected value="dipublikasikan"><?= lang('Admin.dipublikasikan') ?></option>
                    <?php endif; ?>
                </select>
                <label for="status"><?= lang('Admin.status') ?></label>
                <div class="invalid-feedback">
                    <?= validation_show_error('status'); ?>
                </div>
            </div>

            <!-- Radio sumber gambar -->
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input" id="radioUnggah" type="radio" name="image_source" value="unggah" checked />
                <label class="form-check-label" for="radioUnggah"><?= lang('Admin.unggah') ?></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="radioGaleri" name="image_source" value="galeri">
                <label class="form-check-label" for="radioGaleri"><?= lang('Admin.galeri') ?></label>

            </div>

            <!-- Gambar -->
            <div id="upload-section">
                <div class="mb-3">
                    <label class="form-label" for="gambar"><?= lang('Admin.unggah') ?></label>
                    <input type="file" class="form-control" id="gambar" name="file_gambar" accept="image/" value="<?= $valueUploadImage ?>" />
                    <div class="invalid-feedback">
                        <?= validation_show_error('uploadimage'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="judul" class="form-label"><?= lang('Admin.judulGambar') ?></label>
                    <input type="text" class="form-control" name="judul" id="judul" placeholder="<?= lang('Admin.judulGambar') ?>">
                </div>
                <div class="mb-3">
                    <label for="alt" class="form-label">Alt Text</label>
                    <input type="text" class="form-control" name="alt" id="alt" placeholder="Alt Text">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="<?= lang('Admin.deskripsi') ?>"></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <!-- Select from Gallery Section -->
            <div id="gallery-section" style="display:none;">
                <div id="loading-spinner" class="text-center" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="row" id="gallery-thumbnails"></div>
                <div id="pagination"></div>
                <input type="hidden" name="galeri" id="selected-image-id">
            </div>
        </div>
    </div>
    <!-- Tombol simpan -->
    <button id="btn-submit" name="submit" type="submit" class="btn btn-primary mb-5"><?= lang('Admin.simpan') ?></button>
</form>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>

<!-- Datetime picker -->
<script>
    $('#waktu').datetimepicker({
        datepicker: {
            showOtherMonths: true
        },
        footer: true,
        modal: true,
        // locale: 'id-id',
        format: 'yyyy-mm-dd HH:MM',
        uiLibrary: 'materialdesign'
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadSection = document.getElementById('upload-section');
        const gallerySection = document.getElementById('gallery-section');

        document.querySelectorAll('input[name="image_source"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'unggah') {
                    uploadSection.style.display = 'block';
                    gallerySection.style.display = 'none';
                } else {
                    uploadSection.style.display = 'none';
                    gallerySection.style.display = 'block';
                    // loadGallery(1); // Load the first page of the gallery

                    // Load the gallery only if it's the first time opening this section
                    if ($('#gallery-thumbnails').is(':empty')) {
                        loadGallery(1);
                    }
                }
            });
        });
    });

    function loadGallery(page) {
        // Show the spinner
        $('#loading-spinner').show();

        $.ajax({
            url: '/api/galeri',
            data: {
                page: page,
                per_page: 12,
                search: ''
            },
            success: function(response) {
                const thumbnailsContainer = $('#gallery-thumbnails');
                const paginationContainer = $('#pagination');
                thumbnailsContainer.empty();
                paginationContainer.empty();

                response.data.forEach(function(item) {
                    const thumbnail = `
                    <div class="col-md-3 mb-4 gallery-item">
    <div class="card card-gallery" data-id="${item.id}"><img src="${item.uri}" class="thumbnail"><div class="card-body">
            <h6 class="card-title">${item.judul}</h6>
        </div>
    </div>
</div>`;
                    thumbnailsContainer.append(thumbnail);
                });
                // thumbnailsContainer.attr('data-masonry', '{"percentPosition": true }');
                // thumbnailsContainer.masonry({
                //     // options
                //     itemSelector: '.gallery-item',
                //     columnWidth: 200
                // });

                // Pagination
                let paginationHtml = '<nav aria-label="Page navigation" class="justify-content-center">';
                paginationHtml += '<ul class="pagination justify-content-center">';

                for (let i = 1; i <= response.total / response.perPage; i++) {
                    paginationHtml += `
                    <li class="page-item ${response.currentPage == i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">
                            ${i}
                        </a>
                    </li>`;
                }

                paginationHtml += '</ul></nav>';

                paginationContainer.html(paginationHtml);

                // Handle card-gallery click
                $('.card-gallery').click(function() {
                    $('.card-gallery').removeClass('selected');
                    $(this).addClass('selected');
                    $('#selected-image-id').val($(this).data('id')); // Store the selected image ID

                    // Show a small notification
                    // const message = $('<div class="selection-message">Image Selected!</div>');
                    // $('body').append(message);
                    // message.css({
                    //     position: 'absolute',
                    //     left: $(this).offset().left + $(this).width() / 2 - message.width() / 2,
                    //     top: $(this).offset().top - 30,
                    //     display: 'none'
                    // });
                    // message.fadeIn().delay(1000).fadeOut(function() {
                    //     $(this).remove();
                    // });
                });

                // Handle pagination click
                $('.page-link').click(function(e) {
                    e.preventDefault();
                    thumbnailsContainer.empty()
                    loadGallery($(this).data('page'));
                });
            },

            complete: function() {
                // Hide the spinner when the request completes
                $('#loading-spinner').hide();
            }
        });
    }
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