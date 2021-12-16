<?php

$view_name = "info-s";


$s = null;

if(!($s = DB::get_soin_by_id($_GET["ids"]))){
    goto noSoin;
}

?>

<br>
<span class="page-btn">
        <a href="./fiche-refuge.php?idref=<?php echo $refuge->data["r_id"]."&view=soins"; ?>" class="add">
            <i class="fas fa-arrow-left fa-2x left"></i>
        </a>
</span>
<br><br><br>


<?php
    echo '
        <div class=" row" >
            <div class="col-md-6">
                <p class=""> Soin effectué par '
                    .$s["p_prenom"]
                    .' '.$s["p_nom"]
                    .' le '
                    . date('d/m/Y', strtotime($s["s_date"]))
                    .' à '
                    . date('h:m:s', strtotime($s["s_date"]))
                .'</p>
                <p class=""> <b>Animal </b><br>
                    <a style="color: var(--main-warn-orange)!important;" href="'.ROOT.'administration/fiche-refuge.php?idref='.$refuge->data["r_id"].'&view=fa&aid='.$s["a_id"].'" >
                        <b>'.$s["a_nom"].'</b>
                    </a>
                </p>
                <p class=""> <b>Type de soin </b><br> '.$s["ts_libelle"].'</p>
                <p class=""> '.($s["v_nom"] ? '<b>Vaccin </b><br> '.$s["v_nom"] : '').'</p>
                <p class=""> '.($s["s_commentaire"] ? '<b>Commentaire </b><br> '.$s["s_commentaire"] : '').'</p>
            </div>
        </div>
    ';
noSoin:
?>


