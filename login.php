<?php 
require("connexion.php");
session_start();

$sign_error = "";


if(isset($_POST["signup"])){
    if(!empty($_POST["username_sign"]) && !empty($_POST["email"]) && !empty($_POST["password_sign"]) && !empty($_POST["checkpassword"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["tele"]) && !empty($_POST["adresse"])){
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
           $sign_error = "Email n'est pas valide";
        }
        else {
            $stmt = $connexion->prepare("SELECT email from users where email = ?");
        $stmt->execute([$_POST["email"]]);
        $data_sign = $stmt->fetch(PDO::FETCH_ASSOC);

        if($_POST["password_sign"] === $_POST["checkpassword"] && !$data_sign){
            if(strlen($_POST["password_sign"]) < 8){
                $sign_error = "Votre Mot De passe doit depasser 8 caracteres";
            }
            else {
                $username_sign = trim(strip_tags($_POST["username_sign"]));
            $email =  trim($_POST["email"]);
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $tele = $_POST["tele"];
            $adresse = $_POST["adresse"];
            $hash = password_hash(trim($_POST["password_sign"]),PASSWORD_DEFAULT);
            $stmt = $connexion->prepare("INSERT into users (username,email,password,nom,prenom,tele,adresse) values(?,?,?,?,?,?,?)");
            $stmt->execute([$username_sign,$email,$hash,$nom,$prenom,$tele,$adresse]);
            header("location: login.php");
            exit;
            
            }
            
        }
        else {
           $sign_error = "Passwords or email Doesn't Match";
        }
    }
   
        }
    else {
        $sign_error = "les champs sont vides";
    }     
}
 $error = "";
if(isset($_POST["login"])){
   /* if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die("Action non autorisée !");
    }
*/
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = $_POST["username"];
        $stmt = $connexion->prepare("SELECT username,password,role,id,email FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data && password_verify($_POST["password"], $data["password"])) {
            $_SESSION["id"] = $data['id'];
            $_SESSION["username"] = $data['username'];
            $_SESSION["role"] = $data['role'];
            $_SESSION["email"] = $data['email'];

            switch($data['role']){
                case "user":
                    header("location: userdashbord.php?page=dashboard");
                    exit;
                case "client":
                    header("location: Clientdashbord.php?page=dashboard");
                    exit;
                case "admin":
                    header("location: admindashbord.php?page=dashboard");
                    exit;
                default:
                    $error = "Role inconnu";
            }

        } else {
            $error = "Username ou mot de passe incorrects";
        }
    } else {
        $error = "Les champs sont vides";
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoFix Login</title>
    <link rel="stylesheet" href="assests/login2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="container">
        <div class="formulaire">
        <form action="login.php" method="post">
            <div id="login_form">
                   <?php if(!empty($error)){ ?>
    <p class="error bg-danger p-10 d-flex justify-content-center text-white rounded shadow-sm"><?php echo htmlspecialchars($error); ?></p>
<?php } ?>
                <h2 class="fw-bold d-flex justify-content-center">AutoFix Login</h2>
        <label class="form-label">Username *:</label>
        <div class="input-group mb-3">
             <span class="input-group-text">
    <i class="bi bi-person"></i>
  </span>
 <input type="text" name="username" placeholder="Enter Username" class="form-control form-control-sm">
        </div>
       
        <label class="form-label">Password *:</label>
        <input type="password" name="password" placeholder="Enter Password" class="form-control form-control-sm">
        <button type="submit" name="login" class="btn  btn-login btn-danger mt-3 w-25">Log In</button>
         <p class="text-center mt-3">
      Don't have an account? 
      <button type="button" id="showSignup" class="btn btn-link p-0">Sign Up</button>
    </p>
        </div>
       
        <div id="signup">
           
                 <?php if(!empty($sign_error)){ ?>
    <p class="error bg-danger p-10 d-flex justify-content-center text-white rounded shadow-sm"><?php echo htmlspecialchars($sign_error); ?></p>
<?php } ?>
        <h1 class="fw-bold d-flex justify-content-center">Sign Up</h1>
         <label class="form-label">Nom : </label>
        <input type="text" name="nom" class="form-control form-control-sm" placeholder="Enter Votre Nom">
        <label class="form-label">Prenom : </label>
        <input type="text" name="prenom" class="form-control form-control-sm" placeholder="Enter Votre Prenom">
         <label class="form-label">Numero Telephone : </label>
        <input type="tele" name="tele" class="form-control form-control-sm" placeholder="Enter Votre Numero">
         <label class="form-label">Adresse : </label>
        <input type="tele" name="adresse" class="form-control form-control-sm" placeholder="Enter Votre Adresse">
        <label class="form-label">Username : </label>
        <input type="text" name="username_sign" class="form-control form-control-sm" placeholder="Enter Votre Username">
        <label class="form-label">Email : </label><br>
        <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter Votre email">
        <label class="form-label">Password : </label><br>
        <input type="password" name="password_sign" class="form-control form-control-sm" placeholder="Enter Votre password">
        <label class="form-label">Verifie Password : </label><br>
        <input type="password" name="checkpassword" class="form-control form-control-sm" placeholder="Enter Votre password">
        <button type="submit" name="signup" class="btn btn-danger  mt-3 w-25">Sign Up</button>
         <p class="text-center mt-3">
      Already have an account? 
      <button type="button" id="showLogin" class="btn btn-link p-0">Log In</button>
    </p>
    </form>
        </div>
        
    
    </div>
    </div>
    <script>
      const showSignupBtn = document.getElementById("showSignup");
const showLoginBtn = document.getElementById("showLogin");
const signupBox = document.getElementById("signup");
const login = document.getElementById("login_form");
showSignupBtn.addEventListener("click", () => {
    login.style.display = "none";
    signupBox.style.display = "block";
});

showLoginBtn.addEventListener("click", () => {
    signupBox.style.display = "none";
    login.style.display = "block";
});


    </script>
</body>
</html>