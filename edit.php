<?php
	session_start();
	
	if(!isset($_SESSION['id'])){
		header("Location login.php");
	}
	
	include_once("db.php");
	
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
    <div id="topmenu">
            	<ul>
                	<li class="current"><a href="index.php">Pacientes</a></li>
              </ul>
          </div>
      </div>

        <div id="wrapper">
            <div id="content">
            <?php
				//Open a new connection to the MySQL server
				$mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
							
					$names = $mysqli->query("select nome, sobrenome, idade, email, cpf, rua, numero, complemento, cidade, estado, pais, cep, telefone, celular, idPaciente, idFisio, escalaRankin, diagnostico, modoFuncional, maxInt FROM paciente WHERE idFisio=" . $_SESSION["username"] . " and idPaciente =" . $_GET["id"] . ";");
							
					while($rowNames = $names->fetch_assoc()) {
					echo '<div id="box">';
                	echo '<h3 id="adduser">Editar Usuário</h3>';
                    echo '<form id="form" action="editPaciente.php?id=' . $_GET["id"] . '" method="post">';
                      echo '<fieldset id="personal">';
                        echo '<legend>Informações Pessoais</legend>';
                        echo '<label for="firstname">Nome: </label>';
                        echo '<input name="firstname" id="firstname" type="text" value="'.$rowNames["nome"].'"
							tabindex="1" required />';
                        echo '<br />';
						echo '<label for="lastname">Sobrenome: </label> ';
                        echo '<input name="lastname" id="lastname" type="text" value="'.$rowNames["sobrenome"].'" tabindex="2" required />';
                        echo '<br />';
						echo '<label for="age">Idade: </label> ';
                        echo '<input name="age" id="age" type="number" value="'.$rowNames["idade"].'" tabindex="2" required />';
                        echo '<br />';
                        echo '<label for="email">E-mail : </label>';
                        echo '<input name="email" id="email" type="email" tabindex="3" value="'.$rowNames["email"].'"/>';
                        echo '<br />';
						echo ' <label for="cpf">CPF : </label>';
						echo ' <input type="text" name="cpf" id="cpf" maxlength="14" OnKeyPress="formatar(\'###.###.###-##\', this)" tabindex="3" value="'.$rowNames["cpf"].'" required />';
                        echo '<br />';
                      echo '</fieldset>';
                      echo '<fieldset id="address">';
                        echo '<legend>Endereço</legend>';
                        echo '<label for="street">Rua: </label> ';
                        echo '<input name="street" id="street" type="text" 
							tabindex="4" value="'.$rowNames["rua"].'"	required />';
                        echo '<br />';
						echo '<label for="number">Número: </label> ';
                        echo '<input name="number" id="number" type="number" 
							tabindex="5" value="'.$rowNames["numero"].'"	required />';
						echo '<br />';
						echo '<label for="acompl">Complemento: </label> ';
                        echo '<input name="compl" id="compl" type="text" 
							tabindex="4" value="'.$rowNames["complemento"].'"	 />';
                        echo '<br />';
                        echo '<label for="city">Cidade: </label>';
                        echo '<input name="city" id="city" type="text" 
							tabindex="6" required value="'.$rowNames["cidade"].'"	/>';
                        echo '<br />';
                        echo '<label for="state">Estado: </label>';
                        echo '<input name="state" id="state" type="text" 
							tabindex="7" required value="'.$rowNames["estado"].'"	/>';
                        echo '<br />';
						echo '<label for="country">País: </label> ';
                        echo '<input name="country" id="country" type="text" 
							tabindex="8" required value="'.$rowNames["pais"].'"	/>';
                        echo '<br />';
                        echo '<label for="cep">CEP: </label>';
						echo '<input type="text" name="cep" id="cep" maxlength="9" OnKeyPress="formatar(\'#####-###\', this)" tabindex="9" required value="'.$rowNames["cep"].'"	/>';
                        echo '<br />';
                        echo '<label for="tel">Telefone : </label>';
                        echo '<input name="tel" id="tel" type="number" 
							tabindex="10" required value="'.$rowNames["telefone"].'"	/>';
						echo '<br />';
						echo '<label for="cel">Celular : </label>';
                        echo '<input name="cel" id="cel" type="number" 
							tabindex="11" value="'.$rowNames["celular"].'"	/>';
                      echo '</fieldset>';
                      echo '<fieldset id="opt">';
						echo '<legend>Informações Médicas</legend>';
						echo '<label for="idFisio">ID Fisioterapeuta: </label>';
                        echo '<input name="idFisio" id="idFisio" type="number" 
                        tabindex="12" required  value="'.$rowNames["idFisio"].'"	/>';
                        echo '<br />';
						echo '<label for="idPaciente">ID Paciente: </label>';
                        echo '<input name="idPaciente" id="idPaciente" type="number" 
                        tabindex="12" readonly value="'.$rowNames["idPaciente"].'"	/>';
                        echo '<br />';
						echo '<label for="escalaRankin">Escala Rankin: </label>';
                        echo '<input name="escalaRankin" id="escalaRankin" type="number" 
                        tabindex="12" min="1" max="5" required value="'.$rowNames["escalaRankin"].'"	/>';
                        echo '<br />';
						echo '<label for="diagnostico">Diagnóstico: </label>';
                        echo '<textarea name="diagnostico" id="diagnostico" rows="20" cols="100"
                        tabindex="12" required />'.$rowNames["diagnostico"].'</textarea>';
                        echo '<br /><br />';
						echo '<label for="modoFuncional">Permite modo Funcional?: </label>';
						echo '<select name="modoFuncional" id="modoFuncional" 
                        tabindex="12" required>';
						echo '	<option value=""></option>';
						echo '	<option value="Sim">Sim</option>';
						echo '	<option value="Não">Não</option>';
						echo '</select> (atual: '.$rowNames["modoFuncional"].')';
						echo '<br /><br />';
						echo '<label for="maxInt">Valor Máximo Intensidade: </label>';
                        echo '<input name="maxInt" id="maxInt" type="number" min="0" max="40" tabindex="12" value="'.$rowNames["maxInt"].'" required /> (mA)';
                      echo '</fieldset>';
					}
				mysqli_close($mysqli);
				?>
                
				
					  
                      <div align="center">
                      <input id="button1" type="submit" value="Salvar" tabindex="14" /> 
                      <input id="button2" type="reset" value="Reverter Alterações" tabindex="15" />
                      </div>
                    </form>

                </div>
            </div>
            <div id="sidebar">
  				<ul>
                  <li><h3><a href="#" class="online">Navegação</a></h3>
          				<ul>
							<?php echo'<li class="back"><a href="index.php">Voltar</a></li>'; ?>
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
