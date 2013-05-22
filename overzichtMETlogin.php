<?php
session_start();

$stat = $_GET['stat'];

// LOGIN FUNCITES
include_once("classes/User.class.php");
$_SESSION['loggedin'] = false;

$user = new User();
$salt = "548412181@&ééé&^ùµ=^^12/788";

if(isset($_POST['btnSignup']))
{
try
{
$user->Naam = $_POST['name'];
$user->Email =  $_POST['email'];
$user->Password = md5($_POST['password'].$salt);
$user->Locatie = $_POST['locatie'];
$user->Leeftijd = $_POST['leeftijd'];
$_SESSION['username'] = $user->Naam;
$user->Registreer();
}
catch(Exception $e)
{
$error = $e->getMessage();
}
}

if(isset($_POST['btnLogin']))
{
$db = new Db();	
try
{
$user->Naam = $db->conn->real_escape_string($_POST['username']);
$user->Password = md5($_POST['password'].$salt);
$user->canLogin();
}
catch(Exception $e)
{
$error = $e->getMessage();	
}
}

if(isset($_POST['btnSignupFB']))
{
$_SESSION['loggedin'] = true;

}

// API COMMUNICATIE

$url = "http://build.uitdatabank.be/api/events/search?key=AEBA59E1-F80E-4EE2-AE7E-CEDD6A589CA9&regio=". $_SESSION['locatie'] ."&agebetween=".$_SESSION['leeftijd']."..25&format=json";

$events = json_decode(file_get_contents($url)); //json data omzetten in php array adhv jason decode


if(isset($_GET['regio']))
{
$regio = $_GET['regio'];
$urlfilter = "http://build.uitdatabank.be/api/events/search?key=AEBA59E1-F80E-4EE2-AE7E-CEDD6A589CA9&regio=".$regio."&format=json";	
$eventsFilter = json_decode(file_get_contents($urlfilter));
}

if(isset($_GET['heading']))
{
$heading = $_GET['heading'];
$urlcat = "http://build.uitdatabank.be/api/events/search?key=AEBA59E1-F80E-4EE2-AE7E-CEDD6A589CA9&heading=".$heading."&regio=". $_SESSION['locatie'] . "&format=json";
$eventsCat = json_decode(file_get_contents($urlcat));
}
if(isset($_GET['regio']) && isset($_GET['heading']))
{
$regio = $_GET['regio'];
$heading = $_GET['heading'];
$urlfiltDubbel = "http://build.uitdatabank.be/api/events/search?key=AEBA59E1-F80E-4EE2-AE7E-CEDD6A589CA9&regio=".$regio."&heading=".$heading."&format=json";	
$eventsfiltDubbel = json_decode(file_get_contents($urlfiltDubbel));
}
	
?>

<!DOCTYPE html> 
<html> 
<head> 
	<meta charset="UTF-8">
	<title>Overzicht</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="jquery.mobile.structure-1.0.1.css" />
	<link rel="apple-touch-icon" href="images/launch_icon_57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="images/launch_icon_72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="images/launch_icon_114.png" />
	<link rel="stylesheet" href="jquery.mobile-1.0.1.css" />
	<link rel="stylesheet" href="custom.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.0.1.min.js"></script>
