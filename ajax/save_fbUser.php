<?php
session_start();
include_once("../classes/User.class.php");

if (isset($_POST['Naam'])) 
{
	$naam = $_POST['Naam'];
	$loc = $_POST['Locatie'];
	$bday = $_POST['Bday'];
	
	try {
	$user = new User();
	$user->Naam = $naam;
	$user->Email = "facebookEmail";
	$user->Password = "facebookWachtwoord";
	$user->Locatie = $loc;
	$user->Leeftijd = $bday;
	$user->Registreer();

	$fb['status'] = 'succes';

	}
	catch(Exception $e) 
	{
	$fb['text'] = $e->getMessage();
	$fb['status'] = "error";
	}
}

header('Content-type: application/json');
echo json_encode($fb);
?>

