<?php
if(!isset($refuge)){
    echo "erreur";
}
$view_name = "animaux";

// nécessaire pour la pagination
if(!isset($_GET["page"])){
    $_GET["page"] = 0;
}

?>
<div class="row">
    <span class="page-btn"><a href=""> <i class="fas fa-user-plus fa-lg right"></i></a></span>
</div>
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

<?php

    $animaux_by_last_refuge = Animal::get_animals(
        $refuge->data["r_id"],
        ($_GET["nom"] ?? ""),
        ($_GET["espece"] ?? "all"),
        $offset_page,
        $offset_page * $_GET["page"],
        (checktobool($_GET["deces"] ?? false)),
        (checktobool($_GET["adopte"] ?? false))
    );

    $row_count =  count($animaux_by_last_refuge);
    foreach($animaux_by_last_refuge as $row){
        echo '
                  <a href="#" class="row-data-a">
                    <div class="row-data" >
                        <p>'.$row["a_nom"].' &nbsp;&nbsp;-&nbsp;&nbsp; '.$row["e_nom"].' ('.$row["a_sexe"].')</p>
                    </div>
                  </a>';
    }

    // Update du paramètre de pagination
    // et construction du nouvel l'URL
    $get_cpy = $_GET;
    $get_cpy["page"]+=1;
    $suivant = http_build_query($get_cpy);
    $get_cpy["page"]-=1;
    $get_cpy["page"] -= ($get_cpy["page"] === 0 ? 0 : 1) ;
    $precedent = http_build_query($get_cpy);
    $base_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)."?";
    $get_cpy["page"]+=abs($get_cpy["page"]);
?>

<div class="data-scroller">

    <span class="page-btn">
        <?php
        if($_GET["page"] != 0){
        echo '
             <a href="'.$base_url.$precedent.'">
                 <i class="fas fa-arrow-circle-left fa-2x" ></i>
             </a>   
            ';
        }else{
            echo '<a>&nbsp</a>';
        }
        ?>
    </span>

    <?php

    if($row_count == $offset_page){
    echo '<span class="page-btn">
                    <a href="'.$base_url.$suivant.'" class="right">
                        <i class="fas fa-arrow-circle-right fa-2x" ></i>
                    </a>
                  </span>';
    }

    ?>

</div>