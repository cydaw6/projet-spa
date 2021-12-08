<?php
$view_name = "vaccins";

// construction du dictionnaire des rappels (ou première injection)
$result = array();
foreach ($refuge->liste_rappel_vaccin() as $element) {
    if(!array_key_exists($element['a_id'], $result)){
        $result[$element['a_id']] = array();
        $result[$element['a_id']]["a_nom"] = $element["a_nom"];
        $result[$element['a_id']]["e_nom"] = $element["e_nom"];
        $result[$element['a_id']]["a_sexe"] = $element["a_sexe"];
        $result[$element['a_id']]["vaccins"] = array();
    }
    array_push($result[$element['a_id']]["vaccins"], $element["v_nom"]);
}

?>

<span class="page-btn">
    <a href="./fiche-refuge.php?idref=<?php echo $_GET["idref"]; ?>&view=soins" class="add">
        <i class="fas fa-arrow-left fa-2x left"></i>
    </a>
</span>
<br><br><br>
<div class="container">


    <table class="table table-striped" style="color: white; font-weight: normal;">
        <tr>
            <th>Nom</th>
            <th>Espèce</th>
            <th>Vaccins</th>
        </tr>
        <?php
            foreach ($result as $row){
                echo '
                    <tr>
                        <td>'.$row["a_nom"].'</td>
                        <td>'.$row["e_nom"].'</td>
                        <td>'.implode(', ', $row["vaccins"]).'</td>
                    </tr>
                    ';
            }



        ?>


    </table>


</div>