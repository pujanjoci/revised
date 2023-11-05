<?php
include('config.php');

// Check if a search term is provided in the URL
if (isset($_GET['search-term'])) {
    $searchTerm = $_GET['search-term'];

    // Modify the SQL query to search for items with names containing the search term
    $sql = "SELECT * FROM items WHERE item_name LIKE '%$searchTerm%'";
    $result = $con->query($sql);

    if (!$result) {
        die("SQL query error: " . $con->error);
    }

    // Check if any matching items were found
    if ($result->num_rows > 0) {
        // Display matching items
        while ($row = $result->fetch_assoc()) {
            $itemName = $row['item_name'];
            $itemImage = $row['item_image'];

            echo "<div class='item'>";
            echo "<div class='item-content'>";
            echo "<div class='item-image-container'>";
            echo "<img class='item-image' src=\"../images/" . $itemImage . "\" alt=\"" . $itemName . "\">";
            echo "<div class='item-info'>";
            echo "<h2 class='item-name'>$itemName</h2>";
            echo "<a class='view-button' href='#'>View</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        // No matching items found
        echo "<p class='no-items-message'>No such items.</p>";
    }
} else {
    // If no search term is provided, fetch all items
    $sql = "SELECT * FROM items";
    $result = $con->query($sql);

    if (!$result) {
        die("SQL query error: " . $con->error);
    }

    // Display all items
    echo "<div class='details'>";
    echo "<div class='slider-buttons'>";
    echo "<button id='slide-right-button' class='slide-button'>←</button>";
    echo "<button id='slide-left-button' class='slide-button'>→</button>";
    echo "</div>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $itemName = $row['item_name'];
            $itemImage = $row['item_image'];

            echo "<div class='item'>";
            echo "<div class='item-content'>";
            echo "<div class='item-image-container'>";
            echo "<img class='item-image' src=\"../images/" . $itemImage . "\" alt=\"" . $itemName . "\">";
            echo "<div class='item-info'>";
            echo "<h2 class='item-name'>$itemName</h2>";
            echo "<a class='view-button' href='#'>View</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-items-message'>No items at the moment.</p>";
    }

    echo "</div>"; // Close the 'details' div
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../assets/items.css">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const container = document.getElementById("item-container");
        const scrollLeftButton = document.getElementById("slide-left-button");
        const scrollRightButton = document.getElementById("slide-right-button");
        const scrollStep = 200;

        scrollLeftButton.addEventListener("click", () => {
            container.scrollBy({
                left: -scrollStep,
                behavior: "smooth"
            });
        });

        scrollRightButton.addEventListener("click", () => {
            container.scrollBy({
                left: scrollStep,
                behavior: "smooth"
            });
        });
    </script>
</body>

</html>