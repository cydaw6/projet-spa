<?php
require_once("../classes/__init__.php");
session_start();
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
        <link href="../main-style.css" rel="stylesheet">
        <link href="admin-style.css" rel="stylesheet">
        <title>SPA</title>

    </head>
    <body>

    <?php
    require_once("../global-includes/header.php");
    $user = $_SESSION["user"];
    $refuges = $user->get_refuges();
    ?>
    <div class="main">
        <!-- infos -->
        <div class="container-fluid text-center section-login">

            <div class="container-fluid fade-accueil-container">
                <div class="container unique-font" >
                    <p class="" id="title"> Mes refuges </p>
                    <br>
                    <div id="liste-refuge" >
                        <?php
                            // boucle sur les refuges ou l'utilisateur à une fonction
                            foreach($refuges as $r){
                                echo '
                                    <a href="fiche-refuges.php?idref='. $r["r_id"].'">
                                        <div class="refuge-card">
                                            <p>'.$r["r_nom"].'</p>
                                        </div>
                                    </a>
                                
                                ';
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
