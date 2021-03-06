
<?php
// $path =  '/'.basename(dirname(__FILE__));
// $path = dirname($_SERVER["PHP_SELF"]);
//define("ROOT","/~antoine.bastos/");
//const ROOT = "/";
const ROOT = "/~antoine.bastos/";


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
                        <li class="nav-item brd-right">
                            <a class="nav-link"  <?php echo 'href="'.ROOT.'./refuges.php"'; ?>>Refuges</a>
                        </li>
                        <li class="nav-item brd-right">
                            <a class="nav-link"  <?php echo 'href="'.ROOT.'./animaux.php"'; ?>>Animaux</a>
                        </li>
                        <?php
                            if(isset($_SESSION["user"])){
                                echo '
                                     <li class="nav-item  brd-right">
                                        <a class="nav-link" aria-current="page" href="'.ROOT.'./administration/accueil.php">Mes refuges</a>
                                    </li>
                                    <li class="nav-item  brd-right">
                                        <a class="nav-link" aria-current="page" href="'.ROOT.'./administration/deconnexion.php">D??connexion</a>
                                    </li>
                                ';
                            }else{
                                echo '
                                    <li class="nav-item  brd-right">
                                        <a class="nav-link" aria-current="page" href="'.ROOT.'administration/login.php">Connexion</a>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
                <?php
                    if(isset($_SESSION["user"]) && basename($_SERVER['PHP_SELF']) != "login.php"){
                        $refuges = $_SESSION["user"]->get_refuges();
                        echo '<a href="'.ROOT.'administration/fiche-refuge.php?idref='. $refuges[0]["r_id"].'&view=info-p&idp='.$_SESSION["user"]->data["p_id"].'"><p id="nav-username">'.$_SESSION["user"]->data["p_prenom"].' '.$_SESSION["user"]->data["p_nom"].'&nbsp;&nbsp;<i class="fas fa-user"></i></p></a>';
                    }
                ?>
            </div>
        </nav>
    </div>
</div>
<!--
<img src="https://upload.wikimedia.org/wikipedia/fr/archive/0/00/20161112112229%21Logo_de_la_SPA_%28France%29.png" alt="logo spa">
-->
