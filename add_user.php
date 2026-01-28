<?php

require("connexion.php");
session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}
else {
    $error = "";
$message = "";
if(isset($_POST["adduser"])){
    if(!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["checkpassword"])){
        if($_POST["password"] == $_POST["checkpassword"]){
            $username = $_POST["username"];
            $email = $_POST["email"];
            $hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
            $role = $_POST["role"];
            $stmt = $connexion->prepare("INSERT into users (username,email,password,role) values(?,?,?,?)");
            $stmt->execute([$username,$email,$hash,$role]);
            $message = "Ajouter Avec Success";
            header("location: admindashbord.php?page=dashboard");
        }
        else {
            $error = "Passwords Doesn't Match";
        }
    }
    else {
        $error = "les champs sont vides";
    }
}
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="assests/add_user.css">
</head>
<body>
    <div class="formulaire">
        <div class="form">
           <h1>Add User</h1>
            
           <?php if(!empty($error)){ ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>
 <?php if(!empty($message)){ ?>
    <p class="success"><?php echo $message; ?></p>
<?php } ?>
    <form action="add_user.php" method="post">
     <label>Username : </label><br>
        <input type="text" name="username" placeholder="Enter Votre Nom"><br><br>
        <label>Email : </label><br>
        <input type="email" name="email" placeholder="Enter Votre email"><br><br>
        <label>Password : </label><br>
        <input type="password" name="password" placeholder="Enter Votre password"><br><br>
        <label>Verifie Password : </label><br>
        <input type="password" name="checkpassword" placeholder="Enter Votre password"><br><br>
        <label>Role</label>
        <select name="role">
            <option value="admin">admin</option>
            <option value="user">User</option>
        </select><br><br>
        <input type="submit" name="adduser" value="Add User" class="button">
        </form>
        </div>
    </div>
</body>
</html>