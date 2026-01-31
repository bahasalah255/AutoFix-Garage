
<?php
require("connexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
    
/*if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}
*/

$stmt = $connexion->prepare("SELECT * FROM reparations order by created_at ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);



if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from reparations where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=reparations");
    
}
if(isset($_POST["changevalue"])){
    $choice = $_POST["choices"];
    $id = $_POST["id"];
    $stmt = $connexion->prepare("UPDATE reparations set statut = ? where id = ? ");
    $stmt->execute([$choice,$id]);
    
    header("location: admindashbord.php?page=reparations");
}
if(isset($_GET["facture_create"])){
    $id = $_GET["id"];
   $stmt =$connexion->prepare("select * from reparations where id = ?");
   $stmt->execute([$id]);
   $data = $stmt->fetch(PDO::FETCH_ASSOC);
   $stmt = $connexion->prepare("insert into factures (reparation_id,voiture_id,client_id,montant,user_id) values(?,?,?,?,?) ");
   $stmt->execute([$data["id"],$data["voiture_id"],$data["client_id"] ,$data["prix"],$data["user_id"] ]);
    header("location: admindashbord.php?page=reparations");
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
    <h1 class="fw-bold text-danger d-flex justify-content-center">List Of Reparations</h1>
     <table class="table table-hover w-100 table-striped " id="mytable">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Voiture ID</th>
      <th scope="col">Client ID</th>
      <th scope="col">Empolyer ID</th>
      <th scope="col">Description</th>
      <th scope="col">Statut</th>
      <th scope="col">Prix</th>
      <th scope="col">Date Debut</th>
      <th scope="col">Date Fin</th>
      <th scope="col">Created At</th>
      <th scope="col">Actions</th>
      
    </tr>
    </thead>
    <tbody>
        <?php 
            foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['voiture_id']}</td>
    <td>{$row['client_id']}</td>
    <td>{$row['user_id']}</td>
    <td>{$row['description']}</td>
    <td>
    <div class='badge bg-primary rounded-pill'>
    {$row['statut']} 
    </div>
    <form action='list_reparation.php' method='post'>
    <select name='choices' class='form-select'>
            <option value='en_cours' >En Cours</option>
            <option value='en_attente'>En attente</option>
            <option value='terminee'>Termines</option>
    </select>
    <button type='submit' name='changevalue' class='btn btn-info'><i class='bi bi-arrow-repeat'></i></button>
    <input type='hidden' name='id' value='{$row['id']}'>
    </form>
    
    </td>
    <td> <div class='badge bg-primary rounded-pill'>
    {$row['prix']} DHS
    </div> </td>
    <td>{$row['date_debut']}</td>
    <td>{$row['date_fin']}</td>
    <td>{$row['created_at']}</td>
    <td><form action='list_reparation.php' method='get'>
    <button type='submit' name='facture_create' class='btn btn-info'><i class='bi bi-receipt'></i></button>
    <button type='submit' name='delete' class='btn btn-danger'><i class='bi bi-trash'></i></button>
    <input type='hidden' name='id' value='{$row['id']}'>
    </form></td>
    ";
    echo "</tr>";
}
        ?>
</body>
</html>