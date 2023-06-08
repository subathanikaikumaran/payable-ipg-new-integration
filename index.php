<?php

require_once('config/APIController.php');
require_once('config/config.php');
$paymentURL="";
$data='{
    "invoiceId": "'.rand().'",
    "merchantKey": "'.MERCHANT_KEY.'",
    "merchantToken": "'.MERCHANT_TOKEN.'",
    "integrationType": "MSDK",
    "integrationVersion": "1.0.1",
    "refererUrl": "https://www.yourdomain.lk/check_status.php",
    "logoUrl": "https://images.cinemaexpress.com/uploads/user/imagelibrary/2023/2/6/original/LeoTrailerBreakdownAssassinchocolatierorasweetkiller.jpg",
    "webhookUrl": "'.PAYMENT_WEBHOOK_URL.'",
    "returnUrl": "'.PAYMENT_RETURN_URL.'",
    "amount": "39.39",
    "currencyCode": "LKR",
    "orderDescription": "Sri Shakthi Product - Oil",
    "customerFirstName": "Subashini",
    "customerLastName": "Thanikaikumaran",
    "customerEmail": "your@gmail.com",
    "customerMobilePhone": "0770000000",
    "billingAddressStreet": "Kovil Road",
    "billingAddressCity": "Koomankulam",
    "billingAddressCountry": "LK",
    "billingAddressPostcodeZip": "43000",
    "billingAddressStateProvince": "Nothern",
    "shippingContactFirstName": "Subashini",
    "shippingContactLastName": "Thanikaikumaran",
    "shippingContactEmail": "your@gmail.com",
    "shippingContactMobilePhone": "0770000000",
    "shippingAddressStreet": "Kovil Road",
    "shippingAddressCity": "Koomankulam",
    "shippingAddressCountry": "LK",
    "shippingAddressPostcodeZip": "43000",
    "shippingAddressStateProvince": "Nothern"
}';


$apiService = new APIController();
$paymentInit=$apiService->paymentInitiate(PAYMENT_INT_URL,$data,'Payment Initiate');
$dataArr = json_decode($paymentInit, true);



if (isset($dataArr['error'])) {
    echo $dataArr['error'];
    
} elseif (isset($dataArr['paymentPage'])) {
    $paymentURL=$dataArr['paymentPage'];
    header("Location: $paymentURL");
} else {
    echo "error";
}
