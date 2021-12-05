<?php
$view_name = "soins";


$gerant = Personnel::get_personnel_by_id($refuge->data["p_id"]);
$nbr_animaux = count($refuge->get_animals("", "all"));
echo '
    <br>
    <br>
   
    <div class=" row" >
        <div class="col">
            <h4 class=""><b>' . $refuge->data["r_nom"] .'</b></h4>
            
            <p class=""> <b>Gérant</b> : '.$gerant["p_prenom"].' '. $gerant["p_nom"].'</p>

        </div>
        <div class="col text-lg-end">
            <p class="">' . $refuge->data["r_adresse"]. ', ' .$refuge->data["r_localite"].' ' .$refuge->data["r_code_postal"].'</p>
           <p class="">' . trim(strrev(chunk_split(strrev($refuge->data["r_tel"]),2, ' '))).'</p>
        </div>
    </div>
    <br>
    <div class=" row" >
    <p><b>Animaux pris en charge</b> : '. $nbr_animaux .'</p>
    <p><b>Capacité</b> : '. $refuge->data["r_capacite"] .'</p>
    </div>
    

';

