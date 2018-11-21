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
<script src="js/dateValidation.js"></script>
<script src="js/confirmDeletion.js"></script>

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
                	<li><a href="index.php">Pacientes</a></li>
                    <?php echo'<li><a href="userPage.php?id=' . $_GET["id"] . '">Dashboard</a></li>'; ?>
                	<?php echo'<li class="current"><a href="setup.php?id=' . $_GET["id"] . '">Setup</a></li>'; ?>
              </ul>
          </div>
      </div>

        <div id="wrapper">
            <div id="content">
            <?php
				//Open a new connection to the MySQL server
				$mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
							
					$names = $mysqli->query("select dataInicial, dataFinal, ts, td, tp, threshold, intensidade, frequencia, larguraPulso, repeticoes, tempoUtilizacao, maxInt FROM setup WHERE idSetup=" .  $_GET["idSetup"] . ";");
							
					while($rowNames = $names->fetch_assoc()) {
					echo '<div id="box">';
                	echo '<h3 id="adduser">Editar Usuário</h3>';
                    echo '<form id="form" action="editAgendaDB.php?idSetup=' . $_GET["idSetup"] . '&id=' . $_GET["id"] . '" method="post">';
                      echo '<fieldset id="personal">';
                        echo '<legend>Informações de Agenda</legend>';
                        echo '<label for="dataInicial">Data Inicial: </label> ';
                        echo '<input name="dataInicial" id="dataInicial" type="date"  value="'.$rowNames["dataInicial"].'" tabindex="1" />';
						echo '<br />';
						echo '<label for="dataFinal">Data Final: </label> ';
                        echo '<input name="dataFinal" id="dataFinal" type="date" value="'.$rowNames["dataFinal"].'" tabindex="1" />';
						echo '<br />';
                        echo '<label for="ts">Tempo de subida: </label>';
                        echo '<input name="ts" id="ts" type="number" min="1" max="5" step="0.5" value="'.$rowNames["ts"].'" tabindex="2" required /> (s)';
                        echo '<br />';
                        echo '<label for="td">Tempo de desc.: </label>';
                        echo '<input name="td" id="td" type="number" min="1" max="5" step="0.5" value="'.$rowNames["td"].'" tabindex="2" required /> (s)';
                        echo '<br />';
                        echo '<label for="tp">Tempo de platô: </label>';
                        echo '<input name="tp" id="tp" type="number" min="1" max="5" step="0.5" value="'.$rowNames["tp"].'" tabindex="2" required /> (s)';
                        echo '<br />';
						echo '<label for="th	">Threshold: </label>';
                        echo '<input name="th" id="th" type="number" min="1" max="100" value="'.$rowNames["threshold"].'" tabindex="2" required /> (mV)';
                        echo '<br />';
						echo '<label for="intensidade">Intensidade: </label>';
                        echo '<input name="intensidade" id="intensidade" type="number" min="1" max="10" value="'.$rowNames["intensidade"].'" tabindex="2" required /> (mA)';
                        echo '<br />';
						echo '<label for="freq">Frequência: </label>';
                        echo '<input name="freq" id="freq" type="number" min="1" max="20" value="'.$rowNames["frequencia"].'" tabindex="2" required /> (Hz)';
                        echo '<br />';
						echo '<label for="lp">Largura de Pulso: </label>';
                        echo '<select for="lp" name="lp" required />';
						echo '<option hidden disabled selected value></option>';
						echo'<option value="300">300</option>';
						echo'<option value="600">600</option>';
                        echo '</select> (Valor atual: ' .$rowNames["larguraPulso"] . ' ms)';
						echo '<br /><br />';
						echo '<label for="rep">Repetições: </label>';
                        echo '<input name="rep" id="rep" type="number" min="1" max="99" value="'.$rowNames["repeticoes"].'" tabindex="2" required />';
                        echo '<br />';
						echo '<label for="tu">Tempo de util.: </label>';
                        echo '<input name="tu" id="tu" type="number" min="1" max="60" value="'.$rowNames["tempoUtilizacao"].'" tabindex="2" required /> (min)';
                        echo '<br />';
						echo '<label for="maxInt">Valor Máximo Intensidade: </label>';
                        echo '<input name="maxInt" id="maxInt" type="number" min="1" max="10" value="'.$rowNames["maxInt"].'" tabindex="2" required /> (mA)';
                        echo '<br />';
                      echo '</fieldset>';
                      
					}
				mysqli_close($mysqli);
				?>
                
				
					  
                      <div align="center">
                      <input id="button1" type="submit" value="Salvar" tabindex="14" /> 
                      <input id="button2" type="reset" value="Limpar" tabindex="15" />
                      </div>
                    </form>

                </div>
            </div>
            <div id="sidebar">
  				<ul>
                  <li><h3><a href="#" class="online">Navegação</a></h3>
          				<ul>
							<?php echo'<li class="back"><a href="setup.php?id=' . $_GET["id"] . '">Voltar</a></li>'; ?>
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
