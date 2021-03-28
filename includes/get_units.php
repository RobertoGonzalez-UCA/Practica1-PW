<?php
	require ('connection.php');
	
	$subjectid = $_POST['subjectid'];
	
	$queryU = "SELECT unitid, name FROM units WHERE subjectid = '$subjectid' ORDER BY name";
	$resultU = mysqli_query($db,$queryU);
	
	$html= "<option value=''>Seleccionar tema</option>";
	
	while($rowU = $resultU->fetch_assoc())
	{
		$html.= "<option value='".$rowU['unitid']."'>".$rowU['name']."</option>";
	}
	
	echo $html;
?>