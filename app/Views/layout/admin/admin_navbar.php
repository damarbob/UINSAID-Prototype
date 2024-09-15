<header id="header-admin" class="header navbar navbar-expand bg-white">
    <div class="header_toggle me-3 me-md-4">
        <i class="bx bx-menu" id="header-toggle"></i>
    </div>

    <span class="fs-6 fw-bold"><?= $judul; ?></span>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ms-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="me-2 d-none d-lg-inline small"><?= auth()->user()->username ?></span>
                <img class="img-profile rounded-circle" src="https://ui-avatars.com/api/?size=32&name=<?= urlencode(auth()->user()->username) ?>&rounded=true&background=007a33&color=ffffff&bold=true">
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
</header>