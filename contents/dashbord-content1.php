<?php
require("connexion.php");
$stmt = $connexion->prepare("select count(id) as counter from users");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(id) as counter from clients");
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(id) as counter from voiture");
$stmt->execute();
$voiture = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(statut) as counter from reparations where statut = 'en_cours'");
$stmt->execute();
$repa_cours = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("select count(statut) as counter from reparations where statut = 'terminee'");
$stmt->execute();
$repa_terminer = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT * FROM rendezvous order by ID DESC");
$stmt->execute();
$data_rend = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($data_rend as $row){
    
   $id = $row['id'];
   $nom = $row['nom'];
   $email = $row['email'];
   $phone = $row['phone'];
   $service = $row['service'];
   $date = $row['datere'];
   $message = $row['message'];
    
   
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
 $error = "";
$message = "";
if(isset($_POST["addclient"])){
    if(!empty($_POST["name"]) && !empty($_POST["prenom"]) && !empty($_POST["telephone"]) && !empty($_POST["adresse"])){
        $id = $_SESSION["id"];
        $nom = $_POST["name"];
        $prenom = $_POST["prenom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $stmt = $connexion->prepare("INSERT INTO clients (nom,prenom,telephone,adresse,user_id) values(?,?,?,?,?)");
        $stmt->execute([$nom,$prenom,$telephone,$adresse,$id]);
        $message = "Ajouter Avec Success";
        header("location: admindashbord.php?page=dashboard");
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
    else {
        $error = "Les Champs Sont Vides";
    }
}
if(isset($_POST["delete"])){
    $id = $_POST["id"];

    $stmt = $connexion->prepare("DELETE FROM rendezvous where id = ?");
    $stmt->execute([$id]);
    header("Location: dashbord-content1.php#mytable");
    exit;

}
$stmt = $connexion->prepare("SELECT id,nom FROM users");
$stmt->execute();
$clients_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT id FROM voiture");
$stmt->execute();
$voiture_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user_id = $_SESSION["id"];
$error = "";
if(isset($_POST["addvoiture"])){
    if(!empty($_POST["marque"]) && !empty($_POST["modele"]) && !empty($_POST["annee"]) && !empty($_POST["immatriculation"]) && !empty($_POST["carburant"]) && !empty($_POST["client_id"])){
        $client_id = $_POST["client_id"];
        $marque = $_POST["marque"];
        $modele = $_POST["modele"];
        $annee = $_POST["annee"];
        $immatruculation = $_POST["immatriculation"];
        $carburant = $_POST["carburant"];
        $stmt = $connexion->prepare("INSERT INTO voiture (client_id,user_id,marque,modele,annee,immatriculation,carburant) values (?,?,?,?,?,?,?)");
        $stmt->execute([$client_id,$user_id,$marque,$modele,$annee,$immatruculation,$carburant]);
            header("location: admindashbord.php?page=dashboard");
            exit;

    }
    else {
        $error = "Les champs Sont Vides";
    }
}
$user_id = $_SESSION["id"];
$error = "";
if(isset($_POST["addrepa"])){
    if(!empty($_POST["description"]) && !empty($_POST["prix"]) && !empty($_POST["date-debut"]) && !empty($_POST["date-fin"]) && !empty($_POST["voiture_id"]) && !empty($_POST["status"]) && !empty($_POST["client_id"])){
        $client_id = $_POST["client_id"];
        $description = $_POST["description"];
        $prix = $_POST["prix"];
        $date_debut = $_POST["date-debut"];
        $date_fin = $_POST["date-fin"];
        $voiture_id = $_POST["voiture_id"];
        $status = $_POST["status"];
        
        $stmt = $connexion->prepare("INSERT INTO reparations (voiture_id,client_id,user_id,description,statut,prix,date_debut,date_fin) values (?,?,?,?,?,?,?,?)");
        $stmt->execute([$voiture_id,$client_id,$user_id,$description,$status,$prix,$date_debut,$date_fin]);
            header("location: admindashbord.php?page=dashboard");
            exit;
        
    }
    else {
        $error = "Les champs Sont Vides";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assests/dash.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container-fluid">
    <div class="cards">
        <div class="row g-2 gx-4">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-bleu">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card1">
                        <i class="bi icon-dash bi-people"></i>
                        <h6 class="user-texte">Total Users</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $data["counter"]; ?></h2>
                       </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-rose">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card2">
                       <i class="bi icon-dash bi-card-list"></i>
                        <h6 class="user-texte">Total Clients</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $client["counter"]; ?></h2>
                       </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-cyan">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card3">
                        <i class="bi icon-dash bi-car-front-fill"></i>
                        <h6 class="user-texte">Total Voitures</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $voiture["counter"]; ?></h2>
                       </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-orange">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card4">
                        <i class="bi icon-dash bi-wrench"></i>  
                        <h6 class="user-texte">Réparations En Cours</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $repa_cours["counter"] ; ?></h2>
                       </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-vio">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card5">
                        <i class="bi icon-dash bi-check-circle-fill"></i>

                        <h6 class="user-texte">Réparations Terminées</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $repa_terminer["counter"] ; ?></h2>
                       </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    <div class="container bg-light h-100 w-100">
        <h3 class="fw-bold p-5">Derniers Rendez-vous</h3>
        <input type="search" class="form-control search-bar form-control-sm w-25 rounded" placeholder="Rechercher" id="search" >
        <button class="btn btn-danger f-2" id="btt"><i class="bi bi-search"></i></button>
        <table class="table table-hover w-100" id="mytable">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nom</th>
      <th scope="col">Email</th>
      <th scope="col">Téléphone</th>
      <th scope="col">Service</th>
      <th scope="col">Date</th>
      <th scope="col">Message</th>
      <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php 
    foreach ($data_rend as $row){
    echo "<tr>";
   echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nom']}</td>";
     echo "<td>{$row['email']}</td>";
      echo "<td>{$row['phone']}</td>";
       echo "<td class='badge bg-primary text-light d-flex justify-content-center '>{$row['service']}</td>";
        echo "<td>{$row['datere']}</td>";
         echo "<td>{$row['message']}</td>";
         echo "<td><form action='contents/dashbord-content1.php' method='post'>
         <button class='btn btn-primary btn-sm' name='edit'>
  <i class='bi bi-pencil-square'></i>
</button>
<button type='submit' class='btn btn-danger btn-sm' name='delete'>
  <i class='bi bi-trash'></i> 
</button>
<input type='hidden' name='id' value='{$row['id']}'></form></td>";
   echo "</tr>";
   
  
    
   
}
    
    ?>
    </tbody>
    </table>
    <button class="btn btn-primary" id="next-page"><i class="bi bi-chevron-right"></i>Next</button>
  
  
   


    </div>
<div class="container bg-light h-100 w-100">
    <h4 class="fw-bold p-5"> Actions Rapides</h4>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <button class="card card_action"  data-bs-toggle="modal" data-bs-target="#adduserModal"><i class="bi bi-person-plus "></i>Add User</button>
            
        </div>
         <div class="col-lg-3 col-md-4 col-sm-12">
            <button class="card card_action"  data-bs-toggle="modal" data-bs-target="#addclientModal"><i class="bi icon-client bi-people"></i>Add Client</button>
        </div>
         <div class="col-lg-3 col-md-4 col-sm-12">
            <button class="card card_action"  data-bs-toggle="modal" data-bs-target="#addvehiculeModal"><i class="bi bi-car-front"></i>Add Vehicule</button>
        </div>
         <div class="col-lg-3 col-md-4 col-sm-12">
           <button class="card card_action"  data-bs-toggle="modal" data-bs-target="#addrepaModal"><i class="bi bi-tools"></i>Add Reparations</button>
        </div>
    </div>

</div>
<!--- User Form --->
 <div class="modal fade" id="adduserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New User</h5>
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
            <label class="form-label" for="username">Username</label>
            <input type="text" name="username" placeholder="Entrer username" class="form-control form-control-sm" required>
            
           
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="Enter Votre Email" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Votre Password" class="form-control form-control-sm" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="checkpassword">Vérifier Password</label>
            <input type="password" id="checkpassword" name="checkpassword" placeholder="Valider Votre Password" class="form-control form-control-sm" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="role">Choisir Le Rôle</label>
            <select class="form-select" id="role" name="role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        <button type="submit" name="add" class="btn btn-success">Save</button>
    </form>
</div>

    </div>
  </div>
</div>
<!--- Client Form -->
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
<!--- Voiture Form -->
<div class="modal fade" id="addvehiculeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add New Vehicule</h5>
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
            <label class="form-label" for="name">Id Client</label>
           <?php
           echo "<select class='form-select' name='client_id'>";
           echo "<option disabled>Choisir Un Client </option>";
                foreach($clients_id as $row){
                
                    echo "<option> {$row['id']}  </option>";
    
}
echo "</select>";
           ?>
            
           
        </div>

        <div class="mb-3">
            <label class="form-label" for="marque">Marque Du Voiture</label>
            <input type="text"  name="marque" class="form-control form-control-sm" placeholder="Enter La Marque De Voiture" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="model">Modele</label>
            <input type="text"  name="modele" placeholder="Enter Le Modele De Voiture" class="form-control form-control-sm" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="annee">Annee</label>
            <input type="text"  name="annee" placeholder="Enter l'année Dd La Voiture" class="form-control form-control-sm" required>
        </div>
         <div class="mb-3">
            <label class="form-label" for="annee">immatriculation</label>
            <input type="text"  name="immatriculation" placeholder="Enter l'année Dd La Voiture" class="form-control form-control-sm" required>
        </div>
         <div class="mb-3">
            <label class="form-label" for="annee">Type De Carburant</label>
            <select class="form-select" name="carburant">
                <option disabled>-----Choose A type------</option>
                 <option value="essence">essence</option>
                    <option value="diesel">diesel</option>
                    <option value="hybride">hybride</option>
                    <option value="electrique">electrique</option>
            </select>
           
        </div>
        
        <button type="submit" name="addvoiture" class="btn btn-success">Save</button>
    </form>
</div>

    </div>
  </div>
</div>
<!---- Reparation form --->

<div class="modal fade" id="addrepaModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Add reparation</h5>
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
            <label class="form-label" for="name">Id Client</label>
           <?php
           echo "<select class='form-select' name='client_id'>";
           echo "<option disabled>Choisir Un Client </option>";
                foreach($clients_id as $row){
                
                    echo "<option> {$row['id']}  </option>";
    
}
echo "</select>";
           ?>
            
           
        </div>

        <div class="mb-3">
            <label class="form-label" for="voiture_id">Id Voiture</label>
             <?php
           echo "<select class='form-select' name='voiture_id'>";
           echo "<option disabled>Choisir Un Client </option>";
                foreach($voiture_id as $row){
                
                    echo "<option> {$row['id']}  </option>";
    
}
echo "</select>";
           ?>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="description">Description De Problem</label>
            <textarea type="text"  name="description" placeholder="Decris Le Problem" class="form-control form-control-sm" required></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="prix">Prix :</label>
            <input type="number"  name="prix" placeholder="Enter Le Prix" class="form-control form-control-sm" required>
        </div>
         <div class="mb-3">
            <label class="form-label" for="date-debut">Date Debut :</label>
            <input type="date"  name="date-debut" class="form-control form-control-sm" required>
        </div>
         <div class="mb-3">
            <label class="form-label" for="date-debut">Date Fin :</label>
            <input type="date"  name="date-fin" class="form-control form-control-sm" required>
        </div>
         <div class="mb-3">
            <label class="form-label" for="annee">Statut </label>
            <select class="form-select" name="status">
              
            <option value="en_cours">En Cours</option>
            <option value="en_attente">En attente</option>
            <option value="termines">Termines</option>
            </select>
           
        </div>
        
        <button type="submit" name="addrepa" class="btn btn-success">Save</button>
    </form>
</div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        
    const table = document.getElementById("mytable");
const rows = table.getElementsByTagName("tr");
const button = document.getElementById("next-page");
const tds = table.getElementsByTagName("td");
console.log(tds[1].textContent)
const rowsPerPage = 7; 
let currentPage = 0;    


function showPage(page) {
    const start = page * rowsPerPage;
    const end = Math.min(start + rowsPerPage, rows.length);

    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = "none";
    }

    for (let i = start; i < end; i++) {
        rows[i].style.display = "table-row"; 
    }
}

showPage(currentPage);

button.addEventListener("click", () => {
    currentPage++;
    if (currentPage * rowsPerPage >= rows.length) {
        currentPage = 0; // loop back to first page
    }
    showPage(currentPage);
});
const btt = document.getElementById("btt");
btt.addEventListener("click", () => {
     const search = document.getElementById("search").value;
    for (let i = 0 ; i < rows.length;i++){
        const td = rows[i].children[1];
        if(td.textContent.includes(search)){
             rows[i].style.display = "";
        }else {
             rows[i].style.display = "none";
        }
    }
 console.log(search)
})


</script>
</body>

</html>