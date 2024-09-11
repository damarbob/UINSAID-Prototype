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
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('gagal') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Peringatan posting berita -->
        <?php if ($peringatanPostingBerita) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= lang('Admin.tampaknyaSudahLebihDari3BulanSejakBeritaTerakhir') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabelBerita" style="width: 100%;">
            <thead>
                <tr>
                    <td><?= lang('Admin.judul') ?></td>
                    <td><?= lang('Admin.penulis') ?></td>
                    <td><?= lang('Admin.kategori') ?></td>
                    <?php if ($is_child_site): ?>
                        <!-- Kolom pengajuan untuk child dan super -->
                        <td><?= lang('Admin.pengajuan') ?></td>
                    <?php endif ?>
                    <td><?= lang('Admin.tanggal') ?></td>
                    <td><?= lang('Admin.status') ?></td>
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
<!-- TODO: Migrate to the new process bulk -->
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk_new.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var table1 = $('#tabelBerita').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            // ajax: "/api/berita",
            ajax: {
                "url": "<?= base_url('api/berita') ?>",
                "type": "POST"
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/berita/sunting?id=') ?>" + id;
                });
            },
            "columns": [{
                    "data": "judul",
                },
                {
                    "data": "penulis",
                },
                {
                    "data": "kategori",
                    "render": function(data, type, row) {
                        return capitalizeFirstLetter(data);
                    }
                },
                <?php if ($is_child_site): ?> {
                        // Kolom pengajuan untuk child dan super
                        "data": "pengajuan",
                        "render": function(data, type, row) {
                            return data == "tidak diajukan" ? "<?= lang('Admin.tidakDiajukan') ?>" : (data == "diajukan" ? "<?= lang('Admin.diajukan') ?>" : (data == "diterima" ? "<?= lang('Admin.diterima') ?>" : (data == "ditolak" ? "<?= lang('Admin.ditolak') ?>" : "<?= lang('Admin.diblokir') ?>"))) // TODO: Translasi
                        }
                    },
                <?php endif ?> {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        return formatDate(data);
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return data == "publikasi" ? "<?= lang('Admin.publikasi') ?>" : "<?= lang('Admin.draf') ?>"
                        }
                        return data;
                    }
                },
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            order: [
                <?php if ($is_child_site): ?>
                    // Apabila child atau super
                    [4, 'desc']
                <?php else: ?>
                    // Apabila parent
                    [3, 'desc']
                <?php endif ?>
            ],
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url('/admin/berita/tambah') ?>'
                    }
                },
                {
                    text: '<i id="iconFilterRilisMedia" class="bx bx-filter-alt me-2"></i><span id="loaderFilterRilisMedia" class="loader me-2" style="display: none;"></span><span id="textFilterRilisMedia"><?= lang('Admin.semua') ?></span>',
                },
                <?php if ($is_child_site):
                    // Tampilkan tombol ajukan dan batal ajukan di website child dan super
                ?> {
                        // Tombol ajukan
                        extend: 'selected',
                        text: '<i class="bi bi-forward"></i>',
                        action: function(e, dt, node, config) {
                            ajukan();
                        }
                    },
                    {
                        // Tombol batal ajukan
                        extend: 'selected',
                        text: '<i class="bi bi-arrow-return-left"></i>',
                        action: function(e, dt, node, config) {
                            batalAjukan();
                        }
                    },
                <?php endif ?> {
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

            processBulk(table1, "<?= base_url('/admin/berita/hapus') ?>", options);
        }

        function ajukan() {
            var options = {
                title: "<?= lang('Admin.ajukanBerita') ?>",
                confirmMessage: "<?= lang('Admin.kirimkanBeritaIniKeWebsiteUtama') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.kirimkan') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulkNew(table1, "<?= base_url('/api/berita-diajukan/terima-berita') ?>", options);
        }

        function batalAjukan() {
            var options = {
                title: "<?= lang('Admin.batalkanPengajuanBerita') ?>",
                confirmMessage: "<?= lang('Admin.batalkanPengajuanBeritaIni?') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.kirimkan') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulkNew(table1, "<?= base_url('/admin/berita/batal-ajukan') ?>", options);
        }

        table1.on('select.dt', function(e, dt, type, indexes) {
            if (type === 'row') {
                var data = table1.row(indexes).data();
                console.log('Selected row data:', data);
            }
        });

        // Change button styles
        table1.on('preInit.dt', function() {

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg"); // Buat grup tombol jadi besar

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            <?php if ($is_child_site): ?>
                // Warnai tombol ajukan dan batal ajukan di website child dan super
                buttons.eq(2).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
                buttons.eq(3).removeClass("btn-secondary").addClass("btn-warning").addClass("rounded-0");
            <?php endif ?>
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");


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
                '<li><button id="btnFilterRilisMediaPublikasi" class="dropdown-item" type="button"><?= lang('Admin.publikasi') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDraft" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);

            var filterButtons = {
                '#btnFilterRilisMediaSemua': '/api/berita',
                '#btnFilterRilisMediaPublikasi': '/api/berita/publikasi',
                '#btnFilterRilisMediaDraft': '/api/berita/draft'
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