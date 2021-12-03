<?php

require_once("../classes/__init__.php");


$err_msg = "";
$valide = false;
if (isset($_POST["send"])) {
    if (Personnel::connect($_POST["identifiant"], $_POST["mdp"])) {
        header("refresh:2; accueil.php");
        $valide = true;
    } else {
        $err_msg = "Utilisateur introuvable";
    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../style.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <title>SPA</title>

</head>
<body>

<?php
require_once("../global-includes/header.php");
?>
<div class="main">
    <!-- infos -->
    <div class="container-fluid text-center section-login">

        <div class="container-fluid fade-accueil-container">
            <div class="container unique-font" >
                <p class="" id="title"> S'identifier </p>
                <br>
                <form id="form-login" method="POST">
                    <div class="mb-3">
                        <label for="identifiant" class="form-label" >Login</label>
                        <input type="text" class="form-control" id="identifiant" name="identifiant" pattern="[a-zA-Z0-9 ]+" required>
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" required>
                    </div>

                    <button type="submit" name="send" class="btn spa-button" >Valider</button>
                </form>
                <?php
                    if($valide){
                        echo '<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
                    }else{
                        echo '<p style="margin-top: 2em;text-align: center; color: var(--main-warn-orange)" >'.$err_msg.'</p>';
                    }
                ?>
            </div>

        </div>

    </div>

</div>

<?php
require("../global-includes/footer.html");
?>

<!-- Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>
