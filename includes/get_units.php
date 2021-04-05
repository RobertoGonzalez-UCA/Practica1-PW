<?php
	require ('connection.php');
	
	$subjectid = $_POST['subjectid'];
	
	$query = "SELECT unitid, name FROM units WHERE subjectid = '$subjectid' ORDER BY name";
	$result = mysqli_query($db,$query);

	while($row = $result->fetch_assoc())
	{
		$html.= "<option value='".$row['unitid']."'>".$row['name']."</option>";
	}
	
	mysqli_close($db);
	echo $html;
?>