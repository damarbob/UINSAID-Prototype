<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<?php if ($halaman['css']): ?>
    <script type="text/javascript" src="<?= base_url("assets/css/" . $halaman['css']) ?>"></script>
<?php endif; ?>
<?php foreach ($komponen as $k): ?>
    <?php if ($k['css']): ?>
        <script type="text/javascript" src="<?= base_url("assets/css/" . $k['css']) ?>"></script>
    <?php endif; ?>
<?php endforeach; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mt-navbar">
    <?php foreach ($komponen as $k): ?>
        <div>
            <?php eval('?>' . $k['konten_terformat']) ?>
            <?php if ($k['css']): ?>
                <link rel="stylesheet" href="<?= base_url($k['css']) ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?php if ($halaman['js']): ?>
    <script type="text/javascript" src="<?= base_url("assets/js/" . $halaman['js']) ?>"></script>
<?php endif; ?>
<?php foreach ($komponen as $k): ?>
    <?php if ($k['js']): ?>
        <script type="text/javascript" src="<?= base_url("assets/js/" . $k['js']) ?>"></script>
    <?php endif; ?>
<?php endforeach; ?>
<?= $this->endSection() ?>