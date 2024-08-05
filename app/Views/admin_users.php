<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>

<!-- Tabel user -->
<div class="row">
    <div class="col">

        <!-- Pesan sukses atau error -->
        <?php if (session()->getFlashdata('sukses')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('sukses') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('gagal') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($peringatanPostingBerita) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= lang('Admin.peringatanPosting') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabel" style="width: 100%;">
            <thead>
                <tr>
                    <td>User ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Grup</td>
                    <td>Dibuat pada</td>
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
                <h5 class="modal-title" id="editModalLabel">Sunting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="post">
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editUsername" name="username" class="form-control" />
                        <label class="form-label" for="editUsername">Nama Pengguna</label>
                    </div>
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editEmail" name="secret" class="form-control" />
                        <label class="form-label" for="editEmail">Email</label>
                    </div>
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="editGrup" class="form-control" name="group" />
                        <label class="form-label" for="editGrup">Grup</label>
                    </div>
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="password" id="editKataSandi" class="form-control" name="secret2" />
                        <label class="form-label" for="editKataSandi">Kata Sandi</label>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="force_reset" id="editMintaAturUlangKataSandiCheck" value="" placeholder="Minta Atur Ulang Kata Sandi">
                        <label for="editMintaAturUlangKataSandi" class="form-check-label">Minta Atur Ulang Kata Sandi</label>
                    </div>
                    <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i>Update</button>
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
                <h5 class="modal-title" id="tambahModalLabel">Tambah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tambahForm" action="/admin/pengguna/tambah" method="post">
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="username" name="username" class="form-control" />
                        <label class="form-label" for="username">Nama Pengguna</label>
                    </div>
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="email" name="secret" class="form-control" />
                        <label class="form-label" for="email">Email</label>
                    </div>
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="text" id="grup" class="form-control" name="group" />
                        <label class="form-label" for="grup">Grup</label>
                    </div>
                    <div class="form-outline mb-3" data-mdb-input-init>
                        <input type="password" id="kataSandi" class="form-control" name="secret2" />
                        <label class="form-label" for="kataSandi">Kata Sandi</label>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" class="form-check-input" name="force_reset" id="editMintaAturUlangKataSandiCheck" value="" placeholder="Minta Atur Ulang Kata Sandi">
                        <label for="editMintaAturUlangKataSandi" class="form-check-label">Minta Atur Ulang Kata Sandi</label>
                    </div>
                    <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i>Tambah</button>
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
        var table1 = $('#tabel').DataTable({
            ajax: "/api/pengguna",
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Update input value from data
                    $('#editUsername').val(data.username);
                    $('#editEmail').val(data.secret);
                    $('#editGrup').val(data.group);
                    $('#editKataSandi').val(''); // Clear password field for security
                    $('#editMintaAturUlangKataSandiCheck').prop('checked', data.force_reset === "1" ? true : false); // Uncheck the checkbox
                    $('#editForm').attr('action', `/admin/pengguna/edit/${id}`);

                    // Navigate to the Edit page
                    $('#editModal').modal('show');
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
                },
                {
                    "data": "created_at_timestamp",
                    "render": function(data, type, row) {
                        return timestampToIndonesianDateTime(data); // Tampilkan tanggal dengan format Indonesia
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
            dom: '<"row gy-2 mb-2"<"col-lg-6"B><"col-lg-6"f>>r<"table-responsive"t><"row gy-2"<"col-md-6"i><"col-md-6"p>><"row my-2"<"col">>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        // Navigate to the Edit page
                        $('#tambahModal').modal('show');
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
                title: "<?= lang('Admin.hapusBerita') ?>",
                confirmMessage: "<?= lang('Admin.hapusBeritaKonfirmasi') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.hapus') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "/admin/pengguna/hapus", options);
        }


        // Change button styles
        $('#tabel').on('preInit.dt', function() {
            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

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

            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>' +
                '<li><button id="btnFilterDipublikasikan" class="dropdown-item" type="button"><?= lang('Admin.dipublikasikan') ?></button></li>' +
                '<li><button id="btnFilterDraft" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);

            var filterButtons = {
                '#btnFilterSemua': '/api/berita',
                '#btnFilterDipublikasikan': '/api/berita/dipublikasikan',
                '#btnFilterDraft': '/api/berita/draf'
            };

            $.each(filterButtons, function(btnId, apiUrl) {
                $(btnId).on('click', function() {
                    $('#iconFilter').hide();
                    $('#loaderFilter').show();
                    table1.ajax.url(apiUrl).load(function() {
                        $('#iconFilter').show();
                        $('#loaderFilter').hide();
                        $('#textFilter').html($(btnId).html());
                    });
                });
            });
        });

    });
</script>
<?= $this->endSection() ?>