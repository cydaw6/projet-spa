<?php

require_once("./classes/__init__.php");
if(!isset($_GET["ida"])){
    header("location: animaux.php");
}
$animal = Animal::get_animal_by_id($_GET["ida"]);
if(!isset($animal->data["a_id"])){
    header("location: animaux.php");
}

?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css -->

    <link rel="icon" href="./assets/img/favicon.ico"/>
    <link href="main-style.css" rel="stylesheet">
    <link href="public-style.css" rel="stylesheet">

    <title>SPA - Refuges </title>

</head>
<body>

<?php

require_once("./global-includes/header.php");

$data = $animal->get_all_data();
?>

<div class="main">
    <!-- infos -->

    <div class="container-fluid section-fiche" style="background-color: var(--main-beige);">

        <div class="container main-view">

            <p class="" id="title" ></p>
            <br>
            <span class="page-btn">
                <a href="./animaux.php" class="add">
                    <i class="fas fa-arrow-left fa-2x left"></i>
                </a>
            </span>
            <br><br>
            <div class="fiche-container" style="padding: 1.5em; background-color: white;">
                <div class="row">
                    <div class="col-md-4">
                        <img src="
                            <?php echo ($_GET["img"] ?? "https://jcromerohicks.lat/estilos/assets/img/background/ios-linen-light-gray.png"); ?>"
                             class="rounded img-fluid" alt="image animal"
                        >

                    </div>
                    <div class="col-md-7" style="margin: 1em; text-align: left;">
                        <div class="row row-info">
                            <div class="col lib-info">
                                Nom
                            </div>
                            <div class="col">
                                <?php echo $data["a_nom"]; ?>
                            </div>
                        </div>
                        <div class="row row-info">
                            <div class="col lib-info">
                                Espèce
                            </div>
                            <div class="col">
                                <?php echo $data["e_nom"]; ?>
                            </div>
                        </div>
                        <div class="row row-info">
                            <div class="col lib-info">
                                Sexe
                            </div>
                            <div class="col">
                                <?php echo ($data["a_nom"] == "M" ? "Mâle" : "Femelle"); ?>
                            </div>
                        </div>
                        <div class="row row-info">
                            <div class="col lib-info">
                                Description
                            </div>
                            <div class="col">
                                <?php echo $data["a_commentaire"]; ?>
                            </div>
                        </div>
                        <div class="row row-info">
                            <div class="col lib-info">
                                Date de naissance
                            </div>
                            <div class="col">
                                <?php echo $data["a_date_naissance"]; ?>
                            </div>
                        </div>
                        <div class="row row-info">
                            <div class="col lib-info">
                                Refuge
                            </div>
                            <div class="col">
                                <?php echo $animal->get_refuge()["r_nom"]; ?>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <br>
            <div class="col-md-4">
                <div class="btn btn-info" name="set-deces" style="background-color: var(--main-orange); color: white; border: none; border-radius: 10px; font-weight: bold;">Je souhaite rencontrer cet animal</div>
            </div>
            <br>
        </div>

    </div>

</div>

<?php
require("./global-includes/footer.html");
?>

<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>
