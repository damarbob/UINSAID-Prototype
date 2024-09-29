<?php
helper('form');

$valueJudul = (old('judul')) ? old('judul') : $halaman['judul'];
$valueSlug = (old('slug')) ? old('slug') : $halaman['slug'];
$valueStatus = (old('status')) ? old('status') : $halaman['status'];
$valueCSS = $halaman['css'];
$valueJS = $halaman['js'];

// dd($komponen);
// dd($komponenData);
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
                    <?= session()->getFlashdata('sukses') ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (session()->getFlashdata('gagal')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('gagal') ?>
                    <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
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
            <!-- <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?= lang('Admin.judul') ?></th>
                        <th><?= lang('Admin.urutan') ?></th>
                        <th><?= lang('Admin.aksi') ?></th>
                    </tr>
                </thead>
                <tbody id="tabelKomponen">
                    <?php if (!empty($komponen)): ?>
                        <?php foreach ($komponen as $component): ?>
                            <tr data-id="<?= $component['id']; ?>">
                                <td class="sortable-handle">☰</td>
                                <td><?= $component['nama']; ?></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-komponen" data-mdb-ripple-init=""><i class="bi bi-trash"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="no-components">
                            <td colspan="3" class="text-center"><?= lang('Admin.belumAdaKomponenSeretDanTaruh') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table> -->
            <ul class="list-group list-group-light" id="tabelKomponen">
                <?php if (!empty($komponen)): ?>
                    <?php foreach ($komponen as $i => $x): ?>
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center px-3"
                            data-id="<?= $x['id']; ?>"
                            data-instance-id="<?= $komponenData[$i]->komponen_instance_id ?>">
                            <span class="sortable-handle">☰</span>
                            <?= $x['nama']; ?>
                            <button type="button" class="btn btn-danger btn-sm remove-komponen" onclick="deleteKomponen()">
                                <i class="bi bi-trash"></i>
                            </button>
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

            <!-- Daftar komponen tersedia -->
            <div class="mb-3">
                <label for="daftarKomponen" class="form-label"><?= lang('Admin.daftarKomponen') ?></label>
                <ul id="daftarKomponen" class="list-group">
                    <?php foreach ($daftarKomponen as $component): ?>
                        <li class="list-group-item" draggable="true" data-id="<?= $component['id']; ?>">
                            <i class="bi bi-arrows-move me-2"></i>
                            <?= $component['nama']; ?>
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

            <!-- CSS -->
            <div class="position-relative mb-3">
                <label for="css" class="form-label">CSS</label>
                <input type="file" class="form-control <?= (validation_show_error('css_file')) ? 'is-invalid' : ''; ?>" id="css" name="css_file">
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('css_file'); ?>
                </div>

                <!-- CSS lama -->
                <div class="form-helper">
                    <small>
                        <a href="<?= $valueCSS ?>" target="_blank">
                            <?php if (isset($valueCSS) && !empty($valueCSS)): ?>
                                <script>
                                    document.write(getFilenameAndExtension('<?= $valueCSS ?>'));
                                </script>

                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </small>
                </div>

            </div>

            <!-- JS -->
            <div class="position-relative mb-3">
                <label for="js" class="form-label">JS</label>
                <input type="file" class="form-control <?= (validation_show_error('js_file')) ? 'is-invalid' : ''; ?>" id="js" name="js_file">
                <div class="invalid-tooltip end-0">
                    <?= validation_show_error('js_file'); ?>
                </div>

                <!-- JS lama -->
                <div class="form-helper">
                    <small>
                        <a href="<?= $valueJS ?>" target="_blank">
                            <?php if (($valueJS) && !empty($valueJS)): ?>
                                <script>
                                    document.write(getFilenameAndExtension('<?= $valueJS ?>'));
                                </script>

                                <i class="bi bi-box-arrow-up-right ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </small>
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
            <button class="btn btn-primary me-2" type="submit" data-mdb-ripple-init>
                <i class="bi bi-check-lg me-2"></i><?= lang('Admin.simpan') ?>
            </button>

            <!-- Tombol preview -->
            <a href="<?= base_url('halaman/' . $halaman['slug']) ?>" class="btn btn-secondary" target="_blank" data-mdb-ripple-init>
                <i class="bi bi-eye me-2"></i><?= lang('Admin.pratinjau') ?>
            </a>

        </div>
    </div>
</form>

<!-- Edit Meta Modal -->
<div class="modal fade" id="editKomponenMetaModal" tabindex="-1" aria-labelledby="editMetaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMetaModalLabel">
                    <?= lang('Admin.suntingKomponen') ?>

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
                    <button id="saveKomponenMetaButton" type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.sunting') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script> -->
<!-- Latest Sortable -->
<script src="https://raw.githack.com/SortableJS/Sortable/master/Sortable.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

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
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
        });

        tabelKomponen.addEventListener('dragover', function(e) {
            e.preventDefault();
        });

        ////
        tabelKomponen.addEventListener('drop', function(e) {
            e.preventDefault();
            var componentId = e.dataTransfer.getData('text/plain');

            // Generate unique komponen_instance_id
            var komponenInstanceId = `inst-${componentId}-${Date.now()}`; // NEW

            // Check if the component is already in the list
            // if (document.querySelector('#tabelKomponen [data-id="' + componentId + '"]')) {
            //     Swal.fire({
            //         icon: 'warning',
            //         title: '<?= $judul ?>',
            //         text: '<?= lang('Admin.komponenSudahDitambahkan') ?>',
            //         confirmButtonColor: "var(--mdb-primary)",
            //         confirmButtonText: "<?= lang('Admin.tutup') ?>",
            //     });
            //     return; // Prevent adding duplicate component
            // }

            var componentText = document.querySelector('#daftarKomponen [data-id="' + componentId + '"]').innerText;

            // Remove "No components added yet" row if it exists
            var noComponentsRow = document.querySelector('.no-components');
            if (noComponentsRow) {
                noComponentsRow.remove();
            }

            // Add the dropped component to the table with animation
            var newRow = document.createElement('li');
            newRow.setAttribute('data-id', componentId);
            newRow.setAttribute('data-instance-id', komponenInstanceId); // Set instance ID NEW
            newRow.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center', 'fade-in', 'px-3'); // Apply the fade-in animation class
            newRow.innerHTML = '<span class="sortable-handle">☰</span>' + componentText +
                '<button type="button" class="btn btn-danger btn-sm remove-komponen" onclick="deleteKomponen()">' +
                '<i class="bi bi-trash"></i></button>';
            tabelKomponen.appendChild(newRow);

            updateKomponenOrder();
        });

        // // Handle remove komponen functionality
        // tabelKomponen.addEventListener('click', function(e) {
        //     if (e.target.classList.contains('remove-komponen')) {

        //         // Confirm delete
        //         Swal.fire({
        //             title: '<?= lang('Admin.hapusItem') ?>',
        //             text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: 'var(--mdb-danger)',
        //             confirmButtonText: '<?= lang('Admin.hapus') ?>',
        //             cancelButtonText: '<?= lang('Admin.batal') ?>',
        //         }).then((result) => {
        //             if (result.isConfirmed) {

        //                 e.target.closest('li').remove();
        //                 updateKomponenOrder();

        //                 // If there are no more components, show the placeholder row
        //                 if (tabelKomponen.querySelectorAll('li').length === 0) {
        //                     var noComponentsRow = document.createElement('li');
        //                     noComponentsRow.classList.add('list-group-item', 'no-components', 'text-center');
        //                     noComponentsRow.innerHTML = '<?= lang('Admin.belumAdaKomponenSeretDanTaruh') ?>';
        //                     tabelKomponen.appendChild(noComponentsRow);
        //                 }

        //             }
        //         });
        //     }
        // });
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
                var komponenInstanceId = e.target.closest('li').dataset.instanceId; // Use instance ID NEW
                // openEditKomponenMetaModal(componentId);
                openEditKomponenMetaModal(componentId, komponenInstanceId); // NEW
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
                    const value = item['value'];
                    if (NodeList.prototype.isPrototypeOf(element)) {
                        element.forEach(function(radio) {
                            if (radio.type === 'radio' && radio.value === value) {
                                radio.checked = true;
                            }
                        });
                    } else if (element.type) {
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
                                if (Array.isArray(value)) {

                                    // We cannot do anything to file input including changing the text
                                    // Instead, we store the previously uploaded file to a hidden input 'old'
                                    let elementValue = document.getElementById(item['id'] + '_old');
                                    elementValue.value = JSON.stringify(value); // This will result in array even with a single value JUST DON'T FORGET TO PARSE BEFORE STRINGIFYING AGAIN, OTHERWISE BROKEN

                                    // Log
                                    value.forEach(fileUrl => {
                                        // console.log('File URL:', fileUrl);
                                    });
                                }
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
            }

            meta.forEach(item => {
                const {
                    id,
                    nama,
                    tipe,
                    options
                } = item; // Destructure necessary fields
                let inputHTML = '';

                // Create input elements based on type
                switch (tipe) {
                    case 'text':
                    case 'email':
                    case 'password':
                    case 'number':
                        inputHTML = `
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="${tipe}" id="${id}" name="${id}" class="form-control" />
                        <label class="form-label" for="${id}">${nama}</label>
                    </div>`;
                        break;
                    case 'datetime-local':
                        inputHTML = `
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="${tipe}" id="${id}" name="${id}" class="form-control form-control-lg" />
                        <label class="form-label" for="${id}">${nama}</label>
                    </div>`;
                        break;
                    case 'color':
                        inputHTML = `
                    <div class="mb-3">
                        <label class="form-label" for="${id}">${nama}</label>
                        <input type="${tipe}" id="${id}" name="${id}" class="form-control form-control-color" title="${nama}" />
                    </div>`;
                        break;

                    case 'textarea':
                        inputHTML = `
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <textarea id="${id}" name="${id}" class="form-control"></textarea>
                        <label class="form-label" for="${id}">${nama}</label>
                    </div>`;
                        break;

                    case 'checkbox':
                        inputHTML = `
                    <div class="form-check mb-3">
                        <input type="checkbox" id="${id}" name="${id}" class="form-check-input" />
                        <label class="form-check-label" for="${id}">${nama}</label>
                    </div>`;
                        break;

                    case 'radio':
                        if (options && Array.isArray(options)) {
                            inputHTML = options.map(option => `
                            <div class="form-check mb-3">
                                <input type="radio" id="${id}_${option.value}" name="${id}" value="${option.value}" class="form-check-input" />
                                <label class="form-check-label" for="${id}_${option.value}">${option.label}</label>
                            </div>
                            `).join('');
                        }
                        break;

                    case 'range':
                        inputHTML = `
                    <label class="form-label" for="${id}">${nama}</label>
                    <div class="range mb-3">
                        <input type="range" id="${id}" name="${id}" class="form-range" />
                    </div>`;
                        break;

                    case 'file':
                        // Create the file input as well as hidden input in case there are old files
                        inputHTML = `
                    <div class="mb-3">
                        <label class="form-label" for="${id}">${nama}</label>
                        <input type="file" id="${id}" name="${id}[]" class="form-control" multiple />
                        <input type="hidden" id="${id}_old" name="${id}" />
                    </div>`;
                        break;

                    case 'select':
                        if (options && Array.isArray(options)) {
                            let optionsHTML = options.map(option => `<option value="${option.value}">${option.label}</option>`).join('');
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

            });

            // Reinitialize MDB elements after creating inputs
            reinitializeMDBElements();
        }

        // Function to open the component editor
        function openEditKomponenMetaModal(componentId, componentInstanceId) {
            document.getElementById('editMetaModalSpinner').style.display = 'inline-block'; // Show edit modal spinner

            // Initialize and show the MDB modal
            const modalElement = document.getElementById('editKomponenMetaModal');
            const modalInstance = new mdb.Modal(modalElement);
            modalInstance.show();

            // Initialize view
            document.getElementById('saveKomponenMetaButton').disabled = true; // Disable save button

            // Save componentId in a data attribute so handleSubmit can access it
            modalElement.dataset.componentId = componentId;
            modalElement.dataset.componentInstanceId = componentInstanceId;

            // console.log(modalElement.dataset.componentId);
            // console.log(modalElement.dataset.componentInstanceId);

            const content = getKomponenKontenById("<?php echo addcslashes(json_encode($daftarKomponen), '\"'); ?>", componentId);
            const metaDataArray = extractKomponenMetaFromHTML(content);
            createInputsFromKomponenMeta(metaDataArray);

            // AJAX get existing meta for the selected component
            $.ajax({
                url: '<?= base_url('api/komponen/meta') ?>',
                type: 'POST',
                data: {
                    idInstance: componentInstanceId,
                    idKomponen: componentId,
                    idHalaman: '<?= $halaman['id'] ?>'
                },
                success: function(response) {
                    if (response['data']) {
                        const responseMeta = response['data']['meta']; // Get the component's meta
                        if (responseMeta) {

                            const meta = JSON.parse(responseMeta); // Deserialize responseMeta

                            populateEditKomponenMetaFields(meta); // Populate the inputs with retreived meta

                        } else {
                            console.log('Component meta is null');
                        }


                    } else {
                        console.log('Component data is null');
                    }
                    // console.log(response);

                    // Update UI
                    document.getElementById('editMetaModalSpinner').style.display = 'none'; // Hide edit modal spinner
                    document.getElementById('saveKomponenMetaButton').disabled = false; // Enable save button
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

            const formData = encodeKomponenMetaInputsToJSON("editKomponenMetaForm");
            const componentId = document.getElementById('editKomponenMetaModal').dataset.componentId; // Retrieve componentId from data attribute
            const componentInstanceId = document.getElementById('editKomponenMetaModal').dataset.componentInstanceId; // Retrieve componentInstanceId from data attribute
            sendKomponenMetaJSONToServer(formData, componentInstanceId, componentId, <?= $halaman['id'] ?>);
        }

        function sendKomponenMetaJSONToServer(formData, componentInstanceId, componentId, halamanId) {
            // Append componentId and halamanId to the FormData
            formData.append('instance_id', componentInstanceId);
            formData.append('komponen_id', componentId);
            formData.append('halaman_id', halamanId);

            fetch('<?= base_url('admin/komponen/simpan/meta') ?>', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('<?= lang('Admin.sukses') ?>', data.message, 'success');
                    } else {
                        Swal.fire('<?= lang('Admin.galat') ?>', data.message, 'error');
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
<?= $this->endSection() ?>