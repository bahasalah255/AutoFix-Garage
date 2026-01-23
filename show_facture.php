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
/*
echo  $_SESSION["id_facture"] ."<br>";

echo    $_SESSION["reparation_id"]."<br>";
 echo   $_SESSION["voiture_id"]."<br>";
 echo   $_SESSION["client_id"]."<br>";
 echo   $_SESSION["montant"]."<br>";
 echo   $_SESSION["created_at"]."<br>";
 echo   $_SESSION["nom"]."<br>";
 echo     $_SESSION["telephone"] ."<br>";
  echo    $_SESSION["marque"]."<br>";
  echo    $_SESSION["modele"]."<br>";
   echo   $_SESSION["immatriculation"]."<br>";
  echo  $_SESSION["description"] ."<br>";
  echo   $_SESSION["prix"] ."<br>";
  echo "<table border='1'> 
  <tr>

  </tr>
  </table> "*/
  $tva = $_SESSION["prix"] * 20 / 100;
  $prix_ttc = $_SESSION["prix"] + $tva;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture </title>
    <link rel="stylesheet" href="assests/show_facture.css">
</head>
<body>
    <div class="facture">
        <h2>Facture - AutoGarage</h2>
        <p><strong>Date :</strong> <?php echo $_SESSION["created_at"] ?></p>

        <h3>Client :</h3>
        <p>Nom: <?php echo $_SESSION["nom"] ?><br>
           Téléphone: +212 <?php echo $_SESSION["telephone"] ?>
        </p>

        <h3>Voiture :</h3>
        <p>Marque: <?php echo $_SESSION["marque"] ?><br>
           Modèle: <?php echo $_SESSION["modele"] ?><br>
           Immatriculation: <?php echo $_SESSION["immatriculation"] ?>
        </p>

        <h3>Réparations :</h3>
        <table>
            <tr>
                <th>Description</th>
                <th>Prix (DH)</th>
            </tr>
            <tr>
                <td><?php echo $_SESSION["description"] ?></td>
                <td><?php echo $_SESSION["prix"] ?></td>
            </tr>
        </table>

        <div class="montants">
            <p>Montant HT: <?php echo $_SESSION["prix"] ?> DH</p>
            <p>TVA (20%): <?php echo $tva ?> DH</p>
            <p><strong>Total TTC: <?php echo $prix_ttc ?> DH</strong></p>
        </div>

        <p class="footer">Merci pour votre confiance !</p>
    </div>
</body>
</html>