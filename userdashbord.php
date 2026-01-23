<?php 
require("connexion.php");
session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
if($_SESSION["role"] == "user"){
     if(isset($_POST["logout"])){
        session_destroy();
        header("location: login.php");
     }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["username"] ?> Dashbord</title>
    <link rel="stylesheet" href="assests/admin.css">
</head>
<body>

    <navbar>
   <div class="navbar">
    
    <div class="navbarlinks">
   <p>Welcome, <?php echo $_SESSION["username"] ?> </p> 
   <form action="userdashbord.php" method="post">
    <input type="submit" name="logout" value="logout" class="button">
   </form> 

   </div>
   </div>
</navbar>
<aside>
    <div class="aside">
        <p>Garage Admin</p>
        <hr>
        <div class="asideslinks">
         <div class="link"><a href="userdashbord.php?page=dashboard">Dashbord </a></div>
         <div class="link"><a href="userdashbord.php?page=clients">Clients</a></div>
         <div class="link"><a href="userdashbord.php?page=voitures">Voitures</a></div>
         <div class="link"><a href="userdashbord.php?page=reparations">Reparations</a></div>
         
        </div>
    </div>
</aside>
<main class="main-content">
    <?php 
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == "dashboard"){
            include("contents/dashbord-user.php");
        }
        elseif($page == "clients"){
            include("list_clients.php");
        }
        elseif($page == "voitures"){
            include("list_vehicules.php");
        }
        else {
            include("list_reparation.php");
        }
    }?>
</main>
</body>
</html>