<?php
require("connexion.php");
$stmt = $connexion->prepare("select count(id) as counter from users");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(id) as counter from clients");
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(id) as counter from voiture");
$stmt->execute();
$voiture = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(statut) as counter from reparations where statut = 'en_cours'");
$stmt->execute();
$repa_cours = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(statut) as counter from reparations where statut = 'terminee'");
$stmt->execute();
$repa_terminer = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT * FROM rendezvous");
$stmt->execute();
$data_rend = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($data_rend as $row){
    
   $id = $row['id'];
   $nom = $row['nom'];
   $email = $row['email'];
   $phone = $row['phone'];
   $service = $row['service'];
   $date = $row['datere'];
   $message = $row['message'];
    
   
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>content</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assests/dash-content.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
<div class="cards">
    <div class="card users">
        <p class="titre"> <i class="fa-solid fa-user"></i> Total Users</p>
        <p class="counter"><?php echo $data["counter"]; ?></p>
    </div>
    <div class="card clients">
        <p class="titre"> <i class="fa-solid fa-user"></i> Total Clients</p>
        <p class="counter"><?php echo $client["counter"]; ?></p>
    </div>
    <div class="card voitures">
        <p class="titre"> <i class="fa-solid fa-car"></i> Total Voitures</p>
        <p class="counter"><?php echo $voiture["counter"]; ?></p>
    </div>
    <div class="card repa">
        <p class="titre"> <i class="fa-solid fa-screwdriver-wrench"></i> Reparations En Cours</p>
        <p class="counter"><?php echo $repa_cours["counter"] ; ?></p>
    </div>
    <div class="card repater">
        <p class="titre"><i class="fa-solid fa-circle-check"></i>Reparations Termines</p>
       <p class="counter"><?php echo $repa_terminer["counter"] ; ?></p>
    </div>
</div>   
<table class="table table-hover w-25">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nom</th>
      <th scope="col">Email</th>
      <th scope="col">Téléphone</th>
      <th scope="col">Service</th>
      <th scope="col">Date</th>
      <th scope="col">Message</th>
    </tr>
    <?php 
    foreach ($data_rend as $row){
    echo "<tr>";
   echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nom']}</td>";
     echo "<td>{$row['email']}</td>";
      echo "<td>{$row['phone']}</td>";
       echo "<td>{$row['service']}</td>";
        echo "<td>{$row['datere']}</td>";
         echo "<td>{$row['message']}</td>";
   echo "</tr>";
  
    
   
}
    
    ?>
  </thead>
  <tbody>
   

</table>
<div class="links">
    <div class="navlinks">
        
    <div class="action_link"><a href="add_user.php" class="llinks"><i class="fa-solid fa-user-plus"></i> Ajouter Utilisateur</a></div>
    <div class="action_link"><a href="add_client.php" class="llinks"><i class="fa-solid fa-user-tie"></i> Ajouter Client</a></div>
    <div class="action_link"><a href="add_vehicule.php" class="llinks"><i class="fa-solid fa-car"></i> Ajouter Voiture</a></div>
    <div class="action_link"><a href="add_reparation.php" class="llinks"><i class="fa-solid fa-screwdriver-wrench"></i>Ajouter Reparation</a></div>
    </div>
</div> 

</body>
</html>