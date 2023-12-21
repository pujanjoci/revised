<!DOCTYPE html>
<html lang="en">

<head>
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...your-integrity-code-here..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .gallery-wrap {
            width: calc(100% - 10px);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin: 0 auto;
        }

        .gallery {
            display: flex;
            overflow-x: hidden;
            scroll-behavior: smooth;
            flex-grow: 1;
            padding: 20px;
        }

        .gallery span {
            min-width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            overflow: hidden;
            border-radius: 15px;
            transition: background-image 0.3s ease-in-out, transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            padding: 20px;
            margin-right: 50px;
        }

        .gallery span img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .gallery span:hover {
            background-image: none;
            background-color: rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
        }

        .gallery span:not(.visible) {
            transform: scale(0.8);
            opacity: 0.5;
            pointer-events: none;
        }

        .icon {
            font-size: 2em;
            display: flex;
            cursor: pointer;
            border-radius: 50%;
            background-color: #fff;
            padding: 10px;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
            margin-left: 10px;
        }

        .icon:hover {
            background-color: #ddd;
        }

        .icon:active {
            transform: scale(0.8);
        }

        #left,
        #right {
            order: 0;
        }

        #left {
            margin-right: 10px;
        }

        #left:hover,
        #right:hover {
            color: blue;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .fadeIn {
            animation: fadeIn 0.8s ease-in-out;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(5px);
            z-index: -1;
        }


        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: relative;
            z-index: 1;
            padding: 10px;
        }

        .slide-button {
            background-color: #0074d9;
            color: #fff;
            border: none;
            border-radius: 5px;
            width: 50px;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        .slide-button:hover {
            background-color: #0056b3;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: absolute;
            top: 0;
            padding: 10px;
            margin-top: 42%;
        }

        .slide-button {
            background-color: #8d8d8d;
            color: #fff;
            border: none;
            border-radius: 5px;
            width: 50px;
            height: 40px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 2%;
        }

        .slide-button:hover {
            background-color: #0056b3;
        }

        .details {
            overflow: hidden;
            white-space: nowrap;
            overflow-y: hidden;
        }

        .item-container {
            display: flex;
            overflow-x: hidden;
            position: relative;
        }

        .item {
            position: relative;
            width: calc(20.33% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5%;
            background-color: #f5f5f5;
            margin-right: 2%;
            overflow: hidden;
            display: inline-block;
            flex-shrink: 0;
            margin-bottom: 2%;
            text-align: center;
        }

        .item-info {
            margin-top: 10px;
        }

        .item-name {
            font-size: 20px;
            color: #333;
        }

        .item-image-container {
            position: relative;
            text-align: center;
        }

        .item-image {
            max-width: 100%;
            height: auto;
            border-radius: 10%;
        }

        .view-button {
            background-color: #020202;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .view-button:hover {
            opacity: 0.8;
        }

        .no-items-message {
            font-size: 18px;
            color: #575757;
            text-align: center;
            margin: 20px 0;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="gallery-wrap">

        <div id="left" class="icon" onclick="navigate('left')"><i class="fas fa-arrow-left"></i></div>

        <div class="gallery">
            <?php
            include('config.php');

            $searchTerm = isset($_GET['search-term']) ? $_GET['search-term'] : '';

            if (!empty($searchTerm)) {
                $sql = "SELECT id, item_name, item_image FROM items WHERE item_name LIKE '%$searchTerm%' ORDER BY RAND()";
            } else {
                $sql = "SELECT id, item_name, item_image FROM items ORDER BY RAND()";
            }

            $result = $con->query($sql);

            if (!$result) {
                die("SQL query error: " . $con->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $item_id = $row['id'];
                    $itemName = $row['item_name'];
                    $itemImage = $row['item_image'];

                    // Check if the current item_id is the one in the URL, and skip it
                    if (isset($_GET['item_id']) && $_GET['item_id'] == $item_id) {
                        continue; // Skip this iteration of the loop
                    }

                    echo "<div class='item'>";
                    echo "<div class='item-image-container'>";
                    echo "<img class='item-image' src='images/$itemImage' alt='$itemName'>";
                    echo "</div>";
                    echo "<div class='item-info'>";
                    echo "<h2 class='item-name'>$itemName</h2>";
                    echo "<a class='view-button' href='product_page.php?item_id=$item_id'>View</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-items-message'>No items found.</p>";
            }
            ?>
        </div>


        <div id="right" class="icon" onclick="navigate('right')"><i class="fas fa-arrow-right"></i></div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function navigate(direction) {
                const gallery = document.querySelector('.gallery');
                const scrollAmount = 300;

                if (direction === 'left') {
                    gallery.scrollLeft -= scrollAmount;
                } else {
                    gallery.scrollLeft += scrollAmount;
                }

                updateVisibility(direction);
            }

            function updateVisibility(direction) {
                const gallery = document.querySelector('.gallery');
                const spans = gallery.querySelectorAll('.gallery span');

                spans.forEach(span => {
                    const rect = span.getBoundingClientRect();
                    const isVisible = (
                        rect.left >= 0 &&
                        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                    );

                    if (isVisible || (direction === 'left' && rect.right >= 0) || (direction === 'right' && rect.left <= (window.innerWidth || document.documentElement.clientWidth))) {
                        span.classList.add('visible');
                    } else {
                        span.classList.remove('visible');
                    }
                });
            }

            const leftButton = document.getElementById('left');
            const rightButton = document.getElementById('right');
            const gallery = document.querySelector('.gallery');

            leftButton.addEventListener('click', function() {
                navigate('left');
            });

            rightButton.addEventListener('click', function() {
                navigate('right');
            });

            gallery.addEventListener('scroll', function() {
                updateVisibility('scroll');
            });

            document.addEventListener("DOMContentLoaded", function() {
                const searchForm = document.getElementById('search-form');

                searchForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const searchTerm = document.getElementById('search-bar').value;
                    const currentUrl = new URL(window.location.href);

                    currentUrl.searchParams.set('search-term', searchTerm);

                    window.location.href = currentUrl.toString();
                });
            });
        });
    </script>
</body>

</html>