<?php 
require("connexion.php");
session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}


   if(isset($_POST["logout"])){
        session_destroy();
        header("location: login.php");
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
   <p class="fw-bold p-4"><i class="bi bi-emoji-smile fs-4"> </i> Welcome,<span class="text-info"> <?php echo $_SESSION["username"] ?></span> </p> 
  
    <form action="" method="post" class="view">
      <div class="clientcontainer"><img src="images/client.jpg" class="img"><?php echo $_SESSION["username"] ?></div>
    <button type="submit" name="logout" class="btn btn-danger d-flex align-items-center gap-2 mt-0"><i class="bi bi-box-arrow-right " style="opacity: 0.5;"></i>
Log out </button>
</form>

   </div>
   
</form>

   </div>
   </div>
</navbar>
<aside>
    <div class="aside">
        <p class="fw-bold p-5">Garage AutoFix</p>
        <hr>
        <div class="asideslinks">
         <div class="link"><a href="Clientdashbord.php?page=dashboard" class="fw-bold"><i class="bi icon-dashbord bi-speedometer2"></i> Dashbord </a></div>
         <div class="link"><a href="Clientdashbord.php?page=voitures" class="fw-bold"><i class="bi icon-dashbord bi-car-front-fill"></i> My Cars</a></div>
         <div class="link"><a href="Clientdashbord.php?page=informations" class="fw-bold"><i class="bi icon-dashbord bi-person-fill"></i> Profile</a></div>
         
        
           

        <h5 class="nom"><?php echo $_SESSION["username"] ?></h5>
    <p class="email"><?php echo $_SESSION["email"] ?></p>
    </div></a>
    </div>
    <form action="Clientdashbord.php" method="post">
            
  <button type="submit" name="logout" class=" btn btn-danger d-flex align-items-center gap-2 mt-0">
    <i class="bi bi-box-arrow-right fs-5"></i>
    
    <span>Logout</span>
  </button>
  </form>
        </div>
       
        
    </div>
</aside>
<main class="main-content">
    <?php 
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == "dashboard"){
            include("contents/dashbord-client.php");
        }
         elseif($page == "voitures"){
            include("list_vehicules.php");
        }
        elseif($page == "reparations"){
            include("list_reparation.php");
        }
        elseif($page == "informations"){
            include("informations.php");
        }
        else {
            include("list_factures.php");
        }
    }?>
</main>
</body>
</html>