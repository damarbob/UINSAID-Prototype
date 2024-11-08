<?php
// Get the current request instance
$request = service('request');

// Get the URI string
$currentRoute = $request->uri->getSegment(1) . "/" . $request->uri->getSegment(2);
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $judul ?></title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Sidebar Mini">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-beta.2.20241031/dist/js/adminlte.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-beta.2.20241031/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- End of AdminLTE -->
    <!-- Boxicons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />
    <?= $this->renderSection('style') ?>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                    <!-- <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Contact</a> </li> -->
                    <li class="nav-item">
                        <span class="nav-link fs-6 fw-bold"><?= $judul; ?></span>
                    </li>
                </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->

                    <!--begin::Fullscreen Toggle-->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                        </a>
                    </li> <!--end::Fullscreen Toggle-->

                    <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img id="profileImage" class="user-image rounded-circle shadow" alt="User Image">
                            <!-- JavaScript -->
                            <script>
                                // Get the CSS variable values
                                const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-primary').trim().replace('#', '');
                                const bodyBgColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-body-bg').trim().replace('#', '');

                                // Get the username and create the URL
                                const username = '<?= urlencode(auth()->user()->username) ?>'; // PHP-generated username
                                const imgUrl = `https://ui-avatars.com/api/?size=32&name=${username}&rounded=true&background=${primaryColor}&color=${bodyBgColor}&bold=true`;

                                // Set the image source
                                document.getElementById('profileImage').src = imgUrl;
                            </script>
                            <span class="d-none d-md-inline"><?= auth()->user()->username ?></span>
                        </a>
                    </li> <!--end::User Menu Dropdown-->

                </ul> <!--end::End Navbar Links-->
            </div> <!--end::Container-->
        </nav>
        <!--end::Header-->

        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand"> <!--begin::Brand Link-->
                <a href="../index.html" class="brand-link"> <!--begin::Brand Image-->
                    <img src="<?= base_url(setting()->get('App.logoSitus') ?: 'assets/img/logo-horizontal-pb-new.png') ?>" class="brand-image">
                    <span class="brand-text fw-light">UINSAID</span> <!--end::Brand Text-->
                </a> <!--end::Brand Link-->
            </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="true">

                        <!-- Dasbor -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/dasbor') ?>" class="nav-link <?= $currentRoute == "admin/dasbor" ? "active" : "" ?>">
                                <i class='nav-icon bx bx-grid'></i>
                                <p><?= lang('Admin.dasbor') ?></p>
                            </a>
                        </li>

                        <li class="nav-header"><?= lang('Admin.konten') ?></li>

                        <!-- Konten -->

                        <!-- Posting -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/posting') ?>" class="nav-link <?= $currentRoute == "admin/posting" ? "active" : "" ?>">
                                <i class="nav-icon bx bx-news"></i>
                                <p><?= lang('Admin.posting') ?></p>
                                <?php if ($peringatanPostingKosong || $peringatanPostingTigaBulan) : ?>
                                    <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger">
                                        !
                                        <span class="visually-hidden">peringatan rilis media</span>
                                    </span>
                                <?php endif ?>
                            </a>
                        </li>

                        <!-- Posting diajukan -->
                        <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/posting-diajukan') ?>" class="nav-link <?= $currentRoute == "admin/posting-diajukan" ? "active" : "" ?>">
                                    <i class="nav-icon bx bx-mail-send"></i>
                                    <p><?= lang('Admin.postingDiajukan') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                        <!-- End of konten -->

                        <?php if (ENVIRONMENT == 'development'): ?>
                            <!-- Acara (development, hidden) -->
                            <div class="nav-item d-none">
                                <a href="<?= base_url('admin/acara') ?>" class="nav-link <?= $currentRoute == "admin/acara" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="<?= lang('Admin.acara') ?>">
                                    <i class='bx bx-calendar-star nav-icon'></i>
                                    <p><?= lang('Admin.acara') ?></p>
                                </a>
                            </div>
                        <?php endif ?>

                        <li class="nav-header"><?= lang('Admin.kegiatan') ?></li>

                        <!-- Kegiatan -->

                        <!-- Agenda -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/agenda') ?>" class="nav-link <?= $currentRoute == "admin/agenda" ? "active" : "" ?>">
                                <i class='bx bx-calendar-event nav-icon'></i>
                                <p><?= lang('Admin.agenda') ?></p>
                            </a>
                        </li>

                        <!-- Pengumuman -->
                        <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/pengumuman') ?>" class="nav-link <?= $currentRoute == "admin/pengumuman" ? "active" : "" ?>">
                                    <i class='bx bxs-megaphone nav-icon'></i>
                                    <p class="nav_name"><?= lang('Admin.pengumuman') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                        <!-- End of kegiatan -->

                        <li class="nav-header"><?= lang('Admin.unggahan') ?></li>

                        <!-- Unggahan -->


                        <!-- Galeri -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/galeri') ?>" class="nav-link <?= $currentRoute == "admin/galeri" ? "active" : "" ?>">
                                <i class='bx bx-images nav-icon'></i>
                                <p><?= lang('Admin.galeri') ?></p>
                            </a>
                        </li>

                        <!-- File -->
                        <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/file') ?>" class="nav-link <?= $currentRoute == "admin/file" ? "active" : "" ?>">
                                    <i class='bx bx-folder-open nav-icon'></i>
                                    <p class="nav_name"><?= lang('Admin.file') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                        <!-- End of unggahan -->

                        <?php if (auth()->user()->inGroup("superadmin")): ?>

                            <li class="nav-header"><?= lang('Admin.editor') ?></li>

                            <!-- Halaman -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/halaman') ?>" class="nav-link <?= $currentRoute == "admin/halaman" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Halaman">
                                    <i class='bx bx-file nav-icon'></i>
                                    <p><?= lang('Admin.halaman') ?></p>
                                </a>
                            </li>

                            <!-- Menu -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/menu') ?>" class="nav-link <?= $currentRoute == "admin/menu" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Menu">
                                    <i class='bx bx-food-menu nav-icon'></i>
                                    <p><?= lang('Admin.menu') ?></p>
                                </a>
                            </li>

                            <!-- Entitas -->
                            <!-- Entitas editor hanya untuk role superadmin -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/entitas') ?>" class="nav-link <?= $currentRoute == "admin/entitas" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Entitas">
                                    <i class='bx bx-hive nav-icon'></i>
                                    <p>
                                        <?= lang('Admin.entitas') ?>
                                    </p>
                                </a>
                            </li>

                            <!-- End of editor -->
                        <?php endif ?>

                        <li class="nav-header"><?= lang('Admin.lainnya') ?></li>

                        <!-- Pengguna -->
                        <?php if (auth()->user()->inGroup("superadmin")): ?>
                            <!-- Pengguna hanya untuk superadmin -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/pengguna') ?>" class="nav-link <?= $currentRoute == "admin/pengguna" ? "active" : "" ?>">
                                    <i class='nav-icon bx bxs-user-account'></i>
                                    <p><?= lang('Admin.pengguna') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                        <!-- Kelola situs -->
                        <?php if ((env('app.siteType') == 'parent' || env('app.siteType') == 'super') && auth()->user()->inGroup("superadmin")): ?>
                            <!-- Kelola situs hanya untuk situs non-child dan superadmin -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/situs') ?>" class="nav-link <?= $currentRoute == "admin/situs" ? "active" : "" ?>">
                                    <i class='nav-icon bx bxs-network-chart'></i>
                                    <p><?= lang('Admin.kelolaSitus') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                        <!-- Pengaturan -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/pengaturan') ?>" class="nav-link">
                                <i class='nav-icon bx bx-cog'></i>
                                <p><?= lang('Admin.pengaturan') ?></p>
                            </a>
                        </li>

                        <!--  -->

                    </ul>
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> <!--end::Sidebar--> <!--begin::App Main-->
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Sidebar Mini</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Sidebar Mini
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-12"> <!-- Default box -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Title</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div>
                                <div class="card-body">
                                    Start creating your amazing application!
                                </div> <!-- /.card-body -->
                                <div class="card-footer">Footer</div> <!-- /.card-footer-->
                            </div> <!-- /.card -->
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->
        <footer class="app-footer"> <!--begin::To the end-->
            <div class="float-end d-none d-sm-inline">Anything you want</div> <!--end::To the end--> <!--begin::Copyright--> <strong>
                Copyright &copy; 2014-2024&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer> <!--end::Footer-->
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
</body><!--end::Body-->

</html>