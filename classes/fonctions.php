<?php

function best_cost(): int
{
    /**
     * Renvoie le meilleur coût (meilleur nombre d'itérations
     * pour la fonction de hachage propre au serveur
     */
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

function hashage($txt){
    /**
     * Renvoi le hachage d'une chaîne de caractère entrée en paramètre
     */
    return password_hash($txt, PASSWORD_DEFAULT, ["cost" => best_cost()]);
}

function sanitize($data) {
    $data = trim($data);
    //$data = stripslashes($data);
    //$data = htmlspecialchars($data);
    return $data;
}