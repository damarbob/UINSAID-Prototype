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

<!-- Display Images with Edit Option -->
<div class="row" data-masonry='{"percentPosition": true }'>
    <?php foreach ($images as $image) : ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="<?= $image['uri'] ?>" class="card-img-top" alt="<?= esc($image['alt']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($image['judul']) ?></h5>
                    <p class="card-text"><?= esc($image['deskripsi']) ?></p>

                    <!-- Edit Metadata Button Trigger -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $image['id'] ?>" data-mdb-ripple-init>Edit Metadata</button>

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
                                        <button type="submit" class="btn btn-success" data-mdb-ripple-init>Update</button>
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
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<?= $this->endSection() ?>