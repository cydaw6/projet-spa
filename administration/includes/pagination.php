<?php
// Update du paramètre de pagination
// et construction du nouvel l'URL
$get_cpy = $_GET;
$get_cpy["page"] += 1;
$suivant = http_build_query($get_cpy);
$get_cpy["page"] -= 1;
$get_cpy["page"] -= ($get_cpy["page"] === 0 ? 0 : 1);
$precedent = http_build_query($get_cpy);
$get_cpy["page"] += abs($get_cpy["page"]);
?>

<div class="data-scroller">

    <span class="page-btn">
        <?php
        if($_GET["page"] != 0){
            echo '
             <a href="'.$base_url.$precedent.'">
                 <i class="fas fa-arrow-circle-left fa-2x" ></i>
             </a>   
            ';
        }else{
            echo '<a>&nbsp</a>';
        }
        ?>
    </span>

    <?php

    if($row_count == $offset_page){
        echo '<span class="page-btn">
                    <a href="'.$base_url.$suivant.'" class="right">
                        <i class="fas fa-arrow-circle-right fa-2x" ></i>
                    </a>
                  </span>';
    }

    ?>

</div>
