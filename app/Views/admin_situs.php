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

        <!-- <div class="table-responsive mt-3"> -->
        <table class="table table-hover" id="tabel" style="width: 100%;">
            <thead>
                <tr>
                    <td><?= lang('Admin.id') ?></td>
                    <td><?= lang('Admin.nama') ?></td>
                    <td><?= lang('Admin.alamatSitus') ?></td>
                    <td><?= lang('Admin.statusSitus') ?></td>
                    <td><?= lang('Admin.tanggal') ?></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
    $(document).ready(function() {
        var table1 = $('#tabel').DataTable({
            processing: true,
            // serverSide: true,
            // ajax: "/api/berita",
            ajax: {
                "url": "<?= base_url('api/situs') ?>",
                "type": "GET"
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    // Navigate to the Edit page
                    window.location.href = "<?= base_url('/admin/situs/sunting?id=') ?>" + id;
                });
            },
            "columns": [{
                    "data": "id",
                },
                {
                    "data": "nama",
                },
                {
                    "data": "alamat",
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        if (type === "display") {
                            return data == "active" ? "<?= lang('Admin.aktif') ?>" : "<?= lang('Admin.nonaktif') ?>"; // TODO: Translasi
                        }
                        return data;
                    }
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        if (type === 'display') {
                            // Return the formatted date for display
                            return formatDate(data);
                        }
                        return (data);
                    }
                },
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [{
                    type: 'date',
                    targets: 4,
                } // Specify the type of the fourth column as 'date'
            ],
            order: [
                [0, 'asc']
            ],
            select: true,
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-plus-lg"></i>',
                    action: function(e, dt, node, config) {
                        window.location.href = '<?= base_url('/admin/situs/tambah') ?>'
                    }
                },
                {
                    text: '<i id="iconFilterRilisMedia" class="bx bx-filter-alt me-2"></i><span id="loaderFilterRilisMedia" class="loader me-2" style="display: none;"></span><span id="textFilterRilisMedia"><?= lang('Admin.semua') ?></span>',
                },
                {
                    extend: 'selected',
                    text: '<i class="bi bi-power"></i>',
                    action: function(e, dt, node, config) {
                        // Konfirmasi nonaktifkan situs
                        Swal.fire({
                            icon: 'warning',
                            title: '<?= lang('Admin.kelolaSitus') ?>',
                            text: '<?= lang('Admin.lanjutkanMenonaktifkanSitus') ?>',
                            showCancelButton: true,
                            confirmButtonColor: "var(--mdb-danger)",
                            confirmButtonText: "<?= lang('Admin.nonaktifkan') ?>",
                            cancelButtonText: "<?= lang('Admin.batal') ?>",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                manageSites('shutdown');
                            }
                        });;
                    }
                },
                {
                    extend: 'selected',
                    text: '<i class="bi bi-play"></i>',
                    action: function(e, dt, node, config) {
                        // Konfirmasi aktifkan situs
                        Swal.fire({
                            icon: 'info',
                            title: '<?= lang('Admin.kelolaSitus') ?>',
                            text: '<?= lang('Admin.lanjutkanMengaktifkanSitus') ?>',
                            showCancelButton: true,
                            confirmButtonColor: "var(--mdb-primary)",
                            confirmButtonText: "<?= lang('Admin.aktifkan') ?>",
                            cancelButtonText: "<?= lang('Admin.batal') ?>",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                manageSites('restore');
                            }
                        });;
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
                title: "<?= lang('Admin.hapusItem') ?>",
                confirmMessage: "<?= lang('Admin.lanjutkanUntukMenghapusItem') ?>",
                errorMessage: "<?= lang('Admin.pilihItemDahulu') ?>",
                type: "warning",
                confirmButtonText: "<?= lang('Admin.hapus') ?>",
                cancelButtonText: "<?= lang('Admin.batal') ?>"
            };

            processBulk(table1, "<?= base_url('/admin/situs/hapus') ?>", options);
        }

        // Kelola shutdown/restore situs
        function manageSites(action) {
            // Get selected rows data
            var selectedData = $('#tabel').DataTable().rows('.selected').data().toArray();

            if (selectedData.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: '<?= lang('Admin.kelolaSitus') ?>',
                    text: '<?= lang('Admin.pilihItemDahulu') ?>',
                });
                return;
            }

            var apiUrl = (action === 'shutdown') ? '/api/shutdown' : '/api/restore';
            var responseMessages = [];
            var totalRequests = 0;

            // Iterate over each selected site and send an individual AJAX request
            selectedData.forEach(function(site) {
                $.ajax({
                    url: site.alamat + apiUrl,
                    type: 'POST',
                    headers: {
                        'X-API-Key': '<?= env('app.apiKey') ?>' // API Key from .env
                    },
                    data: JSON.stringify({
                        id: site.id,
                        alamat: site.alamat
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        // TODO: Translasi
                        responseMessages.push(`<p>${site.nama}: ${response.message || '<?= lang('Admin.tidakAdaResponsDiterima') ?>'}</p>`);
                    },
                    error: function(xhr, status, error) {
                        responseMessages.push(`<p>${site.nama}: ${xhr.responseText || error}</p>`);
                    },
                    complete: function() {
                        totalRequests++;

                        // After each request, check if all requests are done
                        if (totalRequests === selectedData.length) {
                            Swal.fire({
                                icon: 'info',
                                title: '<?= lang('Admin.tindakanSelesai') ?>',
                                html: responseMessages.join(''),
                            });

                            // Optionally, reload the DataTable to reflect changes
                            $('#tabel').DataTable().ajax.reload();
                        }
                    }
                });
            });
        }

        // Change button styles
        $('#tabel').on('preInit.dt', function() {
            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            buttons.eq(2).removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");
            buttons.eq(3).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");

            var secondButton = buttons.eq(1);
            secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
                id: "btnFilterRilisMedia",
                "data-mdb-ripple-init": "",
                "data-mdb-dropdown-init": "",
                "aria-expanded": "false"
            });

            // TODO: Translasi
            var newElement = $(
                '<ul class="dropdown-menu">' +
                '<li><button id="btnFilterRilisMediaSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDipublikasikan" class="dropdown-item" type="button"><?= lang('Admin.aktif') ?></button></li>' +
                '<li><button id="btnFilterRilisMediaDraft" class="dropdown-item" type="button"><?= lang('Admin.nonaktif') ?></button></li>' +
                '</ul>'
            );

            secondButton.after(newElement);

            var filterButtons = {
                '#btnFilterRilisMediaSemua': '<?= base_url('/api/situs') ?>',
                '#btnFilterRilisMediaDipublikasikan': '<?= base_url('/api/situs/aktif') ?>',
                '#btnFilterRilisMediaDraft': '<?= base_url('/api/situs/tidak-aktif') ?>'
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