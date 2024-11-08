<!-- <header id="header-admin" class="header navbar navbar-expand" style="background: var(--mdb-body-bg)"> -->
<nav class="app-header navbar navbar-expand bg-body" data-bs-theme="light">

    <!-- <div class="header_toggle me-3 me-md-4" id="headerToggleButton">
        <i class="bx bx-menu" id="header-toggle"></i>
    </div> -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav w-100">

        <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
            </a>
        </li>

        <li class="nav-item">
            <p class="nav-link fs-6 fw-bold"><?= $judul; ?></p>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow ms-auto">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-mdb-dropdown-init aria-haspopup="true" aria-expanded="false">
                <span class="me-2 d-none d-lg-inline small"><?= auth()->user()->username ?></span>

                <!-- Profile image -->
                <img id="profileImage" class="img-profile rounded-circle" src="" alt="Profile Image">

                <!-- JavaScript -->
                <script>
                    // Get the CSS variable values
                    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--mdb-primary').trim().replace('#', '');
                    const bodyBgColor = getComputedStyle(document.documentElement).getPropertyValue('--mdb-body-bg').trim().replace('#', '');

                    // Get the username and create the URL
                    const username = '<?= urlencode(auth()->user()->username) ?>'; // PHP-generated username
                    const imgUrl = `https://ui-avatars.com/api/?size=32&name=${username}&rounded=true&background=${primaryColor}&color=${bodyBgColor}&bold=true`;

                    // Set the image source
                    document.getElementById('profileImage').src = imgUrl;
                </script>

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="<?= base_url('admin/atur-profil') ?>">
                    <i class="icon bi bi-person-circle me-2 text-gray-400"></i>
                    Atur Profil
                </a> 
                <div class="dropdown-divider"></div>-->
                <a class="dropdown-item" href="<?= base_url('logout') ?>">
                    <i class="bi bi-box-arrow-left me-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
    <!-- End of Topbar -->
</nav>
<!-- </header> -->