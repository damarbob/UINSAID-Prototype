<style>
    .custom-dropdown-right {
        right: 0 !important;
        left: auto !important;
    }
</style>
<header id="header-admin" class="header navbar navbar-expand" style="background: var(--mdb-body-bg)">
    <!-- <div class="container"> -->

    <div class="header_toggle me-3 me-md-4" id="headerToggleButton">
        <i class="bx bx-menu" id="header-toggle"></i>
    </div>

    <span class="fs-6 fw-bold"><?= $judul; ?></span>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ms-auto">

        <!-- Notification Bell Icon in MDB Style -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="notificationDropdown" role="button" data-mdb-dropdown-init aria-expanded="false" onclick="loadNotifications()" aria-haspopup="true">
                <i class="fas fa-bell"></i>
                <span class="badge rounded-pill badge-notification bg-danger" style="display: none;" id="notification-count"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end custom-dropdown-right" aria-labelledby="notificationDropdown">
                <li class="d-flex align-items-center">
                    <h6 class="dropdown-header">Notifikasi</h6>
                    <a class="text-end small text-primary ms-auto me-3" href="#" onclick="markAllAsRead()">Tandai semua sudah dibaca</a>
                </li>
                <div id="notification-list" style="max-height: 300px; overflow-y: auto;">
                    <!-- Notifications will be populated here -->
                </div>
                <li class="text-center">
                    <button id="load-more-btn" class="btn btn-link text-primary w-100">Muat lebih banyak</button>
                </li>
            </ul>
        </li>


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
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

    <!-- </div> -->
</header>

