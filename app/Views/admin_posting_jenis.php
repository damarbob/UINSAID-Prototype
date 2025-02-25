<?php
helper('setting');

$context = 'user:' . user_id(); //  Context untuk pengguna
$barisPerHalaman = setting()->get('App.barisPerHalaman', $context) ?: 10;
?>
<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<style>
    .loader {
        width: 12px;
        height: 12px;
        border: 2px solid var(--mdb-primary);
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
</style>
<div class="row">
    <div class="col">

        <!-- Pesan sukses atau error -->
        <?php if (session()->getFlashdata('sukses')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('sukses') ?>
            </div>
        <?php elseif (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('gagal') ?>
            </div>
        <?php elseif (session()->getFlashdata('peringatan')) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('peringatan') ?>
            </div>
        <?php endif; ?>

        <!-- Peringatan buat posting -->
        <?php if ($peringatanPostingBerita) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= lang('Admin.tampaknyaSudahLebihDari3BulanSejakBeritaTerakhir') ?>
            </div>
        <?php endif; ?>


        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabelPostingJenis">
            <thead class="border-bottom border-primary">
                <tr>
                    <th class="fw-bold"><i class="bi bi-pencil-square me-2"></i><br><?= lang('Admin.nama') ?></th>
                    <th class="fw-bold"><i class="bi bi-person me-2"></i><br><?= lang('Admin.dibuatPada') ?></th>
                    <th class="fw-bold"><i class="bi bi-bookmark me-2"></i><br><?= lang('Admin.diperbaruiPada') ?></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <!-- </div> -->

    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><?= lang('Admin.sunting') ?></h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="post">

                    <!-- ID -->
                    <input type="hidden" id="editId" name="id" />

                    <!-- Nama -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editNama" name="nama" class="form-control" />
                        <label class="form-label" for="editNama"><?= lang('Admin.nama') ?></label>
                    </div>

                    <!-- Submit -->
                    <button id="editFormSubmitButton" type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.simpan') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel"><?= lang('Admin.tambah') ?></h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tambahForm" action="<?= base_url('/admin/pengguna/tambah') ?>" method="post">

                    <!-- Nama -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="nama" name="nama" class="form-control" />
                        <label class="form-label" for="nama"><?= lang('Admin.nama') ?></label>
                    </div>

                    <!-- Submit -->
                    <button id="tambahFormSubmitButton" type="submit" class="btn btn-success" data-mdb-ripple-init>
                        <i class='bx bx-check me-2'></i>
                        <?= lang('Admin.tambah') ?>
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<!-- TODO: Migrate to the new process bulk -->
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk_new.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        const tambahModal = new mdb.Modal($('#tambahModal'));
        const editModal = new mdb.Modal($('#editModal'));

        function showEditModal(data, index) {
            // Get the ID from the data
            var id = data.id;

            // Update input value from data
            $('#editId').val(data.id);
            $('#editNama').val(data.nama);

            // Navigate to the Edit page
            editModal.show();
        }

        var table1 = $('#tabelPostingJenis').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: {
                "url": "<?= base_url('api/posting-jenis') ?>",
                "type": "POST",
                "data": function(d) {
                    return d;
                }
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/posting/sunting?id=') ?>" + id;
                });
            },
            "columns": [{
                    "data": "nama",
                    "render": function(data, type, row, meta) {
                        return `<a href="#" class="preview-link" data-row-index="${meta.row}">` + (data) + "</a>";
                    }
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        return (data) ? '' + formatDate(data) + '' : '';
                    }
                },
                {
                    "data": "updated_at",
                    "render": function(data, type, row) {
                        return (data) ? '' + formatDate(data) + '' : '';
                    }
                },
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    type: 'date',
                    targets: 2
                } // Specify the type of the fourth column as 'date'
            ],
            order: [
                [0, 'desc']
            ],
            dom: '<"mb-5"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"dataTables_paginate_wrapper align-self-start align-self-sm-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        // Navigate to the Edit page
                        tambahModal.show();
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="bx bx-table"></i>'
                },
                {
                    extend: 'excel',
                    text: '<i class="bx bx-download"></i>'
                },
                {
                    extend: 'print',
                    text: '<i class="bx bx-printer"></i>'
                },
                {
                    extend: 'selected',
                    text: '<i class="bx bx-trash"></i>',
                    action: function(e, dt, node, config) {
                        hapusBanyak();
                    }
                },
            ],
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

            processBulk(table1, "<?= base_url('/admin/posting-jenis/hapus') ?>", options);
        }

        // Add MDB styles to the search input after initialization
        table1.on('init.dt', function() {
            $('div.dataTables_filter label input').addClass('form-control form-control-md'); // Apply MDB form control styles
            $('div.dataTables_filter label').addClass('form-label'); // Apply MDB label styles
        });

        // Change button styles
        table1.on('preInit.dt', function() {

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            // Reinitialize the ripple effect for the new button
            buttons.each(function() {
                new mdb.Ripple(this); // This will reinitialize the ripple effect on all elements with the data-mdb-ripple-init attribute
            })

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");
        });

        // Use `table.on` to handle clicks on links with the `.preview-link` class
        table1.on('click', '.preview-link', function(e) {
            e.preventDefault();

            // Get the row index from the clicked link's data attribute
            const rowIndex = $(this).data('row-index');

            // Retrieve the row data by index
            const rowData = table1.row(rowIndex).data();

            // Call `showPreviewModal` with the row data and index
            showEditModal(rowData, rowIndex);

            console.log(rowIndex);
            console.log(rowData);
        });

        // Example of adding a user using AJAX
        $('#tambahForm').submit(function(e) {
            e.preventDefault();
            // console.log(this);

            // Adjust UI
            $('#tambahFormSubmitButton').prop('disabled', true);

            // Send request
            $.ajax({
                url: '<?= base_url('/api/posting-jenis/tambah') ?>',
                type: 'POST',
                data: $(this).serialize(), // Assuming the form ID is userForm
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '<?= lang('Admin.sukses') ?>',
                            text: response.message
                        });

                        // Update the view
                        tambahModal.hide();
                        table1.ajax.reload();

                        // Clear the input field
                        $('#nama').val('');

                    } else {

                        // Show validation errors
                        var errors = ['<div class="text-start"><ol>']
                        $.each(response.errors, function(key, value) {
                            errors.push('<li>' + value + '</li>'); // Assuming you have an error span for each field
                        });
                        errors.push('</ol></div>')

                        Swal.fire({
                            icon: 'error',
                            title: '<?= lang('Admin.galat') ?>',
                            html: errors.map(e => `${e}`).join('') // Using <p> tags to separate each error message
                        });

                    }
                },
                error: function(xhr, status, error) {
                    // console.log(xhr);

                    Swal.fire({
                        icon: 'error',
                        title: '<?= lang('Admin.galat') ?>',
                        text: (xhr.responseJSON.message !== null) ? xhr.responseJSON.message : '<?= lang('Admin.galat') ?>: ' + error
                    });
                },
                complete: function(xhr, status) {

                    // Adjust UI
                    $('#tambahFormSubmitButton').prop('disabled', false);

                }
            });
        });

        // Example of editing a user using AJAX
        $('#editForm').submit(function(e) {
            e.preventDefault();

            //Adjust UI
            $('#editFormSubmitButton').prop('disabled', true);

            // Send ajax request
            $.ajax({
                url: '<?= base_url('/api/posting-jenis/sunting') ?>',
                type: 'POST',
                data: $(this).serialize(), // Assuming the form ID is editUserForm
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '<?= lang('Admin.sukses') ?>',
                            text: response.message
                        });

                        // Update the view
                        editModal.hide();
                        table1.ajax.reload();

                    } else {

                        // Show validation errors
                        var errors = ['<div class="text-start"><ol>']
                        $.each(response.errors, function(key, value) {
                            errors.push('<li>' + value + '</li>'); // Assuming you have an error span for each field
                        });
                        errors.push('</ol></div>')

                        Swal.fire({
                            icon: 'error',
                            title: '<?= lang('Admin.galat') ?>',
                            html: errors.map(e => `${e}`).join('') // Using <p> tags to separate each error message
                        });

                    }
                },
                error: function(xhr, status, error) {
                    // console.log(xhr);

                    Swal.fire({
                        icon: 'error',
                        title: '<?= lang('Admin.galat') ?>',
                        text: (xhr.responseJSON.message !== null) ? xhr.responseJSON.message : '<?= lang('Admin.galat') ?>: ' + error
                    });
                },
                complete: function() {

                    // Adjust UI
                    $('#editFormSubmitButton').prop('disabled', false);

                }
            });
        });

    });
</script>
<?= $this->endSection() ?>