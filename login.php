<?php

	session_start();
	if(isset($_POST['login'])){
		include_once("db.php");
		$username = strip_tags($_POST['username']);
		$password = strip_tags($_POST['password']);
		
		$username = stripslashes($username);
		$password = stripslashes($password);
		
		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);
		
		$password = md5($password);
		
		$sql = "SELECT * FROM fisioterapeuta WHERE username='$username' LIMIT 1";
		$query = mysqli_query($db, $sql);
		$row = mysqli_fetch_array($query);
		$id = $row['id'];
		$db_password = $row['password'];
		
		if($password == $db_password){
				$_SESSION['username'] = $username;
				$_SESSION['id'] = $id;
				$_SESSION['login'] = "YES";
				header("Location: index.php");
		}
		else{
			echo '<script type="text/javascript">alert("Usuário ou senha inválidos!");</script>';
		}
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/masks.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Users - Admin Template</title>

<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
			
<body>
	<div id="container">
    	<div id="header">
        	<h2>Neuro Stim Web App</h2>

        <div id="wrapper">
            <div id="content">
                
                <div id="box">
                	
                    <form id="form" action="login.php" method="post" enctype="multipart/form-data">
                      <fieldset id="personal">
                        <legend>Login</legend>
                        <input placeholder="Usuário" name="username" type="text" autofocus />
							<br />
							<input placeholder="Senha" name="password" type="password" />
							<br />
                      </fieldset>
                      <input id="button1" name="login" type="submit" value="Entrar"> 
                    </form>

                </div>
            </div>
      </div>
        <div id="content">
        <div id="credits">
   		Powered by <a href="http://facebook.com/lucas.argentim">Lucas Argentim</a>
        </div>
        <br />
        </div>
</div>
</body>
</html>
