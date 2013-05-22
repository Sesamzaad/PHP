<?php
session_start();
include_once("Db.class.php");

class Reactie
{
	private $m_sText;
	
	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
			case "Text":
				$this->m_sText = $p_vValue;
				break;
		}	   
	}
	
	public function __get($p_sProperty)
	{
		switch($p_sProperty)
		{
		case "Text": 
		return $p_sProperty;
		break;
		}
	}
	
	public function Save()
	{

		$bResult = false;
		$db = new Db();
		$sSql = "INSERT INTO `tblprojectreacties`(`ReactiesUser`, `ReactiesInhoud`, `ReactiesEvent`) VALUES ('$_SESSION[username]', '$this->m_sText', '$_SESSION[id]')";				
		try
		{
		$db->conn->query($sSql);
		}
		catch(Exception $e)
		{
		"Save fail";	
		}
	}
	
	public function GetRecentReacties()
	{
		$db = new Db();
		$sql = "select * from tblprojectreacties WHERE ReactiesEvent = '$_SESSION[id]'";
		try
		{
		$result = $db->conn->query($sql);	
		return $result;
		}
		catch(Exception $e)
		{
		"GetRecentReacties fail";	
		}
				

	}
	
	}
?>