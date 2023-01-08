<?php
session_start();
include_once("UsersManager.php");
if (isset($_POST["submitForm"])) {
    $username = $_POST["usn"];
    $usersArr = getUnsArrUsers();

    foreach ($usersArr as $i => $user) {
        // echo "Password: " . $user->getPassword() . " Username: " . $user->getUsername() . "<br>";
        if ($user->getUsername() == $username && password_verify($_POST["psw"] . "asdkj37dj", $user->getPassword())) {
            echo 'logged';
            echo ' as ' . $user->getUsername();
            //header("location: index.php");
            $newTokenAuth = auth($user);
            if (isset($newTokenAuth)) {
                $_SESSION["auth"] = $newTokenAuth;
                header("location: index.php");
            } else {
                echo 'logged but something went wrong sorry';
            }

        }
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
    <title>Sign in - Merende</title>
</head>

<body>
    <div id="mainContainer">
        <div class="containerForm">
            <h1>Accedi</h1>
            <form action="auth.php" method="POST" class="frmmain">
                Username<input type="text" name="usn">
                Passowrd<input type="text" name="psw">
                <input type="submit" name="submitForm" value="Accedi">
            </form>
        </div>
    </div>
</body>

</html>