
<?php
$err_msg = "";

if(isset($_POST["add-send"])){
    // regarde si le type de soin est n'est pas une vaccination
    // si oui alors aucun vaccin ne doit être selectionné
    $vac = Refuge::get_type_soins();
    $ts_id_vac = array_filter($vac, function($v, $k) {
        return $v["ts_libelle"] == "Vaccination";
    }, ARRAY_FILTER_USE_BOTH);
   
    if($_POST["add-v-id"] != -1 && $_POST["add-ts-id"] != array_shift($ts_id_vac)["ts_id"]){
        $err_msg = 'Utilisation de Vaccin impossible. Le type de soin n\'est pas une vaccination';

    }else{
        $espece_exist_v = array();
        if($_POST["add-v-id"] != -1){
            // regarde si le vaccin pour l'espèce existe
            $espece_id = Animal::get_animal_by_id($_POST["add-a-id"])->data["e_id"];
            $vaccins = DB::$db->query("SELECT * FROM requiere r")->fetchAll();
            $espece_exist_v = array_filter($vaccins, function($v, $k) use ($espece_id) {
                return $v["v_id"] == $_POST["add-v-id"] && $espece_id == $v["e_id"];
            }, ARRAY_FILTER_USE_BOTH);
        }


        if($_POST["add-v-id"] == -1 || count($espece_exist_v)){
            // on ajoute le soin
            if($refuge->add_soin(
                $_SESSION["user"]->data["p_id"],
                $_POST["add-a-id"],
                $_POST["add-ts-id"],
                ($_POST["add-v-id"] == -1 ? null: $_POST["add-v-id"]),
                ($_POST["comm"] == "" ? null : $_POST["comm"])
                )){
                 ;

                 echo '
                    <div class=" row" >
                        <div class="col text-lg-center">
                                    <p > <span class="text-lg-center" style="color: lightgreen!important;">Le soin a été ajouté</span> </p>
                        </div>
                    </div>
                 ';


            }else{
                $err_msg = "Impossible d'ajouter le soin";
            }
        }else{
            $err_msg = "Le type de vaccin ne correspond pas à l'espèce de l'animal";
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



<form method="post" >

    <div class="row">

        <div class="col">
            <label for="nom">Animal</label>
            <select name="add-a-id" class="selectpicker show-tick form-control " required>
                <?php
                foreach( $refuge->get_animals("", "all") as  $row){
                    echo '<option value="'.$row["a_id"].'">'.$row["a_nom"].'&nbsp;&nbsp;&nbsp;('.$row["e_nom"].')</option>';
                }
                ?>
            </select>

        </div>
        <div class="col">

            <label for="ts">Type de soin</label>
            <select name="add-ts-id" id="ts" class="selectpicker show-tick form-control " required>
                <?php
                foreach(Refuge::get_type_soins() as  $row){
                    echo '<option value="'.$row["ts_id"].'">'.$row["ts_libelle"].'</option>';
                }
                ?>
            </select>
            <label for="espece">Vaccin</label>
            <select name="add-v-id" class="selectpicker show-tick form-control " required>
                <option value="-1" selected> Aucun </option>
                <?php
                foreach(Animal::get_vaccins() as  $row){
                    echo '<option value="'.$row["v_id"].'">'.$row["v_nom"].'</option>';
                }
                ?>
            </select>
            <!--<input type="text" class="form-control" placeholder="age"><br>-->
        </div>

        <label>
            Description
            <textarea name="comm" placeholder="Description..." class="form-control"></textarea>
        </label>

        <div class="col">
            <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
            <input type="hidden" name="view" value="<?php echo $view_name; ?>">
            <input type="hidden" name="page" value="0">
            <br>
            <button type="submit" name="add-send" class="btn btn-primary right classic-submit ">Valider</button>
        </div>
    </div>
</form>