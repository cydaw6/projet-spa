<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            background-color: darkslategrey;
            color: white;
        }
    </style>
</head>
<body>
<?php require_once("../classes/__init__.php"); ?>

<?php

echo Personnel::connect("antb000", "test");
echo var_dump($_SESSION["user"]);

/*$testp = new Personnel();

foreach ($testp->toArray() as $x => $w){
    echo $x . ' : '.$w. '<br>';
}*/


/*$cnx = $db->query("SELECT * FROM personnel");

echo "<table><tr><th>ID</th><th>Nom</th><th>Prenom</th><th>Adresse</th><th>Localite</th><th>Code Postal</th><th>Num Secu</th><th>Id identifiant</th></tr>";
while($row = $cnx->fetch()){
    echo "<tr><td>".$row["p_id"]."</td><td>".$row["p_nom"]." ".$row["p_prenom"]."</td></tr>";
}*/

echo "</table>";
?>

</body>
</html>