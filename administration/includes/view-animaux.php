
Ajouter un animal
<form>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" placeholder="Nom"><br>
            <input type="date" class="form-control">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="age"><br>
            <textarea name="description" placeholder="Description..."></textarea>

        </div>

    </div>
</form>

<div class="data-scroller">
    <?php
    $animaux_by_last_refuge = Animal::get_animals_from_refuge_id($refuge->data["r_id"]);
    while($row = $animaux_by_last_refuge->fetch()){
        echo '<div class="row-data"><p>'.$row["a_nom"].'</p></div>';
        // '.$row["e_id"].'('.$row["a_sexe"].')
    }

    ?>

    <span class="left"><a href="">< Précédent</a> </span><span class="right"><a href="">Suivant ></a></span>
</div>