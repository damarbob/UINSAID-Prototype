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
                <?= session()->getFlashdata('sukses') ?>
            </div>
        <?php elseif (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('gagal') ?>
            </div>
        <?php endif; ?>

        <table id="halamanTable" class="table table-hover w-100">
            <thead class="border-bottom border-primary">
                <tr>
                    <th class="fw-bold"><i class="bi bi-pencil-square me-2"></i><br><?= lang('Admin.judul') ?></th>
                    <th class="fw-bold"><i class="bi bi-globe2"></i><br><?= lang('Admin.alamatHalaman') ?></th>
                    <th class="fw-bold"><i class="bi bi-app-indicator"></i><br><?= lang('Admin.status') ?></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk_new.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var filterStatus = null;
        var tabel = $('#halamanTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            order: [
                [0, 'asc']
            ],
            ajax: {
                "url": "<?= base_url('api/halaman') ?>",
                "type": "POST",
                "data": function(d) {
                    // Include the filter status in the request data
                    if (filterStatus) {
                        d.status = filterStatus;
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
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/halaman/sunting/'); ?>" + id;
                });
            },
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url("/admin/halaman/tambah"); ?>'
                    }
                },
                {
                    text: '<i id="iconFilterHalaman" class="bx bx-filter-alt me-2"></i><span id="loaderFilterHalaman" class="loader me-2" style="display: none;"></span><span id="textFilterRilisMedia"><?= lang('Admin.semua') ?></span>',
                },
                {
                    text: '<i class="bi bi-window-dock me-2"></i> <?= lang('komponen') ?>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url("/admin/komponen"); ?>'
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
            "columns": [{
                    "data": "judul",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            return `<a href="<?= base_url('/admin/halaman/sunting/'); ?>${row.id}">` + (data) + "</a>";
                        }
                        return data;
                    },
                },
                {
                    "data": "slug",
                    "render": function(data, type, row) {
                        if (type === 'display' && data != null && data != '') {
                            var halamanUri = "<?= base_url('halaman/') ?>" + data;
                            return `<a href='` + halamanUri + `' target='_blank'>` + halamanUri + '<i class="bi bi-box-arrow-up-right ms-2"></i></a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return data == "publikasi" ? "<span class='badge badge-success'><?= lang('Admin.publikasi') ?></span>" : "<span class='badge badge-warning'><?= lang('Admin.draf') ?></span>"
                        }
                        return data;
                    },
                },
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

            processBulkNew(tabel, "<?= base_url('/admin/halaman/hapus') ?>", options);
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

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            buttons.eq(2).removeClass("btn-secondary").addClass("btn-primary");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            var secondButton = buttons.eq(1);
            secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterHalaman",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterHalamanSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>' +
                '<li><button id="btnFilterHalamanPublikasi" class="dropdown-item" type="button"><?= lang('Admin.publikasi') ?></button></li>' +
                '<li><button id="btnFilterHalamanDraf" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);
            new mdb.Dropdown(secondButton); // Reinitialize dropdown

            // Filter button and status
            var filterButtons = {
                '#btnFilterHalamanSemua': null,
                '#btnFilterHalamanPublikasi': 'publikasi',
                '#btnFilterHalamanDraf': 'draf'
            };

            $.each(filterButtons, function(btnId, status) {
                $(btnId).on('click', function() {
                    filterStatus = status; // Update the filter status
                    // table1.ajax.reload(); // Reload the DataTable with the new filter
                    $('#iconFilterHalaman').hide();
                    $('#loaderFilterHalaman').show();
                    tabel.ajax.reload(function() {
                        $('#iconFilterHalaman').show();
                        $('#loaderFilterHalaman').hide();
                        $('#textFilterHalaman').html($(btnId).html());
                    });
                });
            });
        });

        // Add MDB styles to the search input after initialization
        tabel.on('init.dt', function() {
            $('div.dataTables_filter input').addClass('form-control form-control-md'); // Apply MDB form control styles
            $('div.dataTables_filter label').addClass('form-label'); // Apply MDB label styles
        });
    });
</script>
<?= $this->endSection() ?>