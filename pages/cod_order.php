<?php
session_start();
include '../includes/connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /theshoesbox/pages/login.php");
    exit();
}

$user_id     = $_POST['user_id'];
$product_id  = $_POST['product_id'];
$address_id  = $_POST['address_id'];
$rate        = $_POST['rate'];
$size        = $_POST['pro_size'];
$quantity    = $_POST['quantity'];
$totalprice  = $_POST['totalprice'];
$status      = $_POST['status'];

if (
    empty($user_id) || empty($product_id) || empty($address_id) || empty($rate) ||
    empty($size) || empty($quantity) || empty($totalprice)
) {
    die("Required fields are missing.");
}

$sql = "INSERT INTO `order` (`user_id`, `product_id`, `address_id`, `rate`, `pro_size`, `quantity`, `totalprice`, `status`) 
        VALUES ('$user_id', '$product_id', '$address_id', '$rate', '$size', '$quantity', '$totalprice', '$status')";

if (mysqli_query($con, $sql)) {
    $order_id = mysqli_insert_id($con);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <script>
            swal({
                title: "Success!",
                text: "Your order has been placed successfully!",
                icon: "success"
            }).then(function() {
                window.location.href = "/theshoesbox/pages/orders.php?order_id=<?= $order_id ?>";
            });
        </script>
    </body>
    </html>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <script>
            swal({
                title: "Error!",
                text: "There was an error placing your order. Please try again later.",
                icon: "error"
            }).then(function() {
                window.location.href = "/theshoesbox/pages/order_failure.php";
            });
        </script>
    </body>
    </html>
    <?php
}

mysqli_close($con);
?>
