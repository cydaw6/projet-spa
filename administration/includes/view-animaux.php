<?php
$view_name = "animaux";

include_once("search-add-btn.php");

?>

<?php

if($_GET["act"] == "add" && Refuge::check_capacité($refuge->data["r_id"])){ // vérifie que le refuge n'est pas déjà plein
    include("add-forms/add-animaux.php");
}else{
    include("search-forms/search-animaux.php");
}


?>
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
                  <a href="'.$base_url.http_build_query(array("idref" => $refuge->data["r_id"], "view" => "fa", "aid" => $row["a_id"])).'" class="row-data-a">
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
