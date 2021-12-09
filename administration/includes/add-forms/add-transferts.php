<?php
$err_msg = "";

if(isset($_POST["add-send"])){
    if(Refuge::check_capacité($_POST["rf"])){
        if(Refuge::transferer($refuge->data["r_id"], $_POST["add-a-id"], $_POST["rf"])){
            echo '<div class=" row" >
                        <div class="col text-lg-center">
                                    <p > <span class="text-lg-center" style="color: lightgreen!important;">Transfert effectué</span> </p>
                        </div>
                    </div>
                 ';
        }else{
            $err_msg = "Impossible de réaliser le transfert";
        }

    }else{
        $err_msg = "Il n'y a plus de place dans ce refuge";
    }

    echo '

        <div class=" row" >
            <div class="col text-lg-center">
                        <p > <span class="text-lg-center" style="color: var(--main-warn-orange)!important;">'.$err_msg.'</span> </p>
            </div>
        </div>
        
';
}
?>

<form method="post" >

    <div class="row">
        <div class="col">
            <label for="nom">Animal</label>
            <select name="add-a-id" id="nom" class="selectpicker show-tick form-control " required>
                <?php
                foreach( $refuge->get_animals("", "all") as  $row){

                    echo '<option value="'.$row["a_id"].'">'.$row["a_nom"].'&nbsp;&nbsp;&nbsp;('.$row["e_nom"].')</option>';
                }
                ?>
            </select>

        </div>
        <div class="col">

            <label for="refuge">Refuge</label>
            <select name="rf" id="refuge" class="selectpicker show-tick form-control " >
                <?php
                foreach(Refuge::get_all_refuge() as $row){

                    if($row["r_id"] != $refuge->data["r_id"] && Refuge::check_capacité($row["r_id"])){
                        echo '<option value="'.$row["r_id"].'">'.$row["r_nom"].'</option>';
                    }
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
            <input type="hidden" name="page" value="0"><br>
            <button type="submit" name="add-send" class="btn btn-primary right classic-submit ">Valider</button>
        </div>
    </div>
</form>
