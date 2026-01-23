<?php
require("connexion.php");
session_start();
$user_id = $_SESSION["id"];
$error = "";
if(isset($_POST["addvoiture"])){
    if(!empty($_POST["marque"]) && !empty($_POST["modele"]) && !empty($_POST["annee"]) && !empty($_POST["immatriculation"]) && !empty($_POST["carburant"]) && !empty($_POST["client_id"])){
        $client_id = $_POST["client_id"];
        $marque = $_POST["marque"];
        $modele = $_POST["modele"];
        $annee = $_POST["annee"];
        $immatruculation = $_POST["immatriculation"];
        $carburant = $_POST["carburant"];
        $stmt = $connexion->prepare("INSERT INTO voiture (client_id,user_id,marque,modele,annee,immatriculation,carburant) values (?,?,?,?,?,?,?)");
        $stmt->execute([$client_id,$user_id,$marque,$modele,$annee,$immatruculation,$carburant]);
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
    <title>Add Vehicule</title>
    <link rel="stylesheet" href="assests/add_vehicule.css">
</head>
<body>
    <div class="formulaire">
        <div class="form">
           <h1>Add Vehicule</h1>
            
           <?php if(!empty($error)){ ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>
 <?php if(!empty($message)){ ?>
    <p class="success"><?php echo $message; ?></p>
<?php } ?>
    <form action="add_vehicule.php" method="post">
        <label>Id Client :</label><br>
         <input type="text" name="client_id" placeholder="entrer l'id Client"><br><br>
        
        <label>Marque : </label><br>
        <input type="text" name="marque" placeholder="entrer la marque Du Voiture"><br><br>
        <label>Modele : </label><br>
        <input type="text" name="modele" placeholder="entrer le modele Du Voiture"><br><br>
        <label>Année : </label><br>
        <input type="text" name="annee" placeholder="entrer l'année De La Voiture"><br><br>
        <label>immatriculation :</label><br>
        <input type="text" name="immatriculation" placeholder="entrer l'immatriculation De La Voiture"><br><br>
        <label>Carburant : </label>
        <select name="carburant">
            <option value="essence">essence</option>
            <option value="diesel">diesel</option>
            <option value="hybride">hybride</option>
            <option value="electrique">electrique</option>
        </select><br><br>
        <input type="submit" name="addvoiture" value="Add Vehicule" class="button">
    </form>
        </div>
    </div>
</body>
</html>