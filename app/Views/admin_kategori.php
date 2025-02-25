<?php
helper('setting');

$context = 'user:' . user_id(); //  Context untuk pengguna
$barisPerHalaman = setting()->get('App.barisPerHalaman', $context) ?: 10;
?>
<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">

        <!-- Pesan sukses atau error -->
        <?php if (session()->getFlashdata('sukses')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <a href="<?= base_url("admin/kategori") ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                <?= session()->getFlashdata('sukses') ?>
            </div>
        <?php elseif (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <a href="<?= base_url("admin/kategori") ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                <?= session()->getFlashdata('gagal') ?>
            </div>
        <?php endif; ?>

        <table id="kategoriTable" class="table table-hover w-100">
            <thead class="border-bottom border-primary">
                <tr>
                    <th class="fw-bold"><i class="bi bi-pencil-square me-2"></i><br><?= lang('Admin.nama') ?></th>
                    <th class="fw-bold"><i class="bi bi-link"></i><br><?= lang('Admin.jenisPosting') ?></th>
                    <th class="fw-bold"><i class="bi bi-bookmark"></i><br><?= lang('Admin.terkunci') ?></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
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


                    <!-- Kategori -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editKategori" name="nama" class="form-control" />
                        <label class="form-label" for="editKategori"><?= lang('Admin.kategori') ?></label>
                    </div>

                    <!-- Terkunci -->
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="terkunci" id="editTerkunci" value="" placeholder="Terkunci">
                        <label for="editTerkunci" class="form-check-label"><?= lang('Admin.terkunci') ?></label>
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
                <h5 class="modal-title" id="tambahModalLabel"><?= lang('Admin.sunting') ?></h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tambahForm" action="" method="post">

                    <!-- Jenis Posting -->
                    <div class="form-floating mb-3">
                        <select class="form-select" id="tambahPostingJenisSelect" name="jenis">
                            <?php foreach ($jenis as $x): ?>
                                <option value="<?= $x['id'] ?>">
                                    <?= ($x['nama']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <label for="postingJenisSelect" class="form-label"><?= lang('Admin.jenisPosting') ?></label>
                    </div>

                    <!-- Kategori -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="tambahKategori" name="nama" class="form-control" />
                        <label class="form-label" for="tambahKategori"><?= lang('Admin.kategori') ?></label>
                    </div>

                    <!-- Terkunci -->
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="terkunci" id="tambahTerkunci" value="" placeholder="Terkunci">
                        <label for="tambahTerkunci" class="form-check-label"><?= lang('Admin.terkunci') ?></label>
                    </div>

                    <!-- Submit -->
                    <button id="tambahFormSubmitButton" type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.simpan') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk_new.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // Initialize the MDB modal
        const tambahModal = new mdb.Modal($('#tambahModal'));
        const editModal = new mdb.Modal($('#editModal'));

        function showEditModal(data, index) {
            // Get the ID from the data
            var id = data.id;

            // Update input value from data
            $('#editId').val(data.id);
            $('#editKategori').val(data.nama);
            $('#editTerkunci').prop('checked', data.terkunci === "1" ? true : false); // Uncheck the checkbox

            // Navigate to the Edit page
            editModal.show();
        }

        // Example of adding a user using AJAX
        $('#tambahForm').submit(function(e) {
            e.preventDefault();

            // Adjust UI
            $('#tambahFormSubmitButton').prop('disabled', true);
            console.log($(this).serialize());
            // Send request
            $.ajax({
                url: '<?= base_url('/api/kategori/tambah') ?>',
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
                        tabel.ajax.reload();
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
            console.log($(this).serialize());

            // Send ajax request
            $.ajax({
                url: '<?= base_url('/api/kategori/sunting') ?>',
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
                        tabel.ajax.reload();

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


        var filterJenis = null;

        var tabel = $('#kategoriTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: {
                "url": "<?= base_url('api/kategori') ?>",
                "type": "POST",
                "data": function(d) {
                    // Include the filter status in the request data
                    if (filterJenis) {
                        d.jenisNama = filterJenis;
                    }
                    return d;
                }
            },
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            dom: '<"mb-5"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"dataTables_paginate_wrapper align-self-start align-self-sm-end order-1 order-md-2"p>>>',
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {

                });
            },
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        tambahModal.show();
                    }
                },
                {
                    text: '<i id="iconFilterJenis" class="bx bx-filter-alt me-2"></i><span id="loaderFilterJenis" class="loader me-2" style="display: none;"></span><span id="textFilterJenis"><?= lang('Admin.semua') ?></span>',
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
            "columns": [
                // Show kategori name
                {
                    "data": "nama",
                    "render": function(data, type, row, meta) {
                        if (type === 'display') {
                            return `<a href="#" class="preview-link" data-row-index="${meta.row}">` + (data) + "</a>";
                        }
                        return data;
                    },
                },
                {
                    "data": "posting_jenis_nama",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return "<span class='badge badge-secondary'>" + data + '</span>';
                        }
                        return data;
                    }
                },

                {
                    "data": "terkunci",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return data == "1" ? "<span class='badge badge-primary'><?= lang('Admin.terkunci') ?></span>" : "<span class='badge badge-warning'><?= lang('Admin.tidakTerkunci') ?></span>";
                        }
                        return data;
                    },
                }
            ],
        });

        // Hapus banyak
        function hapusBanyak() {
            var options = {
                title: "<?= lang('Admin.hapusItem') ?>",
                confirmMessage: "<?= lang('Admin.lanjutkanUntukMenghapusItem') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.hapus') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>",
            };

            processBulk(tabel, "<?= base_url('/admin/kategori/hapus') ?>", options);
        }

        // Change button styles
        tabel.on('preInit.dt', function() {

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg"); // Buat grup tombol jadi besar

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            // Reinitialize the ripple effect for the new button
            buttons.each(function() {
                new mdb.Ripple(this); // This will reinitialize the ripple effect on all elements with the data-mdb-ripple-init attribute
            })

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0").attr({
                "data-mdb-tooltip-init": "",
                "data-mdb-placement": "bottom",
                "title": "<?= lang('Admin.tambah') ?>",
            });
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0").attr({
                "data-mdb-tooltip-init": "",
                "data-mdb-placement": "bottom",
                "title": "<?= lang('Admin.hapus') ?>",
            });

            var secondButton = buttons.eq(1);
            secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterJenis",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });
            buttons.eq(2).attr({
                "data-mdb-tooltip-init": "",
                "data-mdb-placement": "bottom",
                "title": "<?= lang('Admin.kolom') ?>",
            });
            buttons.eq(3).attr({
                "data-mdb-tooltip-init": "",
                "data-mdb-placement": "bottom",
                "title": "<?= lang('Admin.unduh') ?>",
            });
            buttons.eq(4).attr({
                "data-mdb-tooltip-init": "",
                "data-mdb-placement": "bottom",
                "title": "<?= lang('Admin.cetak') ?>",
            });

            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterJenisSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>'
                <?php foreach ($jenis as $i => $x): ?> + '<li><button id="btnFilter<?= $i ?>" class="dropdown-item" type="button"><?= $x['nama'] ?></button></li>'
                <?php endforeach; ?> +
                '</ul>'
            );

            secondButton.after(newElement);
            new mdb.Dropdown(secondButton); // Reinitialize dropdown

            // Filter button and status
            var filterButtons = {
                '#btnFilterJenisSemua': null,
                <?php foreach ($jenis as $i => $x): ?> '#btnFilter<?= $i ?>': '<?= $x['nama'] ?>',
                <?php endforeach; ?>
            };

            $.each(filterButtons, function(btnId, grup) {
                $(btnId).on('click', function() {
                    filterJenis = grup; // Update the filter grup
                    // table1.ajax.reload(); // Reload the DataTable with the new filter
                    $('#iconFilterJenis').hide();
                    $('#loaderFilterJenis').show();
                    tabel.ajax.reload(function() {
                        $('#iconFilterJenis').show();
                        $('#loaderFilterJenis').hide();
                        $('#textFilterJenis').html($(btnId).html());
                    });
                });
            });

            buttons.each(function() {
                new mdb.Tooltip(this); // This will reinitialize the tooltip on all elements with the data-mdb-tooltip-init attribute
            })
        });

        // Add MDB styles to the search input after initialization
        tabel.on('init.dt', function() {
            $('div.dataTables_filter input').addClass('form-control form-control-md'); // Apply MDB form control styles
            $('div.dataTables_filter label').addClass('form-label'); // Apply MDB label styles
        });

        // Use `table.on` to handle clicks on links with the `.preview-link` class
        tabel.on('click', '.preview-link', function(e) {
            e.preventDefault();

            // Get the row index from the clicked link's data attribute
            const rowIndex = $(this).data('row-index');

            // Retrieve the row data by index
            const rowData = tabel.row(rowIndex).data();

            // Call `showPreviewModal` with the row data and index
            showEditModal(rowData, rowIndex);
        });

    });
</script>
<?= $this->endSection() ?>