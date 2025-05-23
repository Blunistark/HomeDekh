<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<header class="site-header site-header--menu-center zubuz-header-section" id="sticky-menu">
    <div class="container">
        <nav class="navbar site-navbar">
            <div class="brand-logo">
                <a href="/">
                    <img src="images/logo-dark.svg" alt="" class="light-version-logo">
                </a>
            </div>
            <div class="menu-block-wrapper">
                <div class="menu-overlay"></div>
                <nav class="menu-block" id="append-menu-header">
                    <div class="mobile-menu-head">
                        <div class="go-back">
                            <i class="fa fa-angle-left"></i>
                        </div>
                        <div class="current-menu-title"></div>
                        <div class="mobile-menu-close">×</div>
                    </div>
                    <ul class="site-menu-main">
                        <li class="nav-item nav-item-has-children">
                            <ul class="sub-menu" id="submenu-1">
                            </ul>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link-item" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-item" href="/about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-item" href="/contact-us.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-item" href="/pgs.php">View All Pgs</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <?php if ($_SESSION['user_role'] === 'owner') : ?>
                                <li class="nav-item d-md-none">
                                    <a class="nav-link-item" href="/admin/index.php">Admin Dashboard</a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item d-md-none">
                                <a class="nav-link-item" href="/auth/logout.php">Logout</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item d-md-none">
                                <a class="nav-link-item" href="/sign-up.php">Sign Up</a>
                            </li>
                            <li class="nav-item d-md-none">
                                <a class="nav-link-item" href="/sign-in.php">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>

            <div class="header-btn header-btn-l1 ms-auto d-none d-xs-inline-flex">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <div class="zubuz-header-btn-wrap">
                         <a class="zubuz-login-btn" href="/auth/logout.php" style="margin-left: 10px;">Logout</a>
                    </div>
                    <?php if ($_SESSION['user_role'] === 'owner') : ?>
                         <a class="zubuz-default-btn zubuz-header-btn" href="/admin/index.php">
                            <span>Admin Dashboard</span>
                        </a>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="zubuz-header-btn-wrap">
                        <a class="zubuz-login-btn" href="/sign-in.php">Login</a>
                    </div>
                    <a class="zubuz-default-btn zubuz-header-btn" href="/sign-up.php">
                        <span>Sign Up</span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="mobile-menu-trigger light">
                <span></span>
            </div>
            </nav>
    </div>
</header>