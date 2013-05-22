<?php
	session_start();
	
	//GET id van event voor detailinfo
	$id = $_GET['id'];	
	$url = "http://build.uitdatabank.be/api/event/". $id ."?key=AEBA59E1-F80E-4EE2-AE7E-CEDD6A589CA9&format=json";
	$_SESSION['id'] = $_GET['id'];

	$event = json_decode(file_get_contents($url));
	
	// REACTIES BEHEREN
	include_once("classes/Reactie.class.php");
	$reactie = new Reactie();
	$recentActivities = $reactie->GetRecentReacties();

	if(!empty($_POST['activitymessage']))
	{
		$reactie->Text = $_POST['activitymessage'];
		try 
		{
			$reactie->Save();
			$feedback = "Your status has been updated";
		} 
		catch (Exception $e) 
		{
			$feedback = $e->getMessage();
		}
		}
	
	//AANTAL AANWEZIGEN BEPALEN ADHV tblDEELNAMES
	$db = new Db();
	$sql = "SELECT * FROM `tbldeelnames` WHERE `deelnamesEventID` = '$id'";
	$res = $db->conn->query($sql);
	
	if($res->num_rows >= 1)
	{
	$aanwezigen = $res->num_rows;	
	}
	else
	{
	$aanwezigen = 0;	
	}
	
	//Checken of er reeds filters aanwezig zijn voor het terugsturen naar overzicht
	if(isset($_GET['regio']) && isset($_GET['heading']))
	{
	$ahref = "overzichtMETlogin.php?regio=" . $_GET['regio'] . "&heading=".$_GET['heading'];	
	$ahref2 = "Details.php?id=" . $id."&regio=".$_GET['regio'] . "&heading=".$_GET['heading'];
	}
	else if(isset($_GET['regio']))
	{
	$ahref = "overzichtMETlogin.php?regio=" . $_GET['regio'];	
	$ahref2 = "Details.php?id=" . $id."&regio=".$_GET['regio'];
	}
	else if(isset($_GET['heading']))
	{
	$ahref = "overzichtMETlogin.php?heading=".$_GET['heading'];	
	$ahref2 = "Details.php?id=" . $id."&heading=".$_GET['heading'];
	}
	else if(!isset($_GET['regio']) && !isset($_GET['heading']))
	{
	$ahref = "overzichtMETlogin.php?stat=true";	
	$ahref2 = "Details.php?id=" . $id;
	}
	
?>
<!DOCTYPE html> 
<html> 
<head> 
	<meta charset="UTF-8">
	<title>Details</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="jquery.mobile.structure-1.0.1.css" />
	<link rel="stylesheet" href="jquery.mobile-1.0.1.css" />
	<link rel="stylesheet" href="custom.css" />
    
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.0.1.min.js"></script>
    <script type="text/javascript" src="js/apps.js"></script>
	<script type="text/javascript" src="js/deelname.js"></script>
	<!--- <script>$(document).bind("mobileinit", function(){$.mobile.ajaxEnabled = false;});</script>-->
 
</head> 
<body> 
<div id="restau" data-role="page" data-add-back-btn="true">
	<form data-ajax="false" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<div data-role="header"> 
    	<a data-add-back-btn="true" href="<?php echo $ahref ?>">Back</a>
    	<a href="#" class="ui-btn-corner-right" onclick="return postToWall();">Delen op facebook!</a>
		<h1> Evenement details</h1>
	</div> 
	</form>
    
	<!--- meer info over event -->
	<div data-role="content">
	<div class="ui-grid-a" id="restau_infos">	
		<div class="ui-block-a">
		<h1><?php if(isset($event->event->eventdetails->eventdetail->title)){echo $event->event->eventdetails->eventdetail->title;} ?></h1>
        <p><?php echo "<strong>Wanneer?</strong>" . "  " . $event->event->availablefrom?></p>
        <?php
		if(isset($event->event->eventdetails->eventdetail->shortdescription))
		{
		echo "<p><strong>Wat?</strong>" . "  " . $event->event->eventdetails->eventdetail->shortdescription . "</p>";
		}
		?>
		</div>		
		<div class="ui-block-b" style="text-align:center">
       	<?php
		$images = "";
        if(isset($event->event->eventdetails->eventdetail->media->file)){
        $images = $event->event->eventdetails->eventdetail->media->file;
        }
        if(!is_object($images) && !empty($images))
        {
        foreach ($images as $image) {
        if($image->mediatype == "photo")
        {
        echo "<img class='img' src='".$image->hlink."'>";
		echo "<p><a href=# id=btnDeelnemen name=btnDeelnemen data-role=button data-eventid=" . $_SESSION['id'] . "> Deelnemen! </a></p>";	
        }
		}
        }
		else
		{
		echo "<p><img src=images/head2.png></p>";
		echo "<p><a href=# id=btnDeelnemen name=btnDeelnemen data-role=button data-eventid=" . $_SESSION['id'] . "> Deelnemen! </a></p>";	   
		}
		?>
		</div>
	</div>
    <!-- /meer info event -->
	<hr/>
    
	<!-- praktische info event -->
	<div class="ui-grid-a" id="contact_infos">	
		<div class="ui-block-a">
		<h2> Praktische informatie</h2>
		<p><?php echo $event->event->contactinfo->address->physical->street . "  " . $event->event->contactinfo->address->physical->housenr?></p>
		<p><?php echo $event->event->contactinfo->address->physical->city . "  " . $event->event->contactinfo->address->physical->zipcode ?></p>
		<p><img src="images/aanwezigen.png" height="20" width="20"><strong><?php echo $aanwezigen . " aanwezigen" ?></strong></p>
		</div>		
		<div class="ui-block-b">
		<p><img src="images/01_maps.jpg" alt="plan jeanette"/></p>
		</div>
	</div><!-- /grid-a -->
	<div id="contact_buttons">	
		<a href="http://maps.google.fr/maps?q=<?php echo ($event->event->contactinfo->address->physical->street . ' ' . $event->event->contactinfo->address->physical->housenr . ' ' . $event->event->contactinfo->address->physical->city);?>" data-role="button" data-icon="maps"> Vindt het via Google Maps </a> 	
	</div>	
	<hr/>
	
    <!-- /praktische info event -->
	<!--- RATING VAN EVENTEN -->
    <div id="notation">	
	<form>
	<label for="select-choice-0" class="select"><h2> User rating </h2></label>
		<select name="note_utilisateur" id="note_utilisateur" data-native-menu="false" data-theme="c" >
		   <option value="one" class="one"> Not good at all </option>
		   <option value="two" class="two">Average </option>
		   <option value="three" class="three">Pretty good </option>
		   <option value="four" class="four"> Excellent </option>
		</select>	
	</form>
	</div>

