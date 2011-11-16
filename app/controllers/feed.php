<?php

class Feed extends CI_Controller {


	function index(){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');
		$this->load->model("actionmodel");
		$this->load->model("accountmodel");
		
		$props = $this->actionmodel->get_random_props(10);
		$zings = $this->actionmodel->get_random_zings(10);
		$video_requests = $this->actionmodel->get_random_video_requests(10);
		$list = array_merge($props,$zings,$video_requests);
		shuffle($list);
		
		$data = array(
			"feed_list" => array()
		);
		
		foreach($list as $item){
			array_push($data['feed_list'],array_merge($item, array(
				"s_user" => $this->accountmodel->get_profile_by_uid($item['s_uid']),
				"t_user" => $this->accountmodel->get_profile_by_uid($item['t_uid'])
				))
			);
		}
			
			
		$this->load->view('zb-two-feed',$data);
			
	}
	
}
