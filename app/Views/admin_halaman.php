<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <table id="halamanTable" class="table table-hover w-100">
            <thead>
                <tr>
                    <th><?= lang('Admin.judul') ?></th>
                    <th><?= lang('Admin.alamatHalaman') ?></th>
                    <th><?= lang('Admin.status') ?></th>
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
        var tabel = $('#halamanTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            order: [
                [0, 'asc']
            ],
            ajax: {
                "url": "<?= base_url('api/halaman') ?>",
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
                    text: '<i id="iconFilterRilisMedia" class="bx bx-filter-alt me-2"></i><span id="loaderFilterRilisMedia" class="loader me-2" style="display: none;"></span><span id="textFilterRilisMedia"><?= lang('Admin.semua') ?></span>',
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
                },
                {
                    "data": "slug",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            var halamanUri = "<?= base_url('halaman/') ?>" + data;
                            return `<a href='` + halamanUri + `' target='_blank'>` + halamanUri + '<i class="bi bi-box-arrow-up-right ms-2"></i></a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            return data == "publikasi" ? "<?= lang('Admin.publikasi') ?>" : "<?= lang('Admin.draf') ?>";
                        }
                        return data;
                    }
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

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            buttons.eq(2).removeClass("btn-secondary").addClass("btn-primary");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

        });
    });
</script>
<?= $this->endSection() ?>