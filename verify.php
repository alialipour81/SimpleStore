<?php
session_start();
$MerchantID = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
$Amount = $_SESSION['all_price']; //Amount will be based on Toman
$Authority = $_GET['Authority'];

if ($_GET['Status'] == 'OK') {

    $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

    $result = $client->PaymentVerification(
        [
            'MerchantID' => $MerchantID,
            'Authority' => $Authority,
            'Amount' => $Amount,
        ]
    );

    if ($result->Status == 100) {
        echo 'Transaction success. RefID:'.$result->RefID;
        require_once 'files/connect/database.php';
        $query = "UPDATE basket SET status=? WHERE user_id=?";
        $action->inud($query,[1,$_SESSION['userid']]);
        if ($action == true) {
            header('location:bascket.php?order=success');
        }

    } else {

        echo 'Transaction failed. Status:'.$result->Status;
    }
} else {
    header('location:bascket.php?order=error');}

?>