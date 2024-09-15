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
<form action="/admin/halaman/simpan/<?= isset($halaman['id']) ? $halaman['id'] : ''; ?>" method="post">
    <div class="row mb-5">
        <div class="col-12">

            <div class="mb-3">
                <label for="judul" class="form-label">Title</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= isset($halaman['judul']) ? $halaman['judul'] : ''; ?>" required>
            </div>

        </div>
        <div class="col-lg-6">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Content</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="sortableTable">
                    <?php if (!empty($komponen)): ?>
                        <?php foreach ($komponen as $component): ?>
                            <tr data-id="<?= $component['id']; ?>">
                                <td class="sortable-handle">☰</td>
                                <td><?= $component['nama']; ?></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-komponen">X</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="no-components">
                            <td colspan="3" class="text-center">No components added yet. Drag and drop from the available components.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <input type="hidden" name="id_komponen" value='<?= !empty($komponen) ? json_encode(array_column($komponen, 'id')) : '[]'; ?>'>
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <label for="availableComponents" class="form-label">Available Components</label>
                <ul id="availableComponents" class="list-group">
                    <?php foreach ($availableComponents as $component): ?>
                        <li class="list-group-item" draggable="true" data-id="<?= $component['id']; ?>"><?= $component['nama']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<?= isset($halaman['slug']) ? $halaman['slug'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="css" class="form-label">CSS Filename</label>
                <input type="text" class="form-control" id="css" name="css" value="<?= isset($halaman['css']) ? $halaman['css'] : ''; ?>" placeholder="e.g., style-komponen.css">
            </div>
            <div class="mb-3">
                <label for="js" class="form-label">JS Filename</label>
                <input type="text" class="form-control" id="js" name="js" value="<?= isset($halaman['js']) ? $halaman['js'] : ''; ?>" placeholder="e.g., script-komponen.js">
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>

<!-- Edit Meta Modal -->
<div class="modal fade" id="editMetaModal" tabindex="-1" aria-labelledby="editMetaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMetaModalLabel"><?= lang('Admin.sunting') ?></h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editMeta" method="post" class="needs-validation" enctype="multipart/form-data">
                    <div id="input-container">

                    </div>
                    <button id="saveMetaButton" type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.sunting') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sortableTable = document.getElementById('sortableTable');

        // Initialize Sortable.js on the table
        var sortable = Sortable.create(sortableTable, {
            handle: '.sortable-handle',
            animation: 150,
            onEnd: function() {
                updateKomponenOrder();
            }
        });

        // Handle drag and drop of new components
        var availableComponents = document.getElementById('availableComponents');
        availableComponents.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
        });

        sortableTable.addEventListener('dragover', function(e) {
            e.preventDefault();
        });

        sortableTable.addEventListener('drop', function(e) {
            e.preventDefault();
            var componentId = e.dataTransfer.getData('text/plain');

            // Check if the component is already in the list
            if (document.querySelector('#sortableTable [data-id="' + componentId + '"]')) {
                Swal.fire({
                    icon: 'warning',
                    title: '<?= $judul ?>',
                    text: 'This component is already added.',
                    confirmButtonColor: "var(--mdb-primary)",
                });
                return; // Prevent adding duplicate component
            }

            var componentText = document.querySelector('#availableComponents [data-id="' + componentId + '"]').innerText;

            // Remove "No components added yet" row if it exists
            var noComponentsRow = document.querySelector('.no-components');
            if (noComponentsRow) {
                noComponentsRow.remove();
            }

            // Add the dropped component to the table with animation
            var newRow = document.createElement('tr');
            newRow.setAttribute('data-id', componentId);
            newRow.classList.add('fade-in'); // Apply the fade-in animation class
            newRow.innerHTML = '<td class="sortable-handle">☰</td><td>' + componentText + '</td><td><button type="button" class="btn btn-danger btn-sm remove-komponen">X</button></td>';
            sortableTable.appendChild(newRow);

            updateKomponenOrder();
        });

        // Handle remove komponen functionality
        sortableTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-komponen')) {
                e.target.closest('tr').remove();
                updateKomponenOrder();

                // If there are no more components, show the placeholder row
                if (sortableTable.querySelectorAll('tr').length === 0) {
                    var noComponentsRow = document.createElement('tr');
                    noComponentsRow.classList.add('no-components');
                    noComponentsRow.innerHTML = '<td colspan="3" class="text-center">No components added yet. Drag and drop from the available components.</td>';
                    sortableTable.appendChild(noComponentsRow);
                }
            }
        });

        // Handle double-click event on the component list items
        sortableTable.addEventListener('dblclick', function(e) {
            if (e.target.closest('tr')) {
                var componentId = e.target.closest('tr').dataset.id;
                openComponentEditor(componentId);
            }
        });

        /**
         * Creates MDB styled inputs dynamically from an array of meta JSON objects.
         * @param {Array<Object>} metaDataArray - An array of parsed JSON objects.
         */
        function createInputsFromMeta(meta) {
            const container = document.getElementById('input-container');
            container.innerHTML = ''; // Clear the container before adding new inputs

            if (meta.length == 0) {
                // Append the generated input HTML to the container
                container.insertAdjacentHTML('beforeend', `<p>This component contains no meta field</p>`);
                document.getElementById('saveMetaButton').disabled = true; // Disable save button
            } else {
                document.getElementById('saveMetaButton').disabled = false; // Enable save button
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
                        inputHTML = `
                    <div class="mb-3">
                        <label class="form-label" for="${id}">${nama}</label>
                        <input type="file" id="${id}" name="${id}" class="form-control" />
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

                // Re-initialize MDB input fields after adding them dynamically
                if (typeof mdb !== 'undefined' && mdb.Input) {
                    document.querySelectorAll('.form-outline').forEach(element => {
                        new mdb.Input(element); // Initialize each input field
                    });
                    document.querySelectorAll('.range').forEach(element => {
                        new mdb.Range(element); // Initialize each range input field
                    });
                    // Re-initialize other types if necessary
                }
            });
        }

        function updateKomponenOrder() {
            var order = Array.from(sortableTable.querySelectorAll('tr')).map(function(row) {
                return row.dataset.id;
            });
            document.querySelector('input[name="id_komponen"]').value = JSON.stringify(order);
        }

        /**
         * Function to get the 'konten' from the JSON data based on a given 'id'.
         *
         * @param {string} jsonString - The JSON string containing the array of components.
         * @param {string} id - The id of the component to retrieve.
         * @returns {string|null} - The 'konten' of the component with the given id, or null if not found.
         */
        function getKontenById(jsonString, id) {
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

        // Function to open the component editor
        function openComponentEditor(componentId) {
            // alert('Opening editor for component ID: ' + componentId);

            // Initialize and show the MDB modal
            const modalElement = document.getElementById('editMetaModal');
            const modalInstance = new mdb.Modal(modalElement);
            modalInstance.show();

            const content = getKontenById(`<?php echo addcslashes(json_encode($availableComponents), '\'\\'); ?>`, componentId);
            const metaDataArray = extractMetaFromHTML(content);
            createInputsFromMeta(metaDataArray);

            // Remove previous event listener before attaching a new one
            document.getElementById("editMetaModal").removeEventListener("submit", handleSubmit);
            document.getElementById("editMetaModal").addEventListener("submit", handleSubmit);

            function handleSubmit(event) {
                event.preventDefault(); // Prevent default form submission
                const formData = encodeInputsToMetaJSON("editMeta");
                sendMetaJSONToServer(formData, componentId, <?= $halaman['id'] ?>);
            }
        }

        /**
         * Detects custom meta syntax in the provided text and returns an array of parsed JSON objects.
         * @param {string} text - The text to be checked for custom meta syntax.
         * @returns {Array<Object>} - An array of parsed JSON objects.
         */
        function detectMetaSyntax(text) {
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

        function extractMetaFromHTML(content) {

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

        function encodeInputsToMetaJSON(formId) {
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
                if (type === "file" && inputFiles.length > 0) {
                    const fileArray = [];
                    for (let i = 0; i < inputFiles.length; i++) {
                        formData.append(id, inputFiles[i]);
                        fileArray.push(inputFiles[i].name); // Temporary name placeholder
                    }
                    meta.push({
                        id,
                        value: fileArray
                    });
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
                else if (type === "checkbox" && checked) {
                    meta.push({
                        id,
                        value
                    });
                }
                // Handle all other inputs
                else if (type !== "file" && type !== "radio" && type !== "checkbox") {
                    meta.push({
                        id,
                        value
                    });
                }
            });

            // Add the encoded JSON to FormData for sending to the server
            formData.append("meta", JSON.stringify(meta));

            return formData;
        }




        function sendMetaJSONToServer(formData, componentId, halamanId) {
            // Append componentId and halamanId to the FormData
            formData.append('komponen_id', componentId);
            formData.append('halaman_id', halamanId);

            fetch('<?= base_url('admin/komponen/simpan/meta') ?>', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An error occurred while processing your request.', 'error');
                });
        }


    });
</script>
<?= $this->endSection() ?>