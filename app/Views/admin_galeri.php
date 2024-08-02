<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>

<!-- Notification Section -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Upload Button Trigger -->
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#uploadModal" data-mdb-ripple-init><i class='bx bx-upload me-2'></i>Upload Image</button>

<!-- Upload Form Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('admin/galeri/upload') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Title</label>
                        <input type="text" class="form-control" name="judul" id="judul" placeholder="Title">
                    </div>
                    <div class="mb-3">
                        <label for="alt" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" name="alt" id="alt" placeholder="Alt Text">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<button id="multiDeleteBtn" class="btn btn-danger mb-4" data-mdb-ripple-init disabled><i class='bx bx-trash me-2'></i>Delete Selected Images</button>

<!-- Per Page Options -->
<form method="get" class="mb-4">
    <label for="per_page" class="form-label me-2">Images per page:</label>
    <select name="per_page" id="per_page" class="form-select me-2" onchange="this.form.submit()">
        <option value="20" <?= $perPage == 20 ? 'selected' : '' ?>>20</option>
        <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50</option>
        <option value="100" <?= $perPage == 100 ? 'selected' : '' ?>>100</option>
    </select>
</form>

<!-- Multi-Delete Form -->
<form id="multi-delete-form" action="<?= site_url('admin/galeri/delete-multiple') ?>" method="post">

    <!-- Display Images with Edit Option -->
    <div class="row" data-masonry='{"percentPosition": true }'>
        <?php foreach ($images as $image) : ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?= $image['uri'] ?>" class="card-img-top" alt="<?= esc($image['alt']) ?>">
                    <!-- Checkbox for Multi-Delete -->
                    <input type="checkbox" name="image_ids[]" value="<?= $image['id'] ?>" class="image-checkbox form-check-input ms-4 mt-4 position-absolute">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($image['judul']) ?></h5>
                        <p class="card-text"><?= esc($image['deskripsi']) ?></p>

                        <!-- Edit Metadata Button Trigger -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $image['id'] ?>" data-mdb-ripple-init><i class='bx bx-pencil me-2'></i>Edit</button>

                        <!-- Edit Metadata Modal -->
                        <div class="modal fade" id="editModal<?= $image['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $image['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel<?= $image['id'] ?>">Edit Metadata for <?= esc($image['judul']) ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= site_url('admin/galeri/updateMetadata/' . $image['id']) ?>" method="post">
                                            <div class="mb-3">
                                                <label for="judul_<?= $image['id'] ?>" class="form-label">Title</label>
                                                <input type="text" class="form-control" name="judul" id="judul_<?= $image['id'] ?>" value="<?= esc($image['judul']) ?>" placeholder="Title">
                                            </div>
                                            <div class="mb-3">
                                                <label for="alt_<?= $image['id'] ?>" class="form-label">Alt Text</label>
                                                <input type="text" class="form-control" name="alt" id="alt_<?= $image['id'] ?>" value="<?= esc($image['alt']) ?>" placeholder="Alt Text">
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi_<?= $image['id'] ?>" class="form-label">Description</label>
                                                <textarea class="form-control" name="deskripsi" id="deskripsi_<?= $image['id'] ?>" placeholder="Description"><?= esc($image['deskripsi']) ?></textarea>
                                            </div>
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $image['id'] ?>)"><i class='bx bx-trash me-2'></i>Delete</button>
                                            <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i>Update</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</form>

<!-- Pagination -->
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= ceil($total / $perPage); $i++) : ?>
            <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&per_page=<?= $perPage ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script>
    document.getElementById('multiDeleteBtn').addEventListener('click', function() {
        // Get the form and the selected checkboxes
        const form = document.getElementById('multi-delete-form');
        const checkboxes = form.querySelectorAll('input[name="image_ids[]"]:checked');

        if (checkboxes.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No images selected!',
                text: 'Please select at least one image to delete.',
            });
            return;
        }

        // SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                form.submit();
            }
        });
    });

    function confirmDelete(imageId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "<?= site_url('admin/galeri/delete/') ?>" + imageId;

                // Add CSRF token if you're using CSRF protection
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = 'csrf_token';
                csrfField.value = '<?= csrf_hash() ?>'; // Change this to your actual CSRF token method if different

                form.appendChild(csrfField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    const checkboxes = document.querySelectorAll('.image-checkbox');
    const multiDeleteBtn = document.getElementById('multiDeleteBtn');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            multiDeleteBtn.disabled = !isChecked; // Enable or disable button based on checkbox state
        });
    });
</script>
<?= $this->endSection() ?>