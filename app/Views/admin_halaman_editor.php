<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <form action="/admin/halaman/simpan/<?= isset($halaman['id']) ? $halaman['id'] : ''; ?>" method="post">
            <div class="mb-3">
                <label for="judul" class="form-label">Title</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= isset($halaman['judul']) ? $halaman['judul'] : ''; ?>" required>
            </div>
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
            <div class="mb-3">
                <label for="availableComponents" class="form-label">Available Components</label>
                <ul id="availableComponents" class="list-group">
                    <?php foreach ($availableComponents as $component): ?>
                        <li class="list-group-item" draggable="true" data-id="<?= $component['id']; ?>"><?= $component['nama']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
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
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
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
            var componentText = document.querySelector('[data-id="' + componentId + '"]').innerText;

            // Remove "No components added yet" row if it exists
            var noComponentsRow = document.querySelector('.no-components');
            if (noComponentsRow) {
                noComponentsRow.remove();
            }

            // Add the dropped component to the table
            var newRow = document.createElement('tr');
            newRow.setAttribute('data-id', componentId);
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

        function updateKomponenOrder() {
            var order = Array.from(sortableTable.querySelectorAll('tr')).map(function(row) {
                return row.dataset.id;
            });
            document.querySelector('input[name="id_komponen"]').value = JSON.stringify(order);
        }
    });
</script>
<?= $this->endSection() ?>