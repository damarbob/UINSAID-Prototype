<?php
helper('form');

$valueJudul = (old('judul')) ? old('judul') : $halaman['judul'];
$valueSlug = (old('slug')) ? old('slug') : $halaman['slug'];
$valueStatus = (old('status')) ? old('status') : $halaman['status'];
$valueCSS = $halaman['css'];
$valueJS = $halaman['js'];

// dd($komponen);
// dd($komponenData);

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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
                            data-instance-id="<?= $komponenData[$i]->komponen_instance_id ?>">

                            <div class="card d-flex flex-row justify-content-between align-items-center py-3 px-4">

                                <!-- Nama komponen -->
                                <div>
                                    <span class="sortable-handle me-4">☰</span>
                                    <?= $x['nama']; ?>
                                </div>

                                <!-- Tombol aksi -->
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm btn-floating me-2" onclick="editKomponen()">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-floating remove-komponen" onclick="deleteKomponen()">
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
            <input type="hidden" name="id_komponen" value='<?= !empty($komponenData) ? json_encode($komponenData) : '[]'; ?>'>
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
                        <li class="list-group-item p-0 border-0 mb-2" draggable="true" data-id="<?= $x['id']; ?>" data-name="<?= $x['nama'] ?>" data-tunggal="<?= $x['tunggal'] ?>">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* Component search */

        document.getElementById('searchKomponen').addEventListener('input', function() {
            var input = this.value.toLowerCase(); // Get the input value
            var listItems = document.querySelectorAll('#daftarKomponen li'); // Get all list items

            listItems.forEach(function(item) {
                var componentName = item.getAttribute('data-name').toLowerCase(); // Get the name attribute and compare
                if (componentName.includes(input)) {
                    item.style.display = ''; // Show if it matches
                } else {
                    item.style.display = 'none'; // Hide if it doesn't match
                }
            });
        });

        /* End of component search */

        /* Sortable */

        var tabelKomponen = document.getElementById('tabelKomponen');

        // Initialize Sortable.js on the table
        var sortable = new Sortable(tabelKomponen, {
            // handle: '.sortable-handle',
            animation: 150,
            onEnd: function() {
                updateKomponenOrder();
            }
        });

        // Handle drag and drop of new components
        var daftarKomponen = document.getElementById('daftarKomponen');
        daftarKomponen.addEventListener('dragstart', function(e) {
            // e.dataTransfer.setData('text/plain', e.target.dataset.id);
            const data = {
                id: e.target.dataset.id,
                name: e.target.dataset.name,
                tunggal: e.target.dataset.tunggal
            };
            e.dataTransfer.setData('text/plain', JSON.stringify(data));
        });

        tabelKomponen.addEventListener('dragover', function(e) {
            e.preventDefault();
        });

        ////
        tabelKomponen.addEventListener('drop', function(e) {
            e.preventDefault();
            const data = JSON.parse(e.dataTransfer.getData('text/plain'));
            var componentId = data.id;
            var componentName = data.name;
            var componentIsSingular = data.tunggal;

            // Check if the component is SINGULAR/TUNGGAL already in the list
            if (componentIsSingular == true && (document.querySelector('#tabelKomponen [data-id="' + componentId + '"]'))) {
                Swal.fire({
                    icon: 'warning',
                    title: '<?= lang('Admin.komponenTunggal') ?>',
                    text: '<?= lang('Admin.komponenSudahDitambahkan') ?>',
                    confirmButtonColor: "var(--mdb-primary)",
                    confirmButtonText: "<?= lang('Admin.tutup') ?>",
                });
                return;
            }

            // Generate unique komponen_instance_id
            var komponenInstanceId = `inst_${componentId}_${Date.now()}`;

            var componentText = document.querySelector('#daftarKomponen [data-id="' + componentId + '"]').innerText;

            // Remove "No components added yet" row if it exists
            var noComponentsRow = document.querySelector('.no-components');
            if (noComponentsRow) {
                noComponentsRow.remove();
            }

            // Add the dropped component to the table with animation
            var newRow = document.createElement('li');
            newRow.setAttribute('data-id', componentId);
            newRow.setAttribute('data-name', componentName);
            newRow.setAttribute('data-instance-id', komponenInstanceId);
            newRow.classList.add('list-group-item', 'p-0', 'border-0', 'mb-2', 'fade-in');
            newRow.innerHTML = `
        <div class="card w-100 d-flex flex-row justify-content-between align-items-center py-3 px-4">
            <div>
                <span class="sortable-handle me-4">☰</span>
                ${componentText}
            </div>
            <div>
                <button type="button" class="btn btn-primary btn-sm btn-floating me-2" onclick="editKomponen()">
                    <i class="bi bi-pencil"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-floating remove-komponen" onclick="deleteKomponen()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
        `;

            // Get the element at the cursor position
            const closestElement = e.target.closest('li');

            if (closestElement) {
                const boundingRect = closestElement.getBoundingClientRect();
                const middleY = boundingRect.top + (boundingRect.height / 2);

                if (e.clientY > middleY) {
                    // If cursor is in the bottom half, insert after the closest element
                    tabelKomponen.insertBefore(newRow, closestElement.nextSibling);
                } else {
                    // If cursor is in the top half, insert before the closest element
                    tabelKomponen.insertBefore(newRow, closestElement);
                }
            } else {
                // If no elements are found, append to the end
                tabelKomponen.appendChild(newRow);
            }

            updateKomponenOrder();
        });

        // Modular edit function
        window.editKomponen = function() {
            const button = event.target; // Get the element that triggered the event
            const liElement = button.closest('li'); // Find the closest <li> element (the component)
            const komponenId = liElement.getAttribute('data-id'); // Get the ID
            const komponenNama = liElement.getAttribute('data-name'); // Get the ID
            const komponenInstanceId = liElement.getAttribute('data-instance-id'); // Get the instance ID

            const metaDataIndex = document.getElementById('metaDataIndex').innerHTML; // Get meta data index from element

            openEditKomponenMetaModal(komponenId, komponenNama, komponenInstanceId, metaDataIndex); // Open edit meta modal
        }

        // Modular delete function
        window.deleteKomponen = function() {
            const button = event.target; // Get the element that triggered the event
            const liElement = button.closest('li'); // Find the closest <li> element (the component)
            const komponenInstanceId = liElement.getAttribute('data-instance-id'); // Get the instance ID

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
                    // Remove the component from the DOM
                    liElement.remove();

                    // Update the component order
                    updateKomponenOrder();

                    // If there are no more components, show the placeholder row
                    if (tabelKomponen.querySelectorAll('li').length === 0) {
                        var noComponentsRow = document.createElement('li');
                        noComponentsRow.classList.add('list-group-item', 'no-components', 'text-center');
                        noComponentsRow.innerHTML = '<?= lang('Admin.belumAdaKomponenSeretDanTaruh') ?>';
                        tabelKomponen.appendChild(noComponentsRow);
                    }
                }
            });
        }

        ////

        // Handle double-click event on the component list items
        tabelKomponen.addEventListener('dblclick', function(e) {
            if (e.target.closest('li')) {
                var componentId = e.target.closest('li').dataset.id;
                var componentName = e.target.closest('li').dataset.name;
                var komponenInstanceId = e.target.closest('li').dataset.instanceId; // Use instance ID

                const metaDataIndex = 0; // Get meta data index from element

                openEditKomponenMetaModal(componentId, componentName, komponenInstanceId, metaDataIndex); // Open edit meta modal
            }
        });

        /* Akhir dari sortable */

        /* UI */

        function updateKomponenOrder() {
            var order = Array.from(tabelKomponen.querySelectorAll('li')).map(function(row) {
                // return row.dataset.id;
                return {
                    komponen_id: row.dataset.id,
                    komponen_instance_id: row.dataset.instanceId
                }; // NEW
            });
            document.querySelector('input[name="id_komponen"]').value = JSON.stringify(order);
        }

        /**
         * Re-initializes all MDB components inside #editModal's #input-container.
         */
        function reinitializeMDBElements() {
            const container = document.getElementById('input-container');

            // Re-initialize MDB input fields (for floating labels)
            if (typeof mdb !== 'undefined' && mdb.Input) {
                container.querySelectorAll('.form-outline').forEach(element => {
                    const inputInstance = new mdb.Input(element);
                    inputInstance.update(); // Update the input state to handle floating labels
                });
            }

            // Re-initialize MDB range inputs
            if (typeof mdb !== 'undefined' && mdb.Range) {
                container.querySelectorAll('.range').forEach(element => {
                    new mdb.Range(element); // Initialize range inputs
                });
            }

            // Add other MDB component initializations if needed
        }

        function populateEditKomponenMetaFields(meta) {

            // console.log("META THE FOLLOWING:");
            // console.log(meta);

            meta.forEach(function(item) {
                let element = document.getElementById(item['id']) || document.getElementsByName(item['id']);

                if (element) {

                    const id = item['id'];
                    let value = item['value'];

                    if (NodeList.prototype.isPrototypeOf(element)) {
                        element.forEach(function(radio) {
                            if (radio.type === 'radio' && radio.value === value) {
                                radio.checked = true;
                            }
                        });
                    } else if (element.type) {

                        // console.log(element.type);

                        // ELEMENT TYPE MEANS THE HTML ELEMENT TYPE AND NOT THE META TIPE
                        switch (element.type) {
                            case 'text':
                            case 'email':
                            case 'password':
                            case 'number':
                            case 'color':
                            case 'range':
                            case 'datetime-local':
                                element.value = value;
                                break;
                            case 'checkbox':
                                element.checked = value === 'on';
                                break;
                            case 'file':

                                // if (!element.hasAttribute('multiple')) {
                                //     // Handle single file

                                //     if (!value) {
                                //         // If falsy value, return
                                //         return;
                                //     }

                                //     // Declare variables
                                //     const fileInputOld = document.getElementById(id + '_old');
                                //     const fileFormHelper = document.getElementById(id + '_formHelper');
                                //     const fileInputParent = document.getElementById(id + '_parent');

                                //     fileInputOld.value = value;

                                //     fileFormHelper.insertAdjacentHTML('beforeend', `
                                //         <small>
                                //             <a href="${replaceEnvironmentSyntax(value)}" target="_blank">
                                //                 ${getFilenameAndExtension(value)}
                                //                 <i class="bi bi-box-arrow-up-right ms-2"></i>
                                //             </a>
                                //         </small>
                                //     `);

                                //     // Delete button alongside with its script to empty the input old
                                //     // Append the button to the parent
                                //     fileInputParent.insertAdjacentHTML('beforeend', `
                                //         <button type="button" class="btn btn-danger btn-sm btn-floating" id="${id}_buttonHapusFile" data-mdb-ripple-init="">
                                //             <i class="bi bi-trash"></i>
                                //         </button>
                                //     `);

                                //     // Get reference to the button after it's added
                                //     const fileButtonHapus = document.getElementById(`${id}_buttonHapusFile`);

                                //     // Add the event listener
                                //     fileButtonHapus?.addEventListener("click", function() {
                                //         // Confirm delete
                                //         Swal.fire({
                                //             title: "<?= lang('Admin.hapusItem') ?>",
                                //             text: "<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>",
                                //             icon: "warning",
                                //             showCancelButton: true,
                                //             confirmButtonColor: "var(--mdb-danger)",
                                //             confirmButtonText: "<?= lang('Admin.hapus') ?>",
                                //             cancelButtonText: "<?= lang('Admin.batal') ?>",
                                //         }).then((result) => {
                                //             if (result.isConfirmed) {

                                //                 // Set input value to empty and hide delete button
                                //                 fileInputOld.value = "";
                                //                 fileFormHelper.style.display = "none";
                                //                 fileButtonHapus.style.display = "none";

                                //                 console.log(fileFormHelper);

                                //             }
                                //         });
                                //     });

                                // } else {
                                // Handle multiple files

                                // Check whether the value is array, maybe due to user just changed the data type into files
                                if (!Array.isArray(value)) {
                                    if (!value) {
                                        // If falsy value, return
                                        return;
                                    }
                                    value = [value]; // Convert it into array if it's not
                                }

                                // console.log(value);

                                // We cannot do anything to file input including changing the text
                                // Instead, we store the previously uploaded file to a hidden input 'old'
                                const filesInputOld = document.getElementById(id + '_old');
                                const filesFormHelper = document.getElementById(id + '_formHelper');
                                const filesInputParent = document.getElementById(id + '_parent');

                                filesInputOld.value = JSON.stringify(value); // This will result in array even with a single value JUST DON'T FORGET TO PARSE BEFORE STRINGIFYING AGAIN, OTHERWISE BROKEN

                                // Show all files
                                value.forEach(fileUrl => {

                                    // console.log('File URL:', fileUrl);

                                    filesFormHelper.insertAdjacentHTML('beforeend', `
                                        <small>
                                            (
                                            <a href="<?= base_url() ?>${(fileUrl)}" target="_blank">
                                                ${getFilenameAndExtension(fileUrl)}
                                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                                            </a>
                                            )
                                        </small>
                                    `);

                                });

                                // Delete button alongside with its script to empty the input old
                                // Append the button to the parent
                                filesInputParent.insertAdjacentHTML('beforeend', `
                                    <button type="button" class="btn btn-danger btn-sm btn-floating" id="${id}_buttonHapusFile" data-mdb-ripple-init="">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    `);

                                // Get reference to the button after it's added
                                const buttonHapusFile = document.getElementById(`${id}_buttonHapusFile`);

                                // Add the event listener
                                buttonHapusFile?.addEventListener("click", function() {
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

                                            // Set input value to empty and hide delete button
                                            filesInputOld.value = "";
                                            filesFormHelper.style.display = "none";
                                            buttonHapusFile.style.display = "none";

                                            console.log(filesFormHelper);

                                        }
                                    });
                                });
                                // }

                                break;
                            case 'select-one':
                                element.value = value;
                                break;
                            default:
                                if (element.tagName === 'TEXTAREA') {
                                    element.value = value;
                                } else {
                                    element.innerHTML = value;
                                }
                                break;
                        }
                    }
                } else {
                    console.log(`Element with ID or Name ${item['id']} not found.`);
                }

            });

            reinitializeMDBElements(); // Update MDB elements

        }

        /* Akhir dari UI */


        /* Editor komponen */

        /**
         * Creates MDB styled inputs dynamically from an array of meta JSON objects.
         * @param {Array<Object>} metaDataArray - An array of parsed JSON objects.
         */
        function createInputsFromKomponenMeta(meta) {
            const container = document.getElementById('input-container');
            container.innerHTML = ''; // Clear the container before adding new inputs

            if (meta.length == 0) {
                // Append the generated input HTML to the container
                container.insertAdjacentHTML('beforeend', '<p><?= lang('Admin.komponenIniTidakMemilikiKolomMeta') ?></p>');

                // Don't display element that require meta
                document.querySelectorAll(".require-meta").forEach(element => {

                    if (!element.classList.contains("d-none")) {
                        element.classList.add("d-none");
                    }

                });

            } else {
                // Show element that require meta
                document.querySelectorAll(".require-meta").forEach(element => {

                    if (element.classList.contains("d-none")) {
                        element.classList.remove("d-none");
                    }

                });

            }

            meta.forEach(item => {
                let {
                    id,
                    nama,
                    tipe,
                    keterangan,
                    options,
                    required,
                    value,
                    checked
                } = item; // Destructure necessary fields
                let inputHTML = '';

                // Handle undefined values
                value = value ? value : '';
                required = required ? 'required' : '';

                // console.log(item);
                // console.log(item.required);

                // Create input elements based on type
                switch (tipe) {
                    case 'text':
                    case 'email':
                    case 'password':
                    case 'number':
                        inputHTML = `
                            <div class="form-outline ${keterangan ? "mb-4" : "mb-3"}" data-mdb-input-init>
                                <input type="${tipe}" id="${id}" name="${id}" value="${value}" class="form-control" ${required} />
                                <label class="form-label" for="${id}">${nama}</label>
                                ${keterangan ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(keterangan)}</small></div>` : ""}
                            </div>`;
                        break;
                    case 'datetime-local':
                        inputHTML = `
                            <div class="form-outline ${keterangan ? "mb-4" : "mb-3"}" data-mdb-input-init>
                                <input type="${tipe}" id="${id}" name="${id}" value="${value}" class="form-control form-control-lg" ${required} />
                                <label class="form-label" for="${id}">${nama}</label>
                                ${keterangan ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(keterangan)}</small></div>` : ""}
                            </div>`;
                        break;
                    case 'color':
                        inputHTML = `
                            <div class="${keterangan ? "mb-4" : "mb-3"}">
                                <label class="form-label" for="${id}">${nama}</label>
                                <input type="${tipe}" id="${id}" name="${id}" value="${value}" class="form-control form-control-color" title="${nama}" />
                                ${keterangan ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(keterangan)}</small></div>` : ""}
                            </div>`;
                        break;

                    case 'textarea':
                        inputHTML = `
                            <div class="form-outline ${keterangan ? "mb-4" : "mb-3"}" data-mdb-input-init>
                                <textarea id="${id}" name="${id}" class="form-control" ${required}>${value}</textarea>
                                <label class="form-label" for="${id}">${nama}</label>
                                ${keterangan ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(keterangan)}</small></div>` : ""}
                            </div>`;

                        break;

                    case 'editor':
                        inputHTML = `
                            <div class="${keterangan ? "mb-4" : "mb-3"}" data-mdb-input-init>
                                <label class="form-label" for="${id}">${nama}</label>
                                <textarea id="${id}" name="${id}" class="form-control">${value}</textarea>
                                ${keterangan ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(keterangan)}</small></div>` : ""}
                            </div>`;

                        break;

                    case 'checkbox':
                        // Value true = checked
                        inputHTML = `
                            <div class="form-check ${keterangan ? "mb-4" : "mb-3"}">
                                <input type="checkbox" id="${id}" name="${id}" class="form-check-input" ${required}  ${checked === true ? 'checked' : ''} />

                                <label class="form-check-label" for="${id}">${nama}</label>
                                ${keterangan ? `<div class="form-helper"><small>${replaceEnvironmentSyntax(keterangan)}</small></div>` : ""}
                            </div>`;
                        break;

                    case 'radio':
                        // Option value true = checked
                        if (options && Array.isArray(options)) {
                            inputHTML = options.map(option => `
                                <div class="form-check mb-3">
                                    <input type="radio" id="${id}_${option.value}" name="${id}" value="${option.value}" class="form-check-input" ${required}   ${option.checked === true ? 'checked' : ''} />

                                    <label class="form-check-label" for="${id}_${option.value}">${option.label}</label>
                                </div>
                            `).join('');
                        }
                        break;

                    case 'range':
                        inputHTML = `
                            <label class="form-label" for="${id}">${nama}</label>
                            <div class="range mb-3">
                                <input type="range" id="${id}" name="${id}" value="${value}" class="form-range" ${options ? (options.min ? 'min="'+ options.min + '"' : '') : ''} ${options ? (options.max ? 'max="'+ options.max + '"' : '') : ''}/>
                            </div>`;
                        break;

                    case 'file':
                    case 'file-multiple':
                        // Common template for both single and multiple files
                        const isMultiple = tipe === 'file-multiple' ? 'multiple' : '';
                        inputHTML = `
                            <div class="form-floating mb-3" id="${id}_parent">
                                <input type="file" id="${id}" name="${id}${isMultiple ? '[]' : ''}" class="form-control" ${isMultiple} />
                                <label class="form-label" for="${id}">${nama}</label>
                                <div class="form-helper" id="${id}_formHelper">
                                    <!-- Filled dynamically -->
                                </div>
                                <input type="hidden" id="${id}_old" name="${id}" />
                            </div>`;
                        break;


                    case 'select':
                        if (options && Array.isArray(options)) {
                            let optionsHTML = options.map(option => `<option value="${option.value}" ${option.value === true ? 'selected' : ''}>${option.label}</option>`).join('');
                            inputHTML = `
                                <div class="mb-3">
                                    <label class="form-label" for="${id}">${nama}</label>
                                    <select id="${id}" name="${id}" class="form-select">
                                        ${optionsHTML}
                                    </select>
                                </div>`;
                        }
                        break;

                    default:
                        console.warn(`Unknown input type: ${tipe}`);
                }

                // Append the generated input HTML to the container
                container.insertAdjacentHTML('beforeend', inputHTML);

                if (tipe === 'editor') {
                    if (tinymce.get(`${id}`)) {
                        tinymce.get(`${id}`).remove(); // Destroy the existing TinyMCE instance
                    }
                    setTimeout(() => {
                        tinymce.init({
                            cache_suffix: `?v=${new Date().getTime()}`,
                            selector: `#${id}`,
                            license_key: 'gpl', // Important to prevent license issue
                            relative_urls: false,
                            document_base_url: '<?= base_url() ?>', // Set the base URL for relative paths
                            convert_urls: false, // Prevent TinyMCE from converting URLs to relative
                            plugins: [
                                'advlist', 'autolink', 'image',
                                'lists', 'link', 'charmap', 'preview', 'anchor', 'searchreplace',
                                'fullscreen', 'insertdatetime', 'table', 'help',
                                'wordcount', 'dsmgallery', 'dsmfileinsert', 'code'
                            ],
                            toolbar: 'fullscreen | dsmgallery dsmfileinsert | undo redo | casechange blocks | bold italic backcolor | image | ' +
                                'alignleft aligncenter alignright alignjustify | ' +
                                'bullist numlist checklist outdent indent | removeformat | table | code | help',
                            image_title: true,
                            automatic_uploads: true,
                            // image_gallery_api_endpoint: '<?= base_url('/api/galeri') ?>',
                            dsmgallery_api_endpoint: '<?= base_url('/api/galeri') ?>',
                            dsmgallery_gallery_url: '<?= base_url('/admin/galeri') ?>',
                            dsmfileinsert_api_endpoint: '<?= base_url('/api/file') ?>',
                            dsmfileinsert_file_manager_url: '<?= base_url('/admin/file') ?>',
                            images_upload_url: '<?= base_url('/admin/posting/unggah-gambar') ?>',
                            // images_delete_url: '<?= base_url('/admin/posting/hapus-gambar') ?>',
                            file_picker_types: 'file image media',
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
                    }, 500);
                }

            });

            // Reinitialize MDB elements after creating inputs
            reinitializeMDBElements();
        }

        // Function to open the component editor
        function openEditKomponenMetaModal(componentId, componentName, componentInstanceId, metaDataIndex) {
            // console.log("start: " + metaDataIndex);

            /* Initialize UI */
            document.getElementById('nextMetaButton').disabled = true;
            document.getElementById('previousMetaButton').disabled = true;
            document.getElementById('clearMetaHistoryButton').disabled = true;

            document.getElementById('metaDataIndex').innerHTML = 0; // Show meta index
            document.getElementById('metaDataCount').innerHTML = 0; // Show meta count

            document.getElementById('editMetaModalSpinner').style.display = 'inline-block'; // Show edit modal spinner
            document.getElementById('editMetaModalLabel').innerHTML = componentName;
            /* End of UI initialization */

            /* Initialize modal */
            const modalElement = document.getElementById('editKomponenMetaModal');
            let modalInstance = mdb.Modal.getInstance(modalElement); // Check if modal instance already exists

            if (!modalInstance) {
                modalInstance = new mdb.Modal(modalElement, {
                    focus: false, // Disable focus trapping for tinyMCE modal inputs to work properly
                });
            }

            if (!modalElement.classList.contains('show')) {
                modalInstance.show(); // Only show the modal if it's not already shown
            }

            // Remove tinyMCE instances
            modalElement.addEventListener('hidden.mdb.modal', function() {
                // Find all elements inside the modal and destroy TinyMCE instances
                modalElement.querySelectorAll('textarea').forEach(element => {
                    if (tinymce.get(element.id)) { // Check if the element has a TinyMCE instance
                        tinymce.get(element.id).remove(); // Destroy the TinyMCE instance
                    }
                });
            });

            /////

            // Initialize view
            document.getElementById('saveKomponenMetaButton').disabled = true; // Disable save button

            // Save componentId in a data attribute so handleSubmit can access it
            modalElement.dataset.componentId = componentId;
            modalElement.dataset.componentInstanceId = componentInstanceId;

            // console.log(modalElement.dataset.componentId);
            // console.log(modalElement.dataset.componentInstanceId);

            const content = getKomponenKontenById("<?php echo addcslashes(json_encode($daftarKomponen), '\"'); ?>", componentId);
            const metaDataArray = extractKomponenMetaFromHTML(content);

            // console.log(metaDataArray);

            createInputsFromKomponenMeta(metaDataArray); //  Create input fields for editing metadata

            // If komponen has no meta syntax, exit
            if (metaDataArray.length === 0) {
                // Update UI
                document.getElementById('editMetaModalSpinner').style.display = 'none'; // Hide edit modal spinner
                return;
            }

            // If komponen has meta syntax, get existing meta if any
            // AJAX get existing meta for the selected component
            $.ajax({
                url: '<?= base_url('api/komponen/meta') ?>',
                type: 'POST',
                data: {
                    idInstance: componentInstanceId,
                    idKomponen: componentId,
                    idHalaman: '<?= $halaman['id'] ?>',
                    index: parseInt(metaDataIndex),
                },
                success: function(response) {

                    // Update UI
                    document.getElementById('editMetaModalSpinner').style.display = 'none'; // Hide edit modal spinner
                    document.getElementById('saveKomponenMetaButton').disabled = false; // Enable save button

                    // If data exists, populate to meta input fields
                    if (response['data']) {

                        const responseMeta = response['data']['meta']; // Get the component's meta

                        if (responseMeta) {

                            const meta = JSON.parse(responseMeta); // Deserialize responseMeta
                            var metaDataIndexNew = parseInt(response['index']);
                            var metaDataCountNew = parseInt(response['count']);
                            const nextMetaIndex = metaDataIndexNew + 1;
                            const previousMetaIndex = metaDataIndexNew - 1;

                            /* Listeners */
                            const nextMeta = function() {
                                // modalInstance.hide(); // Hide the modal
                                openEditKomponenMetaModal(componentId, componentName, componentInstanceId, nextMetaIndex)

                                // console.log("end: " + (nextMetaIndex));
                            }
                            const prevMeta = function() {
                                // modalInstance.hide(); // Hide the modal
                                openEditKomponenMetaModal(componentId, componentName, componentInstanceId, previousMetaIndex)
                            }

                            // Set listener to previous button
                            document.getElementById('previousMetaButton').onclick = nextMeta;

                            // Set listener to next button
                            document.getElementById('nextMetaButton').onclick = prevMeta;
                            document.getElementById('clearMetaHistoryButton').onclick = function() {

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

                                        // Send request to clear metadata history
                                        $.ajax({
                                            url: '<?= base_url('api/komponen/meta/hapus-riwayat') ?>',
                                            type: 'POST',
                                            data: {
                                                idInstance: componentInstanceId,
                                                idKomponen: componentId,
                                                idHalaman: '<?= $halaman['id'] ?>',
                                            },
                                            success: function(response) {
                                                const status = response['status'];
                                                console.log(response);

                                                if (status) {
                                                    if (status === 'success') {

                                                        // If successful, show success message and load first meta

                                                        // Show success message
                                                        Swal.fire('<?= lang('Admin.sukses') ?>', '<?= lang('Admin.dataMetaBerhasilDibersihkan') ?>', 'success');

                                                        // Load first meta
                                                        openEditKomponenMetaModal(componentId, componentName, componentInstanceId, 0);

                                                    } else {

                                                        // Show error message
                                                        Swal.fire('<?= lang('Admin.galat') ?>', '<?= lang('Admin.tidakDapatMembersihkanDataMeta') ?>', 'error');

                                                    }
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.log('ERROR:' + status);
                                            },
                                            complete: function() {
                                                // Any additional actions on completion
                                            }
                                        });
                                    }

                                });

                            }

                            /* End of listeners */

                            // console.log("response: " + metaDataIndexNew + "| next: " + nextMetaIndex + " | prev: " + previousMetaIndex);

                            populateEditKomponenMetaFields(meta); // Populate the inputs with retreived meta

                            document.getElementById('metaDataIndex').innerHTML = metaDataIndexNew + 1; // Show meta index
                            document.getElementById('metaDataCount').innerHTML = metaDataCountNew; // Show meta count

                            if (metaDataIndexNew <= 0) {
                                // Hide meta button
                                document.getElementById('nextMetaButton').disabled = true;
                                // console.log("metaCount: " + metaDataCountNew);
                                if (metaDataCountNew > 1) {
                                    document.getElementById('previousMetaButton').disabled = false;
                                } else {
                                    document.getElementById('previousMetaButton').disabled = true;
                                }
                            } else if (metaDataIndexNew + 1 >= metaDataCountNew) {
                                // Enable next meta button
                                document.getElementById('nextMetaButton').disabled = false;
                                document.getElementById('previousMetaButton').disabled = true;
                            } else {
                                // Enable previous meta button
                                document.getElementById('nextMetaButton').disabled = false;
                                document.getElementById('previousMetaButton').disabled = false;
                            }

                            if (metaDataCountNew <= 1) {
                                document.getElementById('clearMetaHistoryButton').disabled = true;
                            } else {
                                document.getElementById('clearMetaHistoryButton').disabled = false;
                            }

                        } else {
                            // The komponen meta record is found but meta field is null
                            // console.log('Component meta field is null');
                        }


                    } else {
                        // The komponen meta record is not found
                        // console.log('Component meta data is not found');
                    }
                    // console.log(response);

                },
                error: function(xhr, status, error) {
                    console.log('ERROR:' + status);
                },
                complete: function() {
                    // Any additional actions on completion
                }
            });

            // Remove previous event listener before attaching a new one
            document.getElementById("editKomponenMetaModal").removeEventListener("submit", handleEditKomponenMetaModalSubmit);
            document.getElementById("editKomponenMetaModal").addEventListener("submit", handleEditKomponenMetaModalSubmit);
        }

        // Edit modal submission handler
        function handleEditKomponenMetaModalSubmit(event) {
            event.preventDefault(); // Prevent default form submission

            // Encode form data from the inputs
            const formData = encodeKomponenMetaInputsToJSON("editKomponenMetaForm");

            // Retrieve necessary component and page details from modal dataset
            const componentId = document.getElementById('editKomponenMetaModal').dataset.componentId;
            const componentName = document.getElementById('editMetaModalLabel').innerHTML; // Get component name from HTML
            const componentInstanceId = document.getElementById('editKomponenMetaModal').dataset.componentInstanceId;
            const halamanId = <?= $halaman['id'] ?>;

            // Append componentId, instanceId, and halamanId to the FormData
            formData.append('instance_id', componentInstanceId);
            formData.append('komponen_id', componentId);
            formData.append('halaman_id', halamanId);

            // Send formData to the server
            fetch('<?= base_url('admin/komponen/simpan/meta') ?>', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {

                    if (data.success) {

                        // If successful
                        Swal.fire('<?= lang('Admin.sukses') ?>', data.message, 'success'); // Show success message

                        console.log('Loading first meta');
                        openEditKomponenMetaModal(componentId, componentName, componentInstanceId, 0); // Load first meta

                    } else {

                        // If error

                        Swal.fire('<?= lang('Admin.galat') ?>', data.message, 'error'); // Show eror message

                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('<?= lang('Admin.galat') ?>', '<?= lang('Admin.terjadiGalatSaatMemproses') ?>', 'error');
                });
        }

        /* Akhir dari editor komponen */

        /* Use case */

        /**
         * Function to get the 'konten' from the JSON data based on a given 'id'.
         *
         * @param {string} jsonString - The JSON string containing the array of components.
         * @param {string} id - The id of the component to retrieve.
         * @returns {string|null} - The 'konten' of the component with the given id, or null if not found.
         */
        function getKomponenKontenById(jsonString, id) {
            try {
                // Parse the JSON string
                const data = jQuery.parseJSON(jsonString);

                // Find the component with the matching id
                const component = data.find(item => item.id === id);

                // Return the 'konten' if found, otherwise null
                return component ? component.konten : null;
            } catch (error) {
                console.error("Error parsing JSON or finding component:", error);
                return null;
            }
        }

        /**
         * Detects custom meta syntax in the provided text and returns an array of parsed JSON objects.
         * @param {string} text - The text to be checked for custom meta syntax.
         * @returns {Array<Object>} - An array of parsed JSON objects.
         */
        function detectKomponenMetaSyntax(text) {
            // Define regex pattern for finding custom JSON metadata in comment blocks
            const metaRegex = /\/\*\s*meta\s*({[^}]+})\s*meta\s*\*\//g;

            let match;
            const inputsData = [];

            // Extract and parse all JSON metadata blocks
            while ((match = metaRegex.exec(text)) !== null) {
                try {
                    const jsonData = JSON.parse(match[1].trim());
                    inputsData.push(jsonData);
                } catch (e) {
                    console.error('Invalid JSON detected in meta:', e);
                }
            }

            return inputsData;
        }

        function extractKomponenMetaFromHTML(content) {

            // Regular expression to match meta comments
            const regex = /\/\*\s*meta\s*({.*?})\s*meta\s*\*\//g;
            let matches;
            const metaDataArray = [];

            // Loop to find all matches
            while ((matches = regex.exec(content)) !== null) {
                try {
                    // Parse the matched JSON string into an object
                    const metaObject = JSON.parse(matches[1]);
                    metaDataArray.push(metaObject);
                } catch (error) {
                    console.error("Error parsing meta JSON:", error);
                }
            }

            return metaDataArray;
        }

        function encodeKomponenMetaInputsToJSON(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll("input, textarea, select");
            let meta = [];
            let formData = new FormData();
            let processedNames = new Set(); // To keep track of processed radio button groups

            inputs.forEach((input) => {
                const {
                    id,
                    type,
                    name,
                    value,
                    files: inputFiles,
                    checked
                } = input;

                if (!id) return; // Skip inputs without IDs

                // Handle file inputs
                if (type === "file") {

                    if (input.hasAttribute('multiple')) {
                        // Handle multiple files

                        if (inputFiles.length > 0) {
                            for (let i = 0; i < inputFiles.length; i++) {
                                formData.append(name, inputFiles[i]); // Append files as an array (name should include '[]')
                                // console.log(`id: ${id} | name: ${name}`);
                            }
                            const fileArray = Array.from(inputFiles).map(file => file.name); // Collect file names for meta
                            meta.push({
                                id,
                                value: fileArray
                            });
                        } else {
                            const oldFiles = document.getElementById(id + '_old').value

                            meta.push({
                                id,
                                value: isValidJSON(oldFiles) ? JSON.parse(oldFiles) : '' // MUST BE PARSED BACK TO JS OBJECT BECAUSE ALL META WILL BE STRINGIFIED IN THE END. TO PREVENT DOUBLE STRINGIFICATION!
                            });
                        }

                    } else {
                        //Handle single file

                        if (inputFiles.length > 0) {
                            formData.append(name, inputFiles[0]); // Append file to formData to enable upload
                            const fileArray = Array.from(inputFiles).map(file => file.name); // Collect file names for meta
                            meta.push({
                                id,
                                value: fileArray
                            });
                            // console.log(inputFiles)
                            // console.log(inputFiles[0])
                        } else {
                            const oldFiles = document.getElementById(id + '_old').value

                            meta.push({
                                id,
                                value: isValidJSON(oldFiles) ? JSON.parse(oldFiles) : '' // MUST BE PARSED BACK TO JS OBJECT BECAUSE ALL META WILL BE STRINGIFIED IN THE END. TO PREVENT DOUBLE STRINGIFICATION!
                            });
                        }
                    }

                }

                // Handle radio buttons - only add the checked one, avoid duplicates
                else if (type === "radio" && checked && !processedNames.has(name)) {
                    meta.push({
                        id: name,
                        value
                    }); // Use name to group radio buttons
                    processedNames.add(name);
                }
                // Handle checkboxes - only add the checked ones
                else if (type === "checkbox") {
                    meta.push({
                        id,
                        value: checked ? 'on' : 'off'
                    });
                }
                // Handle hidden input, normally do nothing as there'll be no hidden input for UX
                else if (type === "hidden") {
                    // Do nothing
                }
                // Handle all other inputs
                else {
                    meta.push({
                        id,
                        value
                    });
                }
            });

            console.log(meta); // Log all meta

            // Add the encoded JSON to FormData for sending to the server
            formData.append("meta", JSON.stringify(meta));

            return formData;
        }

        function isValidJSON(str) {
            try {
                JSON.parse(str);
                return true;
            } catch (e) {
                return false;
            }
        }

        /* Akhir dari use case */


    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

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