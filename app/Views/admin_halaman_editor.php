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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tambahForm" action="/admin/pengguna/tambah" method="post">
                    <div id="input-container">

                    </div>
                    <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.sunting') ?></button>
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
                alert('This component is already added.');
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
        function createInputsFromMeta(metaDataArray) {
            const inputContainer = document.getElementById('input-container');
            inputContainer.innerHTML = ''; // Clear any existing inputs

            metaDataArray.forEach(data => {
                // Create a container div with MDB classes
                const formOutlineDiv = document.createElement('div');
                formOutlineDiv.className = 'form-floating mb-3';
                formOutlineDiv.setAttribute('data-mdb-input-init', '');

                // Create input element
                const input = document.createElement('input');
                input.type = data.tipe || 'text'; // Default to 'text' if type is not specified
                input.id = data.id;
                input.name = data.id; // Assuming 'id' as the name here, adjust if needed
                input.className = 'form-control';

                // Create label element
                const label = document.createElement('label');
                label.className = 'form-label';
                label.setAttribute('for', data.id);
                label.textContent = data.nama;

                // Append input and label to the container
                formOutlineDiv.appendChild(input);
                formOutlineDiv.appendChild(label);

                // Append the container to the main input container
                inputContainer.appendChild(formOutlineDiv);
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
            $('#editMetaModal').modal('show');
            const content = getKontenById(`<?php echo addcslashes(json_encode($availableComponents), '\'\\'); ?>`, componentId);
            const metaDataArray = detectMetaSyntax(content);
            createInputsFromMeta(metaDataArray);
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

    });
</script>
<?= $this->endSection() ?>