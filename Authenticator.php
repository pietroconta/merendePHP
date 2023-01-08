<?php
include_once("UsersManager.php");
if (!isset($_SESSION["auth"])) {
    header("location: auth.php");
}
updUsrInSVar();
function getSessionId()
{
    return $_SESSION["auth"];
}

function getUserFromSessionId(string $token)
{
    $unsArray = getUnsArrUsers();
    foreach ($unsArray as $ket => $user) {
        if (in_array($token, $user->getSessionIdArray())) {
            return $user;
        }
    }

}

function updUsrInSVar()
{
    $_SESSION["user"] = getUserFromSessionId($_SESSION["auth"]);
}
?>