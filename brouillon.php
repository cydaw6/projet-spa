<?php
// faut utiliser nos fichiers à nous : Quand on s'est parlé en voc
// je t'ai dis qu'il fallait importer le "__init__.php"
require_once("./classes/__init__.php");
// require('connexion.inc.php');

$errors=[];

// tester le formulaire seulement si le formulaire a été envoyé
if(isset($_GET["send"])){
    if(isset($_GET["nom"]) && empty($_GET['nom'])){
        array_push($errors,"vous devez saisir une localité avant de faire la recherche");
        var_dump($errors);exit;
    }

    if(empty($errors)){
        $get=filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        //var_dump($get);
        // echo $form;
        /* $req=$connexion->prepare('SELECT * from gvhdbjfjk where localiter = :fom');
        $req->binValue(':form',$form,PDO::PARAM_STR);
        $req->execute();
        $results=$req->fetchAll();
        */

        // Je t'ai montré quand on s'est parlé sur discord
        // faut utiliser la classe DB (DataBase = base de données en anglais)
        $resultats = DB::$db->prepare("SELECT * FROM refuge WHERE r_nom LIKE '%' || ? || '%'");
        $resultats->execute(array($_GET["nom"]));
        $resultats = $resultats->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- custom css -->
        <link href="style.css" rel="stylesheet">
        <title>SPA - Accueil</title>

    </head>
</head>
<body>
<?php
// tu peux importer la barre de navigation toute prête que j'ai fait
require("./global-includes/header.php");
?>

<form action="" method = "get">
    <!--
       Tips: L'attribut "required" est pratique,
      il oblige l'utilisateur à rentrer quelque chose sinon il ne peut pas valider
     -->
    <label>
        Nom
        <input type="text" name="nom" required placeholder="Essaye de rentrer une lettre">
    </label>
    <input type="submit" name="send" value="valider" required>
</form>

<?php

if(isset($resultats)){

    foreach($resultats as $resultat):
        echo '<p>'.$resultat["r_nom"].''.$resultat["r_adresse"].'</p>';
    endforeach;
}
?>

<?php
// tu peux importer le pied de page tout prêt que j'ai fait
require("./global-includes/footer.html");
?>

</body>
</html>


<?php
require_once("../classes/__init__.php");
session_start();


// nom de vue passée via GET devient celle par défaut
if(isset($_GET["view"])){
    $_SESSION["view"] = $_GET["view"];
}else{
    $_SESSION["view"] = "infos";
}

$refuge = null;
if(isset($_GET["idref"])){
    $refuge = Refuge::get_refuge_data_by_id($_GET["idref"]);
}else{
    header("location: accueil.php");
}


// nécessaire pour la pagination
if(!isset($_GET["page"])){
    $_GET["page"] = 0;
}

if(!isset($_GET["act"])){
    $_GET["act"] = "search";
}

// nombre d'entrées par requêtes
$offset_page = 10;
$curr_url = $_SERVER["REQUEST_URI"];
$base_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . "?";
//echo $base_url.'<br>';
$row_count = 0;
// on vérifie que le personnel à bien accès à la fiche du refuge
$user = $_SESSION["user"];
if(!$user->exerce_in_refuge($refuge->data["r_id"])){
    header("location: accueil.php");
}
?>