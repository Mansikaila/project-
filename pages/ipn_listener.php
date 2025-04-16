<?php
include '../includes/connection.php';

$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();

foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2) {
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
}

$req = 'cmd=_notify-validate';
foreach ($myPost as $key => $value) {
    $value = urlencode($value);
    $req .= "&$key=$value";
}

// PayPal Sandbox URL (Production માટે લાસ્ટમાં .com)
$paypal_url = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr";
$ch = curl_init($paypal_url);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

$res = curl_exec($ch);
curl_close($ch);

if (strcmp($res, "VERIFIED") == 0) {
    $payment_status = $_POST['payment_status'];
    $txn_id = $_POST['txn_id'];
    $custom = $_POST['custom']; // user_id
    $product_name = $_POST['item_name'];
    $amount = $_POST['mc_gross'];

    // Get product_id
    $product_query = mysqli_query($con, "SELECT id FROM product WHERE name = '$product_name'");
    $product_row = mysqli_fetch_assoc($product_query);
    $product_id = $product_row['id'] ?? 0;

    if ($payment_status == "Completed") {
        // Save to orders table
        mysqli_query($con, "INSERT INTO orders (user_id, product_id, quantity, total_price, payment_method, status, transaction_id)
            VALUES ('$custom', '$product_id', 1, '$amount', 'paypal', 'Paid', '$txn_id')");
    }
}
?>
