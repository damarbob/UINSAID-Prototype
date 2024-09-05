<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('meta') ?>

<?= $this->endSection() ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section
    class="hero"
    class="bg-primary p-0 d-flex align-items-center justify-content-center mt-navbar"
    style="background: url('<?= $entitas['gambar_sampul'] ?>');">
</section>

<!-- Nama -->
<section class="menu-title d-flex align-items-center gradient-1">
    <div class="lurik align-self-start"></div>
    <div class="container text-center">
        <h1><?= $entitas['nama'] ?></h1>
    </div>
    <div class="lurik-2 align-self-end"></div>
</section>

<section>
    <div class="container px-5 mt-sm-5 pt-md-5 mb-5">
        <div class="row">

            <!-- Konten -->
            <div class="col-lg-6">
                <?= $entitas['deskripsi'] ?>
            </div>

            <!-- Gambar sampul dan kontak -->
            <div class="col-lg-6">
                <div class="p-2 p-lg-4 rounded-5" style="background: rgba(var(--mdb-primary-rgb), 0.10)">
                    <!-- <img src="<?= $entitas['gambar_sampul'] ?>"> -->
                    <h2>Informasi</h2>
                    <div class="lurik-3 align-self-end mb-4"></div>
                    <table class="table table-sm table-borderless" style="background: none !important;">
                        <tbody>
                            <tr>
                                <td class="table-fit">Alamat</td>
                                <td class="table-fit">:</td>
                                <td><?= $entitas['alamat'] ?></td>
                            </tr>
                            <tr>
                                <td class="table-fit">Telepon</td>
                                <td class="table-fit">:</td>
                                <td><?= $entitas['telepon'] ?></td>
                            </tr>
                            <tr>
                                <td class="table-fit">Fax</td>
                                <td class="table-fit">:</td>
                                <td><?= $entitas['fax'] ?></td>
                            </tr>
                            <tr>
                                <td class="table-fit">Email</td>
                                <td class="table-fit">:</td>
                                <td><?= $entitas['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Website</td>
                                <td>:</td>
                                <td><?= $entitas['website'] ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Tombol kunjungi website -->
                    <a href="<?= $entitas['website'] ?>" class="btn btn-primary" target="_blank" data-mdb-ripple-init>
                        <i class="bi bi-box-arrow-up-right me-2"></i>
                        Kunjungi Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>