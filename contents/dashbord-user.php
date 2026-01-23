<?php
require("connexion.php");
$stmt = $connexion->prepare("select count(id) as counter from clients where user_id = ?");
$stmt->execute([$_SESSION["id"]]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(id) as counter from voiture where user_id = ?");
$stmt->execute([$_SESSION["id"]]);
$voiture = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(statut) as counter from reparations where statut = 'en_cours'");
$stmt->execute();
$repa_cours = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(statut) as counter from reparations where statut = 'terminee'");
$stmt->execute();
$repa_terminer = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>content</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assests/dash-content.css">
</head>
<body>
<div class="cards">
    <div class="card users">
        <p class="titre"> <i class="fa-solid fa-user"></i> Total Clients</p>
        <p class="counter"><?php echo $data["counter"]; ?></p>
    </div>
    <div class="card voitures">
        <p class="titre"> <i class="fa-solid fa-car"></i> Total Voitures</p>
        <p class="counter"><?php echo $voiture["counter"] ?></p>
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
<div class="links">
    <h1 class="actions">Actions Rapides</h1>
    <div class="navlinks">
    <div class="action_link"><a href="add_client.php" class="llinks"><i class="fa-solid fa-user-tie"></i> Ajouter Client</a></div>
    <div class="action_link"><a href="add_vehicule.php" class="llinks"><i class="fa-solid fa-car"></i> Ajouter Voiture</a></div>
    <div class="action_link"><a href="add_reparation.php" class="llinks"><i class="fa-solid fa-screwdriver-wrench"></i>Ajouter Reparation</a></div>
    </div>
</div> 
</body>
</html>