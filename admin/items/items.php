<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

$query = "SELECT * FROM items";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border: 2px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #items-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-top: 2px solid #ddd;
        }

        #items-table th,
        #items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            color: #333;
        }

        #items-table img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        #items-table thead {
            background-color: #f9f9f9;
        }

        .sold-button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }
    </style>

</head>

<body>

    <div class="container">
        <h2>Items List</h2>
        <a href="additem.php" class="sold-button">
            <i class="fas fa-plus"></i> Add Items
        </a>


        <table id="items-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Starting Price</th>
                    <th>End Time</th>
                    <th>Seller</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['item_name']}</td>";

                    // Display the first 10 words of the description
                    $descriptionWords = explode(' ', $row['item_description']);
                    $shortDescription = implode(' ', array_slice($descriptionWords, 0, 10));

                    echo "<td>{$shortDescription}</td>";
                    echo "<td><img src='../../images/{$row['item_image']}' alt='Item Image'></td>";
                    echo "<td>{$row['starting_price']}</td>";
                    echo "<td>{$row['end_time']}</td>";
                    echo "<td>{$row['seller']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>