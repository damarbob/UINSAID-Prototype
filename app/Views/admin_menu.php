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
                <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (session()->getFlashdata('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('gagal') ?>
                <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <table id="menuTable" class="table table-hover w-100">
            <thead>
                <tr>
                    <th><?= lang('Admin.induk') ?></th>
                    <th><?= lang('Admin.nama') ?></th>
                    <th><?= lang('Admin.link') ?></th>
                    <th><?= lang('Admin.urutan') ?></th>
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
        var tabel = $('#menuTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: {
                "url": "<?= base_url('api/menu') ?>",
                "type": "POST"
            },
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/menu/sunting?id='); ?>" + id;
                });
            },
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url("/admin/menu/tambah"); ?>'
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
            "columns": [ // Show parent_id's name (parent_nama)
                {
                    "data": "parent_nama",
                    "render": function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return '-'; // In case there's no parent category
                        }
                    }
                },
                // Show menu name
                {
                    "data": "nama"
                },
                // Conditionally render the link based on link_eksternal
                {
                    "data": "uri",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            if (row.link_eksternal == 0) {
                                var menuUri = "<?= base_url() ?>" + data;
                                return `<a href='` + menuUri + `' target='_blank'>` + menuUri + '<i class="bi bi-box-arrow-up-right ms-2"></i></a>';
                            } else {
                                return `<a href='` + data + `' target='_blank'>` + data + '<i class="bi bi-box-arrow-up-right ms-2"></i></a>';
                            }
                        }
                        return data;
                    }
                },
                // Show ordering (urutan)
                {
                    "data": "urutan"
                }
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

            processBulk(tabel, "<?= base_url('/admin/menu/hapus') ?>", options);
        }

        // Change button styles
        tabel.on('preInit.dt', function() {

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg"); // Buat grup tombol jadi besar

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            buttons.eq(2).removeClass("btn-secondary").addClass("btn-primary");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

        });

        // Add MDB styles to the search input after initialization
        tabel.on('init.dt', function() {
            $('div.dataTables_filter input').addClass('form-control form-control-md'); // Apply MDB form control styles
            $('div.dataTables_filter label').addClass('form-label'); // Apply MDB label styles
        });
    });
</script>
<?= $this->endSection() ?>