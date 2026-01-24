<?php
require("connexion.php");
$error = "";
$reussi = "";
if(isset($_POST["confirmer"])){
    if(!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["phone"]) && !empty($_POST["service"]) && !empty($_POST["datere"]) && !empty($_POST["horaire"]) && !empty($_POST["message"])){
        $nom = htmlspecialchars($_POST["nom"]);
        $email = htmlspecialchars($_POST["email"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $service = htmlspecialchars($_POST["service"]);
        $date = htmlspecialchars($_POST["datere"]);
        $horaire = htmlspecialchars($_POST["horaire"]);
        $message = htmlspecialchars($_POST["message"]);
        $stmt= $connexion->prepare("INSERT into rendezvous (nom,email,phone,service,datere,horaire,message) values(?,?,?,?,?,?,?)");
        if($stmt->execute([$nom,$email,$phone,$service,$date,$horaire,$message])){
                $reussi = "✅ Votre rendez-vous a été envoyé avec succès ! Nous vous contacterons bientôt.";
        }
        else {
            $error = "Une Erreur est survenue";
        }
        

    }
    else {
        $error = "Les Champs Sont Vides";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoFix Garage - Accueil</title>
    <link rel="stylesheet" href="assests/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
</head>
<body>
<nav class="navbar nav navbar-expand-lg shadow-sm fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="images/logo1.png" alt="logo AutoFix" class="image">
      <span class="fw-bold fs-2">AutoF<span class="text-danger">ix</span></span>
      <span class="fs-small ms-1">Garage</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item link"><a class="nav-link lien" href="Front-end/index.html">Accueil</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="Front-end/services.html">Services</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="Front-end/galerie.html">Galerie</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="Front-end/contact.php">Contact</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="login.php" target="_blank"><i class="bi bi-box-arrow-in-left fs-4"></i></a></li>
        <li class="nav-item link" id="mode"><a class="nav-link" href="#"><i class="bi bi-moon-fill fs-5"></i></a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="rendez-vous">
    <div class="container-fluid">
    <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <form method="post">
            <h4 class="fw-bold">Prendre Rendez Vous</h4>
            <p>Planifie Votre Visite au garage en quelques Clics !</p>
            <div class="formulaire">
                 <?php if($error) echo "<p class='error'>$error</p>"; ?>
<?php if($reussi) echo "<p class='reussi''>$reussi</p>"; ?>
                <legend class="text-center">Formulaire De Rendez-Vous</legend>
                <hr>
                <label>Votre Nom *</label>
                <input type="text" class="form-control" name="nom">
                <label>Votre Email *</label>
                <input type="email" class="form-control"  name="email">
                <label>Votre Telephone *</label>
                <input type="phone" class="form-control"  name="phone">
                <label>Choisir Un Service *</label>
                <select class="form-select"  name="service">
                    <option value="choix" disabled>-- Choisissez un service --</option>
                    <option value="entretien">Entretien régulier</option>
                    <option value="vidange">Vidange moteur</option>
                    <option value="freins">Réparation des freins</option>
                    <option value="pneus">Changement ou réparation de pneus</option>
                    <option value="diagnostic">Diagnostic électronique / contrôle moteur</option>
                    <option value="batterie">Remplacement batterie</option>
                    <option value="climatisation">Entretien climatisation</option>
                    <option value="suspension">Réparation suspension</option>
                    <option value="carrosserie">Carrosserie / peinture</option>
                    <option value="autre">Autre service</option>
                </select>
                <label>Date De Rendez-vous *</label>
                <input type="date" class="form-control"  name="datere">
                <label>Horaire préféré * </label>
                <select class="form-select" required  name="horaire">
                    <option value="" disabled>-- Choisissez un horaire --</option>
                    <option value="08:00">08:00</option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    <option value="17:00">17:00</option>
                </select>
                <label>Commentaire *</label>
                <textarea class="form-control" placeholder="Votre Message optionelle" name="message"></textarea><br>
                <button type="submit" name="confirmer" class="btn btn-danger">Confirmer Le Rendez-vous</button>
            </div>
        </form>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <h3>Nos Cordonnes</h3>
                <hr>
                <div class="Cordonnes">
                    <p><i class="bi text-danger bi-geo-alt-fill">Adresse :</i>123 Rue De Garage ,Ain sebaa,Casablanca</p>
                    <p><i class="bi text-danger bi-telephone-fill">Telephone :</i>0632210402 / 0777168608</p>
                    <p><i class="bi text-danger bi-envelope-fill"> Email :</i>autofixgarage@auto.com</p>
                    <hr>
                    <h4><i class="bi text-danger bi-clock-fill"></i> Nos Horaires </h4>
                    <p><span class="fw-bold">Lundi - Vendredi :</span> 8h - 18h</p>
                    <p><span class="fw-bold">Samedi :</span> 9h - 13h </p>
                    <div class="card-aide">
                        <h5 class="text-center">Besoin d'une assistance rapide ?</h5>
                        <hr class="text-center">
                        <div class="tele-card">
                            <p class="text-center fw-bold">Applez nous-maintenant ! </p>
                            <i class="bi text-danger tele-icon bi-telephone-fill">063210402</i>
                            
                        </div>
                    </div>
                </div>
    </div>
    </div>
    </div>
    <br><br>
</div>
 <div class="footer">
  <div class="container">
    <div class="row text-white py-5">
      <div class="col-lg-3 col-md-6 col-sm-12">
        <img src="images/logo-footer.png" class="footer-logo mb-3">
        <p>Garage professionnel spécialisé dans la réparation, entretien et diagnostic.</p>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <h5>Liens rapides</h5>
        <ul class="list-unstyled">
          <li><a href="#accueil">Accueil</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="galerie.html">Galerie</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <h5>Contact</h5>
        <p>📞 +212 65 333 4444</p>
        <p>✉️ contact@autofix.com</p>
        <p>📍 Casablanca, Maroc</p>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12">
        <h5>Suivez-nous</h5>
        <div class="social-icons d-flex gap-3">
          <i class="bi bi-facebook"></i>
          <i class="bi bi-twitter"></i>
          <i class="bi bi-instagram"></i>
          <i class="bi bi-linkedin"></i>
        </div>
      </div>

    </div>

    <hr class="text-secondary">

    <p class="text-center text-white">© 2026 AutoFix Garage. Tous droits réservés.</p>
  </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
     const mode = document.getElementById("mode");
const body = document.body;
const icon = mode.querySelector("i");


if (localStorage.getItem("theme") === "dark") {
    body.classList.add("dark-mode");
    icon.classList.replace("bi-moon-fill", "bi-sun-fill");
}

mode.addEventListener("click", () => {
    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
        icon.classList.replace("bi-moon-fill", "bi-sun-fill");
        localStorage.setItem("theme", "dark");
    } else {
        icon.classList.replace("bi-sun-fill", "bi-moon-fill");
        localStorage.setItem("theme", "light");
    }
});
</script>