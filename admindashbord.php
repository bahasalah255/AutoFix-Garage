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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <navbar>
   <div class="navbar">
    
    <div class="navbarlinks">
   <p class="fw-bold p-4">Welcome,<span class="text-info">Admin</span> </p> 
   
</form>

   </div>
   </div>
</navbar>
<aside>
    <div class="aside">
        <p class="fw-bold p-5">Garage Admin</p>
        <hr>
        <div class="asideslinks">
         <div class="link"><a href="admindashbord.php?page=dashboard" class="fw-bold"><i class="bi icon-dashbord bi-speedometer2"></i> Dashbord </a></div>
         <div class="link"><a href="admindashbord.php?page=users" class="fw-bold"><i class="bi icon-dashbord bi-person"></i>Users</a></div>
         <div class="link"><a href="admindashbord.php?page=clients" class="fw-bold"><i class="bi icon-dashbord bi-person-fill"></i>Clients</a></div>
         <div class="link"><a href="admindashbord.php?page=voitures" class="fw-bold"><i class="bi icon-dashbord bi-car-front-fill"></i> Voitures</a></div>
         <div class="link"><a href="admindashbord.php?page=reparations" class="fw-bold"><i class="bi icon-dashbord bi-wrench"></i> Reparations</a></div>
         <div class="link"><a href="admindashbord.php?page=factures" class="fw-bold"><i class="bi icon-dashbord bi-receipt"></i> Factures</a></div>
        </div>
        <form action="admindashbord.php" method="post">
  <button type="submit" name="logout" class="button btn btn-danger d-flex align-items-center gap-2 m-5">
    <i class="bi bi-box-arrow-right fs-5"></i>
    <span>Logout</span>
  </button>
  </form>
    </div>
</aside>
<main class="main-content">
    <?php 
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == "dashboard"){
            include("contents/dashbord-content1.php");
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