
<?php
// $path =  '/'.basename(dirname(__FILE__));
// $path = dirname($_SERVER["PHP_SELF"]);
//define("ROOT","/~***REMOVED***.***REMOVED***/");
const ROOT = "/";
/*const ROOT = "/~***REMOVED***.***REMOVED***/";*/
?>

<div class="logo-nav">
    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light " style="padding: 0;">
            <div class="container-fluid" >
                <a href="/">
                    <img src="https://upload.wikimedia.org/wikipedia/fr/archive/0/00/20161112112229%21Logo_de_la_SPA_%28France%29.png" alt="logo spa" style="max-height: 8em; width: auto;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item brd-left brd-right">
                            <a class="nav-link active" aria-current="page" <?php echo 'href="'.ROOT.'"'; ?>>Accueil</a>
                        </li>
                        <li class="nav-item brd-left brd-right">

                            <a class="nav-link" aria-current="page" <?php echo 'href="'.ROOT.'administration/login.php"'; ?> >Connexion</a>
                        </li>
                        <li class="nav-item brd-right">
                            <a class="nav-link"  <?php echo 'href="'.ROOT.'administration/accueil.php"'; ?>>Refuges</a>
                        </li>
                       <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                A propos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </div>
                <?php
                    if(isset($_SESSION["user"])){
                        echo '<a href=""><p id="nav-username">'.$_SESSION["user"]->data["p_prenom"].' '.$_SESSION["user"]->data["p_nom"].'&nbsp;&nbsp;<i class="fas fa-user"></i></p></a>';
                    }

                ?>
            </div>
        </nav>
    </div>
</div>
<!--
<img src="https://upload.wikimedia.org/wikipedia/fr/archive/0/00/20161112112229%21Logo_de_la_SPA_%28France%29.png" alt="logo spa">
-->
