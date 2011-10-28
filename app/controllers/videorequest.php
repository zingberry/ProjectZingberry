<?php

// This controller is responsible for handling video requests
class Videorequest extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();			
	}
	
	// deletes all expired requests for this target user
	// Uses a default time to live for now (as defined in videorequestsmodel)
	function delexpired()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$uid = $this->session->userdata('uid');
		
		if(!$uid)
		{
			redirect('/account/login','location');
		}
		else
		{	
			$this->load->model('videorequestsmodel');
						
			// execute query
			$dbresult = $this->videorequestsmodel->delete_expired_requests_default_ttl();					
			$data['type'] = 'del_expired';
			$data['result'] = $dbresult; // result is an integer of the number of deleted expired requests
			
			// load view that displays the video chat app, passing the relevant data
			$this->load->view('zbvideorequest', $data);						
		}	
	}
	
	// deletes a specific request, where target is this user and
	// requestor is user with id $ruid	
	function delsingle($ruid)
	{
		$this->load->library('session');
		$this->load->helper('url');
		$uid = $this->session->userdata('uid');
		
		if(!$uid)
		{
			redirect('/account/login','location');
		}
		else
		{	
			$this->load->model('videorequestsmodel');
						
			// execute query
			$dbresult = $this->videorequestsmodel->delete_single_request($ruid, $uid);					
			$data['type'] = 'del_single';
			$data['result'] = $dbresult; // result is an integer of the number of deleted requests
			
			// load view that displays the video chat app, passing the relevant data
			$this->load->view('zbvideorequest', $data);						
		}	
	}
	
	// deletes all chat requests for this user and returns number of
	// deleted requests
	function delall()
	{	
		$this->load->library('session');
		$this->load->helper('url');
		$uid = $this->session->userdata('uid');
		
		if(!$uid)
		{
			redirect('/account/login','location');
		}
		else
		{	
			$this->load->model('videorequestsmodel');
						
			// execute query
			$dbresult = $this->videorequestsmodel->delete_all_requests_of_target($uid);					
			$data['type'] = 'del_all';
			$data['result'] = $dbresult; // result is an integer of the number of deleted requests
			
			// load view that displays the video chat app, passing the relevant data
			$this->load->view('zbvideorequest', $data);						
		}		
	}
	
	// returns all requests for current user
	// $onlineFlag - if > 0 it returns only those of online users
	// $orderFlag - determines sort order of result
	function lookupbytarget($onlineFlag, $orderFlag)
	{
		$this->load->library('session');
		$this->load->helper('url');
		$uid = $this->session->userdata('uid');
		
		if(!$uid)
		{
			redirect('/account/login','location');
		}
		else
		{	
			$this->load->model('videorequestsmodel');
						
			// execute query
			$dbresult = $this->videorequestsmodel->lookup_requests_by_target($uid, $onlineFlag, $orderFlag);
			$data['type'] = 'lookup_by_target';
			$data['result'] = $dbresult; // result is an array of (possibly sorted) requests
			
			// load view that displays the video chat app, passing the relevant data
			$this->load->view('zbvideorequest', $data);						
		}
	}
	
	// Registers a video chat request for this user to a target user ($tuid) and
	// with an optional message ($msg)
	function request($tuid = NULL, $msg=NULL)
	{
		
			$this->load->library('session');
			$this->load->helper('url');
			$uid = $this->session->userdata('uid');
			
			if(!$uid)
			{
				redirect('/account/login','location');
			}
			else
			{	
				$this->load->model('videorequestsmodel');
							
				// execute query
				if($tuid != NULL && $msg != NULL){
					$dbresult = $this->videorequestsmodel->register_request($uid, $tuid, urldecode($msg));
				} else if($this->input->post() != FALSE) {
					$dbresult = $this->videorequestsmodel->register_request($uid, $this->input->post("uid"), $this->input->post("message"));
				} else {
					return;
				}
				$data['type'] = 'request';
				$data['result'] = $dbresult; // result is an integer of the number of created requests
				
				// load view that displays the video chat app, passing the relevant data
				$this->load->view('zbvideorequest', $data);						
			}
	}
	
}