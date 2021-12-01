<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php require_once("../classes/__init__.php"); ?>

<?php
$testp = new Personnel();

echo var_dump($testp->toArray());
/*$res = $db->query("SELECT * FROM personnel");

echo "<table><tr><th>ID</th><th>Nom</th><th>Prenom</th><th>Adresse</th><th>Localite</th><th>Code Postal</th><th>Num Secu</th><th>Id identifiant</th></tr>";
while($row = $res->fetch()){
    echo "<tr><td>".$row["p_id"]."</td><td>".$row["p_nom"]." ".$row["p_prenom"]."</td></tr>";
}*/

echo "</table>";
?>

</body>
</html>