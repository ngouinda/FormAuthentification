<?php
session_start();

if(isset($_SESSION['logged'])){
    header('location: index.php');
}
include('bd.php');

if(isset($_POST['handle_login'])){

	$email = $_POST['email'];
	$password = $_POST['password'];
	$have_error = false;
	$error_text = '';
	//Verifier que tous lesz champs sont saisie

    if(!empty($email) && !empty($password)){

        $query = $connect->prepare('SELECT * FROM users where email = ?');
        $query->execute(array($email));

        if($query->rowCount() >=1){
            
            foreach($query as $result){

                if($result['password'] == sha1( $password)){

                    $_SESSION['name'] = $result['name'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['logged'] = true;

                    header('location: index.php');


                }else{
                    $have_error=true;
                    $error_text = 'Password dont reconize';
                }

            }

        }else{
            $have_error=true;
            $error_text= 'Adresse mail non reconnu';
        }

    }else{
        $have_error=true;
        $error_text = 'All field are required';
    }

}

?>
<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style.css">
  <title>Authentification</title>
  <link rel="stylesheet" type="text/css" href="slide navbar style.css">
   <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
			<div class="signup">
				<form action="" method="post">
					<label for="chk" aria-hidden="true">Login</label>

					<?php
						if(isset($have_error)){?>
							<span style="color: #573b8a; font-size: 15px; display: flex; margin-left: 60px; font-weight: 400; "><?= $error_text ?></span>
						<?php }
					?>
					
					<input type="email" name="email"  placeholder="Email" >
					<input type="password" name="password"  placeholder="Password" >
                    <label>Je suis</label>
					<select id="monselect">
						<option value="user" selected>utilisateur</option>
						<option value="admin">Admin</option>
					</select>
				<button type="submit" name="handle_login">se connecter</button>
                <p>pas de compte cliquez <a href="register.php">ici</a></p>
				</form>
			</div>

	</div>
</body>
</html>
