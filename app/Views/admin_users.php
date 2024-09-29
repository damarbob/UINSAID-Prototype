<?php

use function App\Helpers\capitalize_first_letter;

helper('setting');

$context = 'user:' . user_id(); //  Context untuk pengguna
$barisPerHalaman = setting()->get('App.barisPerHalaman', $context) ?: 10;
?>
<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>

<!-- Tabel user -->
<div class="row">
    <div class="col">

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


        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabel" style="width: 100%;">
            <thead>
                <tr>
                    <td><?= lang('Admin.id') ?></td>
                    <td><?= lang('Admin.username') ?></td>
                    <td><?= lang('Admin.email') ?></td>
                    <td><?= lang('Admin.grup') ?></td>
                    <td><?= lang('Admin.dibuatPada') ?></td>
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

                    <!-- Username -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editUsername" name="username" class="form-control" />
                        <label class="form-label" for="editUsername"><?= lang('Admin.username') ?></label>
                    </div>

                    <!-- Email -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editEmail" name="secret" class="form-control" />
                        <label class="form-label" for="editEmail"><?= lang('Admin.email') ?></label>
                    </div>

                    <!-- Grup -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editGrup" class="form-control" name="group" />
                        <label class="form-label" for="editGrup"><?= lang('Admin.grup') ?></label>
                    </div>

                    <!-- Kata sandi -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="password" id="editKataSandi" class="form-control" name="secret2" />
                        <label class="form-label" for="editKataSandi"><?= lang('Admin.kataSandi') ?></label>
                    </div>

                    <!-- Minta atur ulang kata sandi -->
                    <div class="mb-3 d-none">
                        <input type="checkbox" class="form-check-input" name="force_reset" id="editMintaAturUlangKataSandiCheck" value="" placeholder="Minta Atur Ulang Kata Sandi">
                        <label for="editMintaAturUlangKataSandi" class="form-check-label"><?= lang('Admin.mintaAturUlangKataSandi') ?></label>
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

                    <!-- Username -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="username" name="username" class="form-control" />
                        <label class="form-label" for="username"><?= lang('Admin.username') ?></label>
                    </div>

                    <!-- Email -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="email" name="secret" class="form-control" />
                        <label class="form-label" for="email"><?= lang('Admin.email') ?></label>
                    </div>

                    <!-- Grup -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="grup" class="form-control" name="group" />
                        <label class="form-label" for="grup"><?= lang('Admin.grup') ?></label>
                    </div>

                    <!-- Kata sandi -->
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="password" id="kataSandi" class="form-control" name="secret2" />
                        <label class="form-label" for="kataSandi"><?= lang('Admin.kataSandi') ?></label>
                    </div>

                    <!-- Minta atur ulang kata sandi -->
                    <div class="mb-3 d-none">
                        <input type="checkbox" class="form-check-input" name="force_reset" id="tambahMintaAturUlangKataSandiCheck" value="" placeholder="Minta Atur Ulang Kata Sandi">
                        <label for="tambahMintaAturUlangKataSandi" class="form-check-label"><?= lang('Admin.mintaAturUlangKataSandi') ?></label>
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
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // Initialize the MDB modal
        const tambahModal = new mdb.Modal($('#tambahModal'));
        const editModal = new mdb.Modal($('#editModal'));

        var table1 = $('#tabel').DataTable({
            processing: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: "<?= base_url('/api/pengguna') ?>",
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Update input value from data
                    $('#editId').val(data.id);
                    $('#editUsername').val(data.username);
                    $('#editEmail').val(data.secret);
                    $('#editGrup').val(data.group);
                    $('#editKataSandi').val(''); // Clear password field for security
                    $('#editMintaAturUlangKataSandiCheck').prop('checked', data.force_reset === "1" ? true : false); // Uncheck the checkbox
                    // $('#editForm').attr('action', `<?= base_url('/admin/pengguna/edit/') ?>${id}`);

                    // Navigate to the Edit page
                    editModal.show();
                });
            },
            "columns": [{
                    "data": "id",
                },
                {
                    "data": "username",
                },
                {
                    "data": "secret",
                },
                {
                    "data": "group",
                    "render": function(data, type, row) {
                        return capitalizeFirstLetter(data);
                    },
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        return formatDate(data); // Tampilkan tanggal dengan format Indonesia
                    },
                },
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    type: 'date',
                    targets: 3
                } // Specify the type of the fourth column as 'date'
            ],
            order: [
                [3, 'desc']
            ],
            select: true,
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        // Navigate to the Edit page
                        tambahModal.show();
                    }
                },
                {
                    text: '<i id="iconFilter" class="bx bx-filter-alt me-2"></i><span id="loaderFilter" class="loader me-2" style="display: none;"></span><span id="textFilter"><?= lang('Admin.semua') ?></span>',
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
                    text: '<i class="bx bx-printer"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = "<?= base_url('admin/login-log') ?>";
                    }
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

            processBulk(table1, "<?= base_url('/admin/pengguna/hapus') ?>", options);
        }

        // Example of adding a user using AJAX
        $('#tambahForm').submit(function(e) {
            e.preventDefault();
            // console.log(this);

            // Adjust UI
            $('#tambahFormSubmitButton').prop('disabled', true);

            // Send request
            $.ajax({
                url: '<?= base_url('/api/pengguna-ajax/tambah') ?>',
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
                url: '/api/pengguna-ajax/edit/',
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


        // Change button styles
        $('#tabel').on('preInit.dt', function() {

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            // Reinitialize the ripple effect for the new button
            buttons.each(function() {
                new mdb.Ripple(this); // This will reinitialize the ripple effect on all elements with the data-mdb-ripple-init attribute
            })

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");

            var secondButton = buttons.eq(1);
            secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilter",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            // Data dinamis berdasarkan grup yang tersedia
            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>'
                <?php foreach ($auth_groups as $key => $a): ?> + '<li><button id="btnFilter<?= $key ?>" class="dropdown-item" type="button"><?= capitalize_first_letter($key) ?></button></li>'
                <?php endforeach; ?>
                // '<li><button id="btnFilterDraf" class="dropdown-item" type="button"><?= lang('Admin.user') ?></button></li>' +
                +
                '</ul>'
            );

            secondButton.after(newElement);
            new mdb.Dropdown(secondButton); // Reinitialize dropdown

            // Filter buttons and their respective group names
            var filterButtons = {
                '#btnFilterSemua': '',
                <?php foreach ($auth_groups as $key => $a): ?> '#btnFilter<?= $key ?>': '<?= $key ?>',
                <?php endforeach; ?>
            };

            // Add click events to each button
            $.each(filterButtons, function(button, groupName) {
                $(button).on('click', function() {
                    // Filter by group name in the 'Group' column
                    table1.column(3).search(groupName).draw();
                    $('#textFilter').html($(button).html());
                });
            });

            // var filterButtons = {
            //     '#btnFilterSemua': '<?= base_url('/api/pengguna') ?>',
            //     <?php foreach ($auth_groups as $key => $a): ?> '#btnFilter<?= $key ?>': '<?= base_url('/api/pengguna/' . $key) ?>',
            //     <?php endforeach; ?> // ,'#btnFilterDraf': '<?= base_url('/api/berita/draf') ?>'
            // };

            // $.each(filterButtons, function(btnId, apiUrl) {
            //     $(btnId).on('click', function() {
            //         $('#iconFilter').hide();
            //         $('#loaderFilter').show();
            //         table1.ajax.url(apiUrl).load(function() {
            //             $('#iconFilter').show();
            //             $('#loaderFilter').hide();
            //             $('#textFilter').html($(btnId).html());
            //         });
            //     });
            // });
        });

    });
</script>
<?= $this->endSection() ?>