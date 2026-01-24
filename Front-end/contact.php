<?php
require("../connexion.php");
$error = "";
$reussi = "";
if(isset($_POST["send"])){
    if(!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["message"]) ){
    $name = $_POST["nom"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $stmt = $connexion->prepare("INSERT INTO informations (nom,email,message) values(?,?,?)");
    $stmt->execute([$name,$email,$message]);
    $reussi = "✅ Merci ! Votre message a bien été envoyé. Nous reviendrons vers vous très bientôt.";
    }else{
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
    <link rel="stylesheet" href="../assests/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
</head>
<body>
<nav class="navbar nav navbar-expand-lg shadow-sm fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../images/logo1.png" alt="logo AutoFix" class="image">
      <span class="fw-bold fs-2">AutoF<span class="text-danger">ix</span></span>
      <span class="fs-small ms-1">Garage</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item link"><a class="nav-link lien" href="index.html">Accueil</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="services.html">Services</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="galerie.html">Galerie</a></li>
        <li class="nav-item link"><a class="nav-link lien active" href="contact.php">Contact</a></li>
        <li class="nav-item link"><a class="nav-link lien" href="../login.php" target="_blank"><i class="bi bi-box-arrow-in-left fs-4"></i></a></li>
        <li class="nav-item link" id="mode"><a class="nav-link" href="#"><i class="bi bi-moon-fill fs-5"></i></a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="contact-form" id="contact">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <form method="post">
                <div class="form">
                  <?php if($error) echo "<p class='error'>$error</p>"; ?>
<?php if($reussi) echo "<p class='reussi''>$reussi</p>"; ?>

                    <h3 class="fw-bold"><i class="bi text-danger bi-envelope-fill me-2"></i>Contactez-nous</h3>
                    <hr>
                    <label>Nom : </label>
                    <input type="text" class="form-control" name="nom">
                    <label>Email : </label>
                    <input type="email" class="form-control" name="email">
                    <label>Message : </label>
                    <textarea class="form-control" name="message"></textarea><br>
                    <button type="submit" name="send" class="btn btn-danger">Envoyer</button>
                    <button type="reset" name="reset" class="btn btn-info">Reninstaliser</button>
                </div>
            </div>
             <div class="col-lg-6 col-md-6 col-sm-12">
                <h3 class="fw-bold"><i class="bi text-danger bi-geo-alt-fill me-2 fs-2"></i> Nos Cordonnes</h3>
                <hr>
                <div class="Cordonnes">
                    <p><i class="bi text-danger bi-geo-alt-fill">Adresse :</i>123 Rue De Garage ,Ain sebaa,Casablanca</p>
                    <p><i class="bi text-danger bi-telephone-fill">Telephone :</i>0632210402 / 0777168608</p>
                    <p><i class="bi text-danger bi-envelope-fill"> Email :</i>autofixgarage@auto.com</p>
                    <hr>
                    <h4><i class="bi text-danger bi-clock-fill"></i> Nos Horaires </h4>
                    <p><span class="fw-bold">Lundi - Vendredi :</span> 8h - 18h</p>
                    <p><span class="fw-bold">Samedi :</span> 9h - 13h </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
 <div class="footer">
  <div class="container">
    <div class="row text-white">
      <div class="col-lg-3 col-md-6 col-sm-12">
        <img src="../images/logo-footer.png" class="footer-logo mb-3">
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
const contact = document.getElementById("contact");
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
     if(entry.isIntersecting){
    contact.classList.add("active");
    
    
  } 
  })
 
})
observer.observe(contact);
</script>
