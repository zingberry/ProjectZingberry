<?php

class Action extends CI_Controller {


	function index(){
		
	}

    function zing($uid= NULL){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');

        if($uid != NULL && $uid != $this->session->userdata('uid')){
            $this->load->model('actionmodel');
            $result = $this->actionmodel->zing($this->session->userdata('uid'),$uid);

            if($result < 1)
                echo json_encode(
                    array( "success" => false )
                );
            if($result == 1)
                echo json_encode(
                    array( "success" => true )
                );
        }

    }

    function random_zing(){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');

        $this->load->model("actionmodel");
        $this->load->model("accountmodel");

        $props = $this->actionmodel->get_random_zing();


        header("Content-Type: text/plain");
        print_r($props);

    }


	function give_props($uid= NULL){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');
	                    
		if($uid != NULL && $uid != $this->session->userdata('uid')){
			$this->load->model('actionmodel');
			$result = $this->actionmodel->give_props($this->session->userdata('uid'),$uid);
			
			if($result < 1)
				echo json_encode(
					array( "success" => false )
				);
			if($result == 1)
				echo json_encode(
					array( "success" => true )
				);
		}
	
	}
	
	function random_props(){
        if(!$this->session->userdata('uid'))
            redirect('/account/login','location');

        $this->load->model("actionmodel");
        $this->load->model("accountmodel");

	    $props = $this->actionmodel->get_random_props();


		header("Content-Type: text/plain");
		print_r($props);	
	
	}

}
