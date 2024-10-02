<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta dipisah -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="<?= base_url('assets/img/aptmi-logo.png') ?>" />

    <title><?= $this->renderSection('title'); ?></title>

    <!-- MDB -->
    <link id="mdbCSS" rel="stylesheet" href="<?= base_url("assets/css/hijau.css") ?>" />

    <!-- Import Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- End Bootstrap Icon -->

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <!-- import aos animasi on scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <!-- Import Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>" />
    <!-- End Custom CSS -->

    <!-- Style -->
    <?= $this->renderSection('style'); ?>

</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Section konten auth -->
    <section class="vw-100 vh-100 d-flex justify-content-center align-items-center">
        <div class="container d-flex justify-content-center align-items-center m-auto">
            <div class="card col-12 col-md-8 col-xl-4 rounded-0 py-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="/">
                        <img class="w-50" src="<?= base_url('assets/img/logo-horizontal-pb.png') ?>" id="logo" alt="Logo" />
                    </a>
                </div>

                <!-- Konten halaman -->
                <div class="card-body">

                    <!-- Page content -->
                    <?= $this->renderSection('content'); ?>
                </div>

            </div>
        </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

    <!-- Script -->
    <?= $this->renderSection('script'); ?>

</body>

</html>