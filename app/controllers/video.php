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
			$this->load->model('cirrusmodel');
						
			// get name of user
			$dbresult = $this->cirrusmodel->get_name_by_uid($uid);
			if (isset($dbresult))
			{
				$firstname = $dbresult->firstname;
				$data['firstname'] = $firstname;
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
			$this->load->model('cirrusmodel');
						
			// get name of user
			$dbresult = $this->cirrusmodel->get_name_by_uid($uid);
			if (isset($dbresult))
			{
				$firstname = $dbresult->firstname;
				$data['firstname'] = $firstname;
				// set page title and user id
				$data['title'] = 'VideoChat';
				$data['uid'] = $uid;				
								
				// get target's name if present
				if (isset($tuid))
				{					
					// lookup the name of the target user
					$dbresult2 = $this->cirrusmodel->get_name_by_uid($tuid);
					// if found, pass to the view, the name and uid of the target
					if (isset($dbresult2))
					{
						$tname = $dbresult2->firstname;
						$data['tuid'] = $tuid;
						$data['tname'] = $tname;						
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
}