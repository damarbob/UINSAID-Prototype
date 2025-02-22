<?php
// TODO: Rewrite everything
helper('form');

$valueJudul = (old('judul')) ? old('judul') : $halaman['judul'];
$valueSlug = (old('slug')) ? old('slug') : $halaman['slug'];
$valueStatus = (old('status')) ? old('status') : $halaman['status'];
$valueCSS = $halaman['css'];
$valueJS = $halaman['js'];

// dd($komponen);
// dd($halamanKomponen);

// Validasi
$errorCSS = validation_show_error('css_file');
$errorJS = validation_show_error('js_file');
?>
<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<style>
    /* Animation for fade-in effect */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Loader animation */
    .loader {
        width: 1rem;
        height: 1rem;
        border: 3px solid var(--mdb-primary);
        border-bottom-color: transparent;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loader-body {
        animation: rotate 1s infinite;
        height: 50px;
        width: 50px;
    }

    .loader-body:before,
    .loader-body:after {
        border-radius: 50%;
        content: "";
        display: block;
        height: 20px;
        width: 20px;
    }

    .loader-body:before {
        animation: ball1 1s infinite;
        background-color: var(--mdb-secondary);
        box-shadow: 30px 0 0 var(--mdb-primary)0;
        margin-bottom: 10px;
    }

    .loader-body:after {
        animation: ball2 1s infinite;
        background-color: var(--mdb-primary);
        box-shadow: 30px 0 0 var(--mdb-body-bg);
    }

    @keyframes rotate {
        0% {
            transform: rotate(0deg) scale(0.8)
        }

        50% {
            transform: rotate(360deg) scale(1.2)
        }

        100% {
            transform: rotate(720deg) scale(0.8)
        }
    }

    @keyframes ball1 {
        0% {
            box-shadow: 30px 0 0 var(--mdb-primary);
        }

        50% {
            box-shadow: 0 0 0 var(--mdb-primary);
            margin-bottom: 0;
            transform: translate(15px, 15px);
        }

        100% {
            box-shadow: 30px 0 0 var(--mdb-primary);
            margin-bottom: 10px;
        }
    }

    @keyframes ball2 {
        0% {
            box-shadow: 30px 0 0 var(--mdb-body-bg);
        }

        50% {
            box-shadow: 0 0 0 var(--mdb-body-bg);
            margin-top: -20px;
            transform: translate(15px, 15px);
        }

        100% {
            box-shadow: 30px 0 0 var(--mdb-body-bg);
            margin-top: 0;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div id="loaderBody" class="position-fixed d-flex justify-content-center align-items-center top-0 start-0" style="background-color: rgba(var(--mdb-body-bg-rgb), 0.5); width: 100vw; height: 100vh; z-index: 1000000000;">
    <span class="loader-body"></span>
    <span class="visually-hidden">Loading...</span>
</div>
<div id="idHalaman" class="d-none"><?= isset($halaman['id']) ? $halaman['id'] : ''; ?></div>
<script src="<?= base_url('assets/js/formatter.js') ?>"></script>
<form action="<?= base_url('/admin/halaman/simpan/' . (isset($halaman['id']) ? $halaman['id'] : '')); ?>" method="post" enctype="multipart/form-data">
    <div class="row mb-5">
        <div class="col-12">

            <!-- Pesan sukses atau error -->
            <?php if (session()->getFlashdata('sukses')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <a href="<?= base_url('admin/halaman') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                    <?= session()->getFlashdata('sukses') ?>
                </div>
            <?php elseif (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <a href="<?= base_url('admin/halaman') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                    <?= session()->getFlashdata('gagal') ?>
                </div>
            <?php endif; ?>

            <!-- Judul -->
            <div class="form-outline position-relative mb-3" data-mdb-input-init>
                <input type="text" class="form-control form-control-lg" id="judul" name="judul" value="<?= $valueJudul ?>" required>
                <label for="judul" class="form-label"><?= lang('Admin.judul') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('judul'); ?>
                </div>
            </div>

        </div>
        <div class="col-lg-8">

            <!-- Daftar komponen halaman -->
            <ul class="list-group list-group-light pb-5" id="tabelKomponen" style="cursor: grab;">
                <?php if (!empty($komponen)): ?>
                    <?php foreach ($komponen as $i => $x): ?>
                        <li
                            class="list-group-item p-0 border-0 mb-2"
                            data-id="<?= $x['id']; ?>"
                            data-name="<?= $x['nama']; ?>"
                            data-instance-id="<?= $halamanKomponen[$i]->komponen_instance_id ?>">

                            <div class="card d-flex flex-row justify-content-between align-items-center py-3 px-4">

                                <!-- Nama komponen -->
                                <div>
                                    <span class="sortable-handle me-4">☰</span>
                                    <?= $x['nama']; ?>
                                </div>

                                <!-- Tombol aksi -->
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm btn-floating me-2 edit-komponen">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-floating remove-komponen">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                            </div>

                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item no-components text-center">
                        <?= lang('Admin.belumAdaKomponenSeretDanTaruh') ?>
                    </li>
                <?php endif; ?>
            </ul>
            <input id="idKomponen" type="hidden" name="id_komponen" value='<?= !empty($halamanKomponen) ? json_encode($halamanKomponen) : '[]'; ?>'>
            <!-- Akhir dari daftar komponen -->

        </div>
        <div class="col-lg-4">

            <!-- Search input -->
            <div class="form-outline mb-3" data-mdb-input-init>
                <input type="text" id="searchKomponen" class="form-control">
                <label for="searchKomponen" class="form-label"><?= lang('Admin.cariKomponen') ?></label>
            </div>

            <!-- Daftar komponen tersedia -->
            <div class="mb-3" style="height: 512px; overflow: auto; cursor: grab;">
                <!-- <label for="daftarKomponen" class="form-label"><?= lang('Admin.daftarKomponen') ?></label> -->
                <ul id="daftarKomponen" class="list-group pe-3">
                    <?php foreach ($daftarKomponen as $x): ?>
                        <li class="list-group-item p-0 border-0 mb-2" draggable="true" data-id="<?= $x['id']; ?>" data-name="<?= $x['nama'] ?>" data-singular="<?= $x['tunggal'] ?>">
                            <div class="card border border-primary-subtle shadow-0 d-flex flex-row align-items-center py-2 px-3">
                                <i class="bi bi-arrows-move me-3"></i>
                                <?= $x['nama']; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Slug -->
            <label for="slug" class="form-label"><?= lang('Admin.alamatHalaman') ?></label>
            <div class="input-group position-relative mb-3">
                <span class="input-group-text"><?= base_url('halaman/') ?></span>
                <input type="text" class="form-control <?= (validation_show_error('slug')) ? 'is-invalid' : ''; ?>" id="slug" name="slug" value="<?= $valueSlug ?>" required>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('slug'); ?>
                </div>
            </div>

            <!-- Status -->
            <div class="form-floating mb-3">

                <select id="status" name="status" class="form-select <?= (validation_show_error('status')) ? 'is-invalid' : ''; ?>" aria-label="Default select">
                    <option value="draf" <?= ($valueStatus == 'draf') ? 'selected' : ''; ?>><?= lang('Admin.draf') ?></option>
                    <option value="publikasi" <?= ($valueStatus == 'publikasi') ? 'selected' : ''; ?>><?= lang('Admin.publikasi') ?></option>
                </select>
                <label for="status"><?= lang('Admin.status') ?></label>
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('status'); ?>
                </div>

            </div>

            <!-- Tombol simpan -->
            <button class="btn btn-primary me-2 mb-2" type="submit" data-mdb-ripple-init>
                <i class="bi bi-check-lg me-2"></i><?= lang('Admin.simpan') ?>
            </button>

            <!-- Tombol preview -->
            <a href="<?= base_url('halaman/' . $halaman['slug']) ?>" class="btn btn-secondary me-2 mb-2" target="_blank" data-mdb-ripple-init>
                <i class="bi bi-eye me-2"></i><?= lang('Admin.tinjau') ?>
            </a>

            <!-- Tombol opsi tambahan -->
            <a
                class="btn btn-secondary btn-floating mb-2"
                data-mdb-collapse-init
                data-mdb-ripple-init
                href="#collapseOpsiTambahan"
                role="button"
                aria-expanded="false"
                aria-controls="collapseOpsiTambahan">
                <i class="bi bi-gear"></i>
            </a>

            <!-- Opsi tambahan -->
            <div class="collapse" id="collapseOpsiTambahan">

                <!-- CSS file input -->
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" id="css" name="css_file">
                    <label for="css">CSS</label>

                    <?php if (isset($halaman['css']) && $halaman['css'] != ''): ?>

                        <!-- CSS lama -->
                        <div class="form-helper">
                            <small>
                                <a href="<?= base_url($valueCSS) ?>" id="cssOldLabel" target="_blank">
                                    <!-- Filled dynamically by script -->
                                </a>
                            </small>
                        </div>

                        <!-- Button delete CSS -->
                        <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusCSS" data-mdb-ripple-init="">
                            <i class="bi bi-trash"></i>
                        </button>

                        <script>
                            // Add old css label and handle deletion
                            document.addEventListener('DOMContentLoaded', function() {
                                let cssOldLabel = document.getElementById("cssOldLabel");
                                let buttonHapusCSS = document.getElementById('buttonHapusCSS');

                                cssOldLabel.innerHTML =
                                    getFilenameAndExtension('<?= $halaman['css'] ?>') +
                                    '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                                buttonHapusCSS.addEventListener("click", function() {
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
                                            // Set input cssOld value to empty and hide hapus button
                                            document.getElementById('cssOld').value = '';
                                            buttonHapusCSS.style.display = 'none';
                                            cssOldLabel.style.display = 'none';
                                        }
                                    });
                                });
                            });
                        </script>

                    <?php endif; ?>

                    <!-- Galat validasi -->
                    <div class="alert alert-danger mt-2 <?= (!$errorCSS) ? 'd-none' : ''; ?>" role="alert">
                        <?= $errorCSS; ?>
                    </div>

                </div>

                <!-- CSS old input -->
                <input type="hidden" class="form-control" id="cssOld" name="css_old" value="<?= $halaman['css'] ?>">

                <!-- JS file input -->
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" id="js" name="js_file">
                    <label for="js">JS</label>

                    <?php if (isset($halaman['js']) && $halaman['js'] != ''): ?>

                        <!-- JS lama -->
                        <div class="form-helper">
                            <small>
                                <a href="<?= base_url($valueJS) ?>" id="jsOldLabel" target="_blank">
                                    <!-- Filled dynamically by script -->
                                    <i class="bi bi-box-arrow-up-right ms-2"></i>
                                </a>
                            </small>
                        </div>

                        <!-- Button delete JS -->
                        <button type="button" class="btn btn-danger btn-sm btn-floating" id="buttonHapusJS" data-mdb-ripple-init="">
                            <i class="bi bi-trash"></i>
                        </button>

                        <script>
                            // Add old js label and handle deletion
                            document.addEventListener('DOMContentLoaded', function() {
                                let jsOldLabel = document.getElementById("jsOldLabel");
                                let buttonHapusJS = document.getElementById('buttonHapusJS');

                                jsOldLabel.innerHTML =
                                    getFilenameAndExtension('<?= $halaman['js'] ?>') +
                                    '<i class="bi bi-box-arrow-up-right ms-2"></i>';

                                buttonHapusJS.addEventListener("click", function() {
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
                                            // Set input jsOld value to empty and hide hapus button
                                            document.getElementById('jsOld').value = '';
                                            buttonHapusJS.style.display = 'none';
                                            jsOldLabel.style.display = 'none';
                                        }
                                    });
                                });
                            });
                        </script>

                    <?php endif; ?>

                    <!-- Galat validasi -->
                    <div class="alert alert-danger mt-2 <?= (!$errorJS) ? 'd-none' : ''; ?>" role="alert">
                        <?= $errorJS; ?>
                    </div>

                </div>

                <!-- JS old input -->
                <input type="hidden" class="form-control" id="jsOld" name="js_old" value="<?= $halaman['js'] ?>">

            </div>

        </div>
    </div>
