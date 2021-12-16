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
    <!doctype html>
    <html lang="en">
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

        <link href="../main-style.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
        <title>SPA - <?php echo $refuge->data["r_nom"]; ?> </title>
        <link rel="icon" href="../assets/img/favicon.ico"/>

    </head>
    <body>

    <?php
    require_once("../global-includes/header.php");
    ?>

    <div class="main">
        <!-- infos -->

        <div class="container-fluid section-fiche">
                <div class="container">
                    <?php
                    if($_SESSION["view"] == "infos"){
                        echo '
                            <span class="page-btn">
                                <a href="./accueil.php" class="add">
                                    <i class="fas fa-arrow-left fa-2x left"></i>
                                </a>
                            </span>
                        
                        ';
                    }

                    ?>
                    <br><br>
                    <?php
                    $test_info_p = ($_SESSION["view"] == "info-p" && (isset($_GET["idp"]) && $_GET["idp"] == $_SESSION["user"]->data["p_id"]));
                    if(!$test_info_p){
                        echo '<p class="" id="title" > '.$refuge->data["r_nom"].'</p>';
                    }
                    ?>
                        <div class="fiche-container">
                            <?php
                            if(!$test_info_p){
                            ?>
                            <div id="nav-onglet" >
                                <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=infos">
                                    <div class="nav-a <?php echo ($_SESSION["view"] === "infos") ? "nav-a-select" : ""; ?>" >
                                        <p>Le refuge</p>
                                    </div>
                                </a>
                                <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=animaux" >
                                    <div class="nav-a <?php echo ($_SESSION["view"] === "animaux") ? "nav-a-select" : " "; ?>" >
                                        <p>Animaux</p>
                                    </div>
                                </a>
                                <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=personnel">
                                    <div class="nav-a <?php echo ($_SESSION["view"] === "personnel") ? "nav-a-select" : ""; ?>" >
                                        <p>Personnel</p>
                                    </div>
                                </a>
                                <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=transferts">
                                    <div class="nav-a <?php echo ($_SESSION["view"] === "transferts") ? "nav-a-select" : ""; ?>" >
                                        <p>Transferts</p>
                                    </div>
                                </a>
                                <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=soins">
                                    <div class="nav-a <?php echo ($_SESSION["view"] === "soins") ? "nav-a-select" : ""; ?>" >
                                        <p>&nbsp;&nbsp;Soins&nbsp;&nbsp;</p>
                                    </div>
                                </a>
                            </div>
                            <?php
                            }
                            ?>

                            <div class="container-fluid form-onglet">
                                <?php

                                    if($_SESSION["view"] === "animaux"){
                                        include("includes/view-animaux.php");

                                    }elseif ($_SESSION["view"] === "personnel"){
                                        include("includes/view-personnel.php");

                                    }elseif ($_SESSION["view"] === "transferts"){
                                        include("includes/view-transfert.php");

                                    }elseif ($_SESSION["view"] === "soins"){
                                        include("includes/view-soins.php");

                                    }elseif ($_SESSION["view"] === "infos"){
                                        include("includes/view-infos.php");

                                    }elseif ($_SESSION["view"] === "vaccins"){
                                        include("includes/rappels-view.php");

                                    }elseif($_SESSION["view"] === "fa"){
                                        if(isset($_GET["aid"])){
                                            include("includes/view-fiche-animal.php");
                                        }
                                    }elseif($_SESSION["view"] === "info-p"){
                                        if(isset($_GET["idp"])){
                                            include("includes/view-fiche-personnel.php");
                                        }
                                    }

                                    if($_SESSION["view"] != "infos"){
                                        include("includes/pagination.php");
                                    }
                                ?>
                            </div>
                        </div>
                </div>

            </div>

        </div>

    <?php
    require("../global-includes/footer.html");
    ?>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- Bootstrap multiselect Beta -->
    <script src="../assets/lib/bootstrap-select.js"></script>

    <!-- Option du multiselect -->
    <script>
        $.fn.selectpicker.Constructor.DEFAULTS.selectedTextFormat = 'count';
        $.fn.selectpicker.Constructor.DEFAULTS.noneSelectedText = "0 élément";

    </script>





    </body>
</html>
