

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assests/list_clients">
</head>
<body>
    <h1 class="titre">LIST OF CLIENTS</h1>
</body>
</html>
<?php
require("connexion.php");
//session_start();
if($_SESSION["role"] == "user"){
$id = $_SESSION["id"];
$stmt = $connexion->prepare("SELECT * FROM clients where user_id = ? order by nom ASC");
$stmt->execute([$id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>Nom</th> <th>Prenom</th> <th>Telephone</th> <th>adresse</th> <th>user_id</th> <th>Created Time</th> ";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['nom']}</td>
    <td>{$row['prenom']}</td>
    <td>{$row['telephone']}</td>
    <td>{$row['adresse']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['created_time']}</td>
    ";
    echo "</tr>";
}

echo "</table>";
}
else {
    
$stmt = $connexion->prepare("SELECT * FROM clients order by nom ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>Nom</th> <th>Prenom</th> <th>Telephone</th> <th>adresse</th><th>user_id</th> <th>Created Time</th><th>Actions</th> ";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['nom']}</td>
    <td>{$row['prenom']}</td>
    <td>{$row['telephone']}</td>
    <td>{$row['adresse']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['created_time']}</td>
    <td><form action='list_clients.php' method='get'><input type='hidden' name='id' value='{$row['id']}'><input type='submit' name='delete' value='delete' class='button_form'></form></td>
    ";
    echo "</tr>";
}

echo "</table>";
if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from clients where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=clients");
    
}
}


?>