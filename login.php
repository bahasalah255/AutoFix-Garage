<?php 
session_start();
require("connexion.php");
$error = "";
if(empty($_SESSION['token'])){
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST["login"])){
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("Action non autorisée !");
    }
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = $_POST["username"];
        $stmt = $connexion->prepare("SELECT username,password,role,id from users where username = ?");
        $stmt->execute([$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data && $data['role'] == "user" && password_verify($_POST["password"],$data["password"])){
            
            $_SESSION["id"] = $data['id'];
            $_SESSION["username"] = $data['username'];
            $_SESSION["role"] = $data['role'];
            header("location: userdashbord.php?page=dashboard");
            exit;
        }
        else {
            if($data && $data['role'] == "admin" && password_verify($_POST["password"],$data["password"])){
                
                 $_SESSION["id"] = $data['id'];
                $_SESSION["username"] = $data['username'];
                $_SESSION["role"] = $data['role'];
            header("location: admindashbord.php?page=dashboard");
        }
        else {
             $error = "username ou mot de passe incorrects";
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
    <title>Login</title>
    <link rel="stylesheet" href="assests/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="formulaire">
        <div class="form">
            <?php if(!empty($error)){ ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php } ?>
    
    <form action="login.php" method="post">
        <h1>AutoFix Garage</h1>
        <label>Username : </label>
        <input type="text" name="username" class="form-control" placeholder="Enter Votre Nom">
        <label>Password : </label>
        <input type="password" name="password" class="form-control" placeholder="Enter Votre password"><br>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <div class="buttons">
    <input type="submit" name="login" value="Log In" class="button">
    <button class="button1"><a href="signup.php">Sign Up</a></button>
        </div>
        
    </form>
    </div>
    </div>
</body>
</html>