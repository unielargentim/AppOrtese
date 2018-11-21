<?php
	
	//ini_set('max_execution_time', 600); //600 seconds = 10 minutes
	
	ignore_user_abort(true);
	set_time_limit(0);
	
	ob_start();
	
	$counter = 0;
	
	$data = json_decode(file_get_contents('php://input'), true);
	
	$db = mysqli_connect('localhost', 'neurost2_root', 'c4rp3di3m', 'neurost2_neurostim');
	
	$userPassword = md5($data["oathData"]["password"]);
	
	$sql = "SELECT password FROM paciente WHERE idPaciente='" . $data["oathData"]["idPaciente"] .  "'";
	$query = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($query);
	$db_password = $row['password'];

	
	if($userPassword == $db_password){
		
		echo 'ok';
		header('Connection: close');
		header('Content-Length: '.ob_get_length());
		ob_end_flush();
		ob_flush();
		flush();
		
		foreach ($data['procedures'] as $procedure) {
				$sql = "INSERT INTO procedimento (idPaciente, idSetup, inicioExecucao, finalExecucao, linkEMG, repeticoesExecutadas, tempoEstimulando, tempoDescanso, modoUtilizacao, repeticoesRestantes, tempoRestante) VALUES ('" . $procedure['pacienteId'] .  "','" . $procedure['idSetup'] . "','". $procedure['startDate'] .  "','" . $procedure['endDate'] .  "','" . str_replace(".txt",".csv",$procedure['fileName']) . "','" . $procedure['repetitionsDone'] . "','" . ($procedure['stimulationTime']/60000) . "','" . ($procedure['restTime']/60000) . "','" . $procedure['type'] . "','" . $procedure['remainingRepetitions'] . "','" . ($procedure['remainingTime']/60000) ."');";
				$query = mysqli_query($db, $sql);
				$last_id = $db->insert_id;
				echo $last_id .'\n';
				
			foreach ($procedure['events']['sensibilityEventList'] as $eventList) {	
				$sql = "INSERT INTO alteracao_setup_app (idPaciente, idSetup, parameter, oldValue, newValue, dataAlteracao, procedureId) VALUES ('" . $procedure['pacienteId'] .  "','" . $procedure['idSetup'] .  "','Threshold','" . $eventList['oldValue'] .  "','" . $eventList['value'] .  "','" . $eventList['timeStamp'] .  "','". $last_id . "');";
				$query = mysqli_query($db, $sql);
				$counter++;
			}
			foreach ($procedure['events']['intensityEventList'] as $eventList) {	
				$sql = "INSERT INTO alteracao_setup_app (idPaciente, idSetup, parameter, oldValue, newValue, dataAlteracao, procedureId) VALUES ('" . $procedure['pacienteId'] .  "','" . $procedure['idSetup'] .  "','Intensidade','" . $eventList['oldValue'] .  "','" . $eventList['value'] .  "','" . $eventList['timeStamp'] .  "','". $last_id . "');";
				$query = mysqli_query($db, $sql);
				$counter++;
			}
			file_put_contents("../emgFiles/".str_replace(".txt",".csv",$procedure['fileName']), "date,value,stimulating,threshold,intensity" . PHP_EOL , FILE_APPEND );
			foreach ($procedure['events']['emgEvents'] as $eventList) {	
				file_put_contents("../emgFiles/".str_replace(".txt",".csv",$procedure['fileName']), $eventList['timeStamp'] .",".$eventList['value'].",".$eventList['stimulating'].",".$eventList['threshold'].",".$eventList['intensity']. PHP_EOL , FILE_APPEND );
			}
			$counter++;
		}
		 
		file_put_contents( "sync.log", "[".date( 'Y-m-d H:i:s' )."] Finalizou de escrever no banco " .$counter. " registros". PHP_EOL , FILE_APPEND );
	
		
	}
	else{
		echo 'invalid';
		file_put_contents( "sync.log", "[".date( 'Y-m-d H:i:s' )."] Falha de autenticação usuário ". $data["oathData"]["idPaciente"] . PHP_EOL , FILE_APPEND );
	}
	

/*
if ($query === TRUE) {
	echo 'alteração gravada';
} else {
	echo 'Error:' . $sql . '<br>' . $db->error;
}
*/
	
?>