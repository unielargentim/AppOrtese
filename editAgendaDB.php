<html>
<body>
 
 
<?php
//Open a new connection to the MySQL server
$conn = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


date_default_timezone_set('America/Sao_Paulo');


$names = $conn->query("select idPaciente, dataInicial, dataFinal, ts, td, tp, threshold, intensidade, repeticoes, tempoUtilizacao, frequencia, larguraPulso, maxInt from setup WHERE idSetup='" . $_GET["idSetup"] . "';");
							
while($rowNames = $names->fetch_assoc()) {
	if ($rowNames["dataInicial"] != $_POST['dataInicial']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Data Inicial','".$rowNames["dataInicial"]."','$_POST[dataInicial]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["dataFinal"] != $_POST['dataFinal']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Data Final','".$rowNames["dataFinal"]."','$_POST[dataFinal]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["ts"] != $_POST['ts']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Ts','".$rowNames["ts"]."','$_POST[ts]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["td"] != $_POST['td']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Td','".$rowNames["td"]."','$_POST[td]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["tp"] != $_POST['tp']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Tp','".$rowNames["tp"]."','$_POST[tp]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["threshold"] != $_POST['th']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Threshold','".$rowNames["threshold"]."','$_POST[th]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["intensidade"] != $_POST['intensidade']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Intensidade','".$rowNames["intensidade"]."','$_POST[intensidade]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["repeticoes"] != $_POST['rep']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Repetições','".$rowNames["repeticoes"]."','$_POST[rep]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["tempoUtilizacao"] != $_POST['tu']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Tempo de Utilizacao','".$rowNames["tempoUtilizacao"]."','$_POST[tu]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["frequencia"] != $_POST['freq']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Frequeência','".$rowNames["frequencia"]."','$_POST[freq]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	if ($rowNames["larguraPulso"] != $_POST['lp']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Largura de Pulso','".$rowNames["larguraPulso"]."','$_POST[lp]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	}	
	if ($rowNames["maxInt"] != $_POST['maxInt']){
		$sql="INSERT into alteracao_setup  (idSetup, idPaciente, parameter, oldValue, newValue, dataAlteracao) 
		VALUES ('". $_GET["idSetup"] . "','".$rowNames["idPaciente"]."','Intensidade Máxima','".$rowNames["maxInt"]."','$_POST[maxInt]','". date('Y-m-d H:i:s') ."');";
		$conn->query($sql);
	}
	

/*
if ($conn->query($sql) === TRUE) {
	echo 'alteração gravada';
} else {
	echo 'Error:' . $sql . '<br>' . $conn->error;
}
*/

$sql="UPDATE setup SET dataInicial='$_POST[dataInicial]', dataFinal='$_POST[dataFinal]', ts='$_POST[ts]', td='$_POST[td]', tp='$_POST[tp]', threshold='$_POST[th]', intensidade='$_POST[intensidade]', repeticoes='$_POST[rep]', tempoUtilizacao='$_POST[tu]', larguraPulso='$_POST[lp]', maxInt='$_POST[maxInt]' WHERE idSetup='" . $_GET['idSetup']."';";
 
if ($conn->query($sql) === TRUE) {
	echo '<script type="text/javascript">alert("Agenda alterada com sucesso!");</script>';
	echo "<script>setTimeout(\"location.href = 'setup.php?id=" . $_GET["id"] . "';\",500);</script>";
} else {
	echo '<script type="text/javascript">alert("Agenda não pode ser editada! Error: ". $sql . "<br>" . $conn->error .");</script>';
	echo 'script <script type="text/javascript">history.go(-1);">Back </script>';
    //echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


</body>
</html>