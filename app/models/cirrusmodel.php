<?php

// This is the model that handles user registration, deregistration and lookup for videochats
class Cirrusmodel extends CI_Model{
			
	// Fetches the name of a user
	function get_name_by_uid($uid)
	{
		$this->load->database();
		$str = "SELECT firstname
				FROM users
				WHERE uid=?;";
				
		$data = array($uid);
		
		$query = $this->db->query($str, $data);
		
		// return the single record with this user's name, 
		// or return NULL if a user with given uid was not found
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;
	}
	
	// Performs registration of a user for video chat
	function register_user($uid, $identity)
	{
		$this->load->database();
		$str = "REPLACE INTO videochat_registrations (
		   		uid,
				m_identity,
				m_updatetime) 
				VALUES ( 				                
                ? ,
                ? , 
                NOW() );";
		$data = array($uid, $identity);
		
		$query = $this->db->query($str, $data);
		
		// if the user is registered for the first time, affected_rows() == 1
		// if the user's registration is updated, affected_rows() == 2
		return $this->db->affected_rows();
	}
	
	// Unregisters a user from video chat
	function unregister_user($uid)
	{
		$this->load->database();
		$str = "DELETE FROM videochat_registrations 
				WHERE uid=?;";
				
		$data = array($uid);
		
		$query = $this->db->query($str, $data);
		
		// no need to return anything when user deregisters
		return $this->db->affected_rows();
	}
	
	// Looks up the identity of a user for video chat
	function lookup_user_friend($friendid)
	{
		$this->load->database();
		$str = "SELECT m_identity FROM videochat_registrations 
				WHERE uid=?;";
				
		$data = array($friendid);
		
		$query = $this->db->query($str, $data);
		
		// return the single record with this user's identity, 
		// or return NULL if user is not found
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;		
	}	
}