<?php

/**
 * Renvoie le meilleur coût (meilleur nombre d'itérations
 * pour la fonction de hachage propre au serveur
 * @return int
 */
function best_cost(): int
{

    $timeTarget = 0.05; // 50 millisecondes

    $cost = 8;
    do {
        $cost++;
        $start = microtime(true);
        password_hash("test", PASSWORD_DEFAULT, ["cost" => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);
    return $cost;
}

/**
 * Renvoi le hachage d'une chaîne de caractère entrée en paramètre
 * @param $txt
 * @return false|string|null
 */
function hashage($txt){
    return password_hash($txt, PASSWORD_DEFAULT, ["cost" => best_cost()]);
}

/**
 * Enlève les espèce de fin et de début en trop
 * Enlève les slashes
 * Transformes les caractère spéciaux d'une chaîne à son équivalent
 * HTML (ex: '<' => ' &lt;')
 * @param $data
 * @return string
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_NOQUOTES);
    return $data;
}

/**
 * Renvoie le booleen associé
 * à "on" et "off"
 * Pratique pour les input checkbox
 * @param $val
 * @return bool
 */
function checktobool($val){
    if($val == "on"){
        return true;
    }
    return false;
}

/**
 * Renvoie le contraire de 
 * des codes d'ordre de tri sql
 * 
 */
function reverse_ord($ord){
    return $ord === "ASC" ? "DESC": "ASC";
}

/**
 * Renvoie une chaîne de caractère
 * alphanumérique aléatoire d'une taille donné.
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10)
{

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}