<!--- RATING IN DATABANK STEKEN --->

	<script type="text/javascript">

	$( '#restau' ).live( 'pageinit',function(event){
		var SelectedOptionClass = $('option:selected').attr('class');
		$('div.ui-select').addClass(SelectedOptionClass);
		
		$('#note_utilisateur').live('change', function(){	 
			$('div.ui-select').removeClass(SelectedOptionClass);
			
			SelectedOptionClass = $('option:selected').attr('class');
			$('div.ui-select').addClass(SelectedOptionClass);		
		
		var request = $.ajax({
 		url: "ajax/save_rating.php",
  		type: "POST",
  		data: {SelectedOptionClass : SelectedOptionClass},
  		dataType: "json"
});
		return false;

			
		 });
	  
	});

	</script>
<!---  EIDNE RATING IN DATABANK STEKEN --->

<!--- REACTIES EVENTEN -->
	</div>
		<form method="post" action="<?php echo $ahref2?>;">
        <p id="username" style="visibility:hidden"><?php echo $_SESSION['username']?></p>
		<div class="statusupdates">
		<h2>Wat vond je van dit evenement? </h2>
		<input type="text" value="<?php echo($_SESSION['username'] . " deel je mening!")?>" id="activitymessage" name="activitymessage" />
		<input id="btnSubmit" type="submit" value="Share" name="btnSubmit" />
		
		<ul id="listupdates">
		<?php 
			if(mysqli_num_rows($recentActivities) > 0)
			{		
				while($singleActivity = mysqli_fetch_assoc($recentActivities))
				{
					echo "<li class='clearfix'><p><strong>" . $_SESSION['username'] . "  " . "</strong>". $singleActivity['ReactiesInhoud'] ."</p></li>";
					
		
				}
			}
			else
			{
				echo "<li>Waiting for first status update</li>";	
			}
		?>
		</ul>
		
		</div>
</form>
</div>
<!----/REACTIES EVENTEN --->

<!------- FACEBOOK POSTEN ---->
<div id="fb-root"></div>
<a href="#" onclick="return postToWall();">Delen op facebook!</a>
<script src="//connect.facebook.net/en_US/all.js"></script>
<script>
  FB.init({ appId: '167990723365964', status: true, cookie: true, xfbml: true, oauth: true });

  function postToWall() {  
    FB.login(function(response) {
      if (response.authResponse) {
        FB.ui({
            method: 'feed', 
            name: '<?php echo $event->event->eventdetails->eventdetail->title ?>',
            link: 'https://www.google.be/<?php echo $event->event->eventdetails->eventdetail->title?>',
            picture: '<?php $images = $event->event->eventdetails->eventdetail->media->file; foreach($images as $m){if($m->mediatype == 'photo'){echo $m->hlink;}}?>',
            caption: '<?php echo $event->event->contactinfo->address->physical->street . "  " . $event->event->contactinfo->address->physical->housenr . " " . $event->event->contactinfo->address->physical->city?>',
            description: '<?php echo $event->event->eventdetails->eventdetail->shortdescription ?>'
        },
        function(response) {
          if (response && response.post_id) {
            alert('Post was published.');
          } else {
            alert('Post was not published.');
          }
        });
      } else {
        alert('User cancelled login or did not fully authorize.');
      }
    }, {scope: 'user_likes,offline_access,publish_stream'});
    return false;
}
</script>

<!------ FACEBOOK POSTEN EINDE ---->

</body>

</html>>>>>>>>>>>>>