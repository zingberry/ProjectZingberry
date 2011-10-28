<?php

// This is the model that handles video requests (deletion, creation)
class Videorequestsmodel extends CI_Model{				
	
	// This Model uses 2 constants
	// $default_time_to_live - default time to live (in days) for chat requests
	// $timetolive - time to live (in minutes) for online users in video registrations table
	//
	// Default time to live now is 30 days
	public function __construct()
    {
        parent::__construct();
    }
	
	// Deletes all requests that have expired, i.e. (NOW() - daterequested) > timetolive
	//
	// it uses the default time to live value defined above
	function delete_expired_requests_default_ttl()
	{
		$default_time_to_live = '30'; // default time to live (in days)
		
		$this->load->database();
		$str = "DELETE FROM videochat_requests
				WHERE NOW() > DATE_ADD(date_requested, INTERVAL ? DAY);";
				
		$data = array($default_time_to_live);
		
		$query = $this->db->query($str, $data);
		
		// returns the rows that were deleted, i.e. the expired requests
		return $this->db->affected_rows();		
	}
	
	// Deletes all requests that have expired, i.e. (NOW() - daterequested) > timetolive
	//
	// $timetolive - number of days after which a request expires
	function delete_expired_requests($timetolive)
	{
		$this->load->database();
		$str = "DELETE FROM videochat_requests
				WHERE NOW() > DATE_ADD(date_requested, INTERVAL ? DAY);";
				
		$data = array($timetolive);
		
		$query = $this->db->query($str, $data);
		
		// returns the rows that were deleted, i.e. the expired requests
		return $this->db->affected_rows();
	}
	
	
	// Deletes a single request
	// 
	// $r_uid, $t_uid - user id of requestor and target users
	function delete_single_request($r_uid, $t_uid)
	{
		$this->load->database();
		$str = "DELETE FROM videochat_requests
				WHERE requestor_uid = ? AND target_uid = ?;";
				
		$data = array($r_uid, $t_uid);
		
		$query = $this->db->query($str, $data);
		
		// returns the rows that were deleted
		return $this->db->affected_rows();
	}
	
	
	// Deletes all requests whose requestor is user with given id
	// 
	// $r_uid - user id of requestor
	function delete_all_requests_by_requestor($r_uid)
	{
		$this->load->database();
		$str = "DELETE FROM videochat_requests
				WHERE requestor_uid = ?;";
				
		$data = array($r_uid);
		
		$query = $this->db->query($str, $data);
		
		// returns the rows that were deleted
		return $this->db->affected_rows();
	}
	
	
	// Deletes all requests whose target is user with given id
	// 
	// $t_uid - user id of target
	function delete_all_requests_of_target($t_uid)
	{
		$this->load->database();
		$str = "DELETE FROM videochat_requests
				WHERE target_uid = ?;";
				
		$data = array($t_uid);
		
		$query = $this->db->query($str, $data);
		
		// returns the rows that were deleted
		return $this->db->affected_rows();
	}
	
	
	// Registers a chat request in the database. If a request
	// already exists for the (r_uid, t_uid) pair, then that
	// record is updated with the new datetime and new message
	//
	// $r_uid - id of user who requested the chat
	// $t_uid - id of target user
	// $msg - optional message sent by the requestor to the target user
	function register_request($r_uid, $t_uid, $msg)
	{
		$this->load->database();
		if (empty($msg))
		{
			// case when user does NOT provide the optional request message
			$str = "REPLACE INTO videochat_requests (
					requestor_uid,
					target_uid,
					date_requested,
					request_message
					) 
					VALUES ( 				                
					? ,
					? , 
					NOW(),
					NULL
					);";
						
			$data = array($r_uid, $t_uid);								
		}
		else
		{
			// case when user does provide the optional request message			
			$str = "REPLACE INTO videochat_requests (
					requestor_uid,
					target_uid,
					date_requested,
					request_message
					) 
					VALUES ( 				                
					? ,
					? , 
					NOW(),
					?
					);";
					
			$data = array($r_uid, $t_uid, $msg);
		}
		
		$query = $this->db->query($str, $data);
		
		// if this is a new request, affected_rows() == 1
		// if the user's request is updated, affected_rows() == 2
		return $this->db->affected_rows();
	}
	
	
	// Fetches any requests (as result array) where the requestor is user with id $r_uid
	// (requests are ordered by date requested in descending order, i.e., newest is first)
	//
	// $r_uid - id of requestor user to look up
	// $order_flag - integer value {0, 1, -1} : 0 (or null) means no sorting
	//											1 sorts ascending by date_requested
	//											-1 sorts descending by date_requested
	function lookup_requests_by_requestor($r_uid, $order_flag)
	{
		$this->load->database();
		$str = "SELECT * FROM videochat_requests 
				WHERE requestor_uid=?";
		
		if (isset($order_flag))
		{
			if ($order_flag > 0)
			{
				// sort ascending
				$str = $str . " ORDER BY date_requested ASC";
			}		
			elseif ($order_flag < 0)
			{
				// sort descending
				$str = $str . " ORDER BY date_requested DESC";
			}
		}
		$str = $str . ";";				
				
		$data = array($r_uid);
		
		$query = $this->db->query($str, $data);
		
		// return the records found or null if no requests found
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return NULL;		
	}	
	
	
	// Fetches any requests (as a result array) where the target is user with id $t_uid
	// (requests are ordered by date requested in descending order, i.e., newest is first)
	//
	// $t_uid - id of target user to look up
	// $online_flag - integer value, if 1 (=true) it returns only those requests for which
	// 					the requestor is currently online (online status is determined
	//					by looking for the user's entry in the videochat_registrations table),
	//				  if 0 (=false), it returns all matching requests
	// $order_flag - integer value {0, 1, 2} : 0 (or null) means no sorting
	//											1 sorts descending by date_requested
	//											2 sorts ascending by date_requested
	//
	// By default, the time-to-live of chat identities, and hence the online status
	// of a user is set to 2 minutes.
	function lookup_requests_by_target($t_uid, $online_flag, $order_flag)
	{
		$timetolive = '2'; // time to live (in minutes) for online users in video registrations table
		
		$this->load->database();
		
		// form query string
		if (!isset($online_flag) || $online_flag < 1)
		{
			// flag was false, so return all, regardless of online status
			$str = "SELECT requestor_uid, firstname, lastname, date_requested, request_message
					FROM users U, videochat_requests Q
					WHERE Q.target_uid=? AND U.uid = Q.requestor_uid";
			$data = array($t_uid);
		}
		else
		{
			// flag was true, so return only those requests with an online requestor
			// now <= m_updatetime + timetolive
			$str = "SELECT requestor_uid, firstname, lastname, date_requested, request_message 
					FROM users U, videochat_requests Q, videochat_registrations R 
					WHERE Q.requestor_uid = R.uid AND Q.target_uid = ? AND U.uid = R.uid AND NOW() <= DATE_ADD(R.m_updatetime, INTERVAL ? MINUTE)";
			$data = array($t_uid, $timetolive);
		}
		
		// update query string depending on order flag
		if (isset($order_flag))
		{
			if ($order_flag == 2)
			{
				// sort ascending
				$str = $str . " ORDER BY Q.date_requested ASC";
			}		
			elseif ($order_flag == 1)
			{
				// sort descending
				$str = $str . " ORDER BY Q.date_requested DESC";
			}
		}
		$str = $str . ";";	
		
		$query = $this->db->query($str, $data);
		
		// return the records found or null if no requests found
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return NULL;		
	}	
}