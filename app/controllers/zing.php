<?php


class Zing extends CI_Controller{
	
	function index(){
		
		Zing::about();
	}
	
	function about(){
		$data['header']['title'] = 'About US';
		$data['page'] = 'about';
		$this->load->view('zb-two-aboutus',$data);
	}
	function support(){
		$data['header']['title'] = 'Support';
		$data['page'] = 'support';
		$this->load->view('zb-two-support',$data);			
	}
	/*function feedback(){
		$data['header']['title'] = 'Site Feedback';
		$data['page'] = 'feedback';
		$this->load->view('zbzing',$data);			
	}*/
	function careers(){
		$data['header']['title'] = 'Careers';
		$data['page'] = 'careers';
		$this->load->view('zb-two-careers',$data);			
	}
	/*function contact(){
		$data['header']['title'] = 'Contact Us';
		$data['page'] = 'contact';
		$this->load->view('zbzing',$data);			
	}*/
	function terms(){
		$data['header']['title'] = 'Terms &amp; Conditions';
		$data['page'] = 'terms';
		$this->load->view('zb-two-terms',$data);			
	}
	
	
	
}

?>