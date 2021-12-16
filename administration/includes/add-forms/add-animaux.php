<?php

$err_msg = "";

if(isset($_POST["add-send"])) {

    if (Refuge::check_capacité($refuge->data["r_id"])) {
        if ($refuge->add_animal(
            $_POST["add-nom"],
            ($_POST["add-date"] ?? null),
            $_POST["add-sexe"],
            ($_POST["add-description"] == "" ? null : $_POST["add-description"]),
            $_POST["espece"],
            ($_POST["fo"] == "aucune" ? null:  $_POST["fo"])
        )) {

            echo '
                    <div class=" row" >
                        <div class="col text-lg-center">
                                    <p > <span class="text-lg-center" style="color: lightgreen!important;">L\'animal a été ajouté.</p>
                        </div>
                    </div>
                 ';

        } else {
            $err_msg = "Impossible d'ajouter l'utilisateur";
        }

    } else {
        $err_msg = "Impossible d'ajouter. Le refuge est déjà à pleine capacité.";
    }
    echo '

        <div class=" row" >
            <div class="col text-lg-center">
                        <p > <span class="text-lg-center" style="color: var(--main-warn-orange)!important;">' . $err_msg . '</span> </p>
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
                        <label for="daten">Date de naissance</label>
                        <input type="date" class="form-control" name="add-date" id="daten" placeholder="">

                    </div>
                    <div class="col">
                        <label for="sexe">Sexe</label>
                        <select name="add-sexe" id="sexe" class="selectpicker show-tick form-control " required>
                            <option class="fnct-choice" value="M" selected>Mâle</option>
                            <option class="fnct-choice" value="F">Femelle</option>
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <label for="espece">Espece</label>
                        <select name="espece" id="espece" class="form-control selectpicker" required>
                            <?php
                            foreach(DB::get_especes() as $row){
                                echo '<option value="'.$row["e_id"].'">'.$row["e_nom"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="fourriere">Fourrière</label>
                        <select name="fo" id="fourriere" class="selectpicker show-tick form-control " required>
                            <option class="fnct-choice" value="aucune">Aucune</option>

                            <?php
                            foreach(DB::get_fourrieres() as $row){
                                echo '<option class="fnct-choice" value="'.$row["f_id"].'">'.$row["f_localite"].', <b>'.$row["f_adresse"].'</b></option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="col">
                <div class="row">
                    <div class="col">
                        <label for="description">Description</label>
                        <textarea  class="form-control" name="add-description" id="description" placeholder=""></textarea>
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
