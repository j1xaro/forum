<?php
session_start();
require_once './database.php';
require_once('Facebook/autoload.php');

$FBObject = new \Facebook\Facebook([
	'app_id' => '1028209790858963',
	'app_secret' => '8a3d0dcafbdfd832e55164bcf24e79b8',
	'default_graph_version' => 'v4.0'
]);

$handler = $FBObject -> getRedirectLoginHelper();


try {
    $accessToken = $handler->getAccessToken();
}catch(\Facebook\Exceptions\FacebookResponseException $e){
    echo "Response Exception: " . $e->getMessage();
    exit();
}catch(\Facebook\Exceptions\FacebookSDKException $e){
    echo "SDK Exception: " . $e->getMessage();
    exit();
}

if(!$accessToken){
    header('Location: login.php');
    exit();
}

$oAuth2Client = $FBObject->getOAuth2Client();
if(!$accessToken->isLongLived())
    $accessToken = $oAuth2Client->getLongLivedAccesToken($accessToken);

    $response = $FBObject->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
    $userData = $response->getGraphNode()->asArray();
    $_SESSION['userData'] = $userData;
    $_SESSION['access_token'] = (string) $accessToken;
    $_SESSION['fb']= "facebook";

    if (isset($_SESSION['fb']))
 {
	// echo "fb";
	 $a = 0;
	 $results= $_SESSION['userData'];
	 foreach ($results as $result) 
	 {
		if($a==1)
		{
			$ime = $result;
			echo $ime;
		}
		else if ($a==2)
		{
			$priimek= $result;
		}
		else if ($a==3)
		{
			$email = $result;
		}
	$a++;
			
	
	}
	
	 session_destroy();
	 session_start();
/*	echo "Name ".$name." ";
	echo "<br>";
	echo "Surname ".$surname." ";
	echo "<br>";
	echo "Email ".$email." ";
	echo "<br>";*/

		$tip = 1;
		$geslo = "facebook";
		
		
		$query = " SELECT email FROM uporabniki WHERE email=?";
		$stmt = $pdo->prepare($query);
		$stmt->execute([$email]);
			
			
		
			if($stmt->rowCount()==0)
			{
					echo "tobe";
			
					/* $sql = "INSERT INTO uporabniki (ime,priimek,email,geslo,uporabnisko_ime,tip)
						VALUES (NULL,'$ime', '$priimek', '$email', '$geslo', '$username', '$tip')";*/
						
						$query = "INSERT INTO uporabniki (ime, priimek, naslov, email, pass, vrsta_uporabnika) "
						. "VALUES (?,?,?,?,?,?)";
						$stmt = $pdo->prepare($query);
						$stmt->execute([$ime, $priimek, "facebook", $email, $geslo, ""]);
						//$sql= sprintf("INSERT INTO uporabniki (ime,priimek,naslov,email,pass, vrsta_uporabnika)
									//VALUES ( '%s', '%s', '%s', '%s', '%s', '%s');", $ime, $priimek, "c", $email, $geslo, "admin");
									if($row = $stmt->fetch())
					{
						//header("Location:index.php");
						echo "Registracija uspela";
						
					}
					
					else 
						{
						
						echo "Registracija ni uspešna";
					}
				
		
		}
		
			/*$sql= sprintf("SELECT id,ime,priimek,vrsta_uporabnika,email,pass FROM uporabniki WHERE email='%s';", $email);
		
				$result= mysqli_query($link, $sql);
		
		
			$row = mysqli_fetch_array($result);*/
			
		$query = " SELECT * FROM uporabniki WHERE email=?";
		$stmt = $pdo->prepare($query);
		$stmt->execute([$email]);
		$row = $stmt->fetch();
			$geslo2 = $row['pass'];
			$_SESSION['id']=$row['id'];        
            $_SESSION['admin'] = $row['vrsta_uporabnika'];
			$geslo2 == 'facebook';
			if($geslo2 == 'facebook')
			{
				
				header("Location:index.php");
				
			}
			else{
				  
			}
        
        
    header('Location:index.php');
	exit();
 }
?>