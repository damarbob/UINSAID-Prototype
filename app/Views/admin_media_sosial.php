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
                <a href="<?= base_url('admin/media-sosial') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                <?= session()->getFlashdata('sukses') ?>
            </div>
        <?php elseif (session()->getFlashdata('galat')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <a href="<?= base_url('admin/media-sosial') ?>" class="me-2"><i class="bi bi-arrow-left"></i></a>
                <?= session()->getFlashdata('galat') ?>
            </div>
        <?php endif; ?>

        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover w-100" id="tabel">
            <thead>
                <tr>
                    <td><?= lang('Admin.urutan') ?></td>
                    <td><?= lang('Admin.nama') ?></td>
                    <td><?= lang('Admin.alamatSitus') ?></td>
                    <td><?= lang('Admin.ikon') ?></td>
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
        var table1 = $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            pageLength: <?= $barisPerHalaman ?>, // Acquired from settings
            ajax: {
                "url": "<?= base_url('api/media-sosial') ?>",
                "type": "POST"
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/media-sosial/sunting?id=') ?>" + id;
                });
            },
            "columns": [{
                    "data": "urutan",
                },
                {
                    "data": "nama",
                },
                {
                    "data": "url",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            var url = data;
                            return `<a href='` + url + `' target='_blank'>` + url + '<i class="bi bi-box-arrow-up-right ms-2"></i></a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "ikon",
                    "render": function(data, type, row) {
                        if (type === 'display' && data) {
                            var ikonUrl = "<?= base_url('') ?>" + data;
                            return `<a href='` + ikonUrl + `' target='_blank'>` + getFilenameAndExtension(ikonUrl) + '<i class="bi bi-box-arrow-up-right ms-2"></i></a>';
                        }
                        return data;
                    }
                },
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    type: 'date',
                    targets: 3
                } // Specify the type of the second column as 'date'
            ],
            order: [
                [0, 'asc']
            ],
            select: true,
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url('/admin/media-sosial/tambah') ?>'
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
        });

        // Fitur hapus massal
        function hapusBanyak() {
            var options = {
                title: "<?= lang('Admin.hapusAgenda') ?>",
                confirmMessage: "<?= lang('Admin.hapusAgendaKonfirmasi') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.hapus') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "<?= base_url('/admin/agenda/hapus') ?>", options);
        }


        // Change button styles
        $('#tabel').on('preInit.dt', function() {

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            // Reinitialize the ripple effect for the new button
            buttons.each(function() {
                new mdb.Ripple(this); // This will reinitialize the ripple effect on all elements with the data-mdb-ripple-init attribute
            })

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg"); // Make it LARGE

        });

    });
</script>
<?= $this->endSection() ?>