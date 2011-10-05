<?php

class Account extends CI_Controller {
	
/*	function Account(){
		
		parent::CI_Controller();
	}*/
	
	function personal(){
		$this->load->model('accountmodel');
		$data = array();
		
		echo json_encode($data);
		
		print_r($data);
	}
	
	function usercount(){
		$this->load->model('accountmodel');
		$data = $this->accountmodel->numusers();
		echo $data['numusers'];
			
	}
	
	private function is_logged_in(){
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
	}
	
	function organizations(){
		Account::is_logged_in();
		
		$this->load->view('zb-two-organizations');	
	}
	
	function academics(){
		Account::is_logged_in();
		
		$this->load->view('zb-two-academics');	
	}
	
	function interests(){
		Account::is_logged_in();
		
		$this->load->view('zb-two-interests');	
	}
	
	function picture(){
		Account::is_logged_in();
		
		$this->load->view('zb-two-picture');	
	}
	
	
	function json_token($field){
		if($this->input->post("q")){
			$this->load->model('accountmodel');
			switch($field){
				case 'nationalities':
					echo $this->accountmodel->json_token("nationalities","nid","nationality",$this->input->post("q"));
					break;
				case 'languages':
					echo $this->accountmodel->json_token("languages","langid","language",$this->input->post("q"));
					break;
				case 'dorm':
					echo $this->accountmodel->json_token("dorms","dormid","name",$this->input->post("q"));
					break;
				case 'highschool':
					echo $this->accountmodel->json_token("highschool","hid","name",$this->input->post("q"));
					break;
				case 'majors':
					echo $this->accountmodel->json_token("majors","mid","major",$this->input->post("q"));
					break;
				case 'courses':
					echo $this->accountmodel->json_token("courses","courseid","course_name",$this->input->post("q"));
					break;
				case 'favorite_books':
					echo $this->accountmodel->json_token("favorite_books","book_id","book_name",$this->input->post("q"));
					break;
				case 'favorite_foods':
					echo $this->accountmodel->json_token("favorite_foods","ffid","name",$this->input->post("q"));
					break;
				case 'favorite_heros':
					echo $this->accountmodel->json_token("favorite_heros","fhid","name",$this->input->post("q"));
					break;
				case 'favorite_movies':
					echo $this->accountmodel->json_token("favorite_movies","movie_id","movie_title",$this->input->post("q"));
					break;
				case 'favorite_music_artists':
					echo $this->accountmodel->json_token("favorite_music_artists","artist_id","artist_name",$this->input->post("q"));
					break;
				case 'favorite_sports_teams':
					echo $this->accountmodel->json_token("favorite_sports_teams","team_id","team_name",$this->input->post("q"));
					break;
				case 'favorite_tvshows':
					echo $this->accountmodel->json_token("favorite_tvshows","tvshow_id","tvshow_title",$this->input->post("q"));
					break;
				case 'favorite_video_games':
					echo $this->accountmodel->json_token("favorite_video_games","video_game_id","video_game_title",$this->input->post("q"));
					break;
				case 'greeks':
					echo $this->accountmodel->json_token("greeks","greek_id","name",$this->input->post("q"));
					break;
				case 'organizations':
					echo $this->accountmodel->json_token("organizations","oid","name",$this->input->post("q"));
					break;
				default:
					echo json_encode(array());	
					break;
			}
		}
		
	}
	
	
	function index(){
		if(!$this->session->userdata('uid'))
			redirect('/account/login','location');
		$this->load->model('accountmodel');
		
		if($this->input->post("profile_update")){
			//echo print_r($this->input->post());
			$update = $this->input->post();
			$update['nationalities'] = explode(",",$this->input->post("nationalities"));
			$update['languages'] = explode(",",$this->input->post("languages"));
			$this->accountmodel->update_personal_info($update);
			//echo print_r($update);
			
		}
		
		$stuff = $this->accountmodel->get_personal_info($this->session->userdata('uid'));
		$data["user"] = $stuff["user"];
		
		$data['highschool'] = array();
		if($stuff['highschool'] != NULL){
			array_push($data['highschool'],array(
				"id" => $stuff['highschool']['hid'],
				"name" => $stuff['highschool']['name']
			));
		}
		
		$data['dorm'] = array();
		if($stuff['dorm'] != NULL){
			array_push($data['dorm'] ,array(
				"id" => $stuff['dorm']['dormid'],
				"name" => $stuff['dorm']['name']
			));
		}
		
		
		$data['user']["languages"] = array();
		foreach($stuff['languages'] as $i){
			array_push($data['user']["languages"],	
				array(
					"id" => $i['langid'],
					"name" => $i['language']
				)
			);
		}
		
		$data['user']["nationalities"] = array();
		foreach($stuff['nationalities'] as $i){
			array_push($data['user']["nationalities"],	
				array(
					"id" => $i['nid'],
					"name" => $i['nationality']
				)
			);
		}
		$data["user"]["languages"] = json_encode($data["user"]["languages"]);
		$data["user"]["nationalities"] = json_encode($data["user"]["nationalities"]);
		$data["user"]["dorm"] = "[".json_encode($data["dorm"])."]";
		$data["user"]["dorm"] = json_encode($data["dorm"]);
		$data["user"]["highschool"] = json_encode($data["highschool"]);
		
		
		//print_r($data);
		$this->load->view('zb-two-account',$data);
		
		/*$data['name'] = "Brandon";
		$data['title'] = "Programmer";
		$data['lang'] = array('Java','C','JavaScript','Bash');
		
		$this->load->view('account_view',$data);*/
	}
	
