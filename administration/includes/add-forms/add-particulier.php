<?php

$err_msg = "";

if(isset($_POST["addpa-send"])){
    $cnx = DB::$db->prepare("
        SELECT
            *
            FROM particulier
            WHERE 
            (UPPER(pa_nom) LIKE UPPER(?) AND pa_tel = ?)
            OR (UPPER(pa_nom) LIKE UPPER(?) AND pa_code_postal = ? AND UPPER(pa_adresse) LIKE '%' || UPPER(?) || '%')
            OR pa_tel = ? 
    ");
    
    $cnx->execute(array($_POST["addpa-nom"], $_POST["addpa-tel"], $_POST["addpa-nom"], $_POST["addpa-codep"], $_POST["addpa-adresse"], $_POST["addpa-tel"]));
    $pa_data = $cnx->fetch();
    //echo count($pa_data) .' ::: '. var_dump($pa_data).'::: <br>';
    if($pa_data){
        echo '
                <div class=" row" >
                    <div class="col text-lg-center">
                                <p > <span class="text-lg-center" style="color: var(--main-warn-orange)!important;">Cette personne est déjà enregistrée.</span> </p>
                                <p > <span class="text-lg-center" style="color: white!important;">'
                                .$pa_data["pa_nom"]
                                .', '.$pa_data["pa_adresse"]
                                .' '.$pa_data["pa_localite"]
                                .' '.$pa_data["pa_code_postal"]
                                .'<br> '.trim(strrev(chunk_split(strrev($pa_data["pa_tel"]),2, ' ')))
                                .'</span> </p>
                    </div>
                </div>
        ';
    }else{
        $cnx = DB::$db->prepare("INSERT INTO particulier VALUES(default, ?, ?, ?, ?, ?) ");
        
        if($cnx->execute(array(
            $_POST["addpa-nom"], 
            sanitize($_POST["addpa-adresse"]), 
            $_POST["addpa-localite"], 
            $_POST["addpa-codep"], 
            $_POST["addpa-tel"]))){
            echo '<div class=" row" >
                    <div class="col text-lg-center">
                        <p > <span class="text-lg-center" style="color: lightgreen!important;">Particulier ajouté</span> </p>
                    </div>
                </div>
            ';

        }else{
            echo '
                <div class=" row" >
                    <div class="col text-lg-center">
                                <p > <span class="text-lg-center" style="color: var(--main-warn-orange)!important;">L\'ajout n\'a pas pu aboutir.</span> </p>
                    </div>
                </div>
            ';
        }
    }

//     $p = Personnel::verif_exist_personnel($_POST["add-nom"], $_POST["add-prenom"], $_POST["add-secu"], $_POST["add-tel"]);

//     if(count($p) != 0){
//         $err_msg = "L'utilisateur fait déjà partie de la spa";
//     }else{
//         $login = Personnel::create_logins($_POST["add-nom"], $_POST["add-prenom"]);
//         $personnel_id = Personnel::add_personnel(
//             sanitize($_POST["add-nom"]),
//             sanitize($_POST["add-prenom"]),
//             $_POST["add-secu"],
//             $_POST["add-tel"],
//             sanitize($_POST["add-adresse"]),
//             sanitize($_POST["add-localite"]),
//             $_POST["add-codep"],
//             $login["id"]
//         );

//         if($personnel_id){

//             $refuge->update_personnel_fonctions($personnel_id,  ($_POST["fc"] ?? array()));

//             echo '<div class=" row" >
//                         <div class="col text-lg-center">
//                                     <p > <span class="text-lg-center" style="color: lightgreen!important;">L\'utilisateur a été ajouté. <br> login: '.$login["login"].'<br> Mot de passe: '.$login["mdp"].'</span> </p>
//                         </div>
//                     </div>
//                  ';

//         }else{
//             $err_msg = "Impossible d'ajouter l'utilisateur";
//         }
//     }
//     echo '

//         <div class=" row" >
//             <div class="col text-lg-center">
//                         <p > <span class="text-lg-center" style="color: var(--main-warn-orange)!important;">'.$err_msg.'</span> </p>
//             </div>
//         </div>
        
// ';

}

?>
<!--https://regexlib.com/CheatSheet.aspx?AspxAutoDetectCookieSupport=1-->
    <form method="post" >
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" name="addpa-nom" id="nom" placeholder="" required>
                    </div>
                    <div class="col">
                        <label for="nom">Adresse</label>
                        <input type="text" class="form-control" name="addpa-adresse" id="adresse" placeholder="" required>
                    </div>
                    <div class="col">
                        <label for="nom">localite</label>
                        <input type="text" class="form-control" name="addpa-localite" id="adresse" placeholder="" required>
                    </div>
                    <div class="col">
                        <label for="nom">Code postal</label>
                        <input type="text" class="form-control" name="addpa-codep" id="codepostal" placeholder="" required pattern="[0-9]{5}">
                    </div>
                    <div class="col">
                        <label for="tel">Téléphone</label>
                        <input type="text" class="form-control" name="addpa-tel" id="tel" placeholder=""  pattern="[0-9]{2,10}" required>
                    </div>
                   
                </div>
            </div>

            <div class="col-12">
                <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
                <input type="hidden" name="view" value="<?php echo $view_name; ?>">
                <input type="hidden" name="page" value="0"><br>
                <button type="submit" name="addpa-send" class="btn btn-primary right classic-submit ">Valider</button>
            </div>
        </div>
    </form>
<?php
