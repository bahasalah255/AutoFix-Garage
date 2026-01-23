<?php 
session_start();
require("connexion.php");
$error = "";
if(empty($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(isset($_POST["signup"])){
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("Action non autorisée !");
}
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
            header("location: login.php");
            exit;
            unset($_SESSION['token']);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <link rel="stylesheet" href="assests/signup.css">
</head>
<body>
    <div class="formulaire">
        <div class="form">
           <?php if(!empty($error)){ ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php } ?>

    <form action="signup.php" method="post">
        <h1>Sign Up</h1>
        <label>Username : </label><br>
        <input type="text" name="username" placeholder="Enter Votre Nom"><br><br>
        <label>Email : </label><br>
        <input type="email" name="email" placeholder="Enter Votre email"><br><br>
        <label>Password : </label><br>
        <input type="password" name="password" placeholder="Enter Votre password"><br><br>
        <label>Verifie Password : </label><br>
        <input type="password" name="checkpassword" placeholder="Enter Votre password"><br><br>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

        <input type="submit" name="signup" value="Sign Up" class="button">
        
    </form>
    </div>
    </div>
</body>
</html>


