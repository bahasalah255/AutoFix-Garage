
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="assests/list_users">
</head>
<body>
    <h1 class="titre">List Of Reparations</h1>
</body>
</html>
<?php
require("connexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
    
/*if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}
*/
if($_SESSION["role"] == "user"){
$stmt = $connexion->prepare("SELECT * FROM reparations order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>voiture_id </th> <th>client_id</th> <th>user_id</th> <th>description</th> <th>status</th> <th>prix</th> <th>date-debut</th> <th>date-fin</th> <th>Date_creation</th>";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['voiture_id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['description']}</td>
    <td>{$row['statut']} <br>
    <form action='list_reparation.php' method='post'>
    <select name='choices'>
            <option value='en_cours'>En Cours</option>
            <option value='en_attente'>En attente</option>
            <option value='terminee'>Termines</option>
    </select><br>
    <input type='submit' name='changevalue' value='changestatus'>
    <input type='hidden' name='id' value='{$row['id']}'>
    </form>
    
    </td>
    <td>{$row['prix']}</td>
    <td>{$row['date_debut']}</td>
    <td>{$row['date_fin']}</td>
    <td>{$row['created_at']}</td>
    ";
    echo "</tr>";
}

echo "</table>";

}
else {
   $stmt = $connexion->prepare("SELECT * FROM reparations order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>voiture_id </th> <th>client_id</th> <th>user_id</th> <th>description</th> <th>status</th> <th>prix</th> <th>date-debut</th> <th>date-fin</th> <th>Date_creation</th> <th>Actions</th>";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['voiture_id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['description']}</td>
    <td>{$row['statut']} <br>
    <form action='list_reparation.php' method='post'>
    <select name='choices'>
            <option value='en_cours'>En Cours</option>
            <option value='en_attente'>En attente</option>
            <option value='terminee'>Termines</option>
    </select><br>
    <input type='submit' name='changevalue' value='changestatus'>
    <input type='hidden' name='id' value='{$row['id']}'>
    </form>
    
    </td>
    <td>{$row['prix']}</td>
    <td>{$row['date_debut']}</td>
    <td>{$row['date_fin']}</td>
    <td>{$row['created_at']}</td>
    <td><form action='list_reparation.php' method='get'>
    <input type='submit' name='facture_create' value='create Facture'>
    <input type='hidden' name='id' value='{$row['id']}'>
    </form></td>
    ";
    echo "</tr>";
}

echo "</table>";

}
if(isset($_POST["changevalue"])){
    $choice = $_POST["choices"];
    $id = $_POST["id"];
    $stmt = $connexion->prepare("UPDATE reparations set statut = ? where id = ? ");
    $stmt->execute([$choice,$id]);
    
    header("location: admindashbord.php?page=reparations");
}
if(isset($_GET["facture_create"])){
    $id = $_GET["id"];
   $stmt =$connexion->prepare("select * from reparations where id = ?");
   $stmt->execute([$id]);
   $data = $stmt->fetch(PDO::FETCH_ASSOC);
   $stmt = $connexion->prepare("insert into factures (reparation_id,voiture_id,client_id,montant,user_id) values(?,?,?,?,?) ");
   $stmt->execute([$data["id"],$data["voiture_id"],$data["client_id"] ,$data["prix"],$data["user_id"] ]);
    header("location: admindashbord.php?page=reparations");
}
?>