<?php
	require ('connection.php');
	
	$questionid = $_POST['questionid'];

	$query = "SELECT answerid, text, value FROM answers WHERE questionid = '$questionid' ORDER BY text";
	$result = mysqli_query($db,$query);
	
    $html = "<br><h3>Respuestas:</h3>";

	while($row = $result->fetch_assoc())
	{
        $checked = $row['value'] ? "checked" : "";
		$html.= "<div>
        <input name='answer[".$row['answerid']."][answer]' type='text' value='".$row['text']."' style='display: inline-block; margin-right: 10px; width: 35%;'>
        <input style='display: inline-block;' type='radio' name='selected' value='".$row['answerid']."' $checked>
        </div>";
	}

    $html.="<br>";
	
	echo $html;
?>