<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<style>
    .loader {
        width: 12px;
        height: 12px;
        border: 2px solid var(--color-primary);
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
        <table class="table table-hover" id="tabelRilisMedia" style="width: 100%;">
            <thead>
                <tr>
                    <td><?= lang('Admin.judul') ?></td>
                    <td><?= lang('Admin.kategori') ?></td>
                    <td><?= lang('Admin.tanggal') ?></td>
                    <td><?= lang('Admin.status') ?></td>
                    <td>Sumber</td>
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
        var table1 = $('#tabelRilisMedia').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= site_url('api/berita-diajukan') ?>",
                "type": "POST"
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the View page

                });
            },
            "columns": [{
                    "data": "judul",
                },
                {
                    "data": "kategori",
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        return formatDate(data);
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        return data == "published" ? "Dipublikasi" : "Draf" // TODO: Translasi
                    }
                },
                {
                    "data": "sumber",
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
                [2, 'desc']
            ],
            select: true,
            dom: '<"row gy-2 mb-2"<"col-lg-6"B><"col-lg-6"f>>r<"table-responsive"t><"row gy-2"<"col-md-6"i><"col-md-6"p>><"row my-2"<"col">>',
            buttons: [
                // TOmbol publikasi
                {
                    extend: 'selected',
                    text: '<i class="bi bi-check"></i>',
                    action: function(e, dt, node, config) {
                        publikasiBanyak();
                    }
                },
                {
                    text: '<i id="iconFilterRilisMedia" class="bx bx-filter-alt me-2"></i><span id="loaderFilterRilisMedia" class="loader me-2" style="display: none;"></span><span id="textFilterRilisMedia"><?= lang('Admin.semua') ?></span>',
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

        // Terima postingan massal
        function publikasiBanyak() {
            var options = {
                title: "Publikasi Berita",
                confirmMessage: "Publikasikan berita?",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "info",
                confirmButtonText: "Tambahkan",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulkNew(table1, "/admin/berita-diajukan/publikasi", options);
        }

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

            var columnsToSend = ['id']; // specify the columns you want to send
            processBulkNew(table1, "/admin/berita-diajukan/hapus", options, columnsToSend);
        }


        // Change button styles
        $('#tabelRilisMedia').on('preInit.dt', function() {
            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");

            var secondButton = buttons.eq(1);
            secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterRilisMedia",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterRilisMediaSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDipublikasikan" class="dropdown-item" type="button"><?= lang('Admin.dipublikasikan') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDraft" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);

            var filterButtons = {
                '#btnFilterRilisMediaSemua': '/api/berita-diajukan',
                '#btnFilterRilisMediaDipublikasikan': '/api/berita-diajukan/dipublikasikan',
                '#btnFilterRilisMediaDraft': '/api/berita-diajukan/draf'
            };

            $.each(filterButtons, function(btnId, apiUrl) {
                $(btnId).on('click', function() {
                    $('#iconFilterRilisMedia').hide();
                    $('#loaderFilterRilisMedia').show();
                    table1.ajax.url(apiUrl).load(function() {
                        $('#iconFilterRilisMedia').show();
                        $('#loaderFilterRilisMedia').hide();
                        $('#textFilterRilisMedia').html($(btnId).html());
                    });
                });
            });
        });

    });
</script>
<?= $this->endSection() ?>