	function login(){
		$this->load->library('session');
		$this->load->helper('url');
		
		if($this->session->userdata('uid')){
			redirect('browse','location');
		}else if($this->input->post('loginsubmit')){
			$this->load->model('accountmodel');
			$user = $this->accountmodel->login();
			if(isset($user['firstname'])){
				//echo "welcome ".$user->firstname;
				//$this->load->view('events');
				$userdata = array(
					'uid'=>$user['uid'],
					'firstname'=>$user['firstname'],
					'lastname'=>$user['lastname'],
					'firstname'=>$user['firstname'],
				);
				$this->session->set_userdata($userdata);
				redirect('browse','location');
			}else if ($user = $this->accountmodel->is_unregistered()){
				$data = Account::account_forms();
				$data['header']['title'] = 'Home';
				$data['page'] = 'home';
				$data['login_errors'] = 'You still havent verified your email address. Please check your email and click the verification link.';
				$this->load->view('zb-two-login',$data);
			}else{
				$this->accountmodel->bad_login();
				$data = Account::account_forms();
				$data['header']['title'] = 'Home';
				$data['page'] = 'home';
				$data['login_errors'] = 'The email/password you entered is incorrect. Please try again';
				$this->load->view('zb-two-login',$data);
			}
		}else{
			/*$this->load->helper('form');
			$data['formdata']= array(
				'open' => form_open('account/login'),
				'email' => form_input('email'),
				'password' => form_password('password'),
				'submit' => form_submit('loginsubmit','Login'),
				'close' => form_close()
			);*/
			
			$data = Account::account_forms();
			$data['header']['title'] = 'Home';
			$data['page'] = 'home';
			$this->load->view('zb-two-login',$data);
		}
		
				
	}
	
	function forgotpassword($code){
		if(isset($code) && !($this->input->post("email"))){
			
			$this->load->view("zb-two-forgot-password-change");
		} else if($this->input->post("email")){
			$this->load->view("zb-two-forgot-password-success");
		} else {
			$this->load->view("zb-two-forgot-password");
		}
	}
	
	
	
