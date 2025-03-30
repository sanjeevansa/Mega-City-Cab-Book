<?php 
session_start();
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Menu - Admin Panel</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/homepage.css">

    <style>
        body {
            background-image: url("image/background2.jpg");
            background-position: center;
            background-size: cover;
            height: 100vh;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .adminTopic {
            text-align: center;
            color: #fff;
            margin-top: 20px;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin: auto;
            background-color: white;
            border-radius: 10px;
            text-align: center;
            margin-top: 50px;
        }

        th, td {
            padding: 15px;
            border-bottom: 2px solid #bbb;
        }

        th {
            background-color: #333;
            color: white;
        }

        td img {
            width: 120px;
            height: 100px;
            border-radius: 5px;
            object-fit: cover;
        }

        .btnAction {
            padding: 10px;
            border: 2px solid yellow;
            border-radius: 7px;
            background-color: red;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btnAction:hover {
            background-color: darkred;
            cursor: pointer;
        }

        .btnPolicy {
            padding: 10px;
            border: 2px solid yellow;
            border-radius: 7px;
            background-color: red;
            color: white;
            margin: 20px;
            display: inline-block;
            text-decoration: none;
        }

        .btnPolicy:hover {
            background: darkred;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <?php 
    session_start();
    include("connection.php"); 
    include("loginNav.php"); 
    ?>

    <div class="sidebar">
        <header>
            <img src="image/pic-4.png" alt="Admin Profile">
            <p><?php echo $_SESSION['username']; ?></p>
        </header>
        <ul>
            <li><a href="adminDash.php">Manage Driver</a></li>
            <li><a href="ManageVehicle.php">Manage Vehicle</a></li>
            <li><a href="adminLogout.php">Logout</a></li>
        </ul>
    </div>

    <div class="sidebar2">
        <h1 class="adminTopic">...Our Vehicle List...</h1>

        <?php
            // Fetch vehicle data
            $query = "SELECT * FROM vehicle";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr>
                        <th>ID</th>
                        <th>Vehicle Name</th>
                        <th>Vehicle Number</th>
                        <th>Model</th>
                        <th>Transmission</th>
                        <th>Fuel Type</th>
                        <th>Amount</th>
                        <th>Image</th>
                        <th>Get For Rent</th>
                      </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    // Ensure the image path is correct and exists
                    $imagePath = "image/" . basename($row['image']);
                    if (!file_exists($imagePath) || empty($row['image'])) {
                        $imagePath = "image/default.png"; // Fallback image
                    }

                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['vehicle_name']}</td>
                            <td>{$row['vehi_number']}</td>
                            <td>{$row['model']}</td>
                            <td>{$row['transmission']}</td>
                            <td>{$row['fuel_type']}</td>
                            <td>{$row['amount']}</td>
                            <td><img src='{$imagePath}' alt='Vehicle Image' onerror=\"this.src='image/default.png'\"></td>
                            <td><a class='btnAction' href='payment.php'>Get For Rent</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='text-align:center; color: white;'>No vehicles found!</p>";
            }
        ?>

        <br>
        <a href="AddVehicle.php" class="btnPolicy">Add Vehicle</a>
    </div>

</body>
</html>
