<html>
<body>
 
 
<?php
//Open a new connection to the MySQL server
$conn = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 
$sql="INSERT INTO paciente (idPaciente, nome, sobrenome, idade, email, cpf, rua, complemento, numero, cidade, estado, pais, cep, telefone, celular, idFisio, escalaRankin, diagnostico, modoFuncional, maxInt)
VALUES
('$_POST[idPaciente]','$_POST[firstname]','$_POST[lastname]','$_POST[age]','$_POST[email]','$_POST[cpf]','$_POST[street]','$_POST[compl]','$_POST[number]','$_POST[city]','$_POST[state]','$_POST[country]','$_POST[cep]','$_POST[tel]','$_POST[cel]','$_POST[idFisio]','$_POST[escalaRankin]','$_POST[diagnostico]','$_POST[modoFuncional]','$_POST[maxInt]');";
 
if ($conn->query($sql) === TRUE) {
	echo '<script type="text/javascript">alert("Usuário criado com sucesso!");</script>';
	echo "<script>setTimeout(\"location.href = 'index.php';\",500);</script>";
} else {
	echo '<script type="text/javascript">alert("Usuário não pode ser criado! Error: ". $sql . "<br>" . $conn->error .");</script>';
	echo 'script <script type="text/javascript">history.go(-1);">Back </script>';
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


</body>
</html>