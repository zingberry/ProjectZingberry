<?php

class Eventsmodel extends CI_Model{
	
	function events_by_date($enddate = NULL){
		if($enddate == NULL){
			
			
			//CORRECT QUERY
			//$query = $this->db->query("SELECT *, events.eid as eventid, events.name as eventname FROM events JOIN location ON events.lid=location.lid AND end > NOW() LEFT JOIN eventimages ON  events.eid=eventimages.eid  ORDER BY end");
			
			//TESTING QUERY
			$query = $this->db->query("SELECT *, events.eid as eventid, events.name as eventname FROM events JOIN location ON events.lid=location.lid LEFT JOIN eventimages ON  events.eid=eventimages.eid  ORDER BY end");
			return $query;
		}else{
			
		}
		// AND 
		// WHERE end > NOW() 
		
	}
	
	function events_filter($search=NULL,$cats=NULL,$page=0){
		$per_page=8; 
		$first_result=($page)*$per_page; 
		//"select * from contacts  order by last_name;"; 
		
		$query = "SELECT *, events.eid as eventid, events.name as eventname 
					FROM events 
					JOIN location ON events.lid=location.lid ";
		$searchfields = array(
			0 => "name",
			1 => "description"
		);
		
		if($search != NULL && $search != ""){
			$query.= " AND (".Eventsmodel::search_helper($search,$searchfields).") ";
		}
		if($cats != NULL){
			$query.= " AND ".Eventsmodel::cats_helper($cats);
		}
		
		$query .= " LEFT JOIN eventimages ON events.eid=eventimages.eid  ORDER BY end LIMIT $first_result,$per_page";
		$query = $this->db->query($query);
									
		return $query;
	}
	
	private function cats_helper($search){
		$arraySearch = explode(" ", $search);
		// table fields to search
		//$arrayFields = array(0 => "title", 1 => "content");
		$countSearch = count($arraySearch);
		$b = 0;
		$query = "(";//"SELECT * FROM ".$table." WHERE (";
		
		while ($b < $countSearch)
		{
			$query = $query."events.catid = ".$this->db->escape($arraySearch[$b]);
			$b++;
			if ($b < $countSearch)
			{
				$query = $query." OR ";
			}
		}
		$query = $query.") ";
		return $query;
	}
		
	
	private function search_helper($search, $arrayFields){
		$arraySearch = explode(" ", $search);
		// table fields to search
		//$arrayFields = array(0 => "title", 1 => "content");
		$countSearch = count($arraySearch);
		$a = 0;
		$b = 0;
		$query = "(";//"SELECT * FROM ".$table." WHERE (";
		$countFields = count($arrayFields);
		while ($a < $countFields)
		{
			while ($b < $countSearch)
			{
				$query = $query."events.".$this->db->escape_str($arrayFields[$a])." LIKE '%".$this->db->escape_str($arraySearch[$b])."%'";
				$b++;
				if ($b < $countSearch)
				{
					$query = $query." AND ";
				}
			}
			$b = 0;
			$a++;
			if ($a < $countFields)
			{
			  	$query = $query.") OR (";
			}
		}
		$query = $query.")";
		return $query;
		
	}
	
	function event_details($eid){
		//$query = $this->db->query("SELECT *  FROM events, eventimages WHERE end > NOW() ");
		$data = array(
			$eid
		);
		//$query = $this->db->query("SELECT *, events.eid as eventid, location.name as locationname  FROM events LEFT JOIN (eventimages, location) ON (location.lid=events.lid AND events.eid=eventimages.eid AND events.eid= ? )",$data);
		$query = $this->db->query("SELECT *, events.eid as eventid, location.name as locationname, events.name as eventname , DATE_FORMAT(events.start,'%W %m/%e/%Y at %h:%i%p') as startform, DATE_FORMAT(events.end,'%W %m/%e/%Y at %h:%i%p') as endform FROM events, location WHERE location.lid=events.lid  AND events.eid= ? ",$data);
		return $query->row_array();
		
		// AND 
		// WHERE end > NOW() 
		
	}
	
	function add_event(){
		
	}
	
	function add_location(){
		
	}
	
	
	function get_location($lid){
		$data = array(
			$lid
		);
		$query = $this->db->query("SELECT *FROM location WHERE lid = ? ",$data);
		return $query->row_array();
	}
	
	function update_location($lid, $street, $city, $state, $zipcode,$lat, $lng){
		$data = array(
			$street,
			$city,
			$state,
			$zipcode,
			$lat,
			$lng,
			$lid
		);
		$query = $this->db->query("UPDATE location SET  street = '?', city = '?', state = '?', zipcode = '?', latitude = ?, longitude = ? WHERE lid= ?",$data);
	}
	
	function tempevents_by_date($enddate = NULL){
		if($enddate == NULL){
			$query = $this->db->query("SELECT *, events.eid as eventid, events.name as eventname FROM events JOIN location ON events.lid=location.lid AND end > NOW() LEFT JOIN eventimages ON  events.eid=eventimages.eid  ORDER BY end");
			return $query;
		}else{
			
		}
		// AND 
		// WHERE end > NOW() 
		
	}
	
	
	function get_event_pic($eid){
		$data = array(
			$eid
		);
		$query = $this->db->query("SELECT * FROM eventimages WHERE eid= ? ",$data);
		return $query->row_array();
		
	}
	
	function get_categorys(){
		$query = $this->db->query("SELECT * FROM eventCategories");
		
		return $query;	
	}
	
	
	
}

?>