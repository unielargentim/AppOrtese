<?php

	// Start up your PHP Session 
	session_start();

	// If the user is not logged in send him/her to the login form
	if ($_SESSION["login"] != "YES") {
	  header("Location: login.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/addAgenda.js"></script>
<script src="js/dateValidation.js"></script>
<script src="js/exportTableUserSetup.js"></script>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Setup - Parâmetros de Utilização</title>

<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

</head>

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
				    <div id="box1" style="display: none">
                	<h3 id="adduser">Adicionar programação</h3>
                    <form id="form" action="addAgenda.php" method="post">
                      <fieldset id="personal">
                        <legend>Parâmetros de Utilização</legend>
                        <label for="idPaciente">Id Paciente: </label> 
                        <input name="idPaciente" id="idPaciente" type="text" tabindex="1" <?php echo' value="' . $_GET["id"] . '"' ?> readonly />
						<br />
						<label for="dataInicial">Data Inicial: </label> 
                        <input name="dataInicial" id="dataInicial" type="date" tabindex="1" required />
						<br />
						<label for="dataFinal">Data Final: </label> 
                        <input name="dataFinal" id="dataFinal" type="date" tabindex="1" required />
						<br />
                        <label for="ts">Tempo de subida: </label>
                        <input name="ts" id="ts" type="number" min="1" max="5" step="0.5" tabindex="2" required /> (s)
                        <br />
                        <label for="td">Tempo de desc.: </label>
                        <input name="td" id="td" type="number" min="1" max="5" step="0.5" tabindex="2" required /> (s)
                        <br />
                        <label for="tp">Tempo de platô: </label>
                        <input name="tp" id="tp" type="number" min="1" max="5" step="0.5" tabindex="2" required /> (s)
                        <br />
						<label for="th	">Threshold: </label>
                        <input name="th" id="th" type="number" min="1" max="100" tabindex="2" required /> (mV)
                        <br />
						<label for="intensidade">Intensidade: </label>
                        <input name="intensidade" id="intensidade" type="number" min="1" max="10" tabindex="2" required /> (mA)
                        <br />
						<label for="freq">Frequência de Estimulação: </label>
                        <input name="freq" id="freq" type="number" value="30" min="1" max="60" tabindex="2" readonly /> (Hz)
                        <br />
						<label for="lp">Largura de Pulso: </label>
						<select for="lp" name="lp" required>
							<option hidden disabled selected value></option>
							<option value="300">300</option>
							<option value="600">600</option>
                        </select> (µs)
						<br /><br />
						<label for="rep">Repetições: </label>
                        <input name="rep" id="rep" type="number" min="1" max="99" tabindex="2" required />
                        <br />
						<label for="tu">Tempo de util.: </label>
                        <input name="tu" id="tu" type="number" min="1" max="60" tabindex="2" required /> (min)
                        <br />
						<label for="maxInt">Valor Máximo Intensidade: </label>
                        <input name="maxInt" id="maxInt" type="number" min="0" max="40" tabindex="2" required /> (mA)
                        <br />
                      </fieldset>

                      <div align="center">
                      <input id="button1" type="submit" value="Adicionar" /> 
                      <input id="button2" type="reset" value="Limpar" />
                      </div>
                    </form>

                </div>
				</br>
                
				
				<div id="box">
                	<h3>Programação de uso</h3>
                	<table width="100%" id="agendaParametros">
						<thead>
							<tr>
                            	<th width="65px"><a href="#">Data Inicial</a></th>
								<th width="65px"><a href="#">Data Final</a></th>
                                <th width="30px"><a href="#" title="Tempo de subida">Ts (s)</a></th>
                                <th width="30px"><a href="#" title="Tempo de descida">Td (s)</a></th>
                                <th width="30px"><a href="#" title="Tempo de platô">Tp (s)</a></th>
                                <th width="30px"><a href="#" title="Intensidade">Threshold (mV)</a></th>
								<th width="30px"><a href="#">Int. (mA)</a></th>
								<th width="30px"><a href="#" title="Frequência de estimulação">Freq. (Hz)</a></th>
								<th width="60px"><a href="#">Largura Pulso (µs)</a></th>
								<th width="30px"><a href="#">Repetições</a></th>
								<th width="60px"><a href="#" title="Tempo de Utilização">Tempo de util. (min)</a></th>
								<th width="30px"><a href="#" title="Intensidade máxima permitida">Int. Máxima</a></th>
								<th width="40px"><a href="#">Ação</a></th>
                                
                            </tr>
						</thead>
						<tbody>
							<?php
							//Open a new connection to the MySQL server
							$mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
							
							$names = $mysqli->query("select dataInicial, dataFinal, ts, td, tp, threshold, intensidade, frequencia,larguraPulso, repeticoes, tempoUtilizacao, maxInt, idSetup FROM setup WHERE idPaciente=" .  $_GET["id"] . " ORDER BY dataInicial DESC;");
							
							while($rowNames = $names->fetch_assoc()) {
								echo '<tr>';
								echo '<td class="a-center">'. date('d-m-Y', strtotime($rowNames["dataInicial"])) . '</td>';
								echo '<td class="a-center">'. date('d-m-Y', strtotime($rowNames["dataFinal"])) . '</td>';
								echo '<td class="a-center">'. $rowNames["ts"] . '</td>';
								echo '<td class="a-center">'. $rowNames["td"] . '</td>';
								echo '<td class="a-center">'. $rowNames["tp"] . '</td>';
								echo '<td class="a-center">'. $rowNames["threshold"] . '</td>';
								echo '<td class="a-center">'. $rowNames["intensidade"] . '</td>';
								echo '<td class="a-center">'. $rowNames["frequencia"] . '</td>';
								echo '<td class="a-center">'. $rowNames["larguraPulso"] . '</td>';
								echo '<td class="a-center">'. $rowNames["repeticoes"] . '</td>';
								echo '<td class="a-center">'. $rowNames["tempoUtilizacao"] . '</td>';
								echo '<td class="a-center">'. $rowNames["maxInt"] . '</td>';
								echo '<td><a href="editAgenda.php?id=' .  $_GET["id"] . '&idSetup=' . $rowNames["idSetup"] .'"><img src="img/icons/page_white_edit.png" title="Editar agendamento" width="16" height="16" /></a>
								<a href="deleteAgenda.php?id=' . $_GET["id"] . '&idSetup=' . $rowNames["idSetup"] .'"><img src="img/icons/page_white_delete.png" title="Deletar agendamento" width="16" height="16" /></a>';
								echo '</tr>';
							}
							mysqli_close($mysqli);
						?>
						</tbody>
					</table>

                </div>
                <br />
  
            </div>
            <div id="sidebar">
  				<ul>
					<li><h3><a href="#" class="manage">Setup</a></h3>
          				<ul>
							<li><a href="#" id="addAgenda" class="add">Adicionar</a></li>
							<li><a id="exportar" href="#" class="invoices">Exportar</a></li>
                        </ul>
						<br />
					</li>
					<li><h3><a href="#" class="online">Navegação</a></h3>
          				<ul>
							<?php echo '<li><a href="userPage.php?id=' . $_GET["id"] .  '" class="back">Voltar</a></li>'; ?>
							<li><a href="logout.php" class="logout">Sair</a></li>
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
