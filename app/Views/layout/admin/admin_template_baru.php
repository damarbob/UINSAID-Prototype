<?php

helper('setting');

$context = 'user:' . user_id(); //  Context untuk pengguna
$isTemaDasborAdminGelap = setting()->get('App.temaDasborAdmin', $context);

// Tema default
$temaDefault = base_url("assets/css/hijau.css");
// dd($tema);
?>
<!DOCTYPE html>
<html lang="en" <?= $isTemaDasborAdminGelap === 'gelap' ? 'data-mdb-theme="dark"' : '' ?>>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url(setting()->get('App.ikonSitus')) ?>" />

    <!-- Import font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- End import font awesome -->
    <!-- Import font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,600,600i,700,700i&display=swap|Lato:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />
    <!-- End Font -->
    <!-- Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-beta.2.20241031/dist/js/adminlte.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/adminlte4@4.0.0-beta.2.20241031/dist/css/adminlte.min.css" rel="stylesheet">
    <!-- End of AdminLTE -->
    <!-- MDB -->
    <link id="mdbCSS" rel="stylesheet" href="<?= isset($temaSitus['css']) && $temaSitus['css'] != "" ? base_url($temaSitus['css']) : $temaDefault ?>" />
    <!-- End MDB -->
    <!-- Import Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
    <!-- End Bootstrap Icon -->
    <!-- Boxicons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet" />

    <!-- Datatables -->
    <!-- <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    </link>
    <link ref="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" /> -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.css" rel="stylesheet">

    <!-- Import Custom CSS -->
    <!-- <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>" /> -->
    <!-- <link rel="stylesheet" href="<?= base_url('/assets/css/style-admin.css') ?>" /> -->
    <?= $this->renderSection('style') ?>
    <title><?= $judul ?></title>
</head>

<!-- <body id="body-pd"> -->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">
        <?= $this->renderSection('body'); ?>

        <?= $this->include('layout/admin/admin_navbar'); ?>
        <?= $this->include('layout/admin/admin_sidebar'); ?>

        <main class="app-main">
            <!-- Page content -->
            <?= $this->renderSection('content'); ?>
        </main>

    </div>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Script -->
    <?= $this->renderSection('script'); ?>

    <!-- Import Bootstrap JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     // Use setTimeout to delay by 0.1 seconds
        //     setTimeout(function() {
        //         // Create a new script element
        //         var scriptElement = document.createElement("script");

        //         // Set the script source to the desired URL
        //         scriptElement.src = "https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js";

        //         // Append the script element to the document body
        //         document.body.appendChild(scriptElement);
        //     }, 100); // 100 milliseconds (0.1 seconds) delay
        // });
    </script>

    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/af-2.6.0/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/cr-1.7.0/date-1.5.1/fc-4.3.0/fh-3.4.0/kt-2.11.0/r-2.5.0/rg-1.4.1/rr-1.4.1/sc-2.3.0/sb-1.6.0/sp-2.2.0/sl-1.7.0/sr-1.3.0/datatables.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script type="text/javascript">
        const inIframe = window.self !== window.top; // Check if loaded inside an iframe

        // Adjust UI to disable sidebar if in iframe
        if (inIframe) {
            $('#body-pd').addClass('ps-3');
            $('#body-pd').css('transition', 'none');
            $('#header-admin').addClass('ps-3');
            $('#headerToggleButton').hide();
            // $('#header-toggle').addClass('m-0');
            $('#nav-bar').hide();
        }

        document.addEventListener("DOMContentLoaded", function(event) {

            // Show navbar function
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId);

                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener("click", () => {
                        // show navbar
                        nav.classList.toggle("show-sidebar");
                        // change icon
                        toggle.classList.toggle("bx-x");
                        // add padding to body
                        bodypd.classList.toggle("body-pd");
                        // add padding to header
                        headerpd.classList.toggle("body-pd");
                    });
                }
            };

            showNavbar("header-toggle", "nav-bar", "body-pd", "header-admin");
        });
    </script>
    <script>
        // Light mode/dark mode
        $(document).ready(function() {

            // const htmlElement = $("html");
            // const currentTheme = localStorage.getItem("mdb-theme") || "light";

            // // Set the initial theme
            // htmlElement.attr("data-mdb-theme", currentTheme);

            // // Toggle theme on button click
            // $("#themeToggle").click(function() {
            //     console.log("Switched theme");
            //     const newTheme =
            //         htmlElement.attr("data-mdb-theme") === "light" ? "dark" : "light";
            //     htmlElement.attr("data-mdb-theme", newTheme);
            //     localStorage.setItem("mdb-theme", newTheme);
            // });

        });
    </script>

</body>

</html>