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
	
	function initial(){
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
			
		$this->load->model('accountmodel');
		
		
		
		$data = array(
			"users" => array(),
			"initial" => true
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
			
		$this->load->model('accountmodel');
		$data = array(
			"users" => array()
		);
		
		$data['search_errors'] = Browse::search_errors();
		
		if(count($data['search_errors']) ==0){
			$users = $this->accountmodel->search_by_category($this->input->post('category'),$this->input->post('term'));
			shuffle($users);
			if(count($users) > 15)
				$users = array_slice($users,0,15);
		} else {
			$users = $this->accountmodel->get_random_uids(15);
		}
		
		
		foreach($users as $user){
			array_push($data['users'],$this->accountmodel->get_profile_by_uid($user));
		}
			
		$this->load->view('zb-two-home',$data);
	}
	
	
	
	private function search_errors(){
		$errors = array();
		
		
		$categorys = array(
			"favorite_music_artists",
			"favorite_heroes",
			"favorite_movies",
			"favorite_tvshows",
			"favorite_sports_teams",
			"favorite_video_games",
			"favorite_books",
			"favorite_foods",
			"organizations",
			"workplaces",
			"greeks",
			"courses",
			"majors",
			"highschool",
			"languages",
			"nationalities",
			"class"
		);
		
		if($this->input->post("category") == "")
			$errors['category'] = "Please Select a Category";
		if(!in_array($this->input->post("category"),$categorys))
			$errors['category'] = "Category Does Not Exist";
		if($this->input->post('term') == "")
			$errors['term'] = "Please Enter a Search Term";
			
		return $errors;
	}

}


?>
