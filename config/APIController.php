<?php
require_once('config.php');
class APIController
{

    function paymentInitiate($url, $data, $requestType)
    {
        $randam =  rand();
        $this->writeLog($requestType, $randam, "", $url, $data, null, "request");
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data, //json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $this->writeLog($requestType, $randam, "", "", $data, $response, "response");
        return $response;
    }


    function checkPaymentStatus($uid,$statusIndicator)
    {
        $url=PAYMENT_CHECK_STATUS_URL."?uid=$uid&statusIndicator=$statusIndicator";
        $data=array('uid'=>$uid,'statusIndicator'=>$statusIndicator);
        $randam =  rand();
        $this->writeLog('check payment status', $randam, "", $url, $data, null, "request");
        $curl = curl_init();
        

        curl_setopt_array($curl, array(
            CURLOPT_URL =>$url ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $this->writeLog('check payment status', $randam, "", "", $data, $response, "response");
        return $response;
    }






    function writeLog($requestType, $randam, $infor = null, $requestUrl = null, $requestData = null, $responseData = null, $type = null)
    {
        if (LOG == 1) {
            $log = "";
            if ($type == "request") {
                $log = "";
                $log .= "*****************************************************" . PHP_EOL;
                $log .= "                        NEW                          " . PHP_EOL;
                $log .= "*****************************************************" . PHP_EOL;
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " " . $requestType . " Request - " . $randam . PHP_EOL;
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " URL - " . $requestUrl . PHP_EOL;
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " Request " . json_encode($requestData, true)  . PHP_EOL;
            } elseif ($type == "response") {
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " " .  $requestType . " Response - " . $randam . PHP_EOL;
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " body - " . json_encode($responseData, true) . PHP_EOL;
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " json - " .  json_encode($responseData, true) . PHP_EOL;
                if (isset($responseData['error'])) {
                    $log .= "Log v3 : " . date('Y-m-d H:i:s') . " API error - " . $responseData['error'] . PHP_EOL;
                }
            } else {
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " " .  $requestType . " - " . $randam . PHP_EOL;
                $log .= "Log v3 : " . date('Y-m-d H:i:s') . " infor - " . $infor . PHP_EOL;
            }
            $log .= "-----------------------------------------------------" . PHP_EOL;
            file_put_contents('log/Log' . date("j.n.Y") . '.log', $log, FILE_APPEND | LOCK_EX);
        }
    }
}
