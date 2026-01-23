
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="assests/list_users">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
    <h1 class="titre">List Of Receipt </h1>
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
    
if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}


$stmt = $connexion->prepare("SELECT * FROM factures order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID_FACTURE</th> <th>Reparation_id </th> <th>voiture_id</th> <th>client_id</th> <th>Montent</th> <th>Statut Paiment</th> <th>Created_at</th> <th>user_id</th> <th>Actions</th>";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id_facture']}</td>
    <td>{$row['reparation_id']}</td>
    <td>{$row['voiture_id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['montant']}</td>
    <td>{$row['statut_paimenet']}</td>
    <td>{$row['created_at']}</td>
    <td>{$row['user_id']}</td>
    <td> <form action='list_factures.php' method='post'>
   <button type='submit' name='voir'><i class='fa-solid fa-eye'></i></button>
   <button type='submit' name='payer'><i class='fa-solid fa-check'></i></button>
   <input type='hidden' name='id' value='{$row['id_facture']}'>
    </form>
</td>
    ";
    echo "</tr>";
}

echo "</table>";

   if(isset($_POST["payer"])){
    $id = $_POST["id"];
    $stmt = $connexion->prepare("UPDATE factures set statut_paimenet = 'payee' where id_facture = ?");
    $stmt->execute([$id]);
    header("location: admindashbord.php?page=factures");
   }
   if(isset($_POST["voir"])){
    $id = $_POST["id"];
    $stmt = $connexion->prepare("select * from factures where id_facture = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["id_facture"] = $data["id_facture"];
    $_SESSION["reparation_id"] = $data["reparation_id"];
    $_SESSION["voiture_id"] = $data["voiture_id"];
    $_SESSION["client_id"] = $data["client_id"];
    $_SESSION["montant"] = $data["montant"];
    $_SESSION["created_at"] = $data["created_at"];
    $stmt = $connexion->prepare("select nom,telephone from clients where id = ?");
    $stmt->execute([$data["client_id"]]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["nom"] = $client["nom"];
    $_SESSION["telephone"] = $client["telephone"];
    $stmt = $connexion->prepare("select marque,modele,immatriculation from voiture where id = ?");
    $stmt->execute([$data["voiture_id"]]);
    $voiture = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["marque"] = $voiture["marque"];
    $_SESSION["modele"] = $voiture["modele"];
    $_SESSION["immatriculation"] = $voiture["immatriculation"];
    $stmt = $connexion->prepare("select description,prix from reparations where id = ?");
    $stmt->execute([$data["reparation_id"]]);
    $repa = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["description"] = $repa["description"];
    $_SESSION["prix"] = $repa["prix"];
    header("location: show_facture.php");
   }
?>