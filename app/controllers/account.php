<?php

class Account extends CI_Controller {
	
/*	function Account(){
		
		parent::CI_Controller();
	}*/
	

	
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
		
		$this->load->model('accountmodel');
		if($this->input->post("organizations_update")){
			//echo print_r($this->input->post());
			//$update = $this->input->post();
			$update = array();
			$update['organizations'] = explode(",",$this->input->post("organizations"));
			$update['greeks'] = explode(",",$this->input->post("greeks"));
			$update['workplaces'] = explode(",",$this->input->post("workplaces"));
			//echo print_r($update);
			$this->accountmodel->update_organizations($update);
			
			
		}
		
		$stuff = $this->accountmodel->get_organizations($this->session->userdata('uid'));
		$data["user"] = array();
		
		$data["user"]["organizations"] = Account::result_to_token($stuff['organizations'],"oid","name");
		$data["user"]["greeks"] = Account::result_to_token($stuff['greeks'],"greek_id","name");
		$data["user"]["workplaces"] = Account::result_to_token($stuff['workplaces'],"wid","name");
		
		$this->load->view('zb-two-organizations',$data);	
	}

	
	function academics(){
		Account::is_logged_in();
		
		
		$this->load->model('accountmodel');
		if($this->input->post("academics_update")){
			//echo print_r($this->input->post());
			//$update = $this->input->post();
			$update = array();
			$update['majors'] = explode(",",$this->input->post("majors"));
			$update['courses'] = explode(",",$this->input->post("courses"));
			//echo print_r($update);
			$this->accountmodel->update_academics($update);
			
			
		}
		
		$stuff = $this->accountmodel->get_academics($this->session->userdata('uid'));
		$data["user"] = array();
		
		$data["user"]["courses"] = Account::result_to_token($stuff['courses'],"courseid","course_name");
		$data["user"]["majors"] = Account::result_to_token($stuff['majors'],"mid","major");
		
		
		//print_r($data);
		$this->load->view('zb-two-academics',$data);	
	}
	
	function interests(){
		Account::is_logged_in();
		
		$this->load->model('accountmodel');
		if($this->input->post("interests_update")){
			//echo print_r($this->input->post());
			//$update = $this->input->post();
			$update = array();
			$update['favorite_music_artists'] = explode(",",$this->input->post("favorite_music_artists"));
			$update['favorite_heroes'] = explode(",",$this->input->post("favorite_heroes"));
			$update['favorite_movies'] = explode(",",$this->input->post("favorite_movies"));
			$update['favorite_tvshows'] = explode(",",$this->input->post("favorite_tvshows"));
			$update['favorite_sports_teams'] = explode(",",$this->input->post("favorite_sports_teams"));
			$update['favorite_video_games'] = explode(",",$this->input->post("favorite_video_games"));
			$update['favorite_books'] = explode(",",$this->input->post("favorite_books"));
			$update['favorite_foods'] = explode(",",$this->input->post("favorite_foods"));
			//echo print_r($update);
			$this->accountmodel->update_interests($update);
			
			
		}
		
		$stuff = $this->accountmodel->get_interests($this->session->userdata('uid'));
		
		$data["user"] = array();
		
		$data["user"]["favorite_music_artists"] = Account::result_to_token($stuff['favorite_music_artists'],"artist_id","artist_name");
		$data["user"]["favorite_heroes"] = Account::result_to_token($stuff['favorite_heroes'],"fhid","name");
		$data["user"]["favorite_movies"] = Account::result_to_token($stuff['favorite_movies'],"movie_id","movie_title");
		$data["user"]["favorite_tvshows"] = Account::result_to_token($stuff['favorite_tvshows'],"tvshow_id","tvshow_title");
		$data["user"]["favorite_sports_teams"] = Account::result_to_token($stuff['favorite_sports_teams'],"team_id","team_name");
		$data["user"]["favorite_video_games"] = Account::result_to_token($stuff['favorite_video_games'],"video_game_id","video_game_title");
		$data["user"]["favorite_books"] = Account::result_to_token($stuff['favorite_books'],"book_id","book_title");
		$data["user"]["favorite_foods"] = Account::result_to_token($stuff['favorite_foods'],"ffid","name");
		
		
		//print_r($data);
		
		$this->load->view('zb-two-interests',$data);	
	}
	
	private function crop_pic($x,$y,$w,$h,$source,$dest){
		
		
	}
	
	private function resize_pic($w,$h,$source,$dest){
		$this->load->library('image_lib');
		
		$resize['image_library'] = 'gd2';
		$resize['source_image'] = $source;
		$resize['new_image'] =  $dest;
		$resize['width']  = $w;
		$resize['height'] = $h;
		
		$this->image_lib->initialize($resize); 
		$this->image_lib->resize();
		
		
		echo $this->image_lib->display_errors();
		
	}
	
	private function crop_and_resize_pic($x,$y,$w,$h,$source,$dest){
		$this->load->library('image_lib');
				
		$crop['image_library'] = 'gd2';
		$crop['source_image']	= $source;
		$crop['new_image']	= $dest;
		//$image['create_thumb'] = TRUE;
		$crop['maintain_ratio'] = FALSE;
		$crop['x_axis'] = $x;
		$crop['y_axis'] = $y;
		$crop['width']	 = $w;
		$crop['height'] = $h;
		
		$this->image_lib->initialize($crop); 
		$this->image_lib->crop();
		
		echo $this->image_lib->display_errors();
		
		$this->image_lib->clear();
		
		$resize['image_library'] = 'gd2';
		$resize['source_image'] = $dest;
		$resize['new_image'] =  $dest;
		$resize['width']  = '133';
		$resize['height'] = '133';
		
		$this->image_lib->initialize($resize); 
		$this->image_lib->resize();
		
		echo $this->image_lib->display_errors();
		
	}
	
	function picture(){
		Account::is_logged_in();
		
		$this->load->model('accountmodel');
		
		$upload_folder = './user_images/';
		
		$data = array(
			"thumb_width" => 133,
			"thumb_height" => 133,
			"upload_folder" => $upload_folder,
			"thumb" => false
		);
		
		
		if($this->input->post('upload')){
			
			
			
			$config['upload_path'] = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['file_name'] = $this->session->userdata('uid').'_'.time();
			/*$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';*/
	
			$this->load->library('upload', $config);
			
	
			if ( ! $this->upload->do_upload()){
				$data['upload_error'] = $this->upload->display_errors();
				$this->load->view('zb-two-picture', $data);
				return;
			}else{
				$data['upload_data'] = $this->upload->data();
				
				Account::resize_pic('450','450',
					$upload_folder.$data['upload_data']['file_name'],
					$upload_folder.$data['upload_data']['file_name']
				);
				
				$userimage = $this->accountmodel->get_user_pic($this->session->userdata('uid'));
				if($userimage!=NULL){
					if(file_exists($upload_folder.$userimage['filename']))
						unlink($upload_folder.$userimage['filename']);
					if(file_exists($upload_folder."thumb_".$userimage['filename']))
					unlink($upload_folder."thumb_".$userimage['filename']);
				}
				
				$this->accountmodel->set_user_pic($data['upload_data']['file_name']);
			}
			
		}else if($this->input->post('upload_thumbnail')){
			
			$userimage = $this->accountmodel->get_user_pic($this->session->userdata('uid'));
			if($userimage!=NULL){
				Account::crop_and_resize_pic(
					$this->input->post('x'),
					$this->input->post('y'),
					$this->input->post('w'),
					$this->input->post('h'),
					$upload_folder.$userimage['filename'],
					$upload_folder."thumb_".$userimage['filename']
				);
				
			}

		}
			
		$userimage = $this->accountmodel->get_user_pic($this->session->userdata('uid'));
		if($userimage!=NULL){
			$size = getimagesize($upload_folder.$userimage['filename']);
			
			if(file_exists($upload_folder."thumb_".$userimage['filename']))
				$data['thumb'] = true;
			$data['thumb_image'] = "thumb_".$userimage['filename'];
			$data['large_image'] = $userimage['filename'];
			$data['large_width'] = $size[0];
			$data['large_height'] = $size[1];
			$this->load->view('zb-two-picture',$data);	
		}else{
			$this->load->view('zb-two-picture');
		}
		
		
		/*
		
		
		$image['image_library'] = 'gd2';
		$image['source_image']	= '/path/to/image/mypic.jpg';
		$image['create_thumb'] = TRUE;
		$image['maintain_ratio'] = TRUE;
		$image['x_axis'] = '100';
		$image['y_axis'] = '40';
		$image['width']	 = 133;
		$image['height'] = 133;
		
		$this->load->library('image_lib', $image); 
		
		$this->image_lib->crop();*/
		
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
				case 'favorite_heroes':
					echo $this->accountmodel->json_token("favorite_heroes","fhid","name",$this->input->post("q"));
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
				case 'workplaces':
					echo $this->accountmodel->json_token("workplaces","wid","name",$this->input->post("q"));
					break;
				default:
					echo json_encode(array());	
					break;
			}
		}
		
	}
	
		
	private function result_to_token($row,$id,$name){
		$token = array();
		foreach($row as $i){
			array_push($token,	
				array(
					"id" => $i["$id"],
					"name" => $i["$name"]
				)
			);
		}
		return json_encode($token);
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
		
		$data["user"]["languages"] = Account::result_to_token($stuff['languages'],"langid","language");
		$data["user"]["nationalities"] = Account::result_to_token($stuff['nationalities'],"nid","nationality");
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
					'lastname'=>$user['lastname']
				);
				$this->session->set_userdata($userdata);
				if($user['logincount']==0)
					redirect('zing/tutorial','location');
				else
					redirect('browse/initial','location');
			}else if ($this->input->post('email') == ""){
				$data = Account::account_forms();
				$data['login_errors'] = 'Please enter your email and password.';
				$this->load->view('zb-two-login',$data);
			}else if ($user = $this->accountmodel->is_unregistered()){
				$data = Account::account_forms();
				$data['login_errors'] = 'You still havent verified your email address. Please check your email and click the verification link.';
				$this->load->view('zb-two-login',$data);
			}else{
				$this->accountmodel->bad_login();
				$data = Account::account_forms();
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
	
	function forgotpassword($code = NULL){
		$this->load->model('accountmodel');
		if(($code != NULL) && ($this->input->post("email"))){
			$errors = array();
			if($this->input->post("password") != $this->input->post("password")){
				array_push($errors,"Passwords do not match");
			} else {
				$success = $this->accountmodel->reset_password($this->input->post("email"), $this->input->post("password"), $code);
				
				if(!$success){
					array_push($errors,"Your code doesnt match your email address. Please try submitting the forgot password request again.");
					$this->load->view("zb-two-forgot-password-change",array("errors"=>$errors));
					return;
				} else {
					$this->load->view("zb-two-forgot-password-success");
					return;
				}
				
				
			}
			$this->load->view("zb-two-forgot-password-change",array("errors"=>$errors));
			

		} else if(($code != NULL) && !($this->input->post("email"))) {
			$this->load->view("zb-two-forgot-password-change");
		} else if($this->input->post("email")){
			$result = $this->accountmodel->set_forgot_password($this->input->post("email"));
			if($result != false){
				//echo $result['reset_code'];	
				Account::send_password_reset_mail($result['uid'], $result['reset_code']);
				
			}
			$this->load->view("zb-two-forgot-password-sent");
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
		if(count($errors) > 0){
			$data=Account::account_forms();
			$data['register_errors']=$errors;
			$this->load->view('zb-two-login',$data);
		}else{
			$this->load->model('accountmodel');
			$this->accountmodel->register();
			Account::send_verification_mail($this->input->post('name'),$this->input->post('email'),$this->input->post('password'),true);
			$data = Account::account_forms();
			$data['email'] = $this->input->post('email');
			$this->load->view('zb-two-register-sent',$data);
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
			$this->load->view('zb-two-register-success',$data);
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
	
	private function password($data){
		$this->load->model('accountmodel');
		echo $this->accountmodel->password_hash($data);
	}
	
	private function register_errors(){
		$error = array();
       // $error["count"] = 0;

        //$error["email"] = "";
        $eden = "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@eden.rutgers.edu$/";
		$scarlet = "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@scarletmail.rutgers.edu$/";
		$general = "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@rutgers.edu$/";
		$all = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		
		$email = $this->input->post('email');
		
		if(!preg_match($eden , $email) && !preg_match($scarlet , $email) && !preg_match($general, $email)) {
        //if(!preg_match($all , $this->input->post('email'))) {
            $error["email"] = 'You must enter a valid Rutgers student email! (*@eden.rutgers.edu or *@scarletmail.rutgers.edu)';
            //$error["count"] += 1;
        }
        else {
			$this->load->model('accountmodel');
			if($this->accountmodel->is_registered()){
				$error["email"] = "This user already exists!";
                //$error["count"] += 1;
			} 
        }

        $pstr = "/\b[a-z A-Z]+\b/";
        if(!preg_match($pstr, $this->input->post("name"))) {
            $error["name"] = "Enter a real name!";
            //$error["count"] += 1;
        }

        $plen = strlen($this->input->post("password"));
        if($plen > 32 || $plen < 6){
            $error["password"] = "Password must be between 6-32 characters!";
            //$error["count"] += 1;
        }
		
		return $error;
		
	}
	
	
	private function send_verification_mail($name, $email, $password, $needtohash) {
		$this->load->model('accountmodel');
		
		if($needtohash)
			$password = $this->accountmodel->password_hash($password);
		
		$temp = $this->accountmodel->get_temp_account(
			$email,
			$password
		);
		
		$verification_code = $this->accountmodel->verification_code(
			$email,
			$password,
			$temp['verificationsent']
		);
		
			
		$data['verification_url']=site_url('/account/verify').'/'.$temp['tuid'].'/'.$verification_code;
		$html=$this->load->view('zbemail',$data,true);
		
		
        $to = $email;   
        $subject = 'Zingberry Signup | Verification';  
        $message = ' 


--zingboundary
Content-type: text/plain;charset=utf-8

Dear ' . $name . ',

Thank you for registering at www.zingberry.com. You may now log in using the following email and password after confirmation:

username: ' . $email . '
password: ' . $password . '

You may confirm by clicking on this link or copying and pasting it in your browser:

' . site_url('/account/verify') . '/'. $temp['tuid'] . '/' . $verification_code . '





-- The Zingberry team
--zingboundary
Content-type: text/html;charset=utf-8
'.$html.'


--zingboundary--
 
'; // Our message  
  		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: multipart/alternative;boundary=zingboundary; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:"Zingberry" <noreply@zingberry.com>' . "\r\n"; // Set from headers  
        return mail($to, $subject, $message, $headers); // Send our email  
        
    }


	private function send_password_reset_mail($uid, $reset_code) {
		$this->load->model('accountmodel');
		
		$user = $this->accountmodel->get_account_by_uid($uid);
			
		$data['reset_url']=site_url('/account/forgotpassword').'/'.$reset_code;
		//$html=$this->load->view('zbemail',$data,true);
		
		
        $to = $user['email'];   
        $subject = 'Zingberry Password Reset';  
        $message = ' 


--zingboundary
Content-type: text/plain;charset=utf-8

Dear ' . $user['firstname'] . ' ' . $user['lastname'] . ',

You can reset your password by clicking on this link or copying and pasting it in your browser:

' . $data['reset_url']. '





-- The Zingberry team
--zingboundary--
 
'; // Our message  
  		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-Type: multipart/alternative;boundary=zingboundary; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:"Zingberry" <noreply@zingberry.com>' . "\r\n"; // Set from headers  
        return mail($to, $subject, $message, $headers); // Send our email  
        
    }
	
	private function verification_code($email,$password,$verificationsent) {
        $salt = "zing22";
        return hash("sha256", $password.$email.$verificationsent);
    }
	
		

}

?>
