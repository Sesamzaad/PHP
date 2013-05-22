<?php
	session_start();
	include_once("../classes/Db.class.php");

	if(isset($_POST['eventid']))
		{
		$eid = $_POST['eventid'];
		$db=new Db();
		$sql = "INSERT INTO `tbldeelnames`(`deelnamesEventID`, `deelnamesUser`) VALUES ('$eid','$_SESSION[username]')";
		try
		{
		$db->conn->query($sql);	
		$feedback['text'] = "Your tweet has been posted!";
		$feedback['status'] = 'success';
		}
		catch(Exception $e)
		{
		$feedback['text'] = "Somethins has gone terribly wrong!";
		$feedback['status'] = $e->getMessage();	
		}
		}

	header('Content-type: application/json');
	echo json_encode($feedback);
?>