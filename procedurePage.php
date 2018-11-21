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
	  <script src="https://d3js.org/d3.v4.min.js"></script>
      <script src="js/exportTableProcedure.js"></script>
	  <script src="js/emgGraph.js"></script>
	  

      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Dashboard - Admin Template</title>
      <link rel="stylesheet" type="text/css" href="css/theme1.css" />
      <link rel="stylesheet" type="text/css" href="css/style.css" />
      <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
	  <link rel="stylesheet" type="text/css" href="css/emgGraphCSS.css">
   </head>
   <body>
      <div id="container">
      <div id="header">
         <h2>Neuro Stim Web App</h2>
         <div id="topmenu">
            <ul>
               <li><a href="index.php">Pacientes</a></li>
               <?php echo'<li class="current"><a href="UserPage.php?id=' . $_GET["id"] . '">Dashboard</a></li>'; ?>
               <?php echo'<li><a href="setup.php?id=' . $_GET["id"] . '">Setup</a></li>'; ?>
            </ul>
         </div>
         <div id="wrapper">
            <div id="content" class="print">
               <div id="rightnow">
                  <h3 class="reallynow">
                  <?php	
                     //Open a new connection to the MySQL server
                     $mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
                     $names = $mysqli->query("select inicioExecucao, finalExecucao, repeticoesExecutadas, tempoEstimulando, tempoDescanso, tempoRestante, repeticoesRestantes, modoUtilizacao FROM procedimento WHERE procedureId='" . $_GET["idProcedimento"] ."';");
                     	
					while($rowNames = $names->fetch_assoc()) {
						echo '<span>Relatório de procedimento</span>';
						echo '<br />';
						echo '</h3>';
						echo '<p class="youhave">';
						echo '<a>ID Procedimento: </a> ' . $_GET["idProcedimento"] . '<br />';
						echo '<a>Modo de utilização: </a> ' .ucwords(strtolower($rowNames["modoUtilizacao"])). '<br />';	
						echo '<a>Data de início: </a> ' . date('d-m-Y', strtotime($rowNames["inicioExecucao"])) . '<br />';
						echo '<a>Data de término: </a> ' . date('d-m-Y', strtotime($rowNames["finalExecucao"])) . '<br />';
						echo '<a>Horário de início: </a> ' . date('H:i:s', strtotime($rowNames["inicioExecucao"])) . '<br />';
						echo '<a>Horário de término: </a> ' . date('H:i:s', strtotime($rowNames["finalExecucao"])) . '<br />';
						echo '<a>Duração da sessão: </a> ' . date('i:s',strtotime($rowNames["finalExecucao"])-strtotime($rowNames["inicioExecucao"])) . '<br />';
						echo '<a>Repetições executadas: </a> ' . $rowNames["repeticoesExecutadas"] . '<br />';
						echo '<a>Repetições restantes: </a> ' . $rowNames["repeticoesRestantes"] . '<br />';
						echo '<a>Tempo estimulando: </a> ' .floor($rowNames["tempoEstimulando"]). ' (min) '.ceil((($rowNames["tempoEstimulando"] - floor($rowNames["tempoEstimulando"]))*60)).' (seg) <br />';
						echo '<a>Tempo descanso: </a> ' .floor($rowNames["tempoDescanso"]). ' (min) '.ceil((($rowNames["tempoDescanso"] - floor($rowNames["tempoDescanso"]))*60)).' (seg) <br />';
						if($rowNames["tempoRestante"] >=0 && $rowNames["modoUtilizacao"] != "FUNCIONAL"){
							echo '<a>Tempo restante: </a> ' .floor($rowNames["tempoRestante"]). ' (min) '.ceil((($rowNames["tempoRestante"] - floor($rowNames["tempoRestante"]))*60)).' (seg) <br />';
						} elseif($rowNames["tempoRestante"] < 0 && $rowNames["modoUtilizacao"] != "FUNCIONAL"){
							echo '<a>Tempo adicional: </a> ' .floor(-1*$rowNames["tempoRestante"]). ' (min) '.ceil(((-1*$rowNames["tempoRestante"] - (-1)*floor($rowNames["tempoRestante"]))*60)).' (seg) <br />';
						}
						if($rowNames["modoUtilizacao"] == "FUNCIONAL"){
						}elseif ($rowNames["repeticoesRestantes"] == 0 && $rowNames["tempoRestante"] >= 0){
							echo '<a>Status: Concluído com sucesso </a><br />';
						} elseif ($rowNames["repeticoesRestantes"] == 0 && $rowNames["tempoRestante"] < 0){
							echo '<a>Status: Concluído fora do tempo especificado </a><br />';
						} else {
							echo '<a>Status: Não concluído </a><br />';
						}
					echo '</p>';
						
                    }
					
                    mysqli_close($mysqli);
                    ?>
					
               </div>
			   <br />
			   
			   <div id="rightnow">
					<h3 class="reallynow">
						<span>Dados EMG</span>
						<br />
					</h3>
					<script>
						var fileName = "<?php echo $_GET["file"]; ?>";
					</script>
					<svg width="740" height="550"></svg>
				  <br />
				</div>
			   
                  <div id="infobox">
                     <div id="rightnow">
                        <h3 class="reallynow">
                           <span>Alterações de parâmetros (Usuário)</span>
                           <a id="expTabAltParUsu" href="#" class="export">Exportar</a>
                           <br />
                        </h3>
                        <table width="100%" id="tabAltParUsu" >
                           <thead>
                              <tr>
                                 <th width="20px">Data</th>
                                 <th width="20px">Parâmetro</th>
                                 <th width="20px">Valor Original</th>
                                 <th width="20px">Valor Alterado</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 //Open a new connection to the MySQL server
                                 $mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
                                 
                                 $names = $mysqli->query("select dataAlteracao, parameter, oldValue, newValue from alteracao_setup_app WHERE procedureId=" . $_GET["idProcedimento"] . " ORDER BY procedureId DESC;");
                                 
                                 while($rowNames = $names->fetch_assoc()) {
                                 	echo '<tr>';
                                 	echo '<td class="a-center">'. date('d-m-Y h:m:s', strtotime($rowNames["dataAlteracao"])) . '</td>';
                                 	echo '<td class="a-center">'. $rowNames["parameter"] . '</td>';
                                 	echo '<td class="a-center">'. $rowNames["oldValue"] . '</td>';
                                 	echo '<td class="a-center">'. $rowNames["newValue"] . '</td>';
                                 	echo '</tr>';
                                 }
                                 mysqli_close($mysqli);
                                 ?>
                           </tbody>
                        </table>
                        <label><b>Clique em exportar para visualizar lista completa</b></label>
                     </div>
                  </div>
                  <div id="infobox" class="margin-left">
                     <div id="rightnow">
                        <h3 class="reallynow">
                           <span>Alterações de parâmetros (Terapeuta)</span>
                           <a id="expTabAltParFis" href="#" class="export">Exportar</a>
                           <br />
                        </h3>
                        <table id="tabAltParFis">
                           <thead>
                              <tr>
                                 <th width="20px">Data</th>
                                 <th width="20px">Parâmetro</th>
                                 <th width="20px">Valor Original</th>
                                 <th width="20px">Valor Alterado</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 //Open a new connection to the MySQL server
                                 $mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
                                 
                                 $names = $mysqli->query("select dataAlteracao, parameter, oldValue, newValue from alteracao_setup WHERE idSetup=" . $_GET["idSetup"] . " ORDER BY dataAlteracao ASC LIMIT 5;");
                                 
                                 while($rowNames = $names->fetch_assoc()) {
                                 	echo '<tr>';
                                 	echo '<td class="a-center">'. date('d-m-Y h:m:s', strtotime($rowNames["dataAlteracao"])) . '</td>';
                                 	echo '<td class="a-center">'. $rowNames["parameter"] . '</td>';
                                 	echo '<td class="a-center">'. $rowNames["oldValue"] . '</td>';
                                 	echo '<td class="a-center">'. $rowNames["newValue"] . '</td>';
                                 	echo '</tr>';
                                 }
                                 mysqli_close($mysqli);
                                 ?>
                           </tbody>
                        </table>
                        <label><b>Clique em exportar para visualizar lista completa</b></label>
                     </div>
                  </div>
               </div>
			</div>
			
			
			
            <div id="sidebar">
               <ul>
                  <li>
                     <h3><a href="#" class="house">Dashboard</a></h3>
                     <ul>
                        <li><a onclick="window.print();return false;" href="#" class="printPage">Imprimir</a></li>
                     </ul>
                  </li>
                  <br>
                  <li>
                     <h3><a href="#" class="online">Navegação</a></h3>
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