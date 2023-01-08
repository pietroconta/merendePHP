<?php
session_start();
include_once("Merenda.php");
include_once('Authenticator.php');
include_once('UsersManager.php');
include_once('OrdiniManager.php');
$_SESSION["unsArrMerenda"] = getUnsArrMerenda();



function getMerende()
{
    $unsArrMerenda = getUnsArrMerenda();
    foreach ($unsArrMerenda as $i => $elem) {
        if ($elem->getCost() > 0) {

            echo '<div class="formLine"><span>' . $elem->getName() . ' (disp: ' . $elem->getNum() . ')'.$elem->getCost() . '€</span><input type="number" min="0" max="' . $elem->getNum() . '" value="0" name="x' . $elem->getName() . '"></div>';
        }


    }

    echo "<input type='submit' name='submit' class=frmSubmit>";



}


if (isset($_POST["submit"])) {
    if (!validateOrder()) {
        echo 'Ordine non valido';
    }
    $merendeInOrder = [];
    $num = 0;
    $cost = 0;
    //print_r($_POST);
    foreach ($_SESSION["unsArrMerenda"] as $i => $elem) {

        $nameFormatted = str_replace(" ", "_", $elem->getName());
        if (isset($_POST["x" . $nameFormatted]) && $_POST["x" . $nameFormatted] > 0) {
            for ($c = 0; $c < $_POST["x" . $nameFormatted]; $c++) {
                $merendeInOrder[$num] = $elem;

                scaleAvailability($_POST["x" . $nameFormatted], $merendeInOrder[$num]);
                $cost += $merendeInOrder[$num]->getCost();
                $num++;
            }
        }



    }
    //echo $cost;
    // print_r($_SESSION["unsArrMerenda"]);

    //print_r($merendeInOrder);
    $user = $_SESSION["user"];
    if ($user->getCredit() >= $cost) {

        //echo 'ok';
        $user->setCredit($user->getCredit() - $cost);
        updateUser($user);

        $ordine = new Ordine($user, $merendeInOrder, $cost, date("Y-m-d h:i:sa"));
        addOrdine($ordine);
        header("location: index.php");
    }



}



function validateOrder()
{

    foreach ($_SESSION["unsArrMerenda"] as $i => $elem) {

        $nameFormatted = str_replace(" ", "_", $elem->getName());


        if (isset($_POST["x" . $nameFormatted]) && $_POST["x" . $nameFormatted] > $elem->getNum() || $_POST["x" . $nameFormatted] < 0) {
            //echo $elem->getNum() . " " . $_POST["x" . $elem->getName()];
            return false;
        }


    }
    return true;
}

function getUnsArrMerenda()
{
    return array_map('unserialize', file('merende.txt'));
}

function getOrderHistory()
{
    $arrOrder = getOrdersOf($_SESSION["auth"]);
    foreach ($arrOrder as $key => $order) {
        $merendeOfOrder = $order->getMerende();
        foreach ($merendeOfOrder as $key2 => $merenda) {
            echo "-" . $merenda->getName() . " Costo: " . $merenda->getCost() . "<br>";
        }
        echo "Totale: " . $order->getTot() . "<br>";
        echo "Ordine effettuato il: " . $order->getDate() . "<br><br>";
    }

}

function scaleAvailability(int $numb, $merenda)
{
    $arrUns = getUnsArrMerenda();
    $lengthOfArruns = count($arrUns);
    
    for ($i = 0; $i < $lengthOfArruns; $i++) {
       
        if ($arrUns[$i] == $merenda) {
            $num = $arrUns[$i]->getNum();
            $newNum = $num - $numb;
            echo $newNum;
            $arrUns[$i]->setNum($newNum);
            echo "d" . $arrUns[$i]->getNum();
        }
        $merendaSerialized = serialize($arrUns[$i]);
        if ($i > 0) {
            file_put_contents('merende.txt', $merendaSerialized . "\n", FILE_APPEND);
        } else {
            file_put_contents('merende.txt', $merendaSerialized . "\n");
        }
    }

}
?>