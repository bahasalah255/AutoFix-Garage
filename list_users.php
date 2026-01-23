
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="assests/list_users">
</head>
<body>
    <h1 class="titre">List Of Users</h1>
</body>
</html>
<?php
require("connexion.php");
//session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
    
if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}

$stmt = $connexion->prepare("SELECT * FROM users ");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<table border='1'> <th>ID</th> <th>Username</th> <th>email</th> <th>password</th> <th>date</th> <th>role</th> <th>Actions</th>";

foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['username']}</td>
    <td>{$row['email']}</td>
    <td>{$row['password']}</td>
    <td>{$row['date_inscription']}</td>
    <td>{$row['role']}</td>
    <td><form action='list_users.php' method='get'><input type='hidden' name='id' value='{$row['id']}'><input type='submit' name='delete' value='delete' class='button_form'></form></td>
    ";
    echo "</tr>";
}

echo "</table>";
if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from users where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=users");
    
}

?>