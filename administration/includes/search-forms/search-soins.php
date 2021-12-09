<form method="get" >

    <div class="row">

        <div class="col">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder=""><br>
        </div>
        <div class="col">

            <label for="espece">Type de soin</label>
            <select name="ts[]" class="selectpicker show-tick form-control " multiple>
                <?php
                foreach(Refuge::get_type_soins() as  $row){
                    echo '<option value="'.$row["ts_id"].'">'.$row["ts_libelle"].'</option>';
                }
                ?>
            </select>
            <!--<input type="text" class="form-control" placeholder="age"><br>-->
            <!--            <textarea name="description" placeholder="Description..."></textarea>
            -->
        </div>

        <div class="col-12">
            <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
            <input type="hidden" name="view" value="<?php echo $view_name; ?>">
            <input type="hidden" name="page" value="0">
            <button type="submit" class="btn btn-primary right classic-submit ">Rechercher</button>
        </div>
    </div>
</form>