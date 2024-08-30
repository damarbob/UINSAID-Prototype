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

        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover w-100" id="tabelKotakMasuk">
            <thead>
                <tr>
                    <td><?= lang('Admin.tanggal') ?></td>
                    <td><?= lang('Admin.pesan') ?></td>
                    <td><?= lang('Admin.kategori') ?></td>
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
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var table1 = $('#tabelKotakMasuk').DataTable({
            ajax: "<?= base_url('/api/kotak-masuk') ?>",
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/kotak-masuk/sunting?id=') ?>" + id;
                });
            },
            "columns": [{
                    "data": "created_at_timestamp",
                    "render": function(data, type, row) {
                        return '<span class="' + ((row.terbaca == 0) ? 'fw-bold' : '') + '">' + timestampToIndonesianDateTime(data) + '</span>'; // Kapital depan
                    },
                },
                {
                    "data": "isi",
                    "render": function(data, type, row) {
                        // Batasi pesan hanya 4 baris dengan class line-clamp
                        return '<div class="line-clamp-4 ' + ((row.terbaca == 0) ? 'fw-bold' : '') + '">' + data + '</div>';
                    },
                },
                {
                    "data": "keperluan_terformat",
                    "render": function(data, type, row) {
                        return '<span class="' + ((row.terbaca == 0) ? 'fw-bold' : '') + '">' + data + '</span>'; // Kapital depan
                    },
                },
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    type: 'date',
                    targets: 0
                } // Specify the type of the fourth column as 'date'
            ],
            order: [
                [0, 'desc']
            ],
            select: true,
            dom: '<"row gy-2 mb-2"<"col-lg-6"B><"col-lg-6"f>>r<"table-responsive"t><"row gy-2"<"col-md-6"i><"col-md-6"p>><"row my-2"<"col">>',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="bx bx-download"></i>'
                },
                {
                    text: '<i id="iconFilterKotakMasuk" class="bx bx-filter-alt me-2"></i><span id="loaderFilterKotakMasuk" class="loader me-2" style="display: none;"></span><span id="textFilterKotakMasuk"><?= lang('Admin.semua') ?></span>',
                },
                {
                    extend: 'selected',
                    text: '<i class="bi bi-envelope-exclamation-fill"></i>',
                    action: function(e, dt, node, config) {
                        tandaiBelumTerbacaBanyak();
                    }
                },
                {
                    extend: 'selected',
                    text: '<i class="bi bi-envelope-check"></i>',
                    action: function(e, dt, node, config) {
                        tandaiTerbacaBanyak();
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="bx bx-table"></i>'
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

        // Fitur tandai massal
        function tandaiTerbacaBanyak() {
            var options = {
                title: "<?= lang('Admin.tandaiPesan') ?>",
                confirmMessage: "<?= lang('Admin.tandaiPesanKonfirmasi') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "info",
                confirmButtonText: "<?= lang('Admin.tandai') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "<?= base_url('/admin/kotak-masuk/tandai/terbaca') ?>", options);
        }

        // Fitur tandai massal
        function tandaiBelumTerbacaBanyak() {
            var options = {
                title: "<?= lang('Admin.tandaiPesan') ?>",
                confirmMessage: "<?= lang('Admin.tandaiPesanKonfirmasi') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "info",
                confirmButtonText: "<?= lang('Admin.tandai') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "<?= base_url('/admin/kotak-masuk/tandai/belum_terbaca') ?>", options);
        }

        // Fitur hapus massal
        function hapusBanyak() {
            var options = {
                title: "<?= lang('Admin.hapusPesan') ?>",
                confirmMessage: "<?= lang('Admin.lanjutkanUntukMenghapusPesan') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.hapus') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "<?= base_url('/admin/kotak-masuk/hapus') ?>", options);
        }


        // Change button styles
        $('#tabelKotakMasuk').on('preInit.dt', function() {
            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");

            var secondButton = buttons.eq(1);
            secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterKotakMasuk",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterKotakMasukSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>' +
                '<li><button id="btnFilterKotakMasukKritikDanSaran" class="dropdown-item" type="button"><?= lang('Admin.kritikDanSaran') ?></button></li>' +
                '<li><button id="btnFilterKotakMasukPelaporan" class="dropdown-item" type="button"><?= lang('Admin.pelaporan') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);

            var filterButtons = {
                '#btnFilterKotakMasukSemua': '<?= base_url('/api/kotak-masuk') ?>',
                '#btnFilterKotakMasukKritikDanSaran': '<?= base_url('/api/kotak-masuk/kritik-dan-saran') ?>',
                '#btnFilterKotakMasukPelaporan': '<?= base_url('/api/kotak-masuk/pelaporan') ?>'
            };

            $.each(filterButtons, function(btnId, apiUrl) {
                $(btnId).on('click', function() {
                    $('#iconFilterKotakMasuk').hide();
                    $('#loaderFilterKotakMasuk').show();
                    table1.ajax.url(apiUrl).load(function() {
                        $('#iconFilterKotakMasuk').show();
                        $('#loaderFilterKotakMasuk').hide();
                        $('#textFilterKotakMasuk').html($(btnId).html());
                    });
                });
            });
        });

    });
</script>
<?= $this->endSection() ?>