<?php
$view_name = "soins";



?>
    <div class="row">
        <?php
        $cpyget = $_GET;
        if($_GET["act"] == "add"){
            $cpyget["act"] = "search";

            echo '
            <span class="page-btn">
                           

                <a href="./fiche-refuge.php?idref='.$_GET["idref"] .'&view=vaccins" class="add"> 
                
                    <i class="fas fa-syringe fa-2x left"></i>  &nbsp; Prochain vaccins
                </a>
                <a href="'. $base_url.http_build_query($cpyget).'" class="add"> 
                    <i class="fas fa-search fa-2x right"></i>
                </a>
            </span>
        ';
        }else{
            $cpyget["act"] = "add";
            echo '
            <span class="page-btn">
                <a href="./fiche-refuge.php?idref='.$_GET["idref"] .'&view=vaccins" class="add"> 
                    <i class="fas fa-syringe fa-2x left"></i>  &nbsp; Prochain vaccins
                </a>
                <a href="'. $base_url.http_build_query($cpyget).'" class="add"> 
                    <i class="fas fa-plus fa-2x right"></i>
                </a>
            </span>
        ';
        }
        ?>
    </div>
<br>
<?php

    if($_GET["act"] == "add"){
        include("add-forms/add-soins.php");
    }else{
        include("search-forms/search-soins.php");
    }


?>

<br>

<?php

$data_query = $refuge->get_soins(
    ($_GET["nom"] ?? ""),
    ($_GET["ts"] ?? array()),
    $offset_page,
    $offset_page * $_GET["page"],
    ($_GET["dateOrd"] ?? "DESC")
);

$row_count =  count($data_query);

// construction des liens de tri
$cpy_get = $_GET;
$cpy_get["dateOrd"] = reverse_ord($_GET["dateOrd"] ?? "DESC");
$dateOrd = http_build_query($cpy_get);

$cpy_get = $_GET;
$cpy_get["refOrd"] = reverse_ord($_GET["refOrd"] ?? "DESC");
$refOrd = http_build_query($cpy_get);

if($_GET["page"] != 0){
    echo '<p style="color: white;">Page '.$_GET["page"].'</p>';
}
echo '
        <div class=" row" >
            <div class="col">
                <p class="">Nom</p>
            </div>
            <div class="col text-lg-center">
                <a href="'. $base_url . $dateOrd.'" class="a-order"><p > Date <i class="fas fa-sort"></i></p></a>
            </div>
            <div class="col text-lg-end">
                 <p class=""> Type de soin</p>
            </div>
        </div>
    ';

foreach ($data_query as $row) {
    echo '<a href="'.$base_url.http_build_query(array("idref"=> $refuge->data["r_id"], "view" => "info-s", "ids" => $row["s_id"])).'" class="row-data-a">
                <div class="row-data row" >
                    <div class="col">
                        <p class="">' . $row["a_nom"].'</p>
                    </div>
                    <div class="col text-lg-center">
                        <p class="">' . date('d-m-Y H:i:s', strtotime($row["s_date"])) . '</p>
                    </div>
                    <div class="col text-lg-end">
                        <p class="">' . $row["ts_libelle"] . '</p>
                    </div>
                </div>
             </a>';
}
