<form method="get" >
    <div class="row">
        <div class="col">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder=""><br>
            <!--<input type="date" class="form-control">-->
            <label for="deces">Décédés</label>
            <input type="checkbox" id="deces" name="deces">&nbsp;&nbsp; </input>
            <label for="adopte">Adoptés</label>
            <input type="checkbox" id="adopte" name="adopte"> &nbsp;&nbsp;</input>


        </div>
        <div class="col">
            <label for="espece">Espece</label>
            <select name="espece" id="espece" class="form-control selectpicker">
                <option value="all" selected>Toutes</option>
                <?php
                foreach(Animal::get_especes() as  $row){
                    echo '<option value="'.$row["e_id"].'">'.$row["e_nom"].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="col-12">
            <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
            <input type="hidden" name="view" value="<?php echo $view_name; ?>">
            <input type="hidden" name="page" value="0">
            <button type="submit" class="btn btn-primary right classic-submit ">Rechercher</button>
        </div>
    </div>
</form>