	private function account_forms(){
			$this->load->helper('form');
			$data['login_form']= array(
				'open' => form_open('account/login'),
				'email' => form_input(
					array('name' => 'email',
							'id' => 'email')
				),	
				'password' => form_password(
					array('name' => 'password',
							'id' => 'password')
				),	
				'submit' => form_submit(
					array('name' => 'loginsubmit',
							'id' => 'loginsubmit',
							'value' => 'Login')
				),
				'close' => form_close()
			);	
			
			
			$data['register_form']= array(
				'open' => form_open('account/register'),
				'firstname' => form_input('firstname'),
				'lastname' => form_input('lastname'),
				'email' => form_input('email'),
				'password' => form_password('password'),
				'confirmpassword' => form_password('confirmpassword'),
				'gender' => form_dropdown('gender',array(
					'm' => 'male',
					'f' => 'female'
				)),
				'class' => form_input('class'),
				'submit' => form_submit('registersubmit','Register'),
				'close' => form_close()
			);	
			return $data;
	}
	
	function logout(){
		$this->load->library('session');
		$this->load->helper('url');
		
		$this->session->sess_destroy();
		redirect('/','location');
		
	}
	
	function register(){
		$errors = Account::register_errors();
		if($errors['count'] > 0){
			$data=Account::account_forms();
			$data['register_errors']=$errors;
			$data['header']['title'] = 'Home';
			$data['page'] = 'home';
			$this->load->view('zbview',$data);
		}else{
			$this->load->model('accountmodel');
			$this->accountmodel->register();
			Account::send_verification_mail($this->input->post('firstname'),$this->input->post('lastname'),$this->input->post('email'),$this->input->post('confirmpassword'),true);
			$data = Account::account_forms();
			$data['header']['title'] = 'Registration Successful';
			$data['page'] = 'registered';
			$data['email'] = $this->input->post('email');
			$this->load->view('zbview',$data);
		}
		
		
	}
	

	function verify($tuid,$vcode){
		
		$this->load->model('accountmodel');
		
		$temp = $this->accountmodel->get_temp_account_by_tuid($tuid);
		
		$verification_code = $this->accountmodel->verification_code(
			$temp['email'],
			$temp['password'],
			$temp['verificationsent']
		);
		
		if($vcode==$verification_code){
			$this->accountmodel->verify($temp);
			$data = Account::account_forms();
			$data['header']['title'] = 'Verification Successful';
			$data['page'] = 'verified';
			$data['user'] = $temp;
			$this->load->view('zbview',$data);
		}else{
			redirect('/','location');	
		}
			
		
	}
	
	function resend_verification_all(){
		
		$this->load->model('accountmodel');
		$tempusers =  $this->accountmodel->get_temp_accounts();
		foreach($tempusers as $user){
			echo $user['firstname']." ".$user['lastname']." ".$user['email']." ".$user['password']."<br />";
			echo Account::send_verification_mail($user['firstname'],$user['lastname'],$user['email'],$user['password'],false)."<br />";
			sleep(10);
		}
		
	}
	
	function password($data){
		$this->load->model('accountmodel');
		echo $this->accountmodel->password_hash($data);
	}
	
