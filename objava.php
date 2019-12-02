<!DOCTYPE html>
<html lang="en">

<?php
session_start();
    require_once "database.php";  
    $objava = $_GET['obj'];
    $query1 = "SELECT * FROM objave where id=".$objava;
    $stmt1 = $pdo->prepare($query1);
    $stmt1->execute();
    
    $queryx = "SELECT * FROM objave where id=".$objava;
    $stmtx = $pdo->prepare($queryx);
    $stmtx->execute();
    $rowx = $stmtx->fetch();
  

   /* $query2 = "SELECT * FROM uporabniki where id=". $row1['id_uporabnik'];
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();*/
if (isset($_SESSION['id'])){
    

    $query = "SELECT * FROM uporabniki where id = ".$_SESSION['id'];
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($_SESSION['admin'] == "admin"){ ?>
    
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Objava</title>

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
            <a class="nav-link js-scroll-trigger" href="pravila.php">Pravila</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="admin.php">Admin</a>
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
      <th scope='col'>#</th>
      <th scope='col'>Naslov</th>
      <th scope='col'>Tema</th>
      <th scope='col'>Podtema</th>
      <th scope='col'>&nbsp;&nbsp;&nbsp;Objavljeno&nbsp;&nbsp;&nbsp;</th>
      <th scope='col'>Objavil</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      $number=1;
      while($row1 = $stmt1->fetch())
{
  
  $query2 = "SELECT * FROM podteme where id=".$row1['id_podteme'];
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();

    $query3 = "SELECT * FROM teme where id=".$row2['id_tema'];
    $stmt3 = $pdo->prepare($query3);
    $stmt3->execute();
    $row3 = $stmt3->fetch();

    $query4 = "SELECT * FROM uporabniki where id=". $row1['id_uporabnik'];
    $stmt4 = $pdo->prepare($query4);
    $stmt4->execute();
    $row4 = $stmt4->fetch();

      
      echo "
    <tr>
      <th scope='row'>".$number."</th>
      <td>".  $row1['naslov_objave'] . "</td>
      <td>". $row3  ['naslov_teme'] ."</td>
      <td>". $row2  ['naslov_podteme'] ."</td>
      <td>". date("d.m.Y", strtotime($row1['datum_objave'])) ."</td>
      <td>". $row4  ['email'] ."</td>
    </tr> 
    <tr>
    <td colspan='6'>". $row1 ['text']."</td>
    </tr>
    <tr>
    <td colspan='2'>".'<a class="btn btn-light js-scroll-trigger" href="objava_delete.php?obj='.$objava.'" onclick="return confirm(\'Ste prepričani, da hočete objavo izbrisati?\');")>Delete</a>'."</td>
    <td colspan='3'><a class='btn btn-light js-scroll-trigger' href='objava_edit.php?obj=".$objava."'>Edit</a></td>
    <td colspan='2'><a class='btn btn-light js-scroll-trigger' href='forum.php'>Nazaj</a></td>
    </tr>
    ";
  
$number++;
}
echo "
</tbody>
</table> ";

?>  
<h1>Comments</h1>
<?php
$query5 = "SELECT * FROM komentarji where id_objava=".$objava;
$stmt5 = $pdo->prepare($query5);
$stmt5->execute();
while($row5 = $stmt5->fetch())
//0 should be the current post's id
{
?>
<div class="comment">
By: <?php echo $row5->id_uporabnik; //Or similar in your table ?>
<p>
<?php echo $row5->komentar; ?>
</p>
</div>
<?php
}
?>
<?php
echo "<form action='komentar_insert.php?obj=".$objava."' method='post' enctype='multipart/form-data'> ";
?>
<!-- Here the shit they must fill out -->
<textarea class="form-control mb-4" placeholder="Dodaj komentar" required="required" name="text"></textarea>
<input type="file" name="files[]" multiple  id="img"  accept=".jpeg, .jpg, .png, .gif">
  <input type="submit" name="submit" value="Komentiraj" />
</form>
 
        
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
       <?php /* <a href="#" class="mx-2">
          <i class="fab fa-facebook-f"></i>
        </a> */ ?>
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

    <?php } 
    
    else if($rowx['id_uporabnik'] == $_SESSION['id']){
?>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Objava</title>

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
          <a class="nav-link js-scroll-trigger" href="pravila.php">Pravila</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="admin.php">Nastavitve</a>
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
      <th scope='col'>#</th>
      <th scope='col'>Naslov</th>
      <th scope='col'>Tema</th>
      <th scope='col'>Podtema</th>
      <th scope='col'>&nbsp;&nbsp;&nbsp;Objavljeno&nbsp;&nbsp;&nbsp;</th>
      <th scope='col'>Objavil</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      $number=1;
      while($row1 = $stmt1->fetch())
{
  
  $query2 = "SELECT * FROM podteme where id=".$row1['id_podteme'];
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();

    $query3 = "SELECT * FROM teme where id=".$row2['id_tema'];
    $stmt3 = $pdo->prepare($query3);
    $stmt3->execute();
    $row3 = $stmt3->fetch();

    $query4 = "SELECT * FROM uporabniki where id=". $row1['id_uporabnik'];
    $stmt4 = $pdo->prepare($query4);
    $stmt4->execute();
    $row4 = $stmt4->fetch();

      
      echo "
    <tr>
      <th scope='row'>".$number."</th>
      <td>".  $row1['naslov_objave'] . "</td>
      <td>". $row3  ['naslov_teme'] ."</td>
      <td>". $row2  ['naslov_podteme'] ."</td>
      <td>". date("d.m.Y", strtotime($row1['datum_objave']))."</td>
      <td>". $row4  ['email'] ."</td>
    </tr> 
    <tr>
    <td colspan='6'>". $row1 ['text']."</td>
    </tr>
    <tr>
    <td colspan='2'>".'<a class="btn btn-light js-scroll-trigger" href="objava_delete.php?obj='.$objava.'" onclick="return confirm(\'Ste prepričani, da hočete objavo izbrisati?\');")>Delete</a>'."</td>
    <td colspan='3'><a class='btn btn-light js-scroll-trigger' href='objava_edit.php?obj=".$objava."'>Edit</a></td>
    <td colspan='2'><a class='btn btn-light js-scroll-trigger' href='forum.php'>Nazaj</a></td>
    </tr>
    ";
  
$number++;
}
echo "
</tbody>
</table> ";
?>  
      
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
     <?php /* <a href="#" class="mx-2">
        <i class="fab fa-facebook-f"></i>
      </a> */ ?>
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
    <?php } 
    else { 
        ?>

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Objava</title>

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
          <a class="nav-link js-scroll-trigger" href="pravila.php">Pravila</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="nastavitve.php">Nastavitve</a>
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
      <th scope='col'>#</th>
      <th scope='col'>Naslov</th>
      <th scope='col'>Tema</th>
      <th scope='col'>Podtema</th>
      <th scope='col'>&nbsp;&nbsp;&nbsp;Objavljeno&nbsp;&nbsp;&nbsp;</th>
      <th scope='col'>Objavil</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      $number=1;
      while($row1 = $stmt1->fetch())
{
  
  $query2 = "SELECT * FROM podteme where id=".$row1['id_podteme'];
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();

    $query3 = "SELECT * FROM teme where id=".$row2['id_tema'];
    $stmt3 = $pdo->prepare($query3);
    $stmt3->execute();
    $row3 = $stmt3->fetch();

    $query4 = "SELECT * FROM uporabniki where id=". $row1['id_uporabnik'];
    $stmt4 = $pdo->prepare($query4);
    $stmt4->execute();
    $row4 = $stmt4->fetch();

      
      echo "
    <tr>
      <th scope='row'>".$number."</th>
      <td>".  $row1['naslov_objave'] . "</td>
      <td>". $row3  ['naslov_teme'] ."</td>
      <td>". $row2  ['naslov_podteme'] ."</td>
      <td>". date("d.m.Y", strtotime($row1['datum_objave']))."</td>
      <td>". $row4  ['email'] ."</td>
    </tr> 
    <tr>
    <td colspan='6'>". $row1 ['text']."</td>
    </tr>
    <tr>
    <td colspan='6'><a class='btn btn-light js-scroll-trigger' href='forum.php'>Nazaj</a></td>
    </tr>
    ";
  
$number++;
}
echo "
</tbody>
</table> ";
?>  
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
     <?php /* <a href="#" class="mx-2">
        <i class="fab fa-facebook-f"></i>
      </a> */ ?>
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

    <?php } }

else { ?>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Objava</title>

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
            <a class="nav-link js-scroll-trigger" href="pravila.php">Pravila</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="login.php">Prijava</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="register.php">Registracija</a>
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
      <th scope='col'>#</th>
      <th scope='col'>Naslov</th>
      <th scope='col'>Tema</th>
      <th scope='col'>Podtema</th>
      <th scope='col'>&nbsp;&nbsp;&nbsp;Objavljeno&nbsp;&nbsp;&nbsp;</th>
      <th scope='col'>Objavil</th>
    </tr>
  </thead>
  <tbody>
      <?php 
      $number=1;
      while($row1 = $stmt1->fetch())
{
  
  $query2 = "SELECT * FROM podteme where id=".$row1['id_podteme'];
    $stmt2 = $pdo->prepare($query2);
    $stmt2->execute();
    $row2 = $stmt2->fetch();

    $query3 = "SELECT * FROM teme where id=".$row2['id_tema'];
    $stmt3 = $pdo->prepare($query3);
    $stmt3->execute();
    $row3 = $stmt3->fetch();

    $query4 = "SELECT * FROM uporabniki where id=". $row1['id_uporabnik'];
    $stmt4 = $pdo->prepare($query4);
    $stmt4->execute();
    $row4 = $stmt4->fetch();

      
      echo "
    <tr>
      <th scope='row'>".$number."</th>
      <td>".  $row1['naslov_objave'] . "</td>
      <td>". $row3  ['naslov_teme'] ."</td>
      <td>". $row2  ['naslov_podteme'] ."</td>
      <td>". date("d.m.Y", strtotime($row1['datum_objave']))."</td>
      <td>". $row4  ['email'] ."</td>
    </tr> 
    <tr>
    <td colspan='6'>". $row1 ['text']."</td>
    </tr>
    <tr>
    <td colspan='6'><a class='btn btn-light js-scroll-trigger' href='forum.php'>Nazaj</a></td>
    </tr>
    ";
  
$number++;
}
echo "
</tbody>
</table> ";
?>  
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
       <?php /* <a href="#" class="mx-2">
          <i class="fab fa-facebook-f"></i>
        </a> */ ?>
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

<?php }
?>