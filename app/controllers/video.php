<?php

// This controller is responsible for loading up the Flex app for video chatting
class Video extends CI_Controller{
		
	public function __construct()
	{
		parent::__construct();			
	}
	
	// default method with no arguments
	function index()
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
			// load model for video registration
			$this->load->model('cirrusmodel');
			// load model for video chat requests
			$this->load->model('videorequestsmodel');
			
			// get full name of user
			$dbresult = $this->cirrusmodel->get_fullname_by_uid($uid);
			if (isset($dbresult))
			{
				// delete expired chat requests (use default time to live)
				$this->videorequestsmodel->delete_expired_requests_default_ttl();
				
				$firstname = $dbresult->firstname;
				$lastname = $dbresult->lastname;
				$data['firstname'] = $firstname;
				$data['lastname'] = $lastname;
				// set page title and user id
				$data['title'] = 'VideoChat';
				$data['uid'] = $uid;				
				
				// load view that displays the video chat app, passing the relevant data
				$this->load->view('zbvideochat', $data);
			}
			else
			{			
				// could not find user name, possibly invalid user id or database connection problems
				// redirect back to whatever the default page is
				redirect('', 'location');
			}				
		}			
	}	
	
	// Called when a target callee is defined
	// $tuid - user id of target user
	function target($tuid)
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
			// load model for video registration
			$this->load->model('cirrusmodel');
			// load model for video chat requests
			$this->load->model('videorequestsmodel');
						
			// get full name of user
			$dbresult = $this->cirrusmodel->get_fullname_by_uid($uid);
			if (isset($dbresult))
			{
				// delete expired chat requests (use default time to live)
				$this->videorequestsmodel->delete_expired_requests_default_ttl();
				
				$firstname = $dbresult->firstname;
				$lastname = $dbresult->lastname;
				$data['firstname'] = $firstname;
				$data['lastname'] = $lastname;
				// set page title and user id
				$data['title'] = 'VideoChat';
				$data['uid'] = $uid;				
								
				// get target's name if present
				if (isset($tuid))
				{					
					// lookup the full name of the target user
					$dbresult2 = $this->cirrusmodel->get_fullname_by_uid($tuid);
					// if found, pass to the view, the name and uid of the target
					if (isset($dbresult2))
					{
						$t_firstname = $dbresult2->firstname;
						$t_lastname = $dbresult2->lastname;
						$data['tuid'] = $tuid;
						$data['t_firstname'] = $t_firstname;
						$data['t_lastname'] = $t_lastname;
					}
				}
				
				// load view that displays the video chat app, passing the relevant data
				$this->load->view('zbvideochat', $data);
			}
			else
			{			
				// could not find user name, possibly invalid user id or database connection problems
				// redirect back to whatever the default page is
				redirect('', 'location');
			}				
		}		
	}	
	
	
	// updates the m_updatetime of a given user
	function updateOnlineStatus()
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
			// load model for video registration
			$this->load->model('cirrusmodel');
			
			// get full name of user
			$dbresult = $this->cirrusmodel->update_registration($uid);
			if (isset($dbresult))
			{											
				// set query type and result
				$data['type'] = 'update_registration';
				$data['result'] = $dbresult;
				
				// load view that echoes back the result as JSON
				$this->load->view('zbvideorequest', $data);
			}
			else
			{			
				// could not find user name, possibly invalid user id or database connection problems
				// redirect back to whatever the default page is
				redirect('', 'location');
			}				
		}	
	}
}