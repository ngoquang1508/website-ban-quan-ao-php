<nav>
    <div class="nav__header">
        <a href="<?= BASE_URL ?>">
            <i class="fas fa-user-shield"></i>
            <span>Admin</span>
        </a>
    </div>

    <div class="nav__main">
        <ul>
            <li>
                <a class="nav_main-link <?php echo (!isset($_GET['page'])) ? 'active' : '' ?>" href="<?= BASE_URL ?>?page=dashboard">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="nav_main-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'users') ? 'active' : '' ?>" href="<?= BASE_URL ?>?page=users">
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a class="nav_main-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'products') ? 'active' : '' ?>" href="<?= BASE_URL ?>?page=products">
                    <i class="fa-solid fa-box"></i>
                    <span>Products</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="nav__footer">
        <a href="../xuly/dang-xuat.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
    </div>
</nav>