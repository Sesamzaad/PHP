<?php
		
		if(isset($_POST['keuze']) == 'overzicht')
		{
			$url = "http://build.uitdatabank.be/api/events/search?key=AEBA59E1-F80E-4EE2-AE7E-CEDD6A589CA9&regio=Gent&agebetween=14..30&format=json";
			$events = json_decode(file_get_contents($url));

			foreach ($events as $e) {
				$id = $e->cbid;
				$data[] = "<a href='Details.php?id=" . $id . "' data-transition='slidedown'> <img src='". $e->thumbnail . "'/> <h2>" . $e->title . "</h2> <p>" . $e->heading . "<b>" . $e->city . "</b><em>" .substr($e->available_to,0,-8) . "</em></p></a>";
			}
		}
		
		header('Content-type: application/json');
		echo json_encode($data);

?>