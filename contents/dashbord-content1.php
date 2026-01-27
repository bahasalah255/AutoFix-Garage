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
if(isset($_POST["delete"])){
    $id = $_POST["id"];

    $stmt = $connexion->prepare("DELETE FROM rendezvous where id = ?");
    $stmt->execute([$id]);
    header("Location: dashbord-content1.php#mytable");
    exit;

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
        <input type="search" class="form-control form-control-sm w-25 rounded" placeholder="Rechercher" id="search" >
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
         echo "<td><form action='dashbord-content1.php' method='post'>
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
            <a class="card card_action" href="add_user.php"><i class="bi bi-person-plus "></i>Add User</a>
        </div>
         <div class="col-lg-3 col-md-4 col-sm-12">
            <a class="card card_action" href="add_client.php"><i class="bi icon-client bi-people"></i>Add Client</a>
        </div>
         <div class="col-lg-3 col-md-4 col-sm-12">
            <a class="card card_action" href="add_vehicule.php"><i class="bi bi-car-front"></i>Add Vehicule</a>
        </div>
         <div class="col-lg-3 col-md-4 col-sm-12">
            <a class="card card_action" href="add_reparation.php"><i class="bi bi-tools"></i>Add Reparations</a>
        </div>
    </div>

</div>

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