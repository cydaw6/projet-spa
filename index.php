<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>SPA</title>

  </head>
  <body>

      <?php
      require_once("./classes/__init__.php");
      require("./includes/header.php");
      $res = $db->query("SELECT COUNT(*) nbr FROM animal;");

      ?>

      <div class="main">
          <!-- infos -->
          <div class="container-fluid text-center section-info" >

              <div class="" id="fade-accueil-left">
              </div>
              <div class="" style="" id="fade-accueil-right" >
                <div id="div-fade">
                </div>
              </div>

              <div class="container-fluid fade-accueil-container">
                  <div class="container unique-font" >
                      <p class="text-uppercase" id="title"> Donnons-leur autant <br> qu'ils nous apportent <br></p>
                      <p id="decription">
                          Pour toutes les fois où ils nous ont sauvé la mise et nous ont apporté tendresse,
                          joie, réconfort. Parce qu’ils le méritent tant,
                          donnons-leur autant qu’ils nous apportent !
                      </p>
                      <br>
                      <button type="button" class="btn btn-light">Je donne</button>
                      <button type="button" class="btn btn-light">J'adopte</button>
                      <button type="button" class="btn btn-light">Je découvre</button>
                  </div>

              </div>

          </div>
          <!--Sec -->
          <div class="container-fluid text-center" id="stat" >
              <div class="container">
                  <div class="animals-count unique-font text-uppercase">
                      <p >Actuellement <br>
                          <span class="orange">
                              <?php echo $res->fetch()["nbr"] . ' animaux'; ?>
                          </span>
                              à l'adoption
                      </p>
                  </div>
              </div>
          </div>
      </div>

      <?php
      require("./includes/footer.html");
      ?>

    <!-- Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

  </body>
</html>