</head> 
<body> 
<!--- LOGIN --->
<?php if($_SESSION['loggedin'] == false && $_GET['stat'] != true && empty($_GET['regio']) && empty($_GET['heading']))
{
?>
<div id="home" data-role="page" data-add-back-btn="true">
	<div data-role="header"> 
	<h1> Welkom bij CultuurnetApp! Meld je aan om te beginnen </h1>
	<a href="overzichtMETlogin.php?screen=fblogin">Login met facebook</a>
	<a href="overzichtMETlogin.php?screen=eplogin">Login </a>
    </div> 
<div data-role="content">
<div id="rightside">

<?php if(isset($_GET['screen']) && $_GET['screen']=="fblogin"){ ?>
</div>
<section id="fbLoginform">
<p id="fbFeedback"></p>
<form action"overzichtMETlogin.php?screen=fblogin" method="post">
 <div id="fblogin"  style="text-align:center">
   <h2><img src="images/head2.png"/></h2>
   <p><button data-role="button" data-theme="b" id="btnSignupFB" onClick="FB.login();" style="text-align:center">Login met facebook</button></p>
   <p><button name="btnSignupFB" id="btnSignupFB" onClick="FB.login();" style="text-align:center">Verder</button></p>
 </div>
 </form>
</section>
<?php } ?>

<?php if(isset($_GET['screen']) && $_GET['screen']=="eplogin"){ ?>
<section id="loginForm" style="text-align:center">
<h2><img src="images/head2.png"/></h2>
<div><p><?php if(isset($_POST['btnLogin'])){if(!empty($error)){echo $error;}} ?> </p></div>
<form action="overzichtMETlogin.php?screen=eplogin" method="post">
<input type="text" name="username" placeholder="Gebruikersnaam" style="text-align:center"/>
<input type="password" name="password" placeholder="Password" style="text-align:center"/>
<input type="submit" name="btnLogin" value="Aanmelden" />
<a href="overzichtMETlogin.php?screen=signup">Sign up</a>
</form>
</section>
<?php } ?>

<?php if(!isset($_GET['screen']) || (isset($_GET['screen']) && $_GET['screen']=="signup")){?>
<section id="signup" style="text-align:center">
<h2><img src="images/head2.png"/></h2>
<div><p class="error"><?php if(isset($_POST['btnSignup'])){if(!empty($error)){echo $error;}}  ?> </p></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input type="text" name="name" placeholder="Full name" style="text-align:center" />
<input type="email" name="email" placeholder="Email" style="text-align:center"/>
<input type="password" name="password" placeholder="Password"style="text-align:center" />
<input type="text" name="leeftijd" placeholder="Geboortedatum (dd/mm/jaar)" style="text-align:center"/>
<input type="text" name="locatie" placeholder="Locatie (bv: Antwerpen)" style="text-align:center"/>
<input type="submit" name="btnSignup" onClick="signupVisible()" value="Registreer"style="text-align:center" />
</form>
<?php
}
?>
</div>
</div>
</div>

</section>
</div>	
</div>
</div>
<?php
}
?>

<!---- EINDE LOGIN---->

<!--- OVERZICHT --->
<?php if($_SESSION['loggedin'] == true || $_GET['stat'] == true || !empty($_GET['regio']) || !empty($_GET['heading'])) 
{
?>
<div id="home" data-role="page" data-add-back-btn="true">
	<div data-role="header"> 
		<a href="filter.php"><img src="images/option.png" /></a>	
       	<a href='http://localhost/PHP/Project/overzichtMETlogin.php?screen=signup' onClick="FB.logout()" id='btnLogout'>Logout</a>
		<h1> Where to go? </h1>
	</div> 

	<div data-role="content">
	
	<div class="choice_list"> 
	<h1>Overzicht evenementen</h1>
	<div class="ui-navbar">
    </div>
	<ul data-role="listview" data-inset="true" >
    <?php
if(isset($heading) && isset($regio))
	{
	foreach($eventsfiltDubbel as $ee)
	{
		$id = $ee->cdbid;
		echo "<li><a href='Details.php?id=" . $id . "&regio=".$regio."&heading=".$heading."'' data-transition='slidedown'> <img src='". $ee->thumbnail . "'/> <h2>" . $ee->title . "</h2> <p>" . $ee->heading . "   " . $ee->city."</p></a></li>";//
	}	
}

if(isset($regio))
	{
	foreach($eventsFilter as $f)
	{
		$id = $f->cdbid;
		echo "<li><a href='Details.php?id=" . $id . "&regio=".$regio."' data-transition='slidedown'> <img src='". $f->thumbnail . "'/> <h2>" . $f->title . "</h2> <p>" . $f->heading . "   " . $f->city."</p></a></li>";////
	}
	}
else if(isset($heading))
	{
	foreach($eventsCat as $c)
	{
		$id = $c->cdbid;
		echo "<li><a href='Details.php?id=" . $id . "&heading=".$heading."' data-transition='slidedown'> <img src='". $c->thumbnail . "'/> <h2>" . $c->title . "</h2> <p>" . $c->heading . "   " . $c->city."</p></a></li>";//
	}	
}
		
else
{
	foreach($events as $e)
	{
		$id = $e->cdbid;
		echo "<li><a href='Details.php?id=" . $id . "' data-transition='slidedown'> <img src='". $e->thumbnail . "'/> <h2>" . $e->title . "</h2> <p>" . $e->heading . "	      	<b>" . $e->city . "</b>      <em>" . substr($e->available_to,0,-8) . "</em></p></a></li>";
		}
	}
	
?>
</ul>	
</div>
</div>
</div>

<?php
}

?>


</body>
</html>