	private function register_errors(){
		$error = array();
        $error["count"] = 0;

        //$error["email"] = "";
        //$pstr = "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@eden.rutgers.edu$/";
		$pstr = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if(!preg_match($pstr , $this->input->post('email'))) {
            $error["email"] = 'You must enter a valid Rutgers student email! (*@eden.rutgers.edu)';
            $error["count"] += 1;
        }
        else {
			
			$this->load->model('accountmodel');
			if($this->accountmodel->is_registered()){
				$error["email"] = "This email has already been registered and verified!";
                $error["count"] += 1;
			} 
        }

        //$error["firstname"] = "";
        $pstr = "/\b[a-zA-Z]+\b/";
        if(!preg_match($pstr, $this->input->post("firstname"))) {
            $error["firstname"] = "Enter a real first name!";
            $error["count"] += 1;
        }

        //$error["lastname"] = "";
        $pstr = "/\b[a-zA-Z]+\b/";
        if(!preg_match($pstr, $this->input->post("lastname"))) {
            $error["lastname"] = "Enter a real last name!";
            $error["count"] += 1;
        }

       // $error["confirmpassword"] = "";
        $plen = strlen($this->input->post("password"));
        if($plen > 32 || $plen < 6){
            $error["password"] = "Passwords must be between 6-32 characters!";
            $error["count"] += 1;
        }
        /* OLD confirm code 
		else if(strcmp($this->input->post("password"), $this->input->post("confirmpassword")) != 0) {
            $error["confirmpassword"] = "Passwords do not match!";
            $error["count"] += 1;
        }*/
		
		// error["gender"] = "";
		$pstr = "/^[mf]$/";
        if(!preg_match($pstr, $this->input->post("gender"))) {
            $error["gender"] = "Enter an approprate gender!";
            $error["count"] += 1;
        }
		
		return $error;
		
	}
	
	
	private function send_verification_mail($firstname, $lastname, $email, $password, $needtohash) {
		$this->load->model('accountmodel');
		
		$temp = $this->accountmodel->get_temp_account(
			$email,
			$this->accountmodel->password_hash($password)
		);
		if($needtohash==true){
			$verification_code = $this->accountmodel->verification_code(
				$email,
				$this->accountmodel->password_hash($password),
				$temp->verificationsent
			);
		}else{
			$verification_code = $this->accountmodel->verification_code(
				$email,
				$password,
				$temp->verificationsent
			);
		}
			
		$data['verification_url']=site_url('/account/verify').'/'.$temp->tuid.'/'.$verification_code;
		$html=$this->load->view('zbemail',$data,true);
		
		
        $to = $email;   
        $subject = 'Zingberry Signup | Verification';  
        $message = ' 


--zingboundary
Content-type: text/plain;charset=utf-8

Dear ' . $firstname . ' ' . $lastname . ',

Thank you for registering at www.zingberry.com. You may now log in using the following email and password after confirmation:

username: ' . $email . '
password: ' . $password . '

You may confirm by clicking on this link or copying and pasting it in your browser:

<a href="' . site_url('/account/verify') . '/'. $temp->tuid . '/' . $verification_code . '">' . site_url('/account/verify') . '/'. $temp->tuid . '/' . $verification_code . '</a>





-- The Zingberry team
--zingboundary
Content-type: text/html;charset=utf-8
'.$html.'


--zingboundary--
 
'; // Our message  
  		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: multipart/alternative;boundary=zingboundary; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:noreply@zingberry.com' . "\r\n"; // Set from headers  
        return mail($to, $subject, $message, $headers); // Send our email  
        
    }


	private function send_password_reset_mail($firstname, $lastname, $email, $password, $needtohash) {
		$this->load->model('accountmodel');
		
		$temp = $this->accountmodel->get_temp_account(
			$email,
			$this->accountmodel->password_hash($password)
		);
		if($needtohash==true){
			$verification_code = $this->accountmodel->verification_code(
				$email,
				$this->accountmodel->password_hash($password),
				$temp->verificationsent
			);
		}else{
			$verification_code = $this->accountmodel->verification_code(
				$email,
				$password,
				$temp->verificationsent
			);
		}
			
		$data['reset_url']=site_url('/account/passwordreset').'/'.$temp->tuid.'/'.$verification_code;
		$html=$this->load->view('zbemail',$data,true);
		
		
        $to = $email;   
        $subject = 'Zingberry Password Reset';  
        $message = ' 


--zingboundary
Content-type: text/plain;charset=utf-8

Dear ' . $firstname . ' ' . $lastname . ',

You can reset your password by clicking on this link or copying and pasting it in your browser:

<a href="' . $data['reset_url'] . '">' . $data['reset_url']. '</a>





-- The Zingberry team
--zingboundary--
 
'; // Our message  
  		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: multipart/alternative;boundary=zingboundary; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:noreply@zingberry.com' . "\r\n"; // Set from headers  
        return mail($to, $subject, $message, $headers); // Send our email  
        
    }
	
	private function verification_code($email,$password,$verificationsent) {
        $salt = "zing22";
        return hash("sha256", $password.$email.$verificationsent);
    }
	
		

}

?>
