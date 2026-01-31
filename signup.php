<?php 
session_start();
require("connexion.php");
$error = "";
/*if(empty($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("Action non autorisée !");
}*/
if(isset($_POST["signup"])){
    if(!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["checkpassword"])){
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $error = "Email n'est pas valide";
        }
        else {
            $stmt = $connexion->prepare("SELECT email from users where email = ?");
        $stmt->execute([$_POST["email"]]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($_POST["password"] === $_POST["checkpassword"] && !$data){
            if(strlen($_POST["password"]) < 8){
                $error = "Votre Mot De passe doit depasser 8 caracteres";
            }
            else {
                $username = trim(strip_tags($_POST["username"]));
            $email =  trim($_POST["email"]);
            
            $hash = password_hash(trim($_POST["password"]),PASSWORD_DEFAULT);
            $stmt = $connexion->prepare("INSERT into users (username,email,password) values(?,?,?)");
            $stmt->execute([$username,$email,$hash]);
            header("location: login2.php");
            exit;
            //unset($_SESSION['token']);
            }
            
        }
        else {
            $error = "Passwords or email Doesn't Match";
        }
    }
   
        }
    else {
        $error = "les champs sont vides";
    }     
}
?>