</form>

<!-- Edit Meta Modal -->
<div class="modal modal-lg fade" id="editKomponenMetaModal" tabindex="-1" aria-labelledby="editMetaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="editMetaModalLabel"><?= lang('Admin.suntingKomponen') ?></span>

                    <!-- Spinner -->
                    <div class="spinner-border spinner-border-sm ms-2" id="editMetaModalSpinner" role="status">
                        <span class="visually-hidden"><?= lang('Admin.memuat') ?></span>
                    </div>

                </h5>

                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">

                <!-- Form sunting komponen -->
                <form id="editKomponenMetaForm" method="post" class="needs-validation" enctype="multipart/form-data">
                    <div id="input-container">
                        <!-- Input komponen meta akan ditambahkan secara dinamis disini -->
                    </div>

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <button id="saveKomponenMetaButton" type="submit" class="btn btn-primary" data-mdb-ripple-init><i class='bx bx-save me-2'></i><?= lang('Admin.simpan') ?></button>
                        </div>

                        <a
                            class="btn btn-secondary btn-floating mb-2 require-meta"
                            data-mdb-collapse-init
                            data-mdb-ripple-init
                            href="#collapseOpsiMetaTambahan"
                            role="button"
                            aria-expanded="false"
                            aria-controls="collapseOpsiMetaTambahan"
                            data-mdb-tooltip-init
                            title="Riwayat data">
                            <i class="bi bi-clock-history"></i>
                        </a>

                    </div>

                    <!-- Opsi tambahan -->
                    <div class="collapse" id="collapseOpsiMetaTambahan">

                        <div class="require-meta d-flex justify-content-end align-items-center pt-2 border-1 border-top border-secondary">

                            <!-- Button previous metadata -->
                            <button id="previousMetaButton" type="button" class="btn btn-secondary btn-floating" data-mdb-ripple-init data-mdb-tooltip-init title="<?= lang('Admin.dataMetaSebelumnya') ?>">
                                <i class='bx bx-undo'></i>
                            </button>

                            <!-- Button next metadata -->
                            <button id="nextMetaButton" type="button" class="btn btn-secondary btn-floating ms-2" data-mdb-ripple-init data-mdb-tooltip-init title="<?= lang('Admin.dataMetaSesudahnya') ?>">
                                <i class='bx bx-redo'></i>
                            </button>

                            <!-- Metadata index and count -->
                            <span class="badge badge-primary ms-2">
                                <span id="metaDataIndex">0</span>
                                /
                                <span id="metaDataCount"></span>
                            </span>

                            <!-- Button clear metadata history -->
                            <button id="clearMetaHistoryButton" type="button" class="btn btn-danger btn-floating ms-2" data-mdb-ripple-init data-mdb-tooltip-init title="<?= lang('Admin.bersihkanRiwayatDataMeta') ?>">
                                <i class='bx bx-eraser'></i>
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php include_once('assets/js/syntax_processor.js.php') ?>

