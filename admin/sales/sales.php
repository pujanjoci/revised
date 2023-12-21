<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sold Items Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <?php
    require_once 'config.php';

    // Function to update the 'paid' column based on conditions
    function updatePaidColumn($con, $itemsTableName, $biddingHistoryTableName, $soldItemTableName)
    {
        $currentTime = date('Y-m-d H:i:s');
        $querySelectItems = "SELECT * FROM $itemsTableName";
        $result = $con->query($querySelectItems);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $itemId = $row['id'];
                $endTime = $row['end_time'];

                if ($currentTime > $endTime) {
                    $queryCheckBiddingHistory = "SELECT * FROM $biddingHistoryTableName WHERE item_id = $itemId";
                    $biddingHistoryResult = $con->query($queryCheckBiddingHistory);

                    if ($biddingHistoryResult->num_rows > 0) {
                        $biddingHistoryRow = $biddingHistoryResult->fetch_assoc();
                        $amount = $biddingHistoryRow['amount'];
                        $paidStatus = ($amount > 0) ? 'yes' : 'no';

                        // Update the 'paid' column in the sold_item table
                        $queryUpdatePaidStatus = "UPDATE $soldItemTableName SET paid = '$paidStatus' WHERE id = $itemId";
                        $con->query($queryUpdatePaidStatus);
                    } else {
                        // If no data in bidding_history, set 'paid' to 'no'
                        $queryUpdatePaidStatus = "UPDATE $soldItemTableName SET paid = 'no' WHERE id = $itemId";
                        $con->query($queryUpdatePaidStatus);
                    }
                }
            }
        }
    }

    // Call the function to update the 'paid' column
    updatePaidColumn($con, 'items', 'bidding_history', 'sold_item');

    // Display the details of the sold_item table with paid status 'yes'
    $querySelectSoldItem = "SELECT * FROM sold_item WHERE paid = 'yes'";
    $resultSoldItem = $con->query($querySelectSoldItem);

    if ($resultSoldItem->num_rows > 0) {
        echo "<h2>Sold Items Details</h2>";
        echo "<table>";
        echo "<tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Item Description</th>
            <th>Item Image</th>
            <th>Created At</th>
            <th>Starting Price</th>
            <th>End Time</th>
            <th>Seller</th>
            <th>Paid</th>
          </tr>";

        while ($rowSoldItem = $resultSoldItem->fetch_assoc()) {
            echo "<tr>
                <td>{$rowSoldItem['id']}</td>
                <td>{$rowSoldItem['item_name']}</td>
                <td>{$rowSoldItem['item_description']}</td>
                <td>{$rowSoldItem['item_image']}</td>
                <td>{$rowSoldItem['created_at']}</td>
                <td>{$rowSoldItem['starting_price']}</td>
                <td>{$rowSoldItem['end_time']}</td>
                <td>{$rowSoldItem['seller']}</td>
                <td>{$rowSoldItem['paid']}</td>
              </tr>";
        }

        echo "</table>";
    } else {
        echo "No sold items found.";
    }
    ?>

</body>

</html>