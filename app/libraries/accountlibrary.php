<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Accountlibrary {

    public function __construct() {

    }

    public function is_logged_in() {
    	$CI =& get_instance();
		if(!$CI->session->userdata('uid'))
			redirect('/account/login','location');
    }
    
    public function send_notification_email() {
    
    
    }
}

/* End of file accountlibrary.php */
