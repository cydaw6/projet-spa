<!doctype html>
<html lang="fr">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

      <!-- Fontawesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

      <!-- custom css -->
      <link href="main-style.css" rel="stylesheet">
      <title>SPA - Accueil</title>

  </head>
  <body>

      <?php
        require_once("./classes/__init__.php");
        require("./global-includes/header.php");
        $cnx = DB::$db->query("SELECT COUNT(*) nbr FROM animal WHERE a_date_adoption IS NULL AND a_date_deces IS NULL");
        // basename(dirname(__FILE__));
        // echo $GLOBALS["p_root"];
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
                              <?php echo $cnx->fetch()["nbr"] . ' animaux'; ?>
                          </span>
                              à l'adoption

                      </p>
                  </div>
              </div>
          </div>
      </div>

      <?php
      require("./global-includes/footer.html");
      ?>

      <!-- Popper and Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

  </body>
</html>
