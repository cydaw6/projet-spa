
<?php


if(isset($_POST["add-send"])){
    $vac = Refuge::get_type_soins();

    $ts_id_vac = array_filter($_GET, function($v, $k) {
        echo var_dump($v);
        return 1 == 1;
    }, ARRAY_FILTER_USE_BOTH);
   
    if($_POST["add-v-id"] !="Aucun" && $_POST["add-ts-id"] == $ts_id_vac){
       echo 'Le type de soin n\'est pas un vaccin';
    }else{
        $espece = Animal::get_animal_by_id($_POST["add-a-id"])["e_id"];
        $vaccins = Animal::get_vaccins_by_espece();
        echo var_dump($vaccins);
    }
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
                <option value="aucun" selected> Aucun </option>
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
            <textarea name="description" placeholder="Description..." class="form-control"></textarea>
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