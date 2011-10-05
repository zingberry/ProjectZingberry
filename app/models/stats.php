<?php

class Stats extends CI_Model{
	
	function numusers(){
		$query = $this->db->query('SELECT count(*) as numusers from users ');
		
		$result = $query->row_array();
		return $result['numusers'];
	}
	
	function numtempusers(){
		$query = $this->db->query('SELECT count(*) as numusers from tempusers ');
		
		$result = $query->row_array();
		return $result['numusers'];
	}
	
	function user_activity($days){
		$query = $this->db->query("SELECT count(*) as numusers FROM users WHERE lastlogin > DATE_SUB(NOW(), INTERVAL $days DAY)");
		
		$result = $query->row_array();
		return $result['numusers'];	}
		
}

?>