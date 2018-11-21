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
      <script src="js/exportTableUser.js"></script>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Dashboard - Admin Template</title>
      <link rel="stylesheet" type="text/css" href="css/theme1.css" />
      <link rel="stylesheet" type="text/css" href="css/style.css" />
      <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
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
                     	
                     $names = $mysqli->query("select nome, sobrenome, idPaciente, idade, cpf, email, rua, numero, cep, cidade, estado, pais, telefone, celular, escalaRankin, diagnostico FROM paciente WHERE idFisio=" . $_SESSION["username"] . " and idPaciente =" . $_GET["id"] . ";");
                     	
                     while($rowNames = $names->fetch_assoc()) {
                     	echo '<span>' . $rowNames["nome"] . ' ' .  $rowNames["sobrenome"] .'</span>';
                     	echo '<br />';
                     	echo '</h3>';
                     	echo '<p class="youhave">';
                     	echo '<a>ID Paciente:</a> ' . $rowNames["idPaciente"] . '<br />';
                     	echo '<a>Idade:</a> ' . $rowNames["idade"] . '<br />';
                     	echo '<a>CPF:</a>' . $rowNames["cpf"] . '<br />';
                     	echo '<a>E-mail:</a> ' . $rowNames["email"] . '<br />';
                     	echo '<a>Rua:</a> ' . $rowNames["rua"] . '<br />';
                     	echo '<a>Numero:</a> ' . $rowNames["numero"] . '<br />';
                     	echo '<a>CEP:</a> ' . $rowNames["cep"] . '<br />';
                     	echo '<a>Cidade:</a> ' . $rowNames["cidade"] . '<br />';
                     	echo '<a>Estado:</a> ' . $rowNames["estado"] . '<br />';
                     	echo '<a>País:</a> ' . $rowNames["pais"] . '<br />';
                     	echo '<a>Telefone:</a> ' . $rowNames["telefone"] . '<br />';
                     	echo '<a>Celular:</a> ' . $rowNames["celular"] . '<br />';
                     	echo '<a>Escala Rankin:</a> ' . $rowNames["escalaRankin"] . '<br />';
                     	echo '<a>Diagnóstico:</a><br /> <label style="white-space: pre-wrap">' . $rowNames["diagnostico"] . '<br />';
                     	echo '</p>';
                     }
                     mysqli_close($mysqli);
                     ?>
               </div>
			   <br />
			   
			   <div id="rightnow">
					<h3 class="reallynow">
						<span>Procedimentos</span>
						<br />
					</h3>
					<table width="100%" id="tabEmg" >
                           <thead>
                              <tr>
                                 <th width="20px">ID Procedimento</th>
                                 <th width="20px">Início execução</th>
								 <th width="20px">Final execução</th>
								 <th width="20px">Modo</th>
                                 <th width="20px">Link</th>
								 <th width="20px">Ação</th>
                              </tr>
                           </thead>
                           <tbody>
								<?php
                                 //Open a new connection to the MySQL server
                                 $mysqli = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
                                 
                                 $names = $mysqli->query("select procedureId, idPaciente, inicioExecucao, finalExecucao, modoUtilizacao, linkEMG, idSetup from procedimento WHERE idPaciente=" . $_GET["id"] . " ORDER BY inicioExecucao ASC;");
                                 
                                 while($rowNames = $names->fetch_assoc()) {
                                 	echo '<tr>';
                                 	echo '<td class="a-center">'.$rowNames["procedureId"].'</td>';
									echo '<td class="a-center">'. date('d-m-Y H:i:s', strtotime($rowNames["inicioExecucao"])) . '</td>';
									echo '<td class="a-center">'. date('d-m-Y H:i:s', strtotime($rowNames["finalExecucao"])) . '</td>';
									echo '<td class="a-center">'.ucwords(strtolower($rowNames["modoUtilizacao"])). '</td>';
									echo '<td class="a-center"><a href="http://neurostim.x10.bz/NeuroStimWebApp/emgFiles/'.$rowNames["linkEMG"].'"  download>'.$rowNames["linkEMG"].'</td>';
									echo '<td class="a-center"><a href="procedurePage.php?id=' . $rowNames["idPaciente"] .'&idProcedimento='.$rowNames["procedureId"].'&idSetup='.$rowNames["idSetup"].'&file='.$rowNames["linkEMG"].'"><img src="img/icons/report.png" title="Mostrar resultados do procedimento" width="16" height="16" /></a></td>';
									echo '</tr>';
									}
                                 mysqli_close($mysqli);
                                 ?>
						   </tbody>
					</table>
				  <br />
				</div>
			   
               <div id="infowrap">
                  <div id="infobox">
                     <label title="Clique com botão direito sobre a imagem para exportar">
                        <h3>Contagem de estimulações</h3>
                     </label>
                     <p><?php //include "example.php"; ?></p>
                  </div>
                  <div id="infobox" class="margin-left">
                     <label title="Clique com botão direito sobre a imagem para exportar">
                        <h3>Tempo de utilização</h3>
                     </label>
                     <p><?php //include "example.php"; ?></p>
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
                                 
                                 $names = $mysqli->query("select dataAlteracao, parameter, oldValue, newValue from alteracao_setup_app WHERE idPaciente=" . $_GET["id"] . " ORDER BY idAlteracaoApp ASC LIMIT 5;");
                                 
                                 while($rowNames = $names->fetch_assoc()) {
                                 	echo '<tr>';
                                 	echo '<td class="a-center">'. date('d-m-Y H:i:s', strtotime($rowNames["dataAlteracao"])) . '</td>';
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
                                 
                                 $names = $mysqli->query("select dataAlteracao, parameter, oldValue, newValue from alteracao_setup WHERE idPaciente=" . $_GET["id"] . " ORDER BY idAlteracao ASC LIMIT 5;");
                                 
                                 while($rowNames = $names->fetch_assoc()) {
                                 	echo '<tr>';
                                 	echo '<td class="a-center">'. date('d-m-Y H:i:s', strtotime($rowNames["dataAlteracao"])) . '</td>';
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
                        <?php echo '<li><a href="edit.php?id=' . $_GET["id"] .  '" class="user_edit">Editar</a></li>'; ?>
                        <li><a onclick="window.print();return false;" href="#" class="printPage">Imprimir</a></li>
                     </ul>
                  </li>
                  <br>
                  <li>
                     <h3><a href="#" class="online">Navegação</a></h3>
                     <ul>
						<?php echo '<li><a href="index.php" class="back">Voltar</a></li>'; ?>
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