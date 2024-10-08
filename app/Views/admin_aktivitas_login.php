<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('style') ?>
<style>
    #lihatModalKonten img {
        max-width: 100%;
    }

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
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Modal -->
<div class="modal fade" id="lihatModal" tabindex="-1" aria-labelledby="lihatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatModalLabel"><?= lang('Admin.aktivitasLogin') ?></h5>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="lihatModalKonten">
                    ...
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">

        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabelAktivitasLogin" style="width: 100%;">
            <thead>
                <tr>
                    <td><?= lang('Admin.email') ?></td>
                    <td><?= lang('Admin.username') ?></td>
                    <td><?= lang('Admin.status') ?></td>
                    <td><?= lang('Admin.waktuLogin') ?></td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <!-- </div> -->

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk_new.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        // Initialize the MDB modal
        const lihatModal = new mdb.Modal($('#lihatModal'));

        var lastDoubleClickedRowIndex = null;
        var filterEmail = null; // Define a variable to hold the filter status

        var table1 = $('#tabelAktivitasLogin').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('api/aktivitas-login') ?>",
                "type": "POST",
                "data": function(d) {
                    // Include the filter status in the request data
                    if (filterEmail) {
                        d.email = filterEmail;
                    }
                    return d;
                }
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                // $(row).on('dblclick', function() {
                //     // Get the ID from the data
                //     var id = data.id;

                //     // Update input value from data
                //     // $('#lihatModalLabel').html(data.judul);
                //     $('#lihatModalKonten').html(
                //         'Alamat IP: ' + data.ip_address + '<br>' +
                //         'Identifier/Email: ' + data.identifier + '<br>' +
                //         'Username: ' + data.username + '<br>' +
                //         'Waktu Login: ' + data.date + '<br>' +
                //         'Status: ' + data.success == '1' ? 'Berhasil' : 'Gagal' + '<br>'
                //     );

                //     $('#lihatModal').modal('show'); // Tampilkan modal lihat

                //     // Simpan indeks row yang terakhir terpilih
                //     lastDoubleClickedRowIndex = index;

                //     // console.log(index);
                // });
            },
            "columns": [{
                    "data": "identifier",
                },
                {
                    "data": "username",
                },
                {
                    "data": "success",
                    "render": function(data, type, row) {
                        return data == '1' ? 'Sukses' : 'Gagal';
                    }
                },
                {
                    "data": "date",
                    "render": function(data, type, row) {
                        return formatDate(data);
                    }
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
            buttons: [
                // TOmbol publikasi
                {
                    text: '<i id="iconFilterAktivitasLogin" class="bx bx-filter-alt me-2"></i><span id="loaderFilterAktivitasLogin" class="loader me-2" style="display: none;"></span><span id="textFilterAktivitasLogin"><?= lang('Admin.semua') ?></span>',
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
            ],
        });

        table1.on('select.dt', function(e, dt, type, indexes) {
            if (type === 'row') {
                var data = table1.row(indexes).data();
                // console.log('Selected row data:', data);
            }
        });

        // Ganti gaya tombol
        table1.on('preInit.dt', function() {
            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");

            var filterButton = buttons.eq(0);
            filterButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterAktivitasLogin",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterAktivitasLoginSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>'
                <?php foreach ($user as $i => $x): ?> + '<li><button id="btnFilter<?= $i ?>" class="dropdown-item" type="button"><?= $x['identifier'] ?></button></li>'
                <?php endforeach; ?> +
                '</ul>'
            );

            filterButton.after(newElement);
            new mdb.Dropdown(filterButton); // Reinitialize dropdown

            var filterButtons = {
                '#btnFilterAktivitasLoginSemua': null,
                <?php foreach ($user as $i => $x): ?> '#btnFilter<?= $i ?>': '<?= $x['identifier'] ?>',
                <?php endforeach; ?>
            };

            $.each(filterButtons, function(btnId, status) {
                $(btnId).on('click', function() {
                    filterEmail = status; // Update the filter status
                    // table1.ajax.reload(); // Reload the DataTable with the new filter
                    $('#iconFilterAktivitasLogin').hide();
                    $('#loaderFilterAktivitasLogin').show();
                    table1.ajax.reload(function() {
                        $('#iconFilterAktivitasLogin').show();
                        $('#loaderFilterAktivitasLogin').hide();
                        $('#textFilterAktivitasLogin').html($(btnId).html());
                    });
                });
            });
        });

    });
</script>
<?= $this->endSection() ?>