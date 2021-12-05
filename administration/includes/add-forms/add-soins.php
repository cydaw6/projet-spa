<form method="get" >

    <div class="row">

        <div class="col">
            <label for="nom">Animal</label>
            <select name="add-id" class="selectpicker show-tick form-control " required>
                <?php
                foreach( $refuge->get_animals("", "all") as  $row){
                    echo '<option value="'.$row["a_id"].'">'.$row["a_nom"].'&nbsp;&nbsp;&nbsp;('.$row["e_nom"].')</option>';
                }
                ?>
            </select>

        </div>
        <div class="col">

            <label for="espece">Type de soin</label>
            <select name="ts" class="selectpicker show-tick form-control " required>
                <?php
                foreach(Refuge::get_type_soins() as  $row){
                    echo '<option value="'.$row["ts_id"].'">'.$row["ts_libelle"].'</option>';
                }
                ?>
            </select>
            <label for="espece">Vaccin</label>
            <select name="ts" class="selectpicker show-tick form-control " required>
                <option value="aucun"> Aucun </option>
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
            <button type="submit" class="btn btn-primary right classic-submit ">Valider</button>
        </div>
    </div>
</form>