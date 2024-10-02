<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<script src="<?= base_url('assets/js/formatter_frontend.js') ?>" type="text/javascript"></script>
<!-- jsonlint for strict JSON -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsonlint/1.6.0/jsonlint.min.js"></script>
<!-- JSON5 for relaxed JSON -->
<script src="https://unpkg.com/json5@2/dist/index.min.js"></script>

<?php if ($halaman['css']): ?>
    <link rel="stylesheet" href="<?= base_url($halaman['css']) ?>" type="text/css" />
<?php endif; ?>
<?php foreach ($komponen as $k): ?>
    <?php if ($k['css']): ?>
        <link rel="stylesheet" href="<?= base_url($k['css']) ?>" type="text/css" />
    <?php endif; ?>
<?php endforeach; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mt-navbar">
    <?php foreach ($komponen as $k): ?>
        <?php echo $k['konten_terformat'] /*eval('?>' . $k['konten_terformat'])*/ ?>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php if ($halaman['js']): ?>
    <script type="text/javascript" src="<?= $halaman['js'] ?>"></script>
<?php endif; ?>
<?php foreach ($komponen as $k): ?>
    <?php if ($k['js']): ?>
        <script type="text/javascript" src="<?= $k['js'] ?>"></script>
    <?php endif; ?>
<?php endforeach; ?>
<?= $this->endSection() ?>