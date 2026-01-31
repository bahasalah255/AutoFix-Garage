<?php 
require("connexion.php");
$id = $_SESSION["id"];
$stmt = $connexion->prepare("SELECT count(client_id) as counter from voiture where client_id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT count(client_id) as counter from reparations where client_id = ? and statut = 'en_cours'");
$stmt->execute([$id]);
$data1 = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT count(client_id) as counter from reparations where client_id = ? and statut = 'terminee'");
$stmt->execute([$id]);
$data2 = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT SUM(prix) as total_prix  from reparations where client_id = ?");
$stmt->execute([$id]);
$data3 = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT description,statut,date_fin from reparations where client_id = ? ");
$stmt->execute([$id]);
$data4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $connexion->prepare("SELECT id_facture,created_at,montant,statut_paimenet from factures where client_id = ? ");
$stmt->execute([$id]);
$data5 = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <div class="cards mt-10">
        <div class="row g-4 gx-4">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-bleu">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card1">
                        <i class="bi icon-dash bi-people"></i>
                        <h6 class="user-texte">Total Voitures</h6>
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
                        <h6 class="user-texte">Reparations En Cours</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $data1["counter"]; ?></h2>
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
                        <h6 class="user-texte">Reparations Termines</h6>
                        <h2 class="user-texte11 fw-bold"><?php echo $data2['counter'] ?></h2>
                       </div>
                    </div>
                </div>
                
            </div>
           <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card mycard  shadow-sm">
                    <div class="card-header p-0  header-yellow">
                         
                    </div>
                    <div class="card-body">
                       <div class="icon card3">
                        <i class="bi icon-dash bi-receipt"></i>
                        <h6 class="user-texte">Montant Total</h6>
                        <h2 class="user-texte11 fw-bold fs-3"><?php echo $data3["total_prix"]?> Dh</h2>
                       </div>
                    </div>
                </div>
                
            </div>
                
            </div>
        </div>
    </div>
    </div>
    <div class="container">
        <div class="card rounded shadow-sm w-50">
            <div class="card-header">
                <h6>Reparations Recents</h6>
            </div>
            <div class="card-body">
                
                   
                <?php 
                foreach($data4 as $row){
                    echo "<div class='repa d-flex justify-content-between'>";
                    echo "<p class='text-black'>{$row['description']}  <span class='badge bg-primary fs-14'>{$row['statut']}</span></p>
                    <p class='text-black'>{$row['date_fin']} </p>";
                    echo "</div>";
                };
                
                
                ?>

                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card rounded shadow-sm w-100">
            <div class="card-header">
                <h6>Listes Des Factures</h6>
            </div>
            <div class="card-body">
                <table class="table table-hovred">
                    <thead>
                        <tr>
                            <th scope="col">N Facture</th>
                            <th scope="col">Date</th>
                            <th scope="col">Montant</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                <?php 
                    echo "<tbdoy>";
                    foreach($data5 as $row){
                        echo "<tr>";
                        echo "<td class='fw-bold'> #{$row['id_facture']} </td>
                        <td> {$row['created_at']} </td>
                        <td> {$row['montant']} MAD</td>
                        <td> {$row['statut_paimenet']} </td>
                        <td>       
                        <form action='list_factures.php' method='post'>
   <button type='submit' class='btn btn-info' name='voir'><i class='bi bi-eye'></i></button>
   <input type='hidden' name='id' value='{$row['id_facture']}'>
    </form>
                        </td>
                        
                        ";
                    };
                ?>
                </table>
            </div>
            </div>
    </div>