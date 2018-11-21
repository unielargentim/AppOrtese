<html>
<body>
 
 
<?php
//Open a new connection to the MySQL server
$conn = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 
$sql="INSERT INTO setup (idPaciente, dataInicial, dataFinal, ts, td, tp, threshold, intensidade, frequencia, larguraPulso, repeticoes, tempoUtilizacao, maxInt)
VALUES
('$_POST[idPaciente]','$_POST[dataInicial]','$_POST[dataFinal]','$_POST[ts]','$_POST[td]','$_POST[tp]','$_POST[th]','$_POST[intensidade]','$_POST[freq]','$_POST[lp]','$_POST[rep]','$_POST[tu]','$_POST[maxInt]')";
 
if ($conn->query($sql) === TRUE) {
	echo '<script type="text/javascript">alert("Agenda criada com sucesso!");</script>';
	echo "<script>setTimeout(\"location.href = 'setup.php?id=" . $_POST['idPaciente'] ."';\",500);</script>";
} else {
	echo '<script type="text/javascript">alert("Agenda não pode ser criada! Error: ". $sql . "<br>" . $conn->error .");</script>';
	echo '<script type="text/javascript">history.go(-1);">Back </script>';
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


</body>
</html>