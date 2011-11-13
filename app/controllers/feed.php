<?php

class Feed extends CI_Controller {


	function index(){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');

		$this->load->model('propsmodel');
		$propsfrom = $this->propsmodel->get_props_from($this->session->userdata('uid'));
		$propsto = $this->propsmodel->get_props_to($this->session->userdata('uid'));

        header("Content-Type: text/plain");

		echo "props to you:\n\n";
		print_r($propsto);
		echo "\n\n\n\n\nprops from you:\n";
		print_r($propsfrom);
		                    			
	}
	
	function props(){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');

		$this->load->model("propsmodel");
		$this->load->model("accountmodel");
		
		$props = $this->propsmodel->get_props_from($this->session->userdata('uid'));
//		$props = $this->propsmodel->get_random_props();
		
		
		/* 
		//code to give random props from random people
		$uids = $this->accountmodel->get_random_uids(50);
		echo "here";
		for($i=0;$i<20;$i++){
			$this->propsmodel->give_props($uids[array_rand($uids)],$uids[array_rand($uids)]);
		}*/
		
		header("Content-Type: text/plain");		
		print_r($props);
	}
	
}
