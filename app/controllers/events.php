<?php

class Events extends CI_Controller{
	
	private function layman_date($datetime){
		$temp = DateTime($datetime);
		if(date_format($temp,"")=="1")
			return "Today";
	}
	
	private function index(){
		
		$this->load->library('session');
		$this->load->helper('url');
		
		if(!$this->session->userdata('uid')){
			redirect('/account/login','location');
		}else{
			$this->load->model('eventsmodel');
			
			$data['header']['title'] = 'Events';
			$data['page'] = 'events';
			$data['firstname'] = $this->session->userdata('firstname');
			$data['events'] = $this->eventsmodel->events_by_date();
			$this->load->view('zbevents',$data);
		}
		
		
	}
	
	private function map(){
		$this->load->library('session');
		
		if(!$this->session->userdata('uid')){
			redirect('/account/login','location');
		}else{
			$this->load->model('eventsmodel');
			
			$this->load->library('GMap');
			$this->gmap->GoogleMapAPI();
			
			// valid types are hybrid, satellite, terrain, map
			$this->gmap->setMapType('map');
			$this->gmap->enableDirections();
			
			// you can also use addMarkerByCoords($long,$lat)
			// both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
			
			$events = $this->eventsmodel->events_by_date();
			foreach($events->result_array() as $row){
				$address = $row["street"]." ".$row['city']." ".$row['state']." ".$row['zipcode'];
				$html = $row["street"]."<br />".$row['city']." ".$row['state'].",".$row['zipcode']."<br />".'<a href="'.site_url("events/details")."/".$row['eventid'].'">details</a>';
				$this->gmap->addMarkerByAddress($address,$row["street"],$html);
			}
			
			$data['header']['title'] = 'Events Map';
			$data['js'] = $this->gmap->getHeaderJS();
			$data['js'] .= $this->gmap->getMapJS();
			$data['js'] .= $this->gmap->getAddDirectionsJS();
			$data['onload'] = $this->gmap->printOnLoad();
			$data['map'] = $this->gmap->printMap();
			$data['sidebar'] = $this->gmap->printSidebar();
			$data['page'] = 'map';
			$data['firstname'] = $this->session->userdata('firstname');
			//$data['events'] = $this->eventsmodel->events_by_date();
			$this->load->view('zbevents',$data);
			
		}
		
		
	}
	
	private function events_ajax(){
		//$payload = json_decode($this->input->post("payload"));
		
		//print_r($payload);
		
		//echo $data->page;
		
		
		
		//$action = $data->action;
		//echo $action;
		
		$this->load->model('eventsmodel');
		$pagenum = $this->input->post("page");
		$events = $this->eventsmodel->events_filter($this->input->post("searchterm"), $this->input->post("cats"), $pagenum);
		$data = "";
		
		if($events->num_rows() == 0){
			$data .= "Sorry, There are no events scheduled a this time.<br />
						Please check back soon!";
		}else{
			foreach($events->result_array() as $row){
			
				$data .= '<a href="'.site_url("events/details")."/".$row['eventid'].'">
							<div class="event" id="'. ($pagenum+1).'">
									<div id="event_pic">';
										if(isset($row['eiid'])){
											$data .= '<img src="eventimages/'.$row['filename'].'" width="120" height="120" />';
										} else {
											$data .= '<img src="eventimages/placeholder_'.$row['catid'].
											'.png" width="120" height="120" />';
										}
				$data .=           '</div>
									<div id="event_info">'.
										$row['eventname'].
								   '</div>
						  </div>
						  </a>';
			}
			
		}
		
		echo $data;
	}
	
	private function cats(){
		$this->load->model('eventsmodel');
		$result = $this->eventsmodel->get_categorys();	
		
		foreach ($result->result_array() as $row){
			//echo '<li class="'.$row['cid'].'">'.$row['category'].'</li>';	
			echo '<label for="'.$row['cid'].'"><input type="checkbox" name="'.$row['cid'].'" id="'.$row['cid'].'" value="'.$row['cid'].'" checked="checked" />'.$row['category'].'</label><br />';
		}
		
	}
	
	private function details($eid){
			if(!$this->session->userdata('uid'))
				redirect('/account/login','location');
					
			$this->load->model('eventsmodel');
			$data['header']['title'] = 'Event Details';
			$data['page'] = 'details';
			$data['details'] = $this->eventsmodel->event_details($eid);
			$data['pic'] = $this->eventsmodel->get_event_pic($eid);
			$this->load->view('zbevents',$data);
		
	}
	
	function add(){
		
	}
	
	
	
	//My old map geocoding function - doesnt work currently. has to be modified still -- Brandon
	private function geocode($lid){		
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
				
		$this->load->model('eventsmodel');
		$row = $this->eventsmodel->get_location($lid);
		$delay = 0;
		$base_url = "http://maps.google.com/maps/geo?output=xml&key=" . $this->config->item('maps_key');
		
		

		
		$geocode_pending = true;
		while ($geocode_pending) {
			$address = $row["street"]." ".$row['city']." ".$row['state']." ".$row['zipcode'];
			$request_url = $base_url . "&q=" . urlencode($address);
			
			$ch = curl_init();
			$timeout = 5; // set to zero for no timeout
			curl_setopt ($ch, CURLOPT_URL, $request_url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);		
			
			$xml = simplexml_load_string($file_contents);
			//print_r($xml);
			$status = $xml->Response->Status->code;
			if (strcmp($status, "200") == 0) {
				// Successful geocode
				$geocode_pending = false;
				$coordinates = $xml->Response->Placemark->Point->coordinates;
				$coordinatesSplit = split(",", $coordinates);
				$lat = $coordinatesSplit[1];
				$lng = $coordinatesSplit[0];
				
					echo Events::array_search_key("AdministrativeAreaName",$xml);
					$state = $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->AdministrativeAreaName;
					$city = $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->DependentLocality->DependentLocalityName;
					$street = $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->DependentLocality->Thoroughfare->ThoroughfareName;
					$zipcode = $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->DependentLocality->PostalCode->PostalCodeNumber;
				echo "coded: ".$lid."</br>\n";
				
				$this->eventsmodel->update_location($lid, $street, $city, $state, $zipcode,$lat, $lng);
			} else if (strcmp($status, "620") == 0) {
				// sent geocodes too fast
				$delay += 100000;
			} else {
				// failure to geocode
				$geocode_pending = false;
				echo "Address " . $address . " failed to geocoded. ";
				echo "Received status " . $status . "\n";
			}
			usleep($delay);
		}
		
		
		
	}
	
	private function array_search_key( $needle_key, $array ) { 
  		foreach($array AS $key=>$value){ 
    		if($key == $needle_key) 
				return $value; 
    		if(is_array($value)){ 
     			if( ($result = array_search_key($needle_key,$value)) !== false) 
        			return $result; 
    		} 
  		} 
  		return false; 
	} 
	
	
}