<script src="<?= base_url('assets/js/formatter.js') ?>"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script> -->

<!-- Latest Sortable -->
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>

<!-- TinyMCE -->
<script src="<?= base_url('assets/vendor/tinymce/tinymce/tinymce.min.js'); ?>"></script>

<!-- DSM Gallery TinyMCE Plugin -->
<script src="<?= base_url('assets/js/tinymce/dsmgallery-plugin.js'); ?>"></script>

<!-- DSM File Insert TinyMCE Plugin -->
<script src="<?= base_url('assets/js/tinymce/dsmfileinsert-plugin.js'); ?>"></script>

<script type="module" src="<?= base_url('assets/js/admin/page-editor/main.bundle.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // console.log(`<?php echo json_encode($daftarKomponen); ?>`);
        // console.log("addcslashes: <?php echo addcslashes(json_encode($daftarKomponen), '\"'); ?>");

        // Used in complementary
        function metaFileAddHapusButtonScript(id) {
            return `<script>
    const ${id}_buttonHapusFile = document.getElementById('${id}_buttonHapusFile');
    
    ${id}_buttonHapusFile.addEventListener("click", function() {

        // Confirm delete
        Swal.fire({
            title: "<?= lang('Admin.hapusItem') ?>",
            text: "<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "var(--mdb-danger)",
            confirmButtonText: "<?= lang('Admin.hapus') ?>",
            cancelButtonText: "<?= lang('Admin.batal') ?>",
        }).then((result) => {
            
            if (result.isConfirmed) {
                // Set input ${id}_old value to empty and hide hapus button
                document.getElementById('${id}_old').value = "";
                ${id}_buttonHapusFile.style.display = "none";
            }

        });

    });
<\/script>`;
        }
    });
</script>
<?= $this->endSection() ?>