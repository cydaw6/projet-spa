<?php
if(!isset($refuge)){
    echo "erreur";
}
$view_name = "personnel";

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

<?php
    $personnel = Personnel::get_personnel(
            $refuge->data["r_id"],
        ($_GET["nom"] ?? ""),
        ($_GET["fc"] ?? array()),
        $offset_page,
        $offset_page * $_GET["page"]
    );

    $row_count =  count($personnel);

    echo '
        <div class=" row" >
            <div class="col">
                <p class="">Nom</p>
            </div>
            <div class="col text-lg-end">
                <p class=""> <b>Tel</p>
            </div>
        </div>
    ';

    foreach ($personnel as $row) {
        echo '<a href="#" class="row-data-a">
                <div class="row-data row" >
                    <div class="col">
                        <p class="">' . $row["p_prenom"] . ' &nbsp; ' . $row["p_nom"] .'</p>
                    </div>
                    <div class="col text-lg-end">
                        <p class="">' . trim(strrev(chunk_split(strrev($row["p_tel"]),2, ' '))) . '</p>
                    </div>
                </div>
             </a>';
    }

    // Update du paramètre de pagination
    // et construction du nouvel l'URL
    $get_cpy = $_GET;
    $get_cpy["page"] += 1;
    $suivant = http_build_query($get_cpy);
    $get_cpy["page"] -= 1;
    $get_cpy["page"] -= ($get_cpy["page"] === 0 ? 0 : 1);
    $precedent = http_build_query($get_cpy);
    $base_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . "?";
    $get_cpy["page"] += abs($get_cpy["page"]);
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
