<?php
	
	$data = json_decode(file_get_contents('php://input'), true);
	
	$db = mysqli_connect('localhost', 'neurost2_root', 'c4rp3di3m', 'neurost2_neurostim');
	//$db = mysqli_connect('192.168.15.12', 'root', 'c4rp3di3m', 'neurostim');
	
	$userPassword = md5($data["password"]);
	
	$sql = "SELECT password, modoFuncional, maxInt FROM paciente WHERE idPaciente='" . $data["idPaciente"] .  "'";
	$query = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($query);
	$db_password = $row['password'];
	$modo = $row['modoFuncional'];
	$maxInt = $row['maxInt'];
	
	if($userPassword == $db_password){
		if($modo == 'Sim')
			$arr = array('funcional' => 'true', 'logged' => 'true', 'intensidadeMaxima' => $maxInt);
		else
			$arr = array('funcional' => 'false', 'logged' => 'true', 'intensidadeMaxima' => $maxInt);
               
                echo json_encode($arr);
	}
	else{
		//echo 'invalid';
		$arr = array('funcional' => $modo, 'logged' => 'false', 'intensidadeMaxima' => $maxInt);
		echo json_encode($arr);
	}
	
	
?>