
<?php
require("connexion.php");
//session_start();
if(!isset($_SESSION["role"]) ){
    header("location: login.php");
    
    
}
    
if($_SESSION["role"] == "user"){
     header("location: userdashbord.php");
}
 $error = "";
$message = "";
if(isset($_POST["add"])){
    if(!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["checkpassword"])){
        if($_POST["password"] == $_POST["checkpassword"]){
            $username = $_POST["username"];
            $email = $_POST["email"];
            $hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
            $role = $_POST["role"];
            $stmt = $connexion->prepare("INSERT into users (username,email,password,role) values(?,?,?,?)");
            $stmt->execute([$username,$email,$hash,$role]);
            $message = "Ajouter Avec Success";
            
        }
        else {
            $error = "Passwords Doesn't Match";
        }
    }
    else {
        $error = "les champs sont vides";
    }
}

$stmt = $connexion->prepare("SELECT * FROM users ");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET["delete"])){
    $id = $_GET["id"];
    $stmt = $connexion->prepare("DELETE from users where id = ?");
    $stmt->execute([$id]);
    echo "<p id='error'>Deleted Avec Success </p>";
    header("location: admindashbord.php?page=users");
    
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
</head>
<body>
    <h1 class="fw-bold d-flex justify-content-center text-danger">List Of Users</h1>
    
    <button type="button" class="btn btn-user btn-danger"data-bs-toggle="modal" data-bs-target="#addClientModal"><i class="bi bi-person-plus fs-4"></i>Add User</button>
    <div class="modal fade" id="addClientModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form action="" method="POST">
          <div class="mb-3">
             <?php if(!empty($error)){ ?>
    <p class="error"><?php echo $error; ?></p>
<?php } ?>
 <?php if(!empty($message)){ ?>
    <p class="success"><?php echo $message; ?></p>
<?php } ?>
            <label class="form-label">Username</label>
            <input type="text" name="username" placeholder="Enter Votre Nom" class="form-control form-control-sm" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"  placeholder="Enter Votre Email" class="form-control form-control-sm" required>
          </div>
           <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"  placeholder="Enter Votre Password" class="form-control form-control-sm" required>
          </div>
           <div class="mb-3">
            <label class="form-label">Verifie Password</label>
            <input type="password" name="checkpassword"  placeholder="Valider Votre Password" class="form-control form-control-sm" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Choisir Le Role</label>
            <select class="form-select" name="role">

                <option value="admin">Admin</option>
                <option value="user">User</option>
                <option value="client">Client</option>
            </select>
          </div>

          <button type="submit" name="add" class="btn btn-success">Save</button>
        </form>
      </div>

    </div>
  </div>
</div>
    <table class="table table-hover w-100 table-striped " id="mytable">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Uername</th>
      <th scope="col">Email</th>
      <th scope="col">Date</th>
      <th scope="col">Role</th>
      <th scope="col">Actions</th>
      
    </tr>
    </thead>
    <tbody>
<?php
foreach($data as $row){
    echo "<tr>";
    echo "<td>{$row['id']}</td>
    <td>{$row['username']}</td>
    <td>{$row['email']}</td>
    <td>{$row['date_inscription']}</td>
    <td class='badge role d-flex justify-content-center w-50 m-3'>{$row['role']}</td>
    <td><form action='list_users.php' method='get'><input type='hidden' name='id' value='{$row['id']}'><button type='submit' class='btn btn-danger btn-sm fs-6' name='delete'>
  <i class='bi bi-trash'></i> 
</button></form></td>
    ";
    echo "</tr>";
}
?>
    </tbody>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        const tds = document.querySelectorAll("td.role");
        tds.forEach(td => {
                if(td.textContent == "admin"){
            td.classList.add("mybadge1")
        }
        else {
             td.classList.add("mybadge2")
        }
        })
        
       
    </script>
</body>
</html>