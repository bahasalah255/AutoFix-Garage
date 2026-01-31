
<?php
require("connexion.php");
//session_start();


$error = "";
$message = "";
if(isset($_POST["addclient"])){
    if(!empty($_POST["name"]) && !empty($_POST["prenom"]) && !empty($_POST["telephone"]) && !empty($_POST["adresse"]) && !empty($_POST["username_sign"]) && !empty($_POST["password_sign"]) && !empty($_POST["checkpassword"])){
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
           $sign_error = "Email n'est pas valide";
        } else {
            $stmt = $connexion->prepare("SELECT email from users where email = ?");
        $stmt->execute([$_POST["email"]]);
        $data_sign = $stmt->fetch(PDO::FETCH_ASSOC);

        if($_POST["password_sign"] === $_POST["checkpassword"] && !$data_sign){
            if(strlen($_POST["password_sign"]) < 8){
                $sign_error = "Votre Mot De passe doit depasser 8 caracteres";
            }
            else {
                $username_sign = trim(strip_tags($_POST["username_sign"]));
        $id = $_SESSION["id"];
        $nom = $_POST["name"];
        $email = $_POST["email"];
        $prenom = $_POST["prenom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $hash = password_hash(trim($_POST["password_sign"]),PASSWORD_DEFAULT);
       $stmt = $connexion->prepare("INSERT into users (username,email,password,nom,prenom,tele,adresse) values(?,?,?,?,?,?,?)");
            $stmt->execute([$username_sign,$email,$hash,$nom,$prenom,$telephone,$adresse]);
        $message = "Ajouter Avec Success";
        header("location: admindashbord.php?page=clients");
        exit;
        /*
        if($_SESSION["role"] == "user"){
            header("location: userdashbord.php?page=dashboard");
        }
        else {
            header("location: admindashbord.php?page=dashboard");
        }
        */
            }
    }
    else {
        $error = "Les Champs Sont Vides";
    }
        }
}
}
$stmt = $connexion->prepare("SELECT * FROM users where role = 'client' order by username ASC");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from users where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=clients");
    
}


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assests/list_clients">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <h1 class="fw-bold text-danger d-flex justify-content-center">LIST OF CLIENTS</h1>
    <button type="button" class="btn btn-user btn-danger"data-bs-toggle="modal" data-bs-target="#addClientModal"><i class="bi bi-person-plus fs-4"></i>Add Client</button>
    <div class="modal fade" id="addclientModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

     <div class="modal-body">
    <form action="" method="POST">
        <?php if(!empty($error)){ ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php } ?>
            <?php if(!empty($message)){ ?>
                <p class="success"><?php echo htmlspecialchars($message); ?></p>
            <?php } ?>
        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" name="name" placeholder="Entrer username" class="form-control form-control-sm" required>
            
           
        </div>

        <div class="mb-3">
            <label class="form-label" for="prenom">Last Name</label>
            <input type="text"  name="prenom" class="form-control form-control-sm" placeholder="Enter Votre Prenom" required>
        </div>
        <label class="form-label">Username : </label>
        <input type="text" name="username_sign" class="form-control form-control-sm" placeholder="Enter Votre Username">
        <label class="form-label">Email : </label><br>
        <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter Votre email">
        <label class="form-label">Password : </label><br>
        <input type="password" name="password_sign" class="form-control form-control-sm" placeholder="Enter Votre password">
        <label class="form-label">Verifie Password : </label><br>
        <input type="password" name="checkpassword" class="form-control form-control-sm" placeholder="Enter Votre password">
        <div class="mb-3">
            <label class="form-label" for="phone">Phone Number</label>
            <input type="phone"  name="telephone" placeholder="Enter Phone Number" class="form-control form-control-sm" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="adresse">Adresse De Residance</label>
            <input type="text"  name="adresse" placeholder="Enter l'adresse Du Client" class="form-control form-control-sm" required>
        </div>
        
        <button type="submit" name="addclient" class="btn btn-success">Save</button>
    </form>
</div>

    </div>
  </div>
</div>
     <table class="table table-hover w-100 table-striped " id="mytable">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nom</th>
      <th scope="col">Prenom</th>
      <th scope="col">Telephone</th>
      <th scope="col">Adresse</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Created Time</th>
      <th scope="col">Actions</th>
      
    </tr>
    </thead>
    <tbody>
<?php
foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['nom']}</td>
    <td>{$row['prenom']}</td>
    <td>{$row['tele']}</td>
    <td>{$row['adresse']}</td>
    <td>{$row['username']}</td>
    <td>{$row['email']}</td>
    <td>{$row['date_inscription']}</td>
    <td><form action='list_clients.php' method='get'><input type='hidden' name='id' value='{$row['id']}'><button type='submit' class='btn btn-danger  btn-sm fs-6' name='delete'> <i class='bi bi-trash'></i> </button>
    <button type='submit' name='edit' class='btn btn-primary btn-sm fs-6'><i class='bi bi-pencil-square'></i></form></td>
    ";
    echo "</tr>";
}
?>
    </tbody>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>