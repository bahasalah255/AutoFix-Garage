
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="assests/list_users">
</head>
<body>
    <h1 class="titre">List Of Vehicules</h1>
</body>
</html>
<?php
require("connexion.php");
/*session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
    
if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}
*/
if($_SESSION["role"] == "user"){
$stmt = $connexion->prepare("SELECT * FROM voiture order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>client_id</th> <th>user_id</th> <th>marque</th> <th>model</th> <th>année</th> <th>immatriculation</th> <th>carburant</th> <th>Date_creation</th>";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['marque']}</td>
    <td>{$row['modele']}</td>
    <td>{$row['annee']}</td>
    <td>{$row['immatriculation']}</td>
    <td>{$row['carburant']}</td>
    <td>{$row['created_at']}</td>
    ";
    echo "</tr>";
}

echo "</table>";
}
else {
    $stmt = $connexion->prepare("SELECT * FROM voiture order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>client_id</th> <th>user_id</th> <th>marque</th> <th>model</th> <th>année</th> <th>immatriculation</th> <th>carburant</th> <th>Date_creation</th> <th>Actions</th>";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['marque']}</td>
    <td>{$row['modele']}</td>
    <td>{$row['annee']}</td>
    <td>{$row['immatriculation']}</td>
    <td>{$row['carburant']}</td>
    <td>{$row['created_at']}</td>
    <td><form action='list_vehicules.php' method='get'><input type='hidden' name='id' value='{$row['id']}'><input type='submit' name='delete' value='delete' class='button_form'></form></td>
    ";
    echo "</tr>";
}

echo "</table>";
if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from voiture where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=voitures");
    
}
}
?>