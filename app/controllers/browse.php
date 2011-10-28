<?php

class Browse extends CI_Controller{

	function index(){
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
			
		$this->load->model('accountmodel');
		
		
		
		$data = array(
			"users" => array()
		);
		
		$random_users = $this->accountmodel->get_random_uids(15);
		
		foreach($random_users as $user){
			array_push($data['users'],$this->accountmodel->get_profile_by_uid($user));
		}
			
		/*$data = array(
			"users" => array(
				$this->accountmodel->get_profile_by_uid(21),
				$this->accountmodel->get_profile_by_uid(1),
				$this->accountmodel->get_profile_by_uid(32),
				$this->accountmodel->get_profile_by_uid(10),
				$this->accountmodel->get_profile_by_uid(53),
				$this->accountmodel->get_profile_by_uid(350),
			)
		);*/
			
		$this->load->view('zb-two-home',$data);
		
	}
	
	function search(){
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
			
		$this->load->view('zb-two-home');
	}

}


?>