<?php
require("connexion.php");
session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
 $error = "";
$message = "";
if(isset($_POST["addclient"])){
    if(!empty($_POST["name"]) && !empty($_POST["prenom"]) && !empty($_POST["telephone"]) && !empty($_POST["adresse"])){
        $id = $_SESSION["id"];
        $nom = $_POST["name"];
        $prenom = $_POST["prenom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $stmt = $connexion->prepare("INSERT INTO clients (nom,prenom,telephone,adresse,user_id) values(?,?,?,?,?)");
        $stmt->execute([$nom,$prenom,$telephone,$adresse,$id]);
        $message = "Ajouter Avec Success";
        if($_SESSION["role"] == "user"){
            header("location: userdashbord.php?page=dashboard");
        }
        else {
            header("location: admindashbord.php?page=dashboard");
        }
        

    }
    else {
        $error = "Les Champs Sont Vides";
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link rel="stylesheet" href="assests/add_client.css">
</head>
<body>
    <div class="formulaire">
        <div class="form">
             <h1>Add Client</h1>
            
           <?php if(!empty($error)){ ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>
 <?php if(!empty($message)){ ?>
    <p class="success"><?php echo $message; ?></p>
<?php } ?>
     <form action="add_client.php" method="post">
        <label>Client Name : </label><br>
        <input type="text" name="name" placeholder="Enter Votre Nom"><br><br>
        <label>client LastName : </label><br>
        <input type="text" name="prenom" placeholder="prenom"><br><br>
        <label>client Number : </label><br>
        <input type="number" name="telephone" placeholder="phone"><br><br>
        <label>client adresse : </label><br>
        <input type="text" name="adresse" placeholder="adresse"><br><br>

        <div class="buttons">
    <input type="submit" name="addclient" value="addclient" class="button">
   
        </div>
        
    </form>
        </div>
    </div>
</body>
</html>