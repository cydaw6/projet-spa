<div class="row">
    <?php
    $cpyget = $_GET;
    if($_GET["act"] == "add"){
        $cpyget["act"] = "search";
        echo '
            <span class="page-btn"><a href="'. $base_url.http_build_query($cpyget).'" class="add"> <i class="fas fa-search fa-2x right"></i></a></span>
        ';
    }else{
        $cpyget["act"] = "add";
        echo '
            <span class="page-btn"><a href="'. $base_url.http_build_query($cpyget).'" class="add"> <i class="fas fa-plus fa-2x right"></i></a></span>
        ';
    }
    ?>
</div>
