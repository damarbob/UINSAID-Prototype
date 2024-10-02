<?php
helper('setting');

$context = 'user:' . user_id(); //  Context untuk pengguna
$barisPerHalaman = setting()->get('App.barisPerHalaman', $context) ?: 10;
?>
<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <table id="tabel" class="table table-hover w-100">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th><?= lang('Admin.nama') ?></th>
                    <th>CSS</th>
                    <th>JS</th>
                    <th><?= lang('Admin.grup') ?></th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk_new.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var tabel = $('#tabel').DataTable({
            serverSide: true,
            processing: true,
            select: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: {
                "url": "<?= base_url('api/komponen') ?>",
                "type": "POST"
            },
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            dom: '<"row gy-2 mb-2"<"col-lg-6"B><"col-lg-6"f>>r<"table-responsive"t><"row gy-2"<"col-md-6"i><"col-md-6"p>><"row my-2"<"col">>',
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/komponen/sunting/'); ?>" + id;
                });
            },
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url("/admin/komponen/tambah"); ?>'
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
            "columns": [{
                    "data": "nama",
                },
                {
                    "data": "css",
                    "render": function(data, type, row) {
                        if (type === "display" && data != null && data != '') {
                            return '<a href="' + data + '" target="_blank">' +
                                getFilenameAndExtension(data) + '<i class="bi bi-box-arrow-up-right ms-2"></i>' +
                                '</a>'
                        }
                        return data
                    }
                },
                {
                    "data": "js",
                    "render": function(data, type, row) {
                        if (type === "display" && data != null && data != '') {
                            return '<a href="' + data + '" target="_blank">' +
                                getFilenameAndExtension(data) + '<i class="bi bi-box-arrow-up-right ms-2"></i>' +
                                '</a>'
                        }
                        return data
                    }
                },
                {
                    "data": "grup",
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

            processBulkNew(tabel, "<?= base_url('/admin/komponen/hapus') ?>", options);
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
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");
        });
    });
</script>
<?= $this->endSection() ?>