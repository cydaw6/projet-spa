<?php
$view_name = "animaux";

include_once("search-add-btn.php");

?>

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
            <select name="espece" id="espece" class="form-control">
                <option value="all" selected>Toutes</option>
                <?php
                    foreach(Animal::get_especes() as  $row){
                        echo '<option value="'.$row["e_id"].'">'.$row["e_nom"].'</option>';
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
<br>
<?php

$data_query = $refuge->get_animals(
        ($_GET["nom"] ?? ""),
        ($_GET["espece"] ?? "all"),
        $offset_page,
        $offset_page * $_GET["page"],
        (checktobool($_GET["deces"] ?? false)),
        (checktobool($_GET["adopte"] ?? false))
    );

    $row_count =  count($data_query);

if($_GET["page"] != 0){
    echo '<p style="color: white;">Page '.$_GET["page"].'</p>';
}
    foreach($data_query as $row){
        echo '
                  <a href="#" class="row-data-a">
                    <div class="row-data row" >
                        <div class="col">
                            <p class="">' . $row["a_nom"].'</p>
                        </div>
                        <div class="col text-lg-end">
                            <p class="">'.$row["e_nom"].' ('.$row["a_sexe"].')</p>
                        </div>
                    </div>
                  </a>';
    }
