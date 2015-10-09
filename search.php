<?php

include "classes.php";


if(isset($_POST['location']) && isset($_POST['group'])){

    $location = $_POST['location'];
    $group = $_POST['group'];

    $hood = new Neighborhood($location);

    $hood->get_recommended_venues();

    $restaurants = array();

    if($group == "no filter"){
        $restaurants = $hood->recommended_venues;
    }else{
        $restaurants = $hood->filter_by_group($group);
    }


    echo '
        <!doctype html>
            <html>
            	<head>
            		<title> hungry? </title>
            		<link rel="stylesheet" type="text/css" href="css/style.css">
            	</head>
            	<body>

            	<h1> Starving. </h1>
            	<div class="back">  </div><h2><a href="/"> <img src="images/prev_button.png" width="20" height="auto"></a> Restaurant recommendations for '.$location.' </h2>
            	<div class="thick"><hr></div>
    ';

    $i=0;

    foreach($restaurants as $restaurant){

        if(empty($hood->venue_ids)){
            $id=$restaurant->id;
        }else{
            $id=$hood->venue_ids[$i];
        }

        $data = file_get_contents("https://api.foursquare.com/v2/venues/".$id."/photos?client_id=".$hood->clientid."&client_secret=".$hood->clientsecret."&v=".time()."&m=foursquare&limit=1");
        $ob = json_decode($data,true);

        echo '
            <a href = "'.$restaurant->url.'"> <h3> '.$restaurant->name.' </h3> </a>
            <h4>'.$restaurant->address.'</h4>
            <h6>Price range is '.$restaurant->price_range.'</h6>
            <img src="'.$ob['response']['photos']['items'][0]['prefix']."200x200".$ob['response']['photos']['items'][0]['suffix'].'" class="pic" />
            <div><hr></div>
            <br>
        ';
        $i++;
    }
    echo '
        </body>
        </html>
    ';


}

?>