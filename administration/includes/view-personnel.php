<?php
$view_name = "personnel";

include_once("search-add.php");
?>

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
                <p class=""> <b>Tel</p>
            </div>
        </div>
    ';

    foreach ($data_query as $row) {
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
