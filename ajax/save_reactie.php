<?php
include_once ("../classes/Reactie.class.php");
if (isset($_POST['reactie'])) 
{
	$reactie = new Reactie();
	try {
		$reactie->Text = $_POST['reactie'];
		$reactie->Save();
		$reactie->GetRecentReacties();
		$fb['text'] = "Your tweet has been posted!";
		$fb['status'] = "success";
	} catch(Exception $e) 
	{
		$fb['text'] = $e->getMessage();
		$fb['status'] = "error";
	}
	
}

header('Content-type: application/json');
echo json_encode($fb);
?>

