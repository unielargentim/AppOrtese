<html>
<body>
 
 
<?php
//Open a new connection to the MySQL server
$conn = new mysqli("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql="DELETE FROM setup WHERE idSetup=" . $_GET["idSetup"].";";
 
if ($conn->query($sql) === TRUE) {
	echo '<script type="text/javascript">alert("Agendamento deletado com sucesso!");</script>';
	echo "<script>setTimeout(\"location.href = 'setup.php?id=" . $_GET["id"] . "';\",500);</script>";
} else {
	echo '<script type="text/javascript">alert("Agendamento não pode ser deletado! Error: ". $sql . "<br>" . $conn->error .");</script>';
	echo 'script <script type="text/javascript">history.go(-1);">Back </script>';
    //echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


</body>
</html>