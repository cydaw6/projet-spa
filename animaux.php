<?php
require_once("./classes/__init__.php");
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


    <link href="main-style.css" rel="stylesheet">
    <link href="public-style.css" rel="stylesheet">

    <title>SPA - Refuges </title>
    <link rel="icon" href="./assets/img/favicon.ico"/>
</head>
<body>

<?php

require_once("./global-includes/header.php");

$animaux = array();

$animaux = Animal::search_animaux(
    ($_GET["refuge"] ?? array()),
    ($_GET["nom"] ?? ""),
    ($_GET["espece"] ?? array()),
    ($_GET["sexe"] ?? "")
);

?>

<div class="main">
    <!-- infos -->

    <div class="container-fluid section-fiche" >
        <div class="container main-view">
            <br><br>
            <p class="" id="title"></p>
            <div class="form-container">
                <form method="get" >
                    <div class="row">
                        <div class="col">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control">
                        </div>
                        <div class="col">
                            <label for="espece">Espece</label>
                            <select class="selectpicker show-tick form-control" name="espece[]" id="espece" multiple>
                                <?php
                                foreach (DB::get_especes() as $row) {
                                    echo '<option value="' . $row["e_id"] . '">' . $row["e_nom"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col">
                            <label for="sexe">Sexe</label>
                            <select name="sexe" id="sexe" class="selectpicker show-tick form-control ">
                                <option value="" selected>Indifférent</option>
                                <option value="M">Mâle</option>
                                <option value="F">Femelle</option>
                            </select>
                        </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="refuge">Refuge</label>
                            <select class="selectpicker show-tick form-control" name="refuge[]" id="refuge" multiple data-live-search="true"
                                <?php
                                foreach (Refuge::get_all_refuge() as $row) {
                                    echo '<option value="' . $row["r_id"] . '">' . $row["r_nom"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col text-lg-end">
                            <br>
                            <button type="submit" name="send-search" class="btn btn-primary  classic-submit ">Rechercher</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            <br>
            <div class=" flex-scroller" id="a-scroller">
                <?php
                /*foreach($animaux as $a){
                    echo '
                           <a class="ref-link" style="display: none;" espece="'.$a["e_nom"].'">
                                <div class="card card-animal" style="width: 18rem;">
                                  <img src="" class="card-img-top" alt="">
                                  <div class="card-body">
                                    <p class="card-text text-lg-center">
                                    '.$a["a_nom"].'
                                    
                                    </p>
                                  </div>
                                </div>
                            </a> ';
                }
                */?>
            </div>
            <div class="row" style="margin: 1em; text-align: center;">
                <div class="col ">
                    <div type="button" id="plus"  onclick="plus();" class="btn btn-primary" style=""> <i class="fas fa-chevron-down"></i></div>

                </div>
            </div>
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

<!-- Bootstrap multiselect Beta -->
<script src="./assets/lib/bootstrap-select.js"></script>

<!-- Option du multiselect -->
<script>
    $.fn.selectpicker.Constructor.DEFAULTS.selectedTextFormat = 'count';
    $.fn.selectpicker.Constructor.DEFAULTS.noneSelectedText = "0 élément";

</script>

<?php

require_once("./assets/scripts/data-format.php");

?>


</body>

</html>
