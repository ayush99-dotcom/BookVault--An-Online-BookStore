<?php
require_once('../config/constant.php');

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Assign the value of 'id' parameter to $id variable
    $id = $_GET['id'];
} else {
    echo "Error: 'id' parameter not provided in the URL.";
    exit;
}


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
        "return_url" => "http://localhost/composer/admin/psuccess.php",
        "website_url" => "https://index.php/",
        "amount" => $total, // pass $total directly as an integer
        "purchase_order_id" => "Order01",
        "purchase_order_name" => "test",
        "customer_info" => array(
            "name" => "Test Bahadur",
            "email" => "test@khalti.com",
            "phone" => "9800000001"
        )
    )),
    CURLOPT_HTTPHEADER => array(
        'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
        'Content-Type: application/json',
    ),
));

$response = curl_exec($curl);

curl_close($curl);


// Decode the JSON response
$responseData = json_decode($response, true);
var_dump($responseData); // Check the structure of $responseData
if (isset($responseData['payment_url'])) {
    // Redirect the user to the payment URL
    header("Location: " . $responseData['payment_url']);
    exit; // Make sure to exit to prevent further execution
} else {
    echo "Error: Payment URL not found in the response.";
    // Handle this error scenario, log or display an appropriate message
}



?>