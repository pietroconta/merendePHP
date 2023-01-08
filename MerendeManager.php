<?php
include_once("Merenda.php");
include_once("User.php");
if (!empty($_POST)) {

    if (isset($_POST["postbtn"]) && $_POST["postbtn"] == "Aggiungi") {
        echo 'okkkk';
        $merenda = new Merenda($_POST["name"], $_POST["cost"], $_POST["numberOfDisp"]);
        $merenda = serialize($merenda);
        // store $s somewhere where page2.php can find it.
        file_put_contents('merende.txt', $merenda . "\n", FILE_APPEND);
    } else if (isset($_POST["postbtn"]) && $_POST["postbtn"] == "Crea") {
        echo 'okk';
        $pswHashedAndSalted = password_hash($_POST["psw"] . "asdkj37dj", PASSWORD_DEFAULT); 
        $user = new User($_POST["username"], $pswHashedAndSalted, $_POST["credit"]);
        $user = base64_encode(serialize($user));
        // store $s somewhere where page2.php can find it.
        file_put_contents('users.txt', $user . "\n", FILE_APPEND);
    }
    

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Merende manager</title>
</head>

<body>
    <div id="mainContainer">

        <div class="containerForm">
            <form method="post" action="MerendeManager.php" class="frmmain">
                <div class="formLine"><span>Nome Merenda</span><input type="text" name="name"></div>
                <div class="formLine"><span>Numero Disp</span><input type="number" name="numberOfDisp"></div>
                <div class="formLine"><span>Costo</span><input type="number" name="cost" step="0.25"></div>
                <input type="submit" value="Aggiungi" name="postbtn">
            </form>


        </div>

        <div class="containerForm">
            <form method="post" action="MerendeManager.php" class="frmmain">
                <div class="formLine"><span>Nome Utente</span><input type="text" name="username"></div>
                <div class="formLine"><span>Password</span><input type="text" name="psw"></div>
                <div class="formLine"><span>Credito</span><input type="number" name="credit" step="0.1"></div>
                <input type="submit" value="Crea" name="postbtn">
            </form>


        </div>




    </div>
    </div>
</body>

</html>