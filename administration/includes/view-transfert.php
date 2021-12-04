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
Réaliser un transfert
<form method="get" >

    <div class="row">

        <div class="col">
            <label for="nom">Animal</label>
            <input type="text" class="form-control" name="nom" id="nom" placeholder=""><br>
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
            <button type="submit" class="btn btn-primary right classic-submit ">Rechercher</button>
        </div>
    </div>
</form>
<br>

<?php
$transferts = $refuge->get_transferts(
        $offset_page,
    $offset_page * $_GET["page"],
    ($_GET["dateOrd"] ?? "ASC"),
    ($_GET["refOrd"] ?? "ASC")
);

$row_count =  count($transferts);

// construction des liens de tri
$cpy_get = $_GET;
$cpy_get["dateOrd"] = reverse_ord($_GET["dateOrd"] ?? "DESC");
$dateOrd = http_build_query($cpy_get);

$cpy_get = $_GET;
$cpy_get["refOrd"] = reverse_ord($_GET["refOrd"] ?? "DESC");
$refOrd = http_build_query($cpy_get);


echo '
        <div class=" row" >
            <div class="col">
                <p class="">Nom</p>
            </div>
            <div class="col text-lg-center">
                <a href="'. $base_url . $dateOrd.'" class="a-order"><p > Date du transfert <i class="fas fa-sort"></i></p></a>
            </div>
            <div class="col text-lg-end">
                 <a href="'.$base_url.$refOrd.'" class="a-order"><p class=""> Destination <i class="fas fa-sort"></i> </p></a>
            </div>
        </div>
    ';

foreach ($transferts as $row) {
    echo '<a href="#" class="row-data-a">
                <div class="row-data row" >
                    <div class="col">
                        <p class="">' . $row["a_nom"].'</p>
                    </div>
                    <div class="col text-lg-center">
                        <p class="">' . $row["t_date"] . '</p>
                    </div>
                    <div class="col text-lg-end">
                        <p class="">' . $row["r_nom"] . '</p>
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
