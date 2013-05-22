<?php
session_start();
include_once("../classes/Db.class.php");

if (isset($_POST['SelectedOptionClass'])) 
{
	try {
		$db = new Db();
		$sql = "INSERT INTO `tblprojectratings`(`ratingUser`, `ratingEvent`, `ratingWaarde`) VALUES ('$_SESSION[username]', '$_SESSION[id]', '$_POST[SelectedOptionClass]')";
		try
		{
		$db->conn->query($sql);
		$feedback['text'] = "query succes";
	
		}
		catch(Exception $e)
		{
		$feedback['text'] = "query fail";
		}
	} catch(Exception $e) 
	{
		$feedback['text'] = $e->getMessage();
		$feedback['status'] = "error";
	}
}
header('Content-type: application/json');
echo json_encode($feedback);
?>

