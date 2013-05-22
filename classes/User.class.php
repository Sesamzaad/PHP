<?php
include_once("Db.class.php");
class User
{
	private $m_sNaam;
	private $m_sEmail;
	private $m_sPassword;
	private $m_sLocatie;
	private $m_sLeeftijd;		
	private $signup;
	
	
	public function __set($p_sProperty, $p_vValue)
	{
		switch($p_sProperty)
		{
		case "Naam":
		if(!empty($p_vValue))
		{
		$db = new Db();
		$this->m_sNaam = $db->conn->real_escape_string($p_vValue);
		}
		else
		{
		throw new Exception("You forgot your name mate!");
		}
		break;
		
		case "Email":
		if(!empty($p_vValue))
		{
		$this->m_sEmail = $p_vValue;
		}
		else
		{
		throw new Exception("You forgot your e-mail mate!");
		}
		break;
		
		case "Password";
		if(!empty($p_vValue))
		{
		$this->m_sPassword = $p_vValue;
		}
		else
		{
		throw new Exception("Don't forget your password pal!");
		}
		break;	
		
		case "Locatie";
		if(!empty($p_vValue))
		{
		$this->m_sLocatie = $p_vValue;
		}
		else
		{
		throw new Exception("Don't forget your location pal!");
		}
		break;	
		
		case "Leeftijd";
		if(!empty($p_vValue))
		{
		$this->m_sLeeftijd = substr($p_vValue,6,4);
		switch($this->m_sLeeftijd)
		{
			case "2003":
			$_SESSION['leeftijd'] = "10";
			break;
			case "2002":
			$_SESSION['leeftijd'] = "11";
			break;
			case "2001":
			$_SESSION['leeftijd'] = "12";
			break;
			case "2000":
			$_SESSION['leeftijd'] = "13";
			break;
			case "1999":
			$_SESSION['leeftijd'] = "14";
			break;		
			case "1998":
			$_SESSION['leeftijd'] = "15";
			break;		
			case "1997":
			$_SESSION['leeftijd'] = "16";
			break;
			case "1996":
			$_SESSION['leeftijd'] = "17";
			break;
			case "1995":
			$_SESSION['leeftijd'] = "18";
			break;		
			case "1994":
			$_SESSION['leeftijd'] = "19";
			break;
			case "1993":
			$_SESSION['leeftijd'] = "20";
			break;
			case "1992":
			$_SESSION['leeftijd'] = "21";
			break;
			case "1991":
			$_SESSION['leeftijd'] = "22";
			break;
			case "1990":
			$_SESSION['leeftijd'] = "23";
			break;
			case "1989":
			$_SESSION['leeftijd'] = "24";
			break;
			default:
			$_SESSION['leeftijd'] = "18";
			break;
		}

		}
		else
		{
		throw new Exception("You forgot to give your age mate!");
		}
		break;					
			
		}
		
	}
	
	public function __get($p_sProperty)
	{
		switch($p_sProperty)
			{
				case "Naam":
				return $this->m_sNaam;
				break;
				
				case "Email": 
				return $this->m_sEmail;
				break;
				
				case "Password":
				return $this->m_sPassword;
				break;
				
				case "Signup":
				return $this->signup;
				break;
		
				case "Locatie":
				return $this->m_sLocatie;
				break;
				
				case "Leeftijd":
				return $this->m_sLeeftijd;
				break;								
			
			}
		}
	
	public function Registreer()
	
	{
		$db = new Db();
		$sql = "INSERT INTO `tblprojectusers`(`UserNaam`, `UserWachtwoord`, `UserEmail`, `UserProvincie`, `UserLeeftijd`) VALUES ('$this->m_sNaam','$this->m_sPassword','$this->m_sEmail','$this->m_sLocatie','$this->m_sLeeftijd')";
		if($db->conn->query($sql))
		{
		$_SESSION['loggedin'] = true;
		$_SESSION['username'] = $this->m_sNaam;
		$_SESSION['locatie'] = $this->m_sLocatie;
		}
		
	}
	
	public function canLogin()
	{
		$db = new Db();
		if(!$db->conn->connect_errno)
	{
		$sql = "SELECT * FROM `tblprojectusers` WHERE `UserNaam` = '$this->m_sNaam' and `UserWachtwoord` = '$this->m_sPassword'";
		$res = $db->conn->query($sql);
	}
		if($res->num_rows == 1)
	{
		$_SESSION['loggedin'] = true;
		$_SESSION['username'] = $this->m_sNaam;
		
	}
	else
	{
		$_SESSION['loggedin'] = false;
		throw new Exception("Something went terribly wrong!");
	}	
	}
	
	
	public function Logout()
	{
	$_SESSION['loggedin'] = false;	
	}
	
	
	

	}
	
	

	

?>