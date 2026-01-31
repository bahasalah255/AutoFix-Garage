<?php
require("connexion.php");
$id = $_SESSION["id"];
$stmt = $connexion->prepare("SELECT username,email,password,nom,prenom,tele From users where id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$username = $data["username"];
$email = $data["email"];
$pass = $data["password"];
$nom = $data["nom"];
$prenom = $data["prenom"];
$tel = $data["tele"];
$message = "";
if(isset($_POST["changer"])){
    if(!empty($_POST["password"]) && !empty($_POST["newpass"]) && !empty($_POST["confirmnewpass"])){
         $password = $_POST["password"];
        if (password_verify($password,$pass)){
            $new_pass = $_POST["newpass"];
            $checknew = $_POST["confirmnewpass"];
            if($new_pass === $checknew){
                $hash = password_hash($new_pass,PASSWORD_DEFAULT);
                 $stmt = $connexion->prepare("UPDATE users set password = ? where id = ?");
                 $stmt->execute([$hash,$id]);
            }
            else {
                 $message = "Les Mot De Passes Sont Pas Identiques";
            }
        }
        else {
            $message = "Le Mot De Passe Est inccorect";
        }
    }
        $tele = $_POST["tele"];
        $name = $_POST["nom"];
        $pre = $_POST["prenom"];
        $user = htmlspecialchars($_POST["username"]);
        $email = $_POST["email"];
        $stmt = $connexion->prepare("UPDATE users set username = ? ,email = ? ,nom = ?,prenom = ?,tele = ? where id = ?");
        $stmt->execute([$user,$email,$name,$pre,$tele,$id]);
        $message = "Change Avec Success";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assests/info.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <h5 class="fw-bold">Modifier Utilisateur </h5>
    <div class="container">
        <div class="formulaire">
        <h6><i class="bi bi-person fs-4 text-danger"></i>Modifier Les Informations Utilisateur</h6>
        <hr>
        <h6 class="mx-3"><i class="bi bi-person-gear fs-5"></i> Infommations Personnels</h6>
        <form action="" method="post">
            <?php if(!empty($message)){ ?>
                     <div class="message bg-success text-white"><i class="bi bi-check fs-4"></i> <?php echo $message ?></div>
            
            <?php } ?>
           
            <div class="row mx-5">
                <div class="col col-lg-6">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" value="<?php echo $nom ?>" class="form-control form-control-sm">
            <label class="form-label">Prenom</label>
            <input type="text" name="prenom" value="<?php echo $prenom ?>" class="form-control form-control-sm">
             <label class="form-label">Numero De Telephone</label>
            <input type="tele" name="tele" value="<?php echo $tel ?>" class="form-control form-control-sm">
           
            
            </div>
             <div class="col col-lg-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo $email ?>" class="form-control form-control-sm">
             <label class="form-label">Username</label>
            <input type="text" name="username" value="<?php echo $username ?>" class="form-control form-control-sm">
            </div>
            
            </div>
            <hr>
            <h6 class="mx-3"><i class="bi bi-lock"></i> Securite</h6>
            <div class="row mx-5">
                <div class="col col-lg-6">
            <label class="form-label">Mot De Passe Actual</label>
            <input type="password" name="password"  class="form-control form-control-sm">
            
            </div>
             <div class="col col-lg-6">
            <label class="form-label">Nouveau Mot De Passe </label>
            <input type="password" name="newpass"  class="form-control form-control-sm">
            <label class="form-label">Confirmer Mot De Passe </label>
            <input type="password" name="confirmnewpass"  class="form-control form-control-sm">
            
            </div>
            
            </div>
            <hr>
            <div class="buttons d-flex justify-content-end">
                <button type="reset" class="btn btn-light">Anuller</button>
                 <button type="submit" name="changer" class="btn btn-danger">Enregister</button>
            </div>
</form>
        </div>
    </div>
</body>
</html>