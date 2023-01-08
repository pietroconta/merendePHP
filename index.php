<?php
include_once('MerendeEngine.php');
include_once('Authenticator.php');


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ordine per <?php echo $_SESSION["user"]->getUsername() ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div id="mainContainer">
        <?php echo "<h3>Ciao " . $_SESSION["user"]->getUsername() . " il tuo credito è di " . $_SESSION["user"]->getCredit() . "</h3> ";?>
        <div class="containerForm">
            <form action="MerendeEngine.php" method="POST" class="frmmain">
                <?php
                getMerende();
                ?>
            </form>

        </div>

        Storico Ordini:<br>
        <?php
        getOrderHistory()
            ?>
    </div>
</body>

</html>