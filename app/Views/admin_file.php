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
                        <h5 class="modal-title" id="uploadModalLabel"><?= lang('Admin.unggahFile') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('admin/file/unggah') ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="file" class="form-label"><?= lang('Admin.unggahFile') ?></label>
                                <input type="file" class="form-control" name="file" id="file" required>
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
                    <!-- <div class="dropdown">
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
                    </div> -->

                    <!-- Tombol hapus -->
                    <!-- <button id="multiDeleteBtn" class="btn btn-danger rounded-0" data-mdb-ripple-init onclick="hapusBanyak();"><i class='bx bx-trash me-2'></i><?= lang('Admin.hapus') ?></button> -->
                </div>
            </div>
        </div>

        <table class="table table-hover w-100" id="tabelFile">
            <thead>
                <tr>
                    <td><?= lang('Admin.judul') ?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($file as $key) : ?>
                    <tr>
                        <td><?= $key['judul'] ?></td>
                    </tr>

                    <!-- Modal sunting metadata -->
                    <div class="modal fade" id="editModal<?= $key['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $key['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?= $key['id'] ?>"><?= lang('Admin.file') . " " . esc($key['judul']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= base_url('admin/file/simpanMetadata/' . $key['id']) ?>" method="post">
                                        <div class="mb-3">
                                            <label for="judul_<?= $key['id'] ?>" class="form-label"><?= lang('Admin.judul') ?></label>
                                            <input type="text" class="form-control" name="judul" id="judul_<?= $key['id'] ?>" value="<?= esc($key['judul']) ?>" placeholder="Title">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alt_<?= $key['id'] ?>" class="form-label"><?= lang('Admin.teksAlternatif') ?></label>
                                            <input type="text" class="form-control" name="alt" id="alt_<?= $key['id'] ?>" value="<?= esc($key['alt']) ?>" placeholder="Alt Text">
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi_<?= $key['id'] ?>" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                                            <textarea class="form-control" name="deskripsi" id="deskripsi_<?= $key['id'] ?>" placeholder="Description"><?= esc($key['deskripsi']) ?></textarea>
                                        </div>
                                        <button type="button" class="btn btn-danger" onclick="hapus(<?= $key['id'] ?>)"><i class='bx bx-trash me-2'></i><?= lang('Admin.hapus') ?></button>
                                        <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.simpan') ?></button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </tbody>
        </table>



    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var table1 = $('#tabelFile').DataTable({
            processing: true,
            ajax: {
                "url": "<?= site_url('api/file') ?>",
                "type": "POST"
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    // window.location.href = "/admin/file/sunting?id=" + id;
                    const editModal = document.getElementById('editModal' + id);
                    const modal = new bootstrap.Modal(editModal);
                    modal.show();
                });

                $(row).on('select', function() {
                    const hapusButton = document.getElementById('multiDeleteBtn');

                });
            },
            "columns": [{
                "data": "judul",
            }],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            select: true,
        });

        // Fitur hapus massal
        function hapusBanyak() {
            var options = {
                title: "<?= lang('Admin.hapusItem') ?>",
                confirmMessage: "<?= lang('Admin.lanjutkanUntukMenghapusItem') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.hapus') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "<?= base_url('/admin/file/hapus') ?>", options);
        }

    });
</script>
<?= $this->endSection() ?>