<?php
require_once "../config/base-url.php";
require_once "../config/db.php";

// Lấy page từ query string, mặc định dashboard
$page = isset($_GET['page']) ? $_GET['page'] : "dashboard";

$route = "pages/" . $page . ".php";
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>

<body data-page="<?= $_GET['page'] ?? null ?>">
    <div class="overlay"></div>

    <div class="admin-panel">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-cube"></i>
                <span class="logo-text">Admin</span>
            </div>
            <ul class="nav">
                <li><a href="?page=dashboard"><i class="fas fa-tachometer-alt"></i><span class="text">Dashboard</span></a></li>
                <li><a href="?page=users"><i class="fas fa-user"></i><span class="text">Người dùng</span></a></li>
                <li><a href="?page=products"><i class="fas fa-box"></i><span class="text">Sản phẩm</span></a></li>
                <li><a href="?page=orders"><i class="fas fa-shopping-cart"></i><span class="text">Đơn hàng</span></a></li>
                <li><a href="<?= BASE_URL ?>../xuly/dang-xuat.php"><i class="fas fa-sign-out-alt"></i><span class="text">Đăng xuất</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <div class="left">
                    <i class="fas fa-bars" id="sidebar-toggle"></i>
                    <a class="website" href="<?= BASE_URL ?>../">ND Style</a>
                </div>
                <div class="between">
                    <input type="text" placeholder="Tìm kiếm...">
                </div>
                <div class="right">
                    <div class="icon" id="notifIcon">
                        <i class="fas fa-bell"></i>
                        <span id="notifBadge">0</span>
                    </div>
                    <ul id="notifList" class="dropdown-menu"></ul>
                </div>


            </header>

            <main>
                <?php
                if (file_exists($route)) {
                    include $route;
                } else {
                    echo "<h2>Page not found</h2>";
                }
                ?>
            </main>
        </div>
    </div>

    <!-- SEARCH -->
    <script>
        // Gán event search input
        document.querySelector('header input[type="text"]').addEventListener('input', function() {
            const query = this.value.toLowerCase();

            // Kiểm tra trang hiện tại
            const rows = document.querySelectorAll("table tbody tr");

            rows.forEach(row => {
                let rowMatch = false;

                row.querySelectorAll("td:not(:last-child .pro-img)").forEach(td => {
                    // Xóa highlight cũ
                    td.innerHTML = td.textContent;

                    if (!query) return; // nếu chuỗi rỗng thì bỏ qua

                    const text = td.textContent.toLowerCase();
                    const index = text.indexOf(query);

                    if (index !== -1) {
                        rowMatch = true;

                        const original = td.textContent;

                        td.innerHTML =
                            original.substring(0, index) +
                            `<span class="highlight-text">` +
                            original.substring(index, index + query.length) +
                            `</span>` +
                            original.substring(index + query.length);
                    }
                });

                row.style.display = rowMatch || query === "" ? "" : "none";
            });
        });
    </script>

    <!-- NOTIFICATION -->
    <script>
        const notifIcon = document.getElementById('notifIcon');
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');

        function timeAgo(timestamp) {
            const now = new Date();
            const created = new Date(timestamp);
            const diff = now - created; // ms

            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (days > 0) return `${days} ngày trước`;
            if (hours > 0) return `${hours} giờ trước`;
            if (minutes > 0) return `${minutes} phút trước`;
            return `${seconds} giây trước`;
        }

        function loadNotifications() {
            fetch('api/notifications.php?action=list')
                .then(res => res.json())
                .then(data => {
                    notifBadge.textContent = data.length;
                    notifList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(o => {
                            const li = document.createElement('li');
                            li.style.display = "flex";
                            li.style.alignItems = "center";
                            li.style.justifyContent = "space-between";
                            li.style.borderBottom = "1px solid #999";
                            li.innerHTML = `
                        ${o.username || 'Guest'} vừa đặt 1 đơn hàng (${timeAgo(o.created_at)})
                        <button class="btn btn-sm btn-link text-danger float-end" onclick="deleteNotif(${o.id}, this)">Xóa</button>
                    `;
                            notifList.appendChild(li);
                        });
                    } else {
                        const li = document.createElement('li');
                        li.textContent = 'Không có thông báo mới.';
                        notifList.appendChild(li);
                    }
                });
        }

        function deleteNotif(id, btn) {
            fetch(`api/notifications.php?action=delete&id=${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        btn.closest('li').remove();
                        notifBadge.textContent = notifList.children.length;
                    }
                });
        }

        // Xóa tất cả notification
        function deleteAllNotifs() {
            fetch('api/notifications.php?action=deleteAll')
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        notifList.innerHTML = '';
                        notifBadge.textContent = 0;
                    }
                });
        }


        // click vào icon show dropdown
        notifIcon.addEventListener("click", () => {
            notifList.style.display = notifList.style.display === 'block' ? 'none' : 'block';
        });

        // Ẩn dropdown khi click ra ngoài
        document.addEventListener('click', function(e) {
            if (!notifIcon.contains(e.target) && !notifList.contains(e.target)) {
                notifList.style.display = 'none';
            }
        });

        // load lần đầu
        loadNotifications();
        // poll mỗi 10 giây
        setInterval(loadNotifications, 10000);
    </script>

    <!-- TOGGLE SIDEBAR -->
    <script>
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const overlay = document.querySelector('.overlay');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>
</body>

</html>