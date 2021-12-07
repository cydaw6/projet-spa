<?php


if(isset($_POST["add-send"])){

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

            <label for="espece">Refuge</label>
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
            <button type="submit" name="add-send" class="btn btn-primary right classic-submit ">Valider</button>
        </div>
    </div>
</form>
