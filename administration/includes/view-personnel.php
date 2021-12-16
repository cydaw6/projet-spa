<?php
$view_name = "personnel";

if (1 == 1 || $_GET["act"] == "add" && $refuge->data["p_id"] == $_SESSION["user"]->data["p_id"]) {
    ?>
    <div class="row">
        <?php
        $cpyget = $_GET;
        if($_GET["act"] == "update"){
            $cpyget["act"] = "search";
            $url1 = $base_url.http_build_query($cpyget);
            $cpyget["act"] = "add-user";
            $url2 = $base_url.http_build_query($cpyget);

            echo '
            <p>
                <span class="page-btn">
                    <a href="'. $url1.'" class="add"> 
                        <i class="fas fa-search fa-2x right"></i> </a> 
                    <a href="'.$url2.'" class="add">
                        <i class="fas fa-user-plus fa-2x left"></i>
                    </a>
                </span>
            </p>
        ';
        }else if($_GET["act"] == "add-user"){
            $cpyget["act"] = "search";
            $url1 = $base_url.http_build_query($cpyget);
            $cpyget["act"] = "update";
            $url2 = $base_url.http_build_query($cpyget);
            echo '
            <p>
                <span class="page-btn">
                    <a href="'. $url1.'" class="add"> 
                        <i class="fas fa-search fa-2x right"></i> </a> 
                    <a href="'.$url2.'" class="add">
                        <i class="fas fa-user-edit fa-2x left"></i></i>
                    </a>
                </span>
            </p>
        ';
        }else{
            $cpyget["act"] = "update";
            echo '
            <span class="page-btn"><a href="'. $base_url.http_build_query($cpyget).'" class="add"><i class="fas fa-user-edit fa-2x right"></i></a></span>
        ';
        }
        ?>
    </div>
    <?php

}


// vérification des droits de modifications (user doit être gérant)
if ($_GET["act"] == "add-user" && $refuge->data["p_id"] == $_SESSION["user"]->data["p_id"]) {
    include("add-forms/add-personnel.php");

}else if($_GET["act"] == "update" && $refuge->data["p_id"] == $_SESSION["user"]->data["p_id"]) {
    include("add-forms/add-fonction-personnel.php");

} else {
    include("search-forms/search-personnel.php");

}

?>


<br>
<?php
$data_query = Personnel::get_personnel(
            $refuge->data["r_id"],
        ($_GET["nom"] ?? ""),
        ($_GET["fc"] ?? array()),
        $offset_page,
        $offset_page * $_GET["page"]
    );

    $row_count =  count($data_query);
if($_GET["page"] != 0){
    echo '<p style="color: white;">Page '.$_GET["page"].'</p>';
}
    echo '
        <div class=" row" >
            <div class="col">
                <p class="">Nom</p>
            </div>
            <div class="col text-lg-end">
                <p class="">Tel</p>
            </div>
        </div>
    ';


    foreach ($data_query as $row) {
        if($row["p_id"] != $_SESSION["user"]->data["p_id"]){
            echo '<a href="'.$base_url.http_build_query(array("idref"=> $refuge->data["r_id"], "view" => "info-p", "idp" => $row["p_id"])).'" class="row-data-a">
                <div class="row-data row" >
                    <div class="col">
                        <p class="">' . $row["p_prenom"] . '&nbsp;' . $row["p_nom"] .'</p>
                    </div>
                    <div class="col text-lg-end">
                        <p class="">' . trim(strrev(chunk_split(strrev($row["p_tel"]),2, ' '))) . '</p>
                    </div>
                </div>
             </a>';
        }

    }
