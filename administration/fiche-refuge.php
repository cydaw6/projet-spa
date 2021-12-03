<?php
require_once("../classes/__init__.php");
session_start();

// nom de vue passée via GET devient celle par défaut
if(isset($_GET["view"])){
    $_SESSION["view"] = $_GET["view"];
}

// vue par défaut
if(!isset($_SESSION["view"])){
    $_SESSION["view"] = "animaux";
}

$refuge = null;
if(isset($_GET["idref"])){
    $refuge = Refuge::get_refuge_data_by_id($_GET["idref"]);
}

// nombre d'entrées par requêtes
$offset_page = 10;

?>
    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- custom css -->

        <link href="../style.css" rel="stylesheet">
        <link href="./style.css" rel="stylesheet">
        <title>SPA - <?php echo $refuge->data["r_nom"]; ?> </title>

    </head>
    <body>

    <?php
    require_once("../global-includes/header.php");
    ?>
    <div class="main">
        <!-- infos -->

        <div class="container-fluid section-fiche">
                <div class="container">
                        <p class="" id="title" > <?php echo $refuge->data["r_nom"]; ?> </p>
                        <div class="fiche-container">
                            <br>
                            <div id="nav-onglet" >
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
                                        <p>Soins</p>
                                    </div>
                                </a>
                            <?php 

                            ?>
                            </div>

                            <div class="container-fluid form-onglet">
                                <?php

                                    if($_SESSION["view"] === "animaux"){
                                        include("includes/view-animaux.php");

                                    }elseif ($_SESSION["view"] === "personnel"){
                                        include("includes/view-personnel.php");

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

    <!-- Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    </body>
    </html>
<?php
