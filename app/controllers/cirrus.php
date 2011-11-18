<?php

// This is the controller that communicates with the Flex app and handles user lookup
// and user (de)registrations
class Cirrus extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		// need this in order to access the GET variables in the URL
		// need to edit config.php to PATH_INFO - see Readme.txt
		parse_str($_SERVER['QUERY_STRING'],$_GET);		
	}
	
	function index()
	{
        $this->accountlibrary->is_logged_in();
        
			$this->load->model('cirrusmodel');
			//$uid = $this->session->userdata('uid');
			
			// determine the type of request send by Flex
			if (isset($_GET['username']) && isset($_GET['identity']))
			{			
				$username = $_GET['username']; // username here is the uid from the users' table
				$identity = $_GET['identity']; // identity is the unique rtfmp identity of a user
				if ($identity == '0')
				{
					// deregister user - only uid is needed
					$data['type'] = 'deregistration';
					$data['user'] = $username;
					$data['queryresult'] = $this->cirrusmodel->unregister_user($username);
					// load the view that sends XML response back to the Flex app
					$this->load->view('zbcirrus',$data);
				}
				else
				{
					// register user
					$data['type'] = 'registration';
					$data['user'] = $username;				
					$data['queryresult'] = $this->cirrusmodel->register_user($username, $identity);
					// load the view that sends XML response back to the Flex app
					$this->load->view('zbcirrus',$data);
				}				
			}
			elseif (isset($_GET['friends']))
			{
				// lookup user
				$friendname = $_GET['friends'];
				// execute query
				$data['identity'] = $this->cirrusmodel->lookup_user_friend($friendname);				
				$data['user'] = $friendname;
				$data['type'] = 'lookup';
				// load the view that sends XML response back to the Flex app
				$this->load->view('zbcirrus',$data);
			}
			else
			{
				// invalid request - redirect back to whatever the default page is
				redirect('', 'location');
			}
					
	}	
}
