<body>

    <aside id="sidebar">
        <div class="h-100">
            <div class="sidebar-logo">
                <a href="index.php">
                    <img src="../assets/logo.png" alt="Logo" id="logo-image">
                </a>
            </div>
            <ul id="sidebar-nav">
                <li class="sidebar-item">
                    <a href="index.php" class="sidebar-link active" onclick="redirectTo('index.php')">
                        <i class="fa-solid fa-list pe-2"></i>
                        Profile
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../sales/index.php" class="sidebar-link" onclick="redirectTo('../sales/index.php')">
                        <i class="fa-solid fa-chart-line pe-2"></i>
                        Sales
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../items/index.php" class="sidebar-link" onclick="redirectTo('../items/index.php')">
                        <i class="fa-solid fa-boxes-stacked pe-2"></i>
                        Items
                    </a>
                </li>
                <div class="sidebar-item logout-container">
                    <a href="../logout.php" class="logout" onclick="redirectTo('../logout.php')">
                        <i class="fas fa-sign-out-alt pe-2"></i>
                        Logout
                    </a>
                </div>
            </ul>
        </div>
    </aside>

    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>

</body>