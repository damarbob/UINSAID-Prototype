<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-navbar py-64">

    <!-- Konten utama -->
    <div class="row p-3 p-md-0">

        <!-- Konten utama kiri -->
        <div class="col-lg-9">

            <div class="row">

                <h1 class="fw-bold">Ada apa di UIN Raden Mas Said?</h1>
                <p class="mb-5">Jelajah berita terkini</p>

                <!-- Daftar artikel terbaru -->
                <?php foreach ($berita as $key => $r) : ?>
                    <div class="col-lg-6 col-xl-4">
                        <!-- Item berita -->
                        <div class="card shadow mb-3" mdb-ripple-init>
                            <img src="<?= $r['gambar_sampul'] ?>" class="card-img-top" alt="..." />
                            <div class="card-body text-start">
                                <a href="<?= base_url() ?>berita/<?= $r['slug'] ?>">
                                    <h5 class="card-title lh-sm text-dark">
                                        <?= $r['judul'] ?>
                                    </h5>
                                </a>
                                <p class="card-text">
                                    <small class="text-body-secondary"><?= $r['created_at_terformat'] ?></small>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Akhir artikel terbaru -->
            </div>

            <!-- Paginasi -->
            <div class="d-flex">
                <?php //echo $pager->links('artikel', 'pager') 
                ?>
            </div>
            <!-- Akhir paginasi -->

        </div>
        <!-- Akhir konten utama kiri -->

        <!-- Sidebar kanan -->
        <!-- <div class="col-lg-3"> -->

        <!-- Pencarian -->
        <!-- <div class="row">
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control bg-light text-secondary" placeholder="Cari Artikel" aria-label="" aria-describedby="" id="" name="keyword" />
                            <div class="input-group-append">
                                <div class="tooltip"></div>
                                <button class="btn btn-danger rounded-start-0" type="submit">
                                    <span class="bi bi-search"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div> -->

        <!-- Artikel pilihan -->
        <?php
        // $this->include('layout/frontend/frontend_artikel_pilihan') 
        ?>

        <!-- </div> -->
        <!-- Akhir sidebar kanan -->

    </div>
    <!-- Akhir konten utama -->

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>