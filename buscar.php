<?php

	// Start up your PHP Session 
	session_start();

	// If the user is not logged in send him/her to the login form
	if ($_SESSION["login"] != "YES") {
	  header("Location: login.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<img src="img/logotwitter.jpg"  width="10%" height="10%">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/search.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Users - Admin Template</title>

<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />


</head>
			
<body>
	<div id="container">
    	<div id="header">
        	<h2>Neuro Stim Web App</h2>
    <div id="topmenu">
            	<ul>
                	<li class="current"><a href="index.php">Pacientes</a></li>
              </ul>
          </div>
      </div>

        <div id="wrapper">
            <div id="content">
			
			<div id="box">
                	<h3 id="adduser">Buscar Usuário</h3>
                    <form id="form" action="buscar.php" method="post">
                      <fieldset id="personal">
                        <legend>Critérios de Busca</legend>
                        <label for="firstname">ID Paciente: </label>
                        <input name="idPaciente" id="idPaciente" type="number" 
                        tabindex="1" />
                        <br />
						<label for="firstname">Nome: </label>
                        <input name="firstname" id="firstname" type="text"
                        tabindex="1" />
                        <br />
						<label for="lastname">Sobrenome: </label> 
                        <input name="lastname" id="lastname" type="text" tabindex="2" />
                        <br />
                      </fieldset>                    
                      <div align="center">
                      <input id="button1" type="submit" value="Buscar" /> 
                      <input id="button2" type="reset" value="Limpar" />
                      </div>
                    </form>

                </div>
			  <br />
			  
                <div id="box">
                	<h3>Lista de Pacientes</h3>
                	<table width="100%">
						<thead>
							<tr>
                            	<th width="40px"><a href="#">ID<img src="img/icons/arrow_down_mini.gif" width="16" height="16" align="absmiddle" /></a></th>
                            	<th><a href="#">Nome</a></th>
                                <th><a href="#">Sobrenome</a></th>
                                <th width="70px"><a href="#">E-mail</a></th>
                                <th width="90px"><a href="#">CPF</a></th>
                                <th width="60px"><a href="#">Ação</a></th>
                            </tr>
						</thead>
						<tbody>
						
						<?php
							//Open a new connection to the MySQL server
							$mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
							
							$names = $mysqli->query("select idPaciente, nome, sobrenome, email, cpf FROM paciente WHERE idFisio=" .  $_SESSION["username"] . " and idPaciente like '%" . $_POST["idPaciente"] . "%' and nome like '%" . $_POST["firstname"] . "%' and sobrenome like '%" . $_POST["lastname"] . "%';");
							
							while($rowNames = $names->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="a-center">'. $rowNames["idPaciente"] . '</td>';
								echo '<td class="a-center">'. $rowNames["nome"] . '</td>';
								echo '<td class="a-center">'. $rowNames["sobrenome"] . '</td>';
								echo '<td class="a-center">'. $rowNames["email"] . '</td>';
								echo '<td class="a-center">'. $rowNames["cpf"] . '</td>';
								echo '<td><a href="userPage.html"><img src="img/icons/user.png" title="Show profile" width="16" height="16" /></a><a href="#"><img src="img/icons/user_edit.png" title="Edit user" width="16" height="16" /></a><a href="#"><img src="img/icons/user_delete.png" title="Delete user" width="16" height="16" /></a></td>';
								echo '</tr>';
							}
							mysqli_close($mysqli);
						?>
						</tbody>
					</table>
					
                    <div id="pager">
                    	Página <a href="#"><img src="img/icons/arrow_left.gif" width="16" height="16" /></a> 
                    	<input size="1" value="1" type="text" name="page" id="page" /> 
                    	<a href="#"><img src="img/icons/arrow_right.gif" width="16" height="16" /></a>de 42
                    páginas | Visualizar <select name="view">
                    				<option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                    			</select> 
                    por página | Total <strong>420</strong> registros encontrados
                    </div>
					
				</div>
                <br />
				

            </div>
            <div id="sidebar">
  				<ul>
					<li><h3><a href="index.php" class="user">Pacientes</a></h3>
          				<ul>
                            <li><a href="add.html" class="useradd">Adicionar</a></li>
            				<li><a href="#" id="buscar" class="search">Buscar</a></li>
                            <li><a href="#" class="invoices">Exportar</a></li>
                        </ul>
					</li>
					<br />
					
					<li><h3><a href="#" class="online">Navegação</a></h3>
          				<ul>
                            <li><a href="logout.php" class="userdelete">Sair</a></li>
                        </ul>
                    
                    </li>
				</ul>       
          </div>
      </div>
        <div id="footer">
        <div id="credits">
   		Powered by <a href="http://facebook.com/lucas.argentim">Lucas Argentim</a>
        </div>
        <br />
        </div>
</div>
</body>
</html>
