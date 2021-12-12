
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

</head>
<body>

<?php
require_once("./classes/__init__.php");
require_once("./global-includes/header.php");

$refs = Animal::search_animaux();


?>

<div class="main">
    <!-- infos -->

    <div class="container-fluid section-fiche">
        <div class="container main-view">
            <br><br>
            <p class="" id="title" > Trouvez un refuge</p>
            <div class="form-container">
                <form method="get" >
                    <div class="row">
                        <div class="col">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control">
                        </div>
                        <div class="col">
                            <label>Espèce</label>
                            <input type="text" name="code" class="form-control">
                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <div class="col text-lg-end">
                            <button type="submit" name="send-search" class="btn btn-primary  classic-submit ">Rechercher</button>
                        </div>

                    </div>

                </form>
            </div>
            <br>
            <div class="fiche-container flex-scroller">



                <?php

                foreach($refs as $a){
                    echo '
                           <a class="ref-link">
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
                ?>
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

<script>
    window.onload = function() {

        let images = document.getElementsByClassName('card-animal');

        for(let i = 0; i < images.length; i++) (async function(childNode1) {
            if(childNode1) {
                console.log("hey");
                const response = await fetch('https://api.thedogapi.com/v1/images/search?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=1');
                const names = await response.json();
                childNode1.src = names[0].url;
            }
        })(images[i].childNodes[1]);
    };





    /*
*/
</script>


</body>

</html>
