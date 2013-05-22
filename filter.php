<?php
$cat = '';
$regio = '';

//FILTER PARAMATERS CHECKEN
if(isset($_POST['btnF']))
{
if(isset($_POST['Antwerpen']))
{
$regio = '&regio=Antwerpen';
}
if(isset($_POST['Lier']))
{
$regio = '&regio=Lier';
}
if(isset($_POST['Brussel']))
{
$regio = '&regio=Brussel';
}
if(isset($_POST['Mechelen']))
{
$regio = '&regio=Mechelen';
}
if(isset($_POST['Gent']))
{
$regio = '&regio=Gent';
}
if(isset($_POST['Sint-Niklaas']))
{
$regio = '&regio=Sint-Niklaas';
}


if(isset($_POST['Film']))
{
$cat = '&heading=5';
}
if(isset($_POST['Foto']))
{
$cat = '&heading=9';
}
if(isset($_POST['Kunst']))
{
$cat = '&heading=8';
}
if(isset($_POST['Literatuur']))
{
$cat = '&heading=22';
}
if(isset($_POST['Muziek']))
{
$cat = '&heading=14';
}
if(isset($_POST['Sport']))
{
$cat = '&heading=31';
}

$filter = $regio . $cat;
}
?>

<!DOCTYPE html> 
<html> 
<head> 
	 <meta charset="UTF-8">
	<title>Filter</title> 
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
<div id="choisir_ville" data-role="page" data-add-back-btn="true">
	
	<div data-role="header"> 
		<h1>Filter zoekresultaten</h1>
        <a data-add-back-btn="true" href="overzichtMETlogin.php?stat=true">Back</a>
        <a data-add-back-btn="true" name="btnFilter" href= <?php if(isset($filter)){echo "overzichtMETlogin.php?" . $filter;} else{echo "#";} ?>>Filter!</a>
    </div> 

	<div data-role="content">
	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset data-role="controlgroup">
        <legend><h1>Waar wil je uitgaan?</h1></legend>
        <input type="checkbox" name="Antwerpen" id="Antwerpen">
        <label for="Antwerpen">Antwerpen</label>
        <input type="checkbox" name="Lier" id="Lier">
        <label for="Lier">Lier</label>
        <input type="checkbox" name="Brussel" id="Brussel">
        <label for="Brussel">Brussel</label>
        <input type="checkbox" name="Mechelen" id="Mechelen">
        <label for="Mechelen">Mechelen</label>
        <input type="checkbox" name="Gent" id="Gent">
        <label for="Gent">Gent</label>  
        <input type="checkbox" name="Sint-Niklaas" id="Sint-Niklaas">
        <label for="Sint-Niklaas">Sint-Niklaas</label>  
      </fieldset>
      <fieldset data-role="controlgroup">  
        <legend><h1>Wat wil je doen?</h1></legend>
        <input type="checkbox" name="Film" id="Film">
        <label for="Film">Film</label>
        <input type="checkbox" name="Foto" id="Foto">
        <label for="Foto">Foto</label>
        <input type="checkbox" name="Kunst" id="Kunst">
        <label for="Kunst">Kunst</label>
        <input type="checkbox" name="Literatuur" id="Literatuur">
        <label for="Literatuur">Literatuur</label>
        <input type="checkbox" name="Muziek" id="Muziek">
        <label for="Muziek">Muziek</label>  
        <input type="checkbox" name="Sport" id="Sport">
        <label for="Sport">Sport</label>                      
    </fieldset>
    <input type="submit" name="btnF" value="Bewaar filter"/>
	</form>
    
	</div>
	
       
	</div>

</div><!-- /page -->
</body>
</html>