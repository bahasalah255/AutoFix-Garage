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
    <title>Admin Dashbord -</title>
    <link rel="stylesheet" href="assests/admin.css">
</head>
<body>
    <navbar>
   <div class="navbar">
    
    <div class="navbarlinks">
   <p>Welcome,Admin </p> 
   <form action="admindashbord.php" method="post">
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
         <div class="link"><a href="admindashbord.php?page=dashboard">Dashbord </a></div>
         <div class="link"><a href="admindashbord.php?page=users">Users</a></div>
         <div class="link"><a href="admindashbord.php?page=clients">Clients</a></div>
         <div class="link"><a href="admindashbord.php?page=voitures">Voitures</a></div>
         <div class="link"><a href="admindashbord.php?page=reparations">Reparations</a></div>
         <div class="link"><a href="admindashbord.php?page=factures">Factures</a></div>
        </div>
    </div>
</aside>
<main class="main-content">
    <?php 
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == "dashboard"){
            include("contents/dashbord-content.php");
        }
        elseif($page == "users"){
            include("list_users.php");
        }
        elseif($page == "clients"){
            include("list_clients.php");
        }
         elseif($page == "voitures"){
            include("list_vehicules.php");
        }
        elseif($page == "reparations"){
            include("list_reparation.php");
        }
        else {
            include("list_factures.php");
        }
    }?>
</main>
</body>
</html>