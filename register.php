<?php
session_start();

if(isset($_SESSION['logged'])){
    header('location: /');
}

include('bd.php');

if(isset($_POST['handle_signup'])){
	$name = $_POST['name'];
	$birthdate = $_POST['birthdate'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
	$have_error = false;
	$error_text = '';
	//Verifier que tous lesz champs sont saisie

	if(!empty($name) && !empty($birthdate) && !empty($email) && !empty($password)){

		if($password == $confirm){

			//Insertion de  l'utilisateur

			$query = $connect->prepare('INSERT INTO users(name, birthdate, email, password) VALUES (?,?,?,?)');
			$query->execute(array($name, $birthdate, $email, sha1($password)));

			if($query){
				header('location: login.php');
			}else{
				$have_error= true;
				$error_text = 'Erreur lors de linscription';
			}

		}else{
			$have_error =true;
			$error_text = ' Password or Confirm password don\t match';
		}

	}else{
		$have_error = true;
		$error_text = 'All field are required ';
	}

}

?>
<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" type="text/css" href="slide navbar style.css">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
  <title>Creer un compte </title>
</head>
<body>
	<div class="main"> 
			<div class="signup">
				<form action="" method="post">
					<label for="chk" aria-hidden="true">Lorem, ipsum.</label>

					<?php
						if(isset($have_error)){?>
							<span style="color: #573b8a; font-size: 15px; display: flex; margin-left: 60px; font-weight: 400; "><?= $error_text ?></span>
						<?php }
					
					?>
					
                    <input type="text" name="name"  placeholder="User name" >
					<input type="text" name="birthdate"  placeholder="birthdate" >
					<input type="email" name="email"  placeholder="Email" >
					<input type="password" name="password"  placeholder="Password" >
					<input type="password" name="confirm"  placeholder="Confirm-Password" >
					<!-- <label>Je suis</label>
					<select id="monselect">
						<option value="user" selected>utilisateur</option>
						<option value="admin">Admin</option>
					</select> -->
					<button type="submit" name="handle_signup">Nous rejoindre</button>
					<p>Deja un compte? <a href="login.php">ici</a></a></p>
				</form>
			</div>
	</div>
</body>
</html>