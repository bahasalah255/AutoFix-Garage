
<?php
require("connexion.php");
/*session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
    
if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}
*/
if($_SESSION["role"] == "client"){
     $stmt = $connexion->prepare("SELECT * FROM voiture where client_id = ? order by created_at ASC");
$stmt->execute([$_SESSION["id"]]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
     $stmt = $connexion->prepare("SELECT * FROM voiture order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


   

if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from voiture where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=voitures");
    
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="assests/list_users">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <h1 class="fw-bold text-danger d-flex justify-content-center">List Of Vehicules</h1>
  <table class="table table-hover w-100 table-striped " id="mytable">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">client ID</th>
      <th scope="col">User ID</th>
      <th scope="col">Marque</th>
      <th scope="col">Modele</th>
      <th scope="col">Annee</th>
      <th scope="col">Immatriculation</th>
      <th scope="col">Carburant</th>
      <th scope="col">Created At</th>
      <?php 
        if($_SESSION["role"] == "admin"){
            echo "<th scope='col'>Actions</th>";
        }
      ?>
      
      
    </tr>
    </thead>
    <tbody>
<?php
foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['marque']}</td>
    <td>{$row['modele']}</td>
    <td>{$row['annee']}</td>
    <td>{$row['immatriculation']}</td>
    <td>{$row['carburant']}</td>
    <td>{$row['created_at']}</td>";
    if(($_SESSION["role"] == "admin")){
         echo "<td><form action='list_vehicules.php' method='get'>
    <input type='hidden' name='id' value='{$row['id']}'>
    <button type='submit' name='delete' class='btn btn-danger'><i class='bi bi-trash'></i></button>
    </form>
    </td>
    ";
    }
   
    echo "</tr>";
    
}
?>
    </tbody>
</body>
</html>