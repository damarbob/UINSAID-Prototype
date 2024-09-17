<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>

<!-- Notifikasi -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('fileBaru')): ?>
    <?php //dd(json_encode(session()->getFlashdata('fileBaru'))) 
    ?>
    <script>
        // Deserialize the string into a JavaScript object
        const deserializedData = JSON.parse('<?= json_encode(session()->getFlashdata('fileBaru')) ?>');

        // Post the message with the deserialized data included
        window.parent.postMessage({
            mceAction: 'singleFileUpload',
            data: {
                stringData: deserializedData
            }
        }, '*'); // FUTURE: Use proper target origin
    </script>
<?php endif; ?>

<div class="row">
    <div class="col">

        <div class="table-responsive mt-3">
            <table class="table table-hover w-100" id="tabelFile">
                <thead>
                    <tr>
                        <td><?= lang('Admin.id') ?></td>
                        <td><?= lang('Admin.file') ?></td>
                        <td><?= lang('Admin.judul') ?></td>
                        <td><?= lang('Admin.tanggal') ?></td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modal form unggah -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel"><?= lang('Admin.unggahFile') ?></h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/file/unggah') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file" class="form-label"><?= lang('Admin.unggahFile') ?></label>
                        <input type="file" class="form-control" name="file" id="file" accept=".csv, .pdf" required>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label"><?= lang('Admin.judul') ?></label>
                        <input type="text" class="form-control" name="judul" id="judul" placeholder="Title">
                    </div>
                    <div class="mb-3">
                        <label for="alt" class="form-label"><?= lang('Admin.teksAlternatif') ?></label>
                        <input type="text" class="form-control" name="alt" id="alt" placeholder="Alt Text">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= lang('Admin.unggah') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal sunting metadata -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><?= lang('Admin.file') . " " ?></h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php // base_url('admin/file/simpanMetadata/' . $key['id']) 
                                ?>" method="post" id="editForm">
                    <div class="mb-3">
                        <label for="editJudul" class="form-label"><?= lang('Admin.judul') ?></label>
                        <input type="text" class="form-control" name="judul" id="editJudul" placeholder="Title">
                    </div>
                    <div class="mb-3">
                        <label for="editAlt" class="form-label"><?= lang('Admin.teksAlternatif') ?></label>
                        <input type="text" class="form-control" name="alt" id="editAlt" placeholder="Alt Text">
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label"><?= lang('Admin.deskripsi') ?></label>
                        <textarea class="form-control" name="deskripsi" id="editDeskripsi" placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success" data-mdb-ripple-init><i class='bx bx-check me-2'></i><?= lang('Admin.simpan') ?></button>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/formatter.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/datatables_process_bulk.js') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        const uploadModal = new mdb.Modal($('#uploadModal'));
        const editModal = new mdb.Modal($('#editModal'));

        var table1 = $('#tabelFile').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('api/file') ?>",
                "type": "POST"
            },
            "rowCallback": function(row, data, index) {
                // Add double-click event to navigate to Edit page
                $(row).on('dblclick', function() {
                    // Get the ID from the data
                    var id = data.id;

                    $('#editJudul').val(data.judul);
                    $('#editAlt').val(data.alt);
                    $('#editDeskripsi').val(data.deskripsi);
                    $('#editForm').attr('action', `<?= base_url('/admin/file/simpanMetadata/') ?>${id}`);
                    editModal.show();
                });

                $(row).on('select', function() {
                    const hapusButton = document.getElementById('multiDeleteBtn');

                });
            },
            "columns": [{
                    "data": "id",
                },
                {
                    "data": "uri",
                    "render": function(data, type, row) {
                        return type === "display" ? `<a href="${data}" target="_blank">${data}<i class="bi bi-box-arrow-up-right ms-2"></i></a>` : data;
                    }
                },
                {
                    "data": "judul",
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row) {
                        // console.log(data);
                        return type === "display" ? formatDate(data) : data;
                    }
                }
            ],
            order: [
                [0, 'desc']
            ],
            "language": {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            select: true,
            dom: '<"mb-4"<"d-flex flex-column flex-md-row align-items-center mb-2"<"flex-grow-1 align-self-start"B><"align-self-end ps-2 pt-2 pt-md-0 mb-0"f>>r<"table-responsive"t><"d-flex flex-column flex-md-row align-items-center mt-2"<"flex-grow-1 order-2 order-md-1 mt-2 mt-md-0"i><"align-self-end order-1 order-md-2"p>>>',
            buttons: [{
                    text: '<i class="bi bi-upload"></i>',
                    action: function(e, dt, node, config) {
                        // window.location.href = '<?= base_url('/admin/agenda/tambah') ?>'
                        uploadModal.show();
                    }
                },
                // {
                //     text: '<i id="iconFilter" class="bx bx-filter-alt me-2"></i><span id="loaderFilter" class="loader me-2" style="display: none;"></span><span id="textFilter"><?= lang('Admin.semua') ?></span>',
                // },
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

            processBulk(table1, "<?= base_url('/admin/file/hapus') ?>", options);
        }

        // Change button styles
        $('#tabelFile').on('preInit.dt', function() {

            var buttons = $(".dt-buttons.btn-group.flex-wrap .btn.btn-secondary");
            var lastButton = buttons.last();

            // Reinitialize the ripple effect for the new button
            buttons.each(function() {
                new mdb.Ripple(this); // This will reinitialize the ripple effect on all elements with the data-mdb-ripple-init attribute
            })

            buttons.eq(0).removeClass("btn-secondary").addClass("btn-primary").addClass("rounded-0");
            lastButton.removeClass("btn-secondary").addClass("btn-danger").addClass("rounded-0");

            $(".dt-buttons.btn-group.flex-wrap").addClass("btn-group-lg");

            // var secondButton = buttons.eq(1);
            // secondButton.addClass("dropdown-toggle").wrap('<div class="btn-group"></div>').attr({
            //     id: "btnFilter",
            //     "data-mdb-ripple-init": "",
            //     "data-mdb-dropdown-init": "",
            //     "aria-expanded": "false"
            // });

            // var newElement = $(
            //     '<ul class="dropdown-menu">' +
            //     '<li><button id="btnFilterSemua" class="dropdown-item" type="button"><?= lang('Admin.semua') ?></button></li>' +
            //     '<li><button id="btnFilterPublikasi" class="dropdown-item" type="button"><?= lang('Admin.publikasi') ?></button></li>' +
            //     '<li><button id="btnFilterDraf" class="dropdown-item" type="button"><?= lang('Admin.draf') ?></button></li>' +
            //     '</ul>'
            // );

            // secondButton.after(newElement);
            // new mdb.Dropdown(secondButton); // Reinitialize dropdown

            // var filterButtons = {
            //     '#btnFilterSemua': '<?= base_url('/api/agenda') ?>',
            //     '#btnFilterPublikasi': '<?= base_url('/api/agenda/publikasi') ?>',
            //     '#btnFilterDraf': '<?= base_url('/api/agenda/draf') ?>'
            // };

            // $.each(filterButtons, function(btnId, apiUrl) {
            //     $(btnId).on('click', function() {
            //         $('#iconFilter').hide();
            //         $('#loaderFilter').show();
            //         table1.ajax.url(apiUrl).load(function() {
            //             $('#iconFilter').show();
            //             $('#loaderFilter').hide();
            //             $('#textFilter').html($(btnId).html());
            //         });
            //     });
            // });
        });

    });
</script>
<?= $this->endSection() ?>