<script>
    function timeAgo(date) {
        const seconds = Math.floor((new Date() - new Date(date)) / 1000);
        const intervals = [{
                label: 'tahun',
                seconds: 31536000
            },
            {
                label: 'bulan',
                seconds: 2592000
            },
            {
                label: 'pekan',
                seconds: 604800
            },
            {
                label: 'hari',
                seconds: 86400
            },
            {
                label: 'jam',
                seconds: 3600
            },
            {
                label: 'menit',
                seconds: 60
            },
            {
                label: 'detik',
                seconds: 1
            }
        ];

        for (const interval of intervals) {
            const count = Math.floor(seconds / interval.seconds);
            if (count >= 1) {
                return `${count} ${interval.label} yang lalu`;
            }
        }
        return 'baru saja';
    }

    let limit = 10;
    let latestNotificationId = null;
    let isLoadingMore = false; // Track if we are currently loading more notifications
    const sessionNotifKey = 'lastToastNotificationId';

    async function loadNotifications(isLoadMore = false) {
        try {
            let url = `<?php echo base_url('api/notifikasi') ?>?limit=${limit}`;

            // If loading more, calculate offset; otherwise, check for newer notifications
            if (isLoadMore) {
                const offset = document.getElementById('notification-list').childElementCount;
                url += `&offset=${offset}`;
            } else if (latestNotificationId) {
                url += `&newer_than=${latestNotificationId}`;
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            const notifications = await response.json();
            const notificationList = document.getElementById('notification-list');

            if (notifications.length > 0) {
                // If not loading more, update latest ID and prepend new notifications
                if (!isLoadMore && notifications[0].id > latestNotificationId) {
                    latestNotificationId = notifications[0].id; // Update latest ID with the most recent
                    notifications.reverse().forEach(notif => {
                        const notificationItem = createNotificationItem(notif);
                        notificationList.insertBefore(notificationItem, notificationList.firstChild);

                        // Check if there's an unread notification and if it hasn't already triggered a session toast
                        const lastToastNotificationId = sessionStorage.getItem(sessionNotifKey);

                        if (notif.terbaca == '0' && (!lastToastNotificationId || notif.id > lastToastNotificationId)) {
                            Swal.fire({
                                toast: true,
                                title: notif.judul,
                                timer: 2000,
                                timerProgressBar: true,
                                position: "top-end",
                                icon: "info",
                                showConfirmButton: false,
                            });

                            // Store this notification ID in session storage
                            sessionStorage.setItem(sessionNotifKey, notif.id);
                        }

                    });
                } else if (isLoadMore) {
                    // Append additional notifications for "Load More"
                    notifications.forEach(notif => {
                        const notificationItem = createNotificationItem(notif);
                        notificationList.appendChild(notificationItem);
                    });
                }

                // Update unread notification count display
                updateNotificationCount();


                // Show or hide the "Load More" button based on if more notifications are available
                document.getElementById('load-more-btn').style.display = notifications.length < limit ? 'none' : 'inline-block';
            }

            updateNotificationTime();
        } catch (error) {
            console.error('Error loading notifications:', error);
        } finally {
            isLoadingMore = false;
        }
    }

    function updateNotificationTime() {
        document.querySelectorAll('.notification-item-time').forEach(timeElement => {
            const createdAt = timeElement.getAttribute('data-created-at');
            timeElement.textContent = timeAgo(createdAt);
        });
    }

    // Helper function to create a notification item
    function createNotificationItem(notif) {
        const notificationItem = document.createElement('li');
        notificationItem.className = `dropdown-item`; // ${notif.terbaca == '0' ? 'bg-light' : ''}`;
        const createdAtRelative = timeAgo(notif.created_at);

        notificationItem.innerHTML = `
        <a href="${notif.link}" class="text-dark" onclick="markAsRead(${notif.id}, this)">
            <strong>${notif.judul}${notif.terbaca == '0' ? '<span class="text-danger notification-item-unread-mark"> *</span>':''}</strong><br>
            <small>${notif.konten}</small><br>
            <span class="text-muted"><small class="notification-item-time" data-created-at="${notif.created_at}">${createdAtRelative}</small></span>
        </a>
    `;
        return notificationItem;
    }

    // Update the unread notification count display
    function updateNotificationCount() {
        const unreadCount = document.querySelectorAll('#notification-list .notification-item-unread-mark').length;
        const notificationCountElement = document.getElementById('notification-count');

        if (unreadCount === 0) {
            notificationCountElement.textContent = 0;
            notificationCountElement.style.display = 'none';
        } else {
            notificationCountElement.style.display = 'inline-block';
            notificationCountElement.textContent = unreadCount > 9 ? '9+' : unreadCount;
        }
    }

    // Initial load on page load or dropdown open
    document.addEventListener('DOMContentLoaded', () => loadNotifications());
    // Call loadNotifications every 60 seconds to refresh the notification list
    setInterval(() => loadNotifications(false), 5000);

    // Load more notifications when button is clicked
    document.getElementById('load-more-btn').addEventListener('click', (event) => {
        if (!isLoadingMore) {
            event.stopPropagation();
            isLoadingMore = true;
            loadNotifications(true); // Set flag to load more
        }
    });

    // document.addEventListener('DOMContentLoaded', loadNotifications);

    async function markAllAsRead() {
        try {
            // Send request to server to mark all notifications as read
            const response = await fetch('<?php echo base_url('api/notifikasi/tandai-semua-sudah-dibaca') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            if (response.ok) {

                // Hide all unread indicators (red asterisks) from notifications
                document.querySelectorAll('.notification-item-unread-mark').forEach(unreadMark => {
                    unreadMark.remove();
                });
                // Set notification count to 0 or hide if no unread notifications remain
                const notificationCount = document.getElementById('notification-count');
                notificationCount.textContent = 0;
                notificationCount.style.display = 'none';

            } else {
                console.error('Failed to mark all notifications as read');
            }
        } catch (error) {
            console.error('Error marking notifications as read:', error);
        }
    }

    async function markAsRead(id, element) {
        try {
            const response = await fetch(`<?php echo base_url('api/notifikasi/tandai-sudah-dibaca') ?>/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            if (response.ok) {
                // Remove the asterisk by finding and hiding the unread mark element
                const unreadMark = element.querySelector('.notification-item-unread-mark');
                if (unreadMark) {
                    unreadMark.style.display = 'none';
                }
                // Decrement the notification count
                const notificationCount = document.getElementById('notification-count');
                const unreadCount = parseInt(notificationCount.textContent, 10);
                if (unreadCount > 1) {
                    notificationCount.textContent = unreadCount - 1;
                } else {
                    notificationCount.style.display = 'none';
                }
                // loadNotifications();
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }
</script>