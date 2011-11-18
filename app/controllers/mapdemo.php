<?php


class Mapdemo extends CI_Controller{
	private function index(){
		$this->load->library('GMap');
		$this->load->model('eventsmodel');

		$this->gmap->GoogleMapAPI();
		
		// valid types are hybrid, satellite, terrain, map
		$this->gmap->setMapType('map');
		$this->gmap->enableDirections();
		
		// you can also use addMarkerByCoords($long,$lat)
		// both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
		
		$events = $this->eventsmodel->events_by_date();
		foreach($events->result_array() as $row){
			$address = $row["street"]." ".$row['city']." ".$row['state']." ".$row['zipcode'];
			$html = $row["street"]."<br />".$row['city']." ".$row['state'].",".$row['zipcode'];
			$this->gmap->addMarkerByAddress($address,$row["street"],$html);
		}
		
		$data['headerjs'] = $this->gmap->getHeaderJS();
		$data['headerjs'] .= $this->gmap->getMapJS();
		$data['headerjs'] .= $this->gmap->getAddDirectionsJS();
		$data['onload'] = $this->gmap->printOnLoad();
		$data['map'] = $this->gmap->printMap();
		$data['sidebar'] = $this->gmap->printSidebar();
		
		$this->load->view('mapdemo',$data);	
	}
}
