<!DOCTYPE html>
<html lang="en">

<?php

require_once "database.php";
session_start();
if (isset($_SESSION['id']) && $_SESSION['admin'] == "admin"){

    $query = "SELECT * FROM uporabniki";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();

        ?>
    
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Domov</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/grayscale.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">PROrum</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Meni
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="index.php">Domov</a>
          </li>
        <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="forum.php">Forum</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="pravila.php">Pravila</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="odjava.php">Odjava</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
 
  <header class="masthead">
    <div class="container d-flex h-100 align-items-center">
      <div class="mx-auto text-center">
        <h2 class="mx-auto my-0 text-uppercase">
        
        </h2>
        <h2 class="text-white-50 mx-auto mt-2 mb-5">
        <table class='table table-dark w-auto'>
  <thead>
    <tr>
      <th scope='col'>ID</th>
      <th scope='col'>Ime</th>
      <th scope='col'>Priimek</th>
      <th scope='col'>Email</th>
      <th scope='col'>&nbsp;&nbsp;&nbsp;Naslov&nbsp;&nbsp;&nbsp;</th>
      <th scope='col'>Datum rojstva</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      
      while($row = $stmt->fetch())
{
  

      
      echo "
    <tr>
      <th scope='row'>". $row['id'] ."</th>
      <td>".  $row['ime'] . "</td>
      <td>". $row  ['priimek'] ."</td>
      <td>". $row  ['email'] ."</td>
      <td>". $row ['naslov'] ."</td>
      <td>". date("d.m.Y", strtotime($row['birthday']))."</td>
       
    </tr> 
    ";
  

}
echo "
</tbody>
</table> ";

?>  
<a class='btn btn-light js-scroll-trigger' href='admin.php'>Nazaj</a>
        </h2>
        
      </div>
    </div>
  </header>

  
  <!-- Contact Section -->
  <section class="contact-section bg-black">
    <div class="container">

      <div class="social d-flex justify-content-center">
        <a href="https://twitter.com/jkxycs" target="_blank" class="mx-2">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://github.com/j1xaro" target="_blank" class="mx-2">
          <i class="fab fa-github"></i>
        </a>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-black small text-center text-white-50">
    <div class="container">
      Copyright &copy; Your Website 2019
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/grayscale.min.js"></script>

</body>

</html>

    <?php 
} 
else {
    header("Location:index.php");
}
?>