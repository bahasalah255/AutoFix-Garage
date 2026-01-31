
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

   if(isset($_POST["delete"])){
     $id = $_POST["id"];
     $stmt = $connexion->prepare("DELETE from factures where id_facture = ?");
    $stmt->execute([$id]);
    header("location: admindashbord.php?page=factures");
   }
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
    $stmt = $connexion->prepare("select nom,tele from users where id = ?");
    $stmt->execute([$data["client_id"]]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["nom"] = $client["nom"];
    $_SESSION["telephone"] = $client["tele"];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="assests/list_users">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>
<body>
    <h1 class="fw-bold text-danger d-flex justify-content-center">List Of Receipt </h1>
      <table class="table table-hover w-100 table-striped " id="mytable">
  <thead>
    <tr>
      <th scope="col">ID Facture</th>
      <th scope="col">Reparation ID</th>
      <th scope="col">Voiture ID</th>
      <th scope="col">Client ID</th>
      <th scope="col">Montant</th>
      <th scope="col">Statut De Paiment</th>
      <th scope="col">Created At</th>
      <th scope="col">Empolyer ID</th>
      <th scope="col">Actions</th>
      
    </tr>
    </thead>
    <tbody>
    <?php 
    foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id_facture']}</td>
    <td>{$row['reparation_id']}</td>
    <td>{$row['voiture_id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['montant']}</td>
    <td>
    <div class='badge bg-primary rounded'>
    {$row['statut_paimenet']}
    </div></td>
    <td>{$row['created_at']}</td>
    <td>{$row['user_id']}</td>
    <td> <form action='list_factures.php' method='post'>
   <button type='submit' class='btn btn-info' name='voir'><i class='bi bi-eye'></i></button>
   <button type='submit'  class='btn btn-success' name='payer'><i class='bi bi-check'></i></button>
   <button type='submit'  class='btn btn-danger' name='delete'><i class='bi bi-trash'></i></button>
   <input type='hidden' name='id' value='{$row['id_facture']}'>
    </form>
</td>
    ";
    echo "</tr>";
}
?>
</body>
</html>