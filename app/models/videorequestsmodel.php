<?php

class Videorequestsmodel extends CI_Model{
			
	// Deletes all requests that have expired, i.e. (NOW() - daterequested) > timetolive
	//
	// $timetolive - number of days after which a request expires
	function delete_expired_requests($timetolive)
	{
		$this->load->database();
		$str = "DELETE FROM videochat_requests
				WHERE NOW() > DATE_ADD(date_requested, INTERVAL ? DAY);"
				
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
				WHERE requestor_uid = ? AND target_uid = ?;"
				
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
				WHERE requestor_uid = ?;"
				
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
				WHERE target_uid = ?;"
				
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
	
	
	// Fetches any requests where the requestor is user with id $r_uid
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
			return $query->row();
		else
			return NULL;		
	}	
	
	
	// Fetches any requests where the target is user with id $t_uid
	// (requests are ordered by date requested in descending order, i.e., newest is first)
	//
	// $t_uid - id of target user to look up
	// $online_flag - boolean value, if true it returns only those requests for which
	// 					the requestor is currently online (online status is determined
	//					by looking for the user's entry in the videochat_registrations table),
	//				  if false, it returns all matching requests
	// $order_flag - integer value {0, 1, -1} : 0 (or null) means no sorting
	//											1 sorts ascending by date_requested
	//											-1 sorts descending by date_requested
	function lookup_requests_by_target($t_uid, $online_flag, $order_flag)
	{
		$this->load->database();
		
		if (!isset($online_flag) || !$online_flag)
		{
			// flag was false, so return all, regardless of online status
			$str = "SELECT requestor_uid, date_requested, request_message
					FROM videochat_requests 
					WHERE target_uid=?";							
		}
		else
		{
			// flag was true, so return only those requests with an online requestor
			$str = "SELECT requestor_uid, date_requested, request_message 
					FROM videochat_requests Q, videochat_registrations R 
					WHERE Q.requestor_uid = R.uid AND Q.target_uid = ?";
		}
		
		if (isset($order_flag))
		{
			if ($order_flag > 0)
			{
				// sort ascending
				$str = $str . " ORDER BY Q.date_requested ASC";
			}		
			elseif ($order_flag < 0)
			{
				// sort descending
				$str = $str . " ORDER BY Q.date_requested DESC";
			}
		}
		$str = $str . ";";	
		
		$data = array($t_uid);
		
		$query = $this->db->query($str, $data);
		
		// return the records found or null if no requests found
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return NULL;		
	}
}