<?php
$view_name = "transfert";
?>


<p style="color: white;">Effectuer un transfert</p>


<br>

<?php
include("add-forms/add-transferts.php");
$data_query = $refuge->get_transferts(
        $offset_page,
    $offset_page * $_GET["page"],
    ($_GET["dateOrd"] ?? "ASC"),
    ($_GET["refOrd"] ?? "ASC")
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
         <br>

        <div class=" row" >
            <div class="col">
                <p class="">Nom</p>
            </div>
            <div class="col">
                <p class="">Espèce</p>
            </div>
            <div class="col text-lg-center">
                <a href="'.$base_url.$dateOrd.'" class="a-order"><p > Date du transfert <i class="fas fa-sort"></i></p></a>
            </div>
            <div class="col text-lg-end">
                 <p class=""> Destination </p>
            </div>
        </div>
    ';

foreach ($data_query as $row) {
    echo '<a class="row-data-a">
                <div class="row-data row" >
                    <div class="col">
                        <p class="">' . $row["a_nom"].'</p>
                    </div>
                    <div class="col ">
                        <p class="">' . $row["e_nom"] .'</p>
                    </div>
                    <div class="col text-lg-center">
                        <p class="">' . date('d-m-Y', strtotime($row["t_date"])) . '</p>
                    </div>
                    <div class="col text-lg-end">
                        <p class="">' . $row["r_nom"] . '</p>
                    </div>
                </div>
             </a>';
}

