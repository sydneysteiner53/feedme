<?php

class Restorant{
    public $name;
    public $address;
    public $url;
    public $price_range;
    public $id;

}


class Neighborhood{

    public $location, $recommended_venues, $venue_id, $venues_to_filter, $venues_by_group, $venues_by_tag, $venues_by_price, $api_response;

    public $clientid = "V20WXD5B52NLNV4NY3TDAPYEUVBCNI0PXQUT1IPPUTXLUVRS", $clientsecret = "WB2CFC1NDSIQZRKVAXHM53HVMXRVKYYANGGH0I0TPNANHH3M";


    function __construct($location){
        $this->location = $location;

        $this->recommended_venues = array();
        $this->venue_ids = array();
        $this->venues_to_filter = array();
        $this->venues_by_group = array();
        $this->venues_by_tag = array();
        $this->venues_by_price = array();
    }


    public function get_recommended_venues(){
        $uri = "https://api.foursquare.com/v2/venues/explore?near=".$this->location."&client_id=".$this->clientid."&client_secret=".$this->clientsecret."&v=".time()."&categoryId=4d4b7105d754a06374d81259&limit=10";

        $this->api_response = json_decode(file_get_contents($uri), true);


        //echo "<pre>";
        //print_r($this->api_response); exit;


        foreach($this->api_response['response']['groups'][0]['items'] as $item){
            $restorant = new Restorant();
            $restorant->id = $item['venue']['id'];
            $restorant->name = $item['venue']['name'];
            $restorant->address = $item['venue']['location']['address'];
            $restorant->url = $item['venue']['url'];
            $restorant->price_range = $item['venue']['price']['message'];

            array_push($this->recommended_venues, $restorant);
        }

        return $this->recommended_venues;
    }


    public function filter_by_group($group){
        if(empty($this->venues_to_filter)){
            $this->get_venues_for_filtering();
        }

        $this->venues_by_group = Array();

        foreach($this->venues_to_filter as $venue){

            //echo "<pre>";
            //print_r($venue);
            //exit;

            foreach($venue['attributes']['groups'] as $groups){
                if(strtolower($groups['name']) == strtolower($group)){
                    foreach($groups['items'] as $item){
                        $parts = explode(" ",$item['displayValue']);
                        if($parts[0] != "No"){
                            $restorant = new Restorant();
                            $restorant->name = $venue['name'];
                            $restorant->address = $venue['location']['address'];
                            $restorant->url = $venue['url'];
                            if(isset($venue['price'])){
                                $restorant->price_range = $venue['price']['message'];
                            }

                            array_push($this->venues_by_group, $restorant);
                        }
                    }
                }
            }
        }

        return $this->venues_by_group;
    }




    public function filter_by_tag($tag){
        if(empty($this->venues_to_filter)){
            $this->get_venues_for_filtering();
        }

        $this->venues_by_tag = Array();
        foreach($this->venues_to_filter as $venue){
            foreach($venue['tags'] as $venue_tag){
                if(strtolower($venue_tag) == strtolower($tag)){
                    array_push($this->venues_by_tag, $venue['name']);
                }
            }
        }

        return $this->venues_by_tag;
    }




    public function get_venue_ids(){
        $this->venue_ids = Array();
        foreach($this->recommended_venues as $venue){
            array_push($this->venue_ids, $venue->id);
        }

        return $this->venue_ids;
    }


    public function get_venues_for_filtering(){
        $this->get_venue_ids();

        foreach($this->venue_ids as $id){

            $uri = "https://api.foursquare.com/v2/venues/".$id."?client_id=".$this->clientid."&client_secret=".$this->clientsecret."&v=".time()."&m=foursquare";

            $content = json_decode(file_get_contents($uri), true);

            array_push($this->venues_to_filter, $content['response']['venue']);
        }

        return $this->venues_to_filter;
    }


}


?>