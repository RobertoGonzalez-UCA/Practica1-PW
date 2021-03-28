<?php
	require ('connection.php');
	
	$unitid = $_POST['unitid'];
	
	$query = "SELECT questionid, text FROM questions WHERE unitid = '$unitid' ORDER BY text";
	$result = mysqli_query($db,$query);

	while($row = $result->fetch_assoc())
	{
		$html.= "<option value='".$row['questionid']."'>".$row['text']."</option>";
	}
	
	echo $html;
?>