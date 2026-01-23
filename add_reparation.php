<?php
require("connexion.php");
session_start();
$user_id = $_SESSION["id"];
$error = "";
if(isset($_POST["addrepa"])){
    if(!empty($_POST["description"]) && !empty($_POST["prix"]) && !empty($_POST["date-debut"]) && !empty($_POST["date-fin"]) && !empty($_POST["voiture_id"]) && !empty($_POST["status"]) && !empty($_POST["client_id"])){
        $client_id = $_POST["client_id"];
        $description = $_POST["description"];
        $prix = $_POST["prix"];
        $date_debut = $_POST["date-debut"];
        $date_fin = $_POST["date-fin"];
        $voiture_id = $_POST["voiture_id"];
        $status = $_POST["status"];
        
        $stmt = $connexion->prepare("INSERT INTO reparations (voiture_id,client_id,user_id,description,statut,prix,date_debut,date_fin) values (?,?,?,?,?,?,?,?)");
        $stmt->execute([$voiture_id,$client_id,$user_id,$description,$status,$prix,$date_debut,$date_fin]);
        if($_SESSION["role"] == "user"){
            header("location: userdashbord.php?page=dashboard");
        }
        else {
            header("location: admindashbord.php?page=dashboard");
        }
    }
    else {
        $error = "Les champs Sont Vides";
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reparation</title>
    <link rel="stylesheet" href="assests/add_repa.css">
</head>
<body>
    <div class="formulaire">
        <div class="form">
           <h1>Add reparation</h1>
            
           <?php if(!empty($error)){ ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>
 <?php if(!empty($message)){ ?>
    <p class="success"><?php echo $message; ?></p>
<?php } ?>
    <form action="add_reparation.php" method="post">
        <label>Id Client :</label><br>
         <input type="text" name="client_id" placeholder="entrer l'id Client"><br><br>
        <label>Id Voiture :</label><br>
         <input type="text" name="voiture_id" placeholder="entrer l'id voiture"><br><br>
        
        <label>Description De Probleme : </label><br>
        <input type="text" name="description" placeholder="entrer Le probleme de voiture"><br><br>
        <label>Prix : </label><br>
        <input type="number" name="prix" placeholder="entrer le prix de reparation"><br><br>
        <label>Date Debut :</label><br>
        <input type="date" name="date-debut" placeholder="entrer date debut"><br><br>
        <label>Date Fin :</label><br>
        <input type="date" name="date-fin" placeholder="entrer date debut"><br><br>
        <label>Status : </label>
        <select name="status">
            <option value="en_cours">En Cours</option>
            <option value="en_attente">En attente</option>
            <option value="termines">Termines</option>
            
        </select><br><br>
        <input type="submit" name="addrepa" value="Add reparation" class="button">
    </form>
        </div>
    </div>
</body>
</html>