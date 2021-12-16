<?php

$view_name = "info-p";


$personnel = Personnel::get_personnel_by_id($_GET["idp"]);
$p_refuges = $personnel->get_personnel_fonctions();
$p = $personnel->data;


?>



<br>
<?php
if($_GET["idp"] != $_SESSION["user"]->data["p_id"]){
?>

<span class="page-btn">
    <a href="./fiche-refuge.php?idref=<?php echo $refuge->data["r_id"]."&view=personnel"; ?>" class="add">
        <i class="fas fa-arrow-left fa-2x left"></i>
    </a>
</span>
<br><br><br>
<?php
}
?>

<div class="container">

</div>
<?php
    echo '

    <div class=" row" >
        <div class="col-md-6">
            <h4 class=""><b>'. $p["p_prenom"] .' ' . $p["p_nom"] .'</b></h4>
            <p class=""> <b>Tel</b>: '.trim(strrev(chunk_split(strrev($p["p_tel"]),2, ' '))).'</p>
            ';
            if($_GET["idp"] == $_SESSION["user"]->data["p_id"] || $refuge->data["p_id"] == $_SESSION["user"]->data["p_id"]){
                echo '
                    <p class=""> <b>Adresse:</b> '.$p["p_adresse"].', '.$p["p_localite"].' '.$p["p_code_postal"].'</p>
                    <p class=""> <b>Num. Sécu. :</b> '.$p["p_num_secu"].'</p>    
                ';
            }

            if($_GET["idp"] == $_SESSION["user"]->data["p_id"]){
    ?>
            <form method="post"  oninput='psswdu2.setCustomValidity(psswdu2.value != psswdu.value ? "Les mots de passe ne correspondent pas" : "")'>
                <div class="row">

                    <div class="col-4">
                        <label for="unom">Login</label>
                        <input type="text" class="" name="unom" value="<?php echo $_SESSION["user"]->identifiants["login"]; ?>" disabled>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6">
                        <label for="psswdu">Nouveau mot de passe</label>
                        <input type="password" class="form-control" name="psswdu" required>
                    </div>
                    <div class="col-6">

                        <label for="psswdu2">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="psswdu2" required>
                    </div>

                </div>
                <div class="col-4">
                    <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
                    <input type="hidden" name="view" value="<?php echo $view_name; ?>">
                    <input type="hidden" name="page" value="0">
                    <br>
                    <button type="submit" class="btn btn-info" name="update-login">Valider</button>
                </div>
            </form>
            <br><br>
            <?php
                if(isset($_POST["update-login"])) {
                    $cnx = DB::$db->prepare("UPDATE identifiant SET mdp = ? WHERE id = ?");

                    if ($cnx->execute(array(hashage($_POST["psswdu2"]), $_SESSION["user"]->data["id"]))) {
                        echo '<div class=" row" >
                                <div class="col text-lg-center">
                                    <p > <span class="text-lg-center" style="color: lightgreen!important;">Mot de passe modifié</span> </p>
                                </div>
                            </div>
                        ';
                    }
                }
            }
            ?>
        </div>
<div class="col-md-6 text-lg-end" >
    <div class="row">
        <h4>Fonctions</h4>
    </div>
    <?php
    if($_GET["idp"] == $_SESSION["user"]->data["p_id"]){

        $result = array();
        foreach ($p_refuges as $elem) {
            if(!array_key_exists($elem["r_nom"], $result)){
                $result[$elem["r_nom"]]["fonctions"] = array();
            }
            array_push($result[$elem["r_nom"]]["fonctions"], $elem["fc_titre"]);
        }
        foreach ($result as $key => $values){

            echo '<div class="row" style="text-align: right; ">
                    <p style="font-weight: bold"> '.$key.':</p>
                   <p style="color: var(--main-warn-orange)!important;">'.implode(", ", $values["fonctions"]).'</p>
                  </div>';
        }
    }else{
        foreach ($p_refuges as $row){
            if($row["r_id"] === $refuge->data["r_id"]){
                echo '<div class="row" style="text-align: right; color: var(--main-warn-orange)!important;"><p>'.$row["fc_titre"].'</p></div>';

            }
        }
    }

    ?>

</div>

</div>
