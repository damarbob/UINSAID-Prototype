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
        <table class="table table-hover" id="tabelBerita">
            <thead class="border-bottom border-primary">
                <tr>
                    <th class="fw-bold"><i class="bi bi-pencil-square me-2"></i><br><?= lang('Admin.judul') ?></th>
                    <th class="fw-bold"><i class="bi bi-person me-2"></i><br><?= lang('Admin.penulis') ?></th>
                    <th class="fw-bold"><i class="bi bi-bookmark me-2"></i><br><?= lang('Admin.kategori') ?></th>
                    <th class="fw-bold"><i class="bi bi-clock me-2"></i><br><?= lang('Admin.tanggal') ?></th>
                    <th class="fw-bold"><i class="bi bi-app-indicator me-2"></i><br><?= lang('Admin.status') ?></th>
                    <th class="fw-bold"><i class="bi bi-pin-angle me-2"></i><br><?= lang('Admin.jenis') ?></th>
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

        var filterStatus = null; // Define a variable to hold the filter status
        var filterJenis = null; // Define a variable to hold the filter jenis

        var table1 = $('#tabelBerita').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: {
                "url": "<?= base_url('api/posting') ?>",
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

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/posting/sunting?id=') ?>" + id;
                });
            },
            "columns": [{
                    "data": "judul",
                    "render": function(data, type, row) {
                        return `<a href="<?= base_url('/admin/posting/sunting?id=') ?>${row.id}" class="line-clamp-2">` + data + '</a>';
                    }
                },
                {
                    "data": "penulis",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return '<span class="badge badge-secondary">' + data + '</span>'
                        }
                        return data;
                    }
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
                        return (data) ? '' + formatDate(data) + '' : '';
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return data == "publikasi" ? "<span class='badge badge-success'><?= lang('Admin.publikasi') ?></span>" : "<span class='badge badge-warning'><?= lang('Admin.draf') ?></span>"
                        }
                        return data;
                    }
                },
                {
                    "data": "posting_jenis_nama",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return "<span class='badge badge-secondary'>" + capitalizeFirstLetter(data) + '</span>';
                        }
                        return data;
                    }
                }
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
                [3, 'desc']
            ],
            dom: '<"mb-5"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"dataTables_paginate_wrapper align-self-start align-self-sm-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url('/admin/posting/tambah') ?>'
                    }
                },
                {
                    text: '<i id="iconFilterRilisMedia" class="bx bx-filter-alt me-2"></i><span id="loaderFilterRilisMedia" class="loader me-2" style="display: none;"></span><span id="textFilterRilisMedia"><?= lang('Admin.semuaStatus') ?></span>',
                },
                {
                    text: '<i id="iconFilterJenis" class="bx bx-filter-alt me-2"></i><span id="loaderFilterJenis" class="loader me-2" style="display: none;"></span><span id="textFilterJenis"><?= lang('Admin.semuaJenis') ?></span>',
                },
                <?php if (env('app.parentSite')):
                    // Tampilkan tombol ajukan dan batal ajukan di website child dan super
                ?> {
                        // Tombol ajukan
                        extend: 'selected',
                        text: '<i class="bi bi-forward"></i>',
                        action: function(e, dt, node, config) {
                            ajukan();
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

        // Function to handle visibility based on window size
        function adjustColumnVisibility() {
            if (window.innerWidth < 576) {
                // Hide all columns except the 'judul' column (index 0)
                table1.columns().every(function(index) {
                    this.visible(index === 0); // Only show the first column (judul)
                });
            } else {
                // Show all columns when the window is wider than 576px
                table1.columns().every(function() {
                    this.visible(true);
                });
            }
        }

        // Initial adjustment
        // adjustColumnVisibility();

        // Adjust visibility on window resize
        // window.addEventListener('resize', adjustColumnVisibility);

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

            processBulk(table1, "<?= base_url('/admin/posting/hapus') ?>", options);
        }

        function ajukan() {
            var parentSite = '<?= env('app.parentSite') ?>';

            if (parentSite == '') { // If app.siteParent is null, it will be captured by JS as empty string
                Swal.fire({
                    title: '<?= lang('Admin.ajukanBerita') ?>',
                    text: '<?= lang('Admin.situsIndukBelumDiatur') ?>',
                    icon: 'error',
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: '<?= lang('Admin.batal') ?>',
                    confirmButtonColor: "var(--mdb-primary)",
                    focusCancel: true,
                })
                return;
            }

            var options = {
                title: "<?= lang('Admin.ajukanBerita') ?>",
                confirmMessage: "<?= lang('Admin.kirimkanBeritaIniKeWebsiteInduk') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.kirimkan') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            // NOTE: Tidak perlu base_url karena akan merequest situs eksternal
            processBulkNew(table1, parentSite + "api/posting-diajukan/terima-posting", options);
        }

        function batalAjukan() {
            var options = {
                title: "<?= lang('Admin.batalkanPengajuanItem') ?>",
                confirmMessage: "<?= lang('Admin.batalkanPengajuanItemIni?') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.kirimkan') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulkNew(table1, "<?= base_url('/admin/posting/batal-ajukan') ?>", options);
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

            // Reinitialize the ripple effect for the new button
            buttons.each(function() {
                new mdb.Ripple(this); // This will reinitialize the ripple effect on all elements with the data-mdb-ripple-init attribute
            })

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            <?php if ($is_child_site): ?>
                // Warnai tombol ajukan dan batal ajukan di website child dan super
                buttons.eq(3).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
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
                '<li><button id="btnFilterRilisMediaSemua" class="dropdown-item" type="button"><?= lang('Admin.semuaStatus') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaPublikasi" class="dropdown-item" type="button"><?= lang('Admin.publikasi') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDraf" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);
            new mdb.Dropdown(secondButton); // Reinitialize dropdown

            // Filter button and status
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

        // Add MDB styles to the search input after initialization
        table1.on('init.dt', function() {
            $('div.dataTables_filter label input').addClass('form-control form-control-md'); // Apply MDB form control styles
            $('div.dataTables_filter label').addClass('form-label'); // Apply MDB label styles
        });

    });
</script>
<?= $this->endSection() ?>