<?php
include_once("Ordine.php");
include_once("User.php");
function getUnsArrOrdini()
{
    $handle = fopen("ordini.txt", "r");
    $arrDec = [];
    if ($handle) {
        $i = 0;
        while (($line = fgets($handle)) !== false) {
            $arrDec[$i] = base64_decode($line);
            $i++;
        }

        fclose($handle);
    }
    return array_map('unserialize', $arrDec);
}

function addOrdine($ordine)
{
    $ordineSerialized = base64_encode(serialize($ordine));
    file_put_contents('ordini.txt', $ordineSerialized . "\n", FILE_APPEND);
}

function getOrdersOf($sessionId)
{
    $allOrders = getUnsArrOrdini();
    $orders = [];
    $i = 0;
    foreach ($allOrders as $key => $order) {
        if (in_array($sessionId, $order->getUser()->getSessionIdArray())) {
            $orders[$i] = $order;
            $i++;
        }
    }
    return $orders;
}
?>