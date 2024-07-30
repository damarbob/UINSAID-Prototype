<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<div class="card container mb-2">
    <div class="card-body">
        <a class="btn btn-light" href="javascript:window.history.back();"><i class="bi bi-arrow-left"></i></a>
        <button id="btnTandaiBelumTerbaca" class="btn btn-primary"><i class="bi bi-envelope-exclamation-fill"></i></button>
    </div>
</div>
<div class="card container mb-5">
    <div class="card-body">

        <p class="mb-5"><?= lang('Admin.diterimaPada') ?> <b><?= $kotakMasuk['created_at_terformat'] ?></b></p>
        <p class="mb-2 fw-bold"><?= lang('Admin.pesan') ?></p>
        <p class="mb-5"><?= $kotakMasuk['isi'] ?></p>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {

        // Script untuk menandai bahwa pesan telah dibaca
        var ajaxTandaiTerbaca = {
            url: "/admin/kotak-masuk/tandai/terbaca",
            type: "POST",
            data: {
                selectedIds: [<?= $kotakMasuk['id'] ?>] // Buat ID jadi array karena API hanya menerima array
            }
        };

        <?php if (ENVIRONMENT === 'development') : ?> // Jika environment adalah development, log respons AJAX
            ajaxTandaiTerbaca.success = function(response) {
                console.log(response.message);
            };
            ajaxTandaiTerbaca.error = function(error) {
                // Handle the error response from the server
                console.error(error);
            };
        <?php endif ?>

        // Script untuk menandai bahwa pesan telah dibaca
        var ajaxTandaiBelumTerbaca = {
            url: "/admin/kotak-masuk/tandai/belum_terbaca",
            type: "POST",
            data: {
                selectedIds: [<?= $kotakMasuk['id'] ?>] // Buat ID jadi array karena API hanya menerima array
            }
        };

        <?php if (ENVIRONMENT === 'development') : ?> // Jika environment adalah development, log respons AJAX
            ajaxTandaiBelumTerbaca.success = function(response) {
                javascript: window.history.back();
                console.log(response.message);
            };
            ajaxTandaiBelumTerbaca.error = function(error) {
                // Handle the error response from the server
                console.error(error);
            };
        <?php else : ?>
            ajaxTandaiBelumTerbaca.success = function(response) {
                javascript: window.history.back();
            }
        <?php endif ?>

        $.ajax(ajaxTandaiTerbaca);

        // Attach click event handler to an element with id "myButton"
        $('#btnTandaiBelumTerbaca').click(function() {

            $.ajax(ajaxTandaiBelumTerbaca);
        });
    });
</script>
<?= $this->endSection() ?>