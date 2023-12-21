<?php
// Assuming the main content files are in the same directory as this PHP file
$contentDirectory = __DIR__ . '/content/';

// Define an array that maps the link URL to the corresponding file to include
$linkToFileMapping = [
    'profile/profile.php' => 'profile.php',
    '../dashboard/dashboard.php' => 'dashboard.php',
    'sales/sales.php' => 'sales.php',
    '../items/items.php' => 'items.php',
];

if (isset($_GET['page']) && array_key_exists($_GET['page'], $linkToFileMapping)) {
    $currentPage = $_GET['page'];
} else {
    // Default to the first page if no page is specified
    $currentPage = 'profile/profile.php';
}

?>


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
                        <a href="?page=profile/profile.php" class="sidebar-link <?php echo ($currentPage === 'profile/profile.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-list pe-2"></i>
                            Profile
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="?page=../dashboard/dashboard.php" class="sidebar-link <?php echo ($currentPage === '../dashboard/dashboard.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-folder-open pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="?page=sales/sales.php" class="sidebar-link <?php echo ($currentPage === 'sales/sales.php') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-chart-line pe-2"></i>
                            Sales
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="?page=../items/items.php" class="sidebar-link <?php echo ($currentPage === '../items/items.php') ? 'active' : ''; ?>">
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
            <div id="content-container">
                <!-- Content will be loaded here dynamically -->
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="sidemenu.js"></script>
    <script>
        $(document).ready(function() {
            // Load the default content
            $('#content-container').load('<?php echo $currentPage; ?>');

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