<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>

<!-- Notifikasi -->
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

<div class="row">
    <div class="col">

        <!-- Modal form unggah -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel"><?= lang('Admin.unggahGambar') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('admin/galeri/unggah') ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="image" class="form-label"><?= lang('Admin.unggahGambar') ?></label>
                                <input type="file" class="form-control" name="image" id="image" required>
                            </div>
                            <div class="mb-3">
                                <label for="judul" class="form-label"><?= lang('Admin.judul') ?></label>
                                <input type="text" class="form-control" name="judul" id="judul" placeholder="Title">
                            </div>
                            <div class="mb-3">
                                <label for="alt" class="form-label"><?= lang('Admin.teksAlternatif') ?></label>
                                <input type="text" class="form-control" name="alt" id="alt" placeholder="Alt Text">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= lang('Admin.unggah') ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex mb-4">
            <div class="flex-grow-1">
                <div class="btn-group rounded-0" role="group">
                    <!-- Tombol unggah -->
                    <button type="button" class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#uploadModal" data-mdb-ripple-init><i class='bx bx-upload me-2'></i><?= lang('Admin.unggah') ?></button>

                    <!-- Per Page Options -->
                    <div class="dropdown">
                        <button
                            class="btn btn-secondary dropdown-toggle rounded-0"
                            type="button"
                            id="perPageDropdown"
                            data-mdb-dropdown-init
                            aria-expanded="false">
                            <i class="bi bi-grid"></i>
                            <span class="ms-2 fw-bold">
                                <?= $perPage ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="perPageDropdown">
                            <li>
                                <a class="dropdown-item <?= $perPage == 20 ? 'active' : '' ?>" href="?per_page=20">20</a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= $perPage == 50 ? 'active' : '' ?>" href="?per_page=50">50</a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= $perPage == 100 ? 'active' : '' ?>" href="?per_page=100">100</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tombol hapus -->
                    <button id="multiDeleteBtn" class="btn btn-danger rounded-0" data-mdb-ripple-init disabled><i class='bx bx-trash me-2'></i><?= lang('Admin.hapus') ?></button>
                </div>
            </div>
            <div>
                <!-- TODO: Pencarian gambar -->
            </div>
        </div>

        <!-- Form hapus banyak -->
        <form id="multi-delete-form" action="<?= base_url('admin/galeri/hapus-banyak') ?>" method="post">

            <!-- Gambar -->
            <div class="row" data-masonry='{"percentPosition": true }'>
                <?php foreach ($images as $image) : ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="<?= $image['uri'] ?>" class="card-img-top" alt="<?= esc($image['alt']) ?>">
                            <!-- Checkbox hapus banyak -->
                            <input type="checkbox" name="image_ids[]" value="<?= $image['id'] ?>" class="image-checkbox form-check-input ms-4 mt-4 position-absolute">
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($image['judul']) ?></h5>
                                <p class="card-text"><?= esc($image['deskripsi']) ?></p>

                                <!-- Tombol sunting metadata -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $image['id'] ?>" data-mdb-ripple-init><i class='bx bx-pencil me-2'></i><?= lang('Admin.sunting') ?></button>

                                <!-- Modal sunting metadata -->
                                <div class="modal fade" id="editModal<?= $image['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $image['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel<?= $image['id'] ?>"><?= lang('Admin.gambar') . " " . esc($image['judul']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?= base_url('admin/galeri/simpanMetadata/' . $image['id']) ?>" method="post">
                                                    <div class="mb-3">
                                                        <label for="judul_<?= $image['id'] ?>" class="form-label"><?= lang('Admin.judul') ?></label>
                                                        <input type="text" class="form-control" name="judul" id="judul_<?= $image['id'] ?>" value="<?= esc($image['judul']) ?>" placeholder="Title">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="alt_<?= $image['id'] ?>" class="form-label"><?= lang('Admin.teksAlternatif') ?></label>
                                                        <input type="text" class="form-control" name="alt" id="alt_<?= $image['id'] ?>" value="<?= esc($image['alt']) ?>" placeholder="Alt Text">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="deskripsi_<?= $image['id'] ?>" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                                                        <textarea class="form-control" name="deskripsi" id="deskripsi_<?= $image['id'] ?>" placeholder="Description"><?= esc($image['deskripsi']) ?></textarea>
                                                    </div>
                                                    <button type="button" class="btn btn-danger" onclick="hapus(<?= $image['id'] ?>)"><i class='bx bx-trash me-2'></i><?= lang('Admin.hapus') ?></button>
                                                    <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.simpan') ?></button>
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

        <!-- Paginasi -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= ceil($total / $perPage); $i++) : ?>
                    <li class="page-item <?= $currentPage == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&per_page=<?= $perPage ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script>
    document.getElementById('multiDeleteBtn').addEventListener('click', function() {

        // Form dan cekbox terpilih
        const form = document.getElementById('multi-delete-form');
        const checkboxes = form.querySelectorAll('input[name="image_ids[]"]:checked');

        if (checkboxes.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: '<?= lang('Admin.hapusGambarTerpilih') ?>',
                text: '<?= lang('Admin.pilihItemDahulu') ?>',
            });
            return;
        }

        // Konfirmasi penghapusan
        Swal.fire({
            title: '<?= lang('Admin.hapusGambarTerpilih') ?>',
            text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--mdb-danger)',
            confirmButtonText: '<?= lang('Admin.hapus') ?>',
            cancelButtonText: '<?= lang('Admin.batal') ?>',
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirimkan form
                form.submit();
            }
        });
    });

    function hapus(imageId) {
        Swal.fire({
            title: '<?= lang('Admin.hapusGambarTerpilih') ?>',
            text: '<?= lang('Admin.itemYangTerhapusTidakDapatKembali') ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--mdb-danger)',
            confirmButtonText: '<?= lang('Admin.hapus') ?>',
            cancelButtonText: '<?= lang('Admin.batal') ?>',
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat form untuk mengirimkan permintaan hapus
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "<?= base_url('admin/galeri/hapus/') ?>" + imageId;

                // Tambah CSRF untuk proteksi
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = 'csrf_token';
                csrfField.value = '<?= csrf_hash() ?>'; // Harus sama dengan fungsi CSRF yang dibuat jika ada

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
            multiDeleteBtn.disabled = !isChecked; // Enable or disable tombol hapus berdasarkan pilihan
        });
    });
</script>
<?= $this->endSection() ?>