<html>
<body>
 
 
<?php
//Open a new connection to the MySQL server
$conn = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql="UPDATE paciente SET idPaciente='$_POST[idPaciente]', nome='$_POST[firstname]', sobrenome='$_POST[lastname]', idade='$_POST[age]', email='$_POST[email]', cpf='$_POST[cpf]', rua='$_POST[street]', complemento='$_POST[compl]', numero='$_POST[number]', cidade='$_POST[city]', estado='$_POST[state]', pais='$_POST[country]', cep='$_POST[cep]', telefone='$_POST[tel]', celular='$_POST[cel]', idFisio='$_POST[idFisio]', escalaRankin='$_POST[escalaRankin]', diagnostico='$_POST[diagnostico]', modoFuncional='$_POST[modoFuncional]', maxInt='$_POST[maxInt]' WHERE idPaciente=" . $_GET["id"].";";
 
if ($conn->query($sql) === TRUE) {
	echo '<script type="text/javascript">alert("Usuário alterado com sucesso!");</script>';
	echo "<script>setTimeout(\"location.href = 'index.php?';\",500);</script>";
} else {
	echo '<script type="text/javascript">alert("Usuário não pode ser editado! Error: ". $sql . "<br>" . $conn->error .");</script>';
	echo 'script <script type="text/javascript">history.go(-1);">Back </script>';
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


</body>
</html>