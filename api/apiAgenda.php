<?php
	
	$data = json_decode(file_get_contents('php://input'), true);
		
	$db = mysqli_connect('localhost', 'neurost2_root', 'c4rp3di3m', 'neurost2_neurostim');
	
	
	$userPassword = md5($data["password"]);
	
	$sql = "SELECT * FROM paciente WHERE idPaciente='" . $data["idPaciente"] .  "'";
	$query = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($query);
	$db_password = $row['password'];

	
	if($userPassword == $db_password){
		$sql = "SELECT COUNT(*) FROM setup WHERE idPaciente='" . $data["idPaciente"] .  "'";
		$query = mysqli_query($db, $sql);
		$rows = mysqli_fetch_array($query);
		
		if($rows[0]!=0){
			$sql = "SELECT * FROM setup WHERE idPaciente='" . $data["idPaciente"] .  "'";
			$query = mysqli_query($db, $sql);
		
			$rows = array();
			while($rows = mysqli_fetch_array($query)){
				$results[] = $rows;
			}

		echo json_encode($results);
		} else {
			echo '[]';
		}
	}
	else{
		echo 'invalid';
	}
	
	
?>