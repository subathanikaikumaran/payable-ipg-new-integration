<?php 

require_once('config/APIController.php');

$uid = isset($_GET['uid'])?$_GET['uid']:"";
$statusIndicator = isset($_GET['statusIndicator'])?$_GET['statusIndicator']:"";


$apiService = new APIController();
$paymentInit=$apiService->checkPaymentStatus($uid,$statusIndicator);
$dataArr = json_decode($paymentInit, true);

// print_r($dataArr['paymentPage']); exit;
if (isset($dataArr['error'])) {
    echo $dataArr['error'];
    
} elseif (isset($dataArr['data'])) {
    $data=$dataArr['data'];
    $status= isset($data['statusMessage'])?$data['statusMessage']:'Failed';
    echo "Payment Status : ".$status;
} else {
    echo "error";
}
