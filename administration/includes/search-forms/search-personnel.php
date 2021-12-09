<form method="get" >

    <div class="row">

        <div class="col">
            <label for="nom">Nom Complet</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder=""><br>
        </div>
        <div class="col">

            <label for="espece">Fonctions</label>
            <select name="fc[]" class="selectpicker show-tick form-control " multiple>
                <?php
                foreach(Personnel::get_fonctions() as  $row){
                    echo '<option value="'.$row["fc_id"].'">'.$row["fc_titre"].'</option>';
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