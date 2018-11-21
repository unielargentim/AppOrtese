<?php
 require_once ('jpgraph-4.0.2/src/jpgraph.php');
 require_once ('jpgraph-4.0.2/src/jpgraph_line.php');
 require_once ('jpgraph-4.0.2/src/jpgraph_error.php');
 
	
 
$x_axis = array();
$y_axis = array();
$i = 0;
 
$con=mysqli_connect("localhost","neurost2_root","c4rp3di3m","neurost2_neurostim");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
$result = mysqli_query($con,"SELECT * FROM rand_data");
 
 
while($row = mysqli_fetch_array($result)) {
$x_axis[$i] =  $row["idSetup"];
$y_axis[$i] = $row["dataInicial"];
    $i++;
 
}
     
mysqli_close($con);
  
 
$graph = new Graph(359,259);
$graph->img->SetMargin(40,40,40,40);  
$graph->img->SetAntiAliasing();
$graph->SetScale("textlin");
$graph->SetShadow();
//$graph->title->Set("Example of line centered plot");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
 
 
// Use 20% "grace" to get slightly larger scale then min/max of
// data
$graph->yscale->SetGrace(0);
 
 
$p1 = new LinePlot($y_axis);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("red");
$p1->mark->SetWidth(4);
$p1->SetColor("blue");
$p1->SetCenter();
$graph->Add($p1);
 
$graph->StrokeCSIM("example.php"); 
 
?>