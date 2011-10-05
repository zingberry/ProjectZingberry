<?php

class Browse extends CI_Controller{

	function index(){
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
			
		$this->load->view('zb-two-home');
		
	}

}


?>