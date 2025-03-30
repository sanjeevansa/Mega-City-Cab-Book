<?php 
session_start();
include("connection.php"); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <!-- CDN Icon Library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/signin.css">

    <style>
        body {
            background-image: url("image/background2.jpg");
            background-position: center;
            background-size: cover;
            height: 700px;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .adminTopic {
            text-align: center;
            color: #fff;
        }
        button {
            padding: 5px;
        }
        .btnPolicy {
            padding: 5px;
            border: 2px solid yellow;
            border-radius: 7px;
            background-color: red;
            color: white;
            margin-left: 20px;
        }
        .btnPolicy:hover {
            background: red;
            padding: 7px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<input type="checkbox" id="check">
<label for="check">
    <i class="fa fa-bars" id="btn"></i>
    <i class="fa fa-times" id="cancle"></i>
</label>

<div class="sidebar">
    <header>
        <img src="image/pic-4.png">
        <p><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></p>
    </header>
    <ul>
        <li><a href="adminDash.php">Manage Driver</a></li>
        <li><a href="ManageVehicle.php">Manage Vehicle</a></li>
        <li><a href="PaymentManage.php">Transaction</a></li>
        <li><a href="adminLogout.php">Logout</a></li>
    </ul>
</div>

<?php 
if (isset($_POST['vehiUpdate'])) {
    $id = $_POST['id'];  
    $name = $_POST['vehicle_name'];
    $number = $_POST['vehi_number'];
    $model = $_POST['model'];
    $transmission = $_POST['transmission'];
    $ftype = $_POST['fuel_type'];
    $amount = $_POST['amount'];

    // Image Upload Handling
    $image_path = ""; 
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = "uploads/";
        $image_path = $upload_dir . $image_name;
        move_uploaded_file($image_tmp_name, $image_path);
    }

    // Update Query
    $query = "UPDATE vehicle SET 
                vehicle_name='$name', 
                vehi_number='$number', 
                model='$model', 
                transmission='$transmission', 
                fuel_type='$ftype', 
                amount='$amount'";

    if ($image_path != "") {
        $query .= ", image='$image_path'"; // Only update image if a new one is uploaded
    }

    $query .= " WHERE id=$id";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo ("<script>
            alert('Successfully updated vehicle!');
            window.location.href='ManageVehicle.php';
        </script>");
    } else {
        echo ("<script>alert('Vehicle update failed!');</script>");
    }
}
?>

<div class="sidebar2">
    <div class="form-box">
        <h1><b><i><center>Update a Vehicle...</center></i></b></h1>

        <!-- Vehicle Update Form -->
        <form id="Register" class="input-group" method="post" enctype="multipart/form-data">
            <input type="number" name="id" class="input-field" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" readonly>

            <input type="text" name="vehicle_name" class="input-field" placeholder="Enter vehicle name" required>
            <input type="text" name="vehi_number" class="input-field" placeholder="Enter vehicle number" required>
            <input type="text" name="model" class="input-field" placeholder="Enter model name" required>
            <input type="text" name="transmission" class="input-field" placeholder="Transmission type" required>
            <input type="text" name="fuel_type" class="input-field" placeholder="Fuel type" required>
            <input type="file" name="image" class="input-field">
            <input type="text" name="amount" class="input-field" placeholder="Amount" required>

            <button type="submit" name="vehiUpdate" class="submit-btn">Update Vehicle Now</button>
        </form>
    </div>
</div>

</body>
</html>
