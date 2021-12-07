<?php


if(isset($_POST["add-send"])){
    $refuge->update_personnel_fonctions( $_POST["p-exists-id"],  ($_POST["fc"] ?? array()));
}

?>



<form method="post" >

    <div class="row">

        <div class="col">
            <label for="p-exists" style="color: white;">Personnel existant</label>
            <select name="p-exists-id" id="p-exists" class="selectpicker show-tick form-control " onchange="getval(this);" required data-live-search="true">
                <option value="-1" selected>Aucun</option>
                <?php
                $exerce_fc = DB::$db->query("SELECT * from exerce WHERE r_id = ".$refuge->data["r_id"])->fetchAll();
                foreach( Refuge::get_all_personnel() as  $row){
                    //recherche de toutes les fonction de la personne dans le refuge
                    $user_fc_id = array_filter($exerce_fc, function($v, $k) use ($row) {
                        return $v["p_id"] == $row["p_id"];
                    }, ARRAY_FILTER_USE_BOTH);

                    // formatage : fc_id-fc-id-fc-id... implode('-', array_values($user_fc_id));
                    $fnct = implode('-', array_column($user_fc_id, "fc_id"));

                    echo '<option class="op-personnel" value="'.$row["p_id"].'" fnct-ref="'.$fnct.'">'.$row["p_prenom"]
                        .'&nbsp;'.$row["p_nom"].'&nbsp;('
                        .$row["p_num_secu"]
                        .')</option>';
                }
                ?>

            </select>
            <script>
                function getval(select){
                    let fnct_ref = $("#p-exists option:selected");
                    let fonctions = fnct_ref.attr("fnct-ref").split("-");
                    let fnct_choice = document.getElementsByClassName("fnct-choice");
                    let e = document.getElementById("mltp-fnc");
                    $('#mltp-fnc').selectpicker('deselectAll');
                    for (const key in fnct_choice) {
                        if(fnct_choice[key].value !== undefined && fonctions.includes(fnct_choice[key].value)){
                            $(`#mltp-fnc option[value=${fnct_choice[key].value}]`).attr("selected", true);
                            fnct_choice[key].select = true;
                        }else{
                            fnct_choice[key].select = false;
                        }
                        $('#mltp-fnc').selectpicker('render');
                        $('#mltp-fnc').selectpicker('refresh');
                    }
                }
            </script>
        </div>

        <div class="col">

            <label for="espece">Fonctions</label>
            <select name="fc[]" id="mltp-fnc" class="selectpicker show-tick form-control " multiple>
                <?php
                foreach(Personnel::get_fonctions() as  $row){
                    echo '<option class="fnct-choice" value="'.$row["fc_id"].'">'.$row["fc_titre"].'</option>';
                }
                ?>
            </select>
        </div>




        <div class="col-12">
            <input type="hidden" name="idref" value="<?php echo $_GET["idref"]; ?>">
            <input type="hidden" name="view" value="<?php echo $view_name; ?>">
            <input type="hidden" name="page" value="0">
            <br>
            <button type="submit" name="add-send" class="btn btn-primary right classic-submit ">Valider</button>
        </div>
    </div>
</form>
