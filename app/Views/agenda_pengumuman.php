<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-navbar pt-5">

    <div class="row mb-4">
        <div class="col">
            <h1 class="fw-bold"><?= $judul ?></h1>
            <div class="lurik-3"></div>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="row g-3">

        <!-- Daftar agenda pengumuman terbaru -->
        <?php foreach ($item as $x) : ?>
            <div class="col-lg-6 col-xl-3">
                <!-- Item berita -->
                <div class="card shadow card-agenda h-100"
                    data-mdb-ripple-init>
                    <div class="ratio ratio-4x3">
                        <img src="<?= ($x['id_galeri'] != null) ? $x['uri'] : base_url('assets/img/icon-notext.png') ?>" class="card-img-top object-fit-contain" alt="..." />
                    </div>
                    <div class="card-body text-start">
                        <p class="card-text"><?= $x['formatted_datetime'] ?>
                            <?php if ($x['waktu_selesai'] && strtotime($x['waktu_selesai']) < time()): ?>
                                <span class="badge badge-secondary" style="width: max-content;"><?= lang('Admin.selesai') ?></span>
                            <?php elseif ($x['waktu_selesai'] && strtotime($x['waktu_mulai']) < time() && strtotime($x['waktu_selesai']) > time()): ?>
                                <span class="badge badge-danger" style="width: max-content;"><?= lang('Admin.berlangsung') ?></span>
                            <?php elseif (!$x['waktu_selesai'] && strtotime($x['waktu_mulai']) < time()): ?>
                                <span class="badge badge-secondary" style="width: max-content;"><?= lang('Admin.selesai') ?></span>
                            <?php else: ?>
                                <span class="badge badge-primary" style="width: max-content;"><?= lang('Admin.akanDatang') ?></span>
                            <?php endif; ?>
                        </p>
                        <a href="<?= base_url('agenda-pengumuman/' . $x['slug']) ?>">
                            <h5 class="card-title lh-sm line-clamp-4">
                                <?= $x['judul'] ?>
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- Akhir agenda pengumuman terbaru -->

    </div>
    <!-- Akhir konten utama -->

    <div class="row mt-5">
        <!-- Paginasi -->
        <div class="d-flex">
            <?php // $pagerAgenda->links('agenda_pengumuman', 'pager') 
            ?>
            <?= $pager ?>
        </div>
        <!-- Akhir paginasi -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<?= $this->endSection() ?>