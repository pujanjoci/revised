<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="index.php">
                        <img src="../assets/logo.png" alt="Logo" id="logo-image">
                    </a>
                </div>
                <ul id="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="profile/profile.php" class="sidebar-link active">
                            <i class="fa-solid fa-list pe-2"></i>
                            Profile
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../dashboard/dashboard.php" class="sidebar-link">
                            <i class="fa-solid fa-folder-open pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="sales/sales.php" class="sidebar-link">
                            <i class="fa-solid fa-chart-line pe-2"></i>
                            Sales
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="../items/items.php" class="sidebar-link">
                            <i class="fa-solid fa-boxes-stacked pe-2"></i>
                            Items
                        </a>
                    </li>
                    <div class="sidebar-item logout-container">
                        <a href="logout.php" class="logout">
                            <i class="fas fa-sign-out-alt pe-2"></i>
                            Logout
                        </a>
                    </div>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <button class="btn" type="button" data-bs-theme="light">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <div id="content-container"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="sidemenu.js"></script>
    <script>
        $(document).ready(function() {
            var defaultLink = $('.sidebar-link.active');
            var defaultHref = defaultLink.attr('href');
            $('#content-container').load(defaultHref);

            defaultLink.closest('.sidebar-item').addClass('active');

            $('.sidebar-link').on('click', function(e) {
                e.preventDefault();

                var href = $(this).attr('href');
                $('#content-container').load(href);

                $('.sidebar-item').removeClass('active');
                $(this).closest('.sidebar-item').addClass('active');
            });
        });
    </script>


</body>