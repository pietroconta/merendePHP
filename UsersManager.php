<?php
include_once("User.php");
function getUnsArrUsers()
{
    $handle = fopen("users.txt", "r");
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

function auth(User $userToLog)
{
    $arrUns = getUnsArrUsers();
    $lengthOfArruns = count($arrUns);
    $authIDToken = getToken(10);
    $added = false;
    for ($i = 0; $i < $lengthOfArruns; $i++) {

        if ($arrUns[$i] == $userToLog) {
            $arrUns[$i]->addSessionId($authIDToken);
            print_r($arrUns[$i]->getSessionIdArray());
            $added = true;
        }
        $userEncoded = base64_encode(serialize($arrUns[$i]));
        if ($i > 0) {
            file_put_contents('users.txt', $userEncoded . "\n", FILE_APPEND);
        } else {
            file_put_contents('users.txt', $userEncoded . "\n");
        }


    }

    if ($added) {
        return $authIDToken;
    }

}

function updateUser(User $newUser)
{

    $arrUns = getUnsArrUsers();
    $lengthOfArruns = count($arrUns);
    $authIDToken = getToken(10);
    $added = false;
    for ($i = 0; $i < $lengthOfArruns; $i++) {

        if (in_array($_SESSION["auth"], $arrUns[$i]->getSessionIdArray())) {
            $arrUns[$i] = $newUser;
            //print_r($arrUns[$i]->getSessionIdArray());
            $added = true;
        }
        $userEncoded = base64_encode(serialize($arrUns[$i]));
        if ($i > 0) {
            file_put_contents('users.txt', $userEncoded . "\n", FILE_APPEND);
        } else {
            file_put_contents('users.txt', $userEncoded . "\n");
        }


    }

    if ($added) {
        return $authIDToken;
    }
}

//https://stackoverflow.com/questions/1846202/how-to-generate-a-random-unique-alphanumeric-string
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
    }

    return $token;
}

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1)
        return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd& $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}



?>