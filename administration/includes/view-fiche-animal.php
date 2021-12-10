<?php

$view_name = "fa";

/**
 * 
 *  Vérifier que l'animal appartient bien aux refuge 
 * 
 * 
 */

// données de l'animal
$animal = Animal::get_animal_by_id($_GET['aid']);
$adata = $animal->get_all_data(); 

$naissance = ($animal->data["a_date_naissance"] ? date('d / m / Y', strtotime($animal->data["a_date_naissance"])) : ''); 
$deces = ($animal->data["a_date_deces"] ? date('d / m / Y', strtotime($animal->data["a_date_deces"])) : '');
$fourriere = ($adata["f_id"] ? $adata["f_adresse"].', '. $adata["f_localite"].', '. $adata["f_code_postal"] : '');
$adoptant = $animal->get_adoptant();

$adoption = (($adoptant["pa_id"] ?? null) ? '<br> Le '
    . date('d/ m/ Y', strtotime($animal->data["a_date_adoption"]))
    . ' <br> Par ' .$adoptant["pa_nom"].
    ', '.$adoptant["pa_adresse"] .' '.$adoptant["pa_localite"].' '.$adoptant["pa_code_postal"] : '' );
$lrefuge = $animal->get_refuge();
?>


<span class="page-btn">
    <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=animaux" class="add">
        <i class="fas fa-arrow-left fa-2x left"></i>
    </a>
</span>
<br><br><br>
<div class="container">


   


</div>


<?php
if(isset($_GET["act"]) && $_GET["act"] === "particulier"){

    echo "'ok";

    include("includes/add-forms/add-particulier.php");

}
?>



<?php


$cpyget = $_GET;
$cpyget["act"]="particulier";
$url_add_particulier = $base_url.http_build_query($cpyget);

echo '
<br>
<br>

<div class=" row" >
    <div class="col">
        <h4 class=""><b>' . $adata["a_nom"] .'</b></h4>
        <p class=""> <b>Espèce</b>: '.$adata["e_nom"].' ('. $adata["a_sexe"].')</p>
        <p class=""> <b>Date de naissance</b> : '.$naissance.'</p>
        <p class=""> <b>Fourrière d\'origine: </b>'.$fourriere.'</p>
        <p class=""> <b>Refuge d\'accueil: </b>'.$adata["r_nom"].'</p>
        <p class=""> <b>Dernier refuge: </b>'.$lrefuge["r_nom"].'</p>
        <p class=""> <b>Adoption: </b>'.$adoption.'</p>';
        
        if($adoption === ''){
            ?>

            <form method="post">

            <div class="row">

                <div class="col-4">
                    <label for="p-exists" style="color: white;">Particuliers</label>
                    <select name="p-exists-id" id="p-exists" class="selectpicker show-tick form-control " onchange="getval(this);" required data-live-search="true">
                        <option value="-1" selected>Aucun</option>
                        <?php
                        $exerce_fc = DB::$db->query("SELECT * from exerce WHERE r_id = ".$refuge->data["r_id"])->fetchAll();
                        foreach( Animal::get_particuliers() as  $row){
                            echo '<option class="op-personnel" value="'.$row["pa_id"].'" fnct-ref="'.$fnct.'">'.$row["pa_nom"]
                                .'&nbsp;&nbsp;('
                                .$row["pa_adresse"] . ', '.$row["pa_localite"] . ' '.$row["pa_code_postal"]
                                .')'.'
                              
                            </option>';
                            // . ' - '.trim(strrev(chunk_split(strrev($row["pa_tel"]),2, ' '))).'
                        }
                        ?>
                    </select>
                <div class="col-4-">
                    <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
                    <input type="hidden" name="view" value="<?php echo $view_name; ?>">
                    <input type="hidden" name="page" value="0">
                    <br>
                    <button type="submit" class="btn btn-info">Valider</button>
                    <a href="<?php echo $url_add_particulier;?>" ><button type="button" class="btn btn-secondary">Nouveau particulier</button></a>
                </div>
            </div>
            </form>
            <br><br>
            <?php
         
        }
echo '<p class=""> <b>Date de décès: </b>'.$deces.'</p>
    </div>
    <div class="col text-lg-end">
        
    </div>
</div>
<br>
<div class=" row" >

</div>


';

?>

