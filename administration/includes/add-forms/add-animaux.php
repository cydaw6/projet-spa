<?php

$err_msg = "";

if(isset($_POST["add-send"])){


    if(count($p) != 0){
        $err_msg = "L'utilisateur fait déjà partie de la spa";
    }else{

        if($personnel_id){

            $refuge->update_personnel_fonctions($personnel_id,  ($_POST["fc"] ?? array()));

            echo '
                    <div class=" row" >
                        <div class="col text-lg-center">
                                    <p > <span class="text-lg-center" style="color: lightgreen!important;">L\'utilisateur a été ajouté. <br> login: '.$login["login"].'<br> Mot de passe: '.$login["mdp"].'</span> </p>
                        </div>
                    </div>
                 ';

        }else{
            $err_msg = "Impossible d'ajouter l'utilisateur";
        }
    }
    echo '

        <div class=" row" >
            <div class="col text-lg-center">
                        <p > <span class="text-lg-center" style="color: var(--main-warn-orange)!important;">'.$err_msg.'</span> </p>
            </div>
        </div>
        
';

}

?>
    <!--https://regexlib.com/CheatSheet.aspx?AspxAutoDetectCookieSupport=1-->
    <form method="post" >
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" name="add-nom" id="nom" placeholder="" required>
                    </div>
                    <div class="col">
                        <label for="prenom">Date de naissance</label>
                        <input type="date" class="form-control" name="add-prenom" id="prenom" placeholder="" required>

                    </div>
                </div>


                <div class="col">
                    <label for="nom">Description</label>
                    <textarea  class="form-control" name="add-adresse" id="adresse" placeholder="" required></textarea>

                </div>
            </div>

            <div class="col">
                <label for="nom">Num. de sécu.</label>
                <input type="text" class="form-control" name="add-secu" id="secu" placeholder="" required pattern="[0-9]{15}">
                <label for="nom">localite</label>
                <input type="text" class="form-control" name="add-localite" id="adresse" placeholder="" required>

            </div>

            <div class="col">
                <div class="row">
                    <div class="col">
                        <label for="tel">Téléphone</label>
                        <input type="text" class="form-control" name="add-tel" id="tel" placeholder=""  pattern="[0-9]{2,10}" required>
                    </div>
                </div>

                <div class="row">

                    <div class="col">
                        <label for="nom">Code postal</label>
                        <input type="text" class="form-control" name="add-codep" id="codepostal" placeholder="" required pattern="[0-9]{5}">
                    </div>
                    <div class="col">
                        <label for="espece">Fourrière</label>
                        <select name="fc[]" id="mltp-fnc" class="selectpicker show-tick form-control " multiple required>
                            <?php
                            foreach(Personnel::get_fonctions() as  $row){
                                echo '<option class="fnct-choice" value="'.$row["fc_id"].'">'.$row["fc_titre"].'</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>






            </div>

            <div class="col-12">
                <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
                <input type="hidden" name="view" value="<?php echo $view_name; ?>">
                <input type="hidden" name="page" value="0"><br>
                <button type="submit" name="add-send" class="btn btn-primary right classic-submit ">Valider</button>
            </div>
        </div>
    </form>
<?php
