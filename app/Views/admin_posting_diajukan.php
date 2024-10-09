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
                <h5 class="modal-title" id="lihatModalLabel"><?= lang('Admin.judul') ?></h5>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="lihatModalKonten">
                    ...
                </p>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">
                    <i class="bi bi-chevron-left me-2"></i>
                    <?= lang('Admin.batal') ?>
                </button>
                <button id="lihatModalTombolPublikasi" type="button" class="btn btn-primary" data-mdb-ripple-init>
                    <i class="bi bi-check me-2"></i>
                    <?= lang('Admin.publikasi') ?>
                </button>
                <button id="lihatModalTombolHapus" type="button" class="btn btn-danger" data-mdb-ripple-init>
                    <i class="bi bi-trash me-2"></i>
                    <?= lang('Admin.hapus') ?>
                </button>
            </div>
        </div>
    </div>
</div>
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
        <?php endif; ?>

        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabelRilisMedia" style="width: 100%;">
            <thead>
                <tr>
                    <td><?= lang('Admin.judul') ?></td>
                    <td><?= lang('Admin.kategori') ?></td>
                    <td><?= lang('Admin.tanggal') ?></td>
                    <td><?= lang('Admin.status') ?></td>
                    <td><?= lang('Admin.sumber') ?></td>
                    <td><?= lang('Admin.jenis') ?></td>
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
        var filterStatus = null; // Define a variable to hold the filter status
        var filterJenis = null; // Define a variable to hold the filter jenis

        var table1 = $('#tabelRilisMedia').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('api/posting-diajukan') ?>",
                "type": "POST",
                "data": function(d) {
                    // Include the filter status in the request data
                    if (filterStatus) {
                        d.status = filterStatus;
                    }
                    if (filterJenis) {
                        d.jenisNama = filterJenis;
                    }
                    return d;
                }
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Update input value from data
                    $('#lihatModalLabel').html(data.judul);
                    $('#lihatModalKonten').html(data.konten);

                    $('#lihatModal').modal('show'); // Tampilkan modal lihat

                    // Simpan indeks row yang terakhir terpilih
                    lastDoubleClickedRowIndex = index;

                    // console.log(index);
                });
            },
            "columns": [{
                    "data": "judul",
                },
                {
                    "data": "kategori",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return capitalizeFirstLetter(data);
                        }
                        return data;
                    }
                },
                {
                    "data": "tanggal_terbit",
                    "render": function(data, type, row) {
                        return (data) ? formatDate(data) : '';
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return data == "publikasi" ? "<?= lang('Admin.publikasi') ?>" : "<?= lang('Admin.draf') ?>";
                        }
                        return data;
                    }
                },
                {
                    "data": "sumber",
                },
                {
                    "data": "posting_jenis_nama",
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
                [2, 'desc']
            ],
            select: true,
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
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
                    text: '<i id="iconFilterJenis" class="bx bx-filter-alt me-2"></i><span id="loaderFilterJenis" class="loader me-2" style="display: none;"></span><span id="textFilterJenis"><?= lang('Admin.semuaJenis') ?></span>',
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

        // Publikasi postingan terpilih aktif
        $('#lihatModalTombolPublikasi').click(function() {
            table1.row(lastDoubleClickedRowIndex).select();
            console.log(table1.row(lastDoubleClickedRowIndex).data);
            publikasiBanyak();
            $('#lihatModal').modal('hide'); // Sembunyikan modal lihat
        });

        // Hapus postingan terpilih aktif
        $('#lihatModalTombolHapus').click(function() {
            table1.row(lastDoubleClickedRowIndex).select();
            hapusBanyak();
            $('#lihatModal').modal('hide'); // Sembunyikan modal lihat
        });

        // Terima postingan massal
        function publikasiBanyak() {
            var options = {
                title: "Publikasi Postingan",
                confirmMessage: "Publikasikan postingan?",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "info",
                confirmButtonText: "Tambahkan",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulkNew(table1, "<?= base_url('/admin/posting-diajukan/publikasi') ?>", options);
        }

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

            var columnsToSend = ['id']; // specify the columns you want to send
            processBulkNew(table1, "<?= base_url('/admin/posting-diajukan/hapus') ?>", options, columnsToSend);
        }

        table1.on('select.dt', function(e, dt, type, indexes) {
            if (type === 'row') {
                var data = table1.row(indexes).data();
                // console.log('Selected row data:', data);
            }
        });

        // Ganti gaya tombol
        table1.on('preInit.dt', function() {
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
                '<li><button id="btnFilterRilisMediaPublikasi" class="dropdown-item" type="button"><?= lang('Admin.publikasi') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDraf" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);
            new mdb.Dropdown(secondButton); // Reinitialize dropdown

            var filterButtons = {
                '#btnFilterRilisMediaSemua': null,
                '#btnFilterRilisMediaPublikasi': 'publikasi',
                '#btnFilterRilisMediaDraf': 'draf'
            };

            $.each(filterButtons, function(btnId, status) {
                $(btnId).on('click', function() {
                    filterStatus = status; // Update the filter status
                    // table1.ajax.reload(); // Reload the DataTable with the new filter
                    $('#iconFilterRilisMedia').hide();
                    $('#loaderFilterRilisMedia').show();
                    table1.ajax.reload(function() {
                        $('#iconFilterRilisMedia').show();
                        $('#loaderFilterRilisMedia').hide();
                        $('#textFilterRilisMedia').html($(btnId).html());
                    });
                });
            });

            // Filter jenis
            var thirdButton = buttons.eq(2);
            thirdButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterJenis",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            var newElementForJenis = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterJenisSemua" class="dropdown-item" type="button"><?= lang('Admin.semuaJenis') ?></button></li>'
                <?php foreach ($jenis as $i => $x): ?> + '<li><button id="btnFilterJenis<?= $i ?>" class="dropdown-item" type="button"><?= $x['nama'] ?></button></li>'
                <?php endforeach; ?> +
                '</ul>'
            );

            thirdButton.after(newElementForJenis);
            new mdb.Dropdown(thirdButton); // Reinitialize dropdown

            // Filter button and jenis
            var filterJenisButtons = {
                '#btnFilterJenisSemua': null,
                <?php foreach ($jenis as $i => $x): ?> '#btnFilterJenis<?= $i ?>': '<?= $x['nama'] ?>',
                <?php endforeach; ?>
            };

            $.each(filterJenisButtons, function(btnId, jenis) {
                $(btnId).on('click', function() {
                    filterJenis = jenis; // Update the filter jenis
                    // table1.ajax.reload(); // Reload the DataTable with the new filter
                    $('#iconFilterJenis').hide();
                    $('#loaderFilterJenis').show();
                    table1.ajax.reload(function() {
                        $('#iconFilterJenis').show();
                        $('#loaderFilterJenis').hide();
                        $('#textFilterJenis').html($(btnId).html());
                    });
                });
            });
        });

    });
</script>
<?= $this->endSection() ?>