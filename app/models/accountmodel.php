<?php

class Accountmodel extends CI_Model{
	

/*    public function __construct($in = array(
        "first_name" => "", 
        "last_name" => "", 
        "email" => "",
        "verified" => "",
        "verification_code" => "",
        "password" => "", 
        "confirm_password" => ""
    )) {
        $this->data = array();
        foreach($in as $k => $v){
            $this->data[$k] = $v;
        }
        return;
    }
	
	function is_attending(){
		$query = $this->db->query("");
		return $query->result();
	}*/
	
	

	
	/*	
	 *	Summary: 	used to get data on a user
	 *	
	 *	Parameters: email address, and an already hashed password
	 * 	Returns:	returns an array of all the data on a user
	 */
	 
	function get_account($email, $password){
		$this->load->database();
		$data = array(
			$email,
			$password
		);
		$query = $this->db->query('SELECT * from users WHERE email = ? , password = ? LIMIT 1', $data);
		
		return $query->row();
		
	}
	
	/*	
	 *	Summary: 	used to get data on a user
	 *	
	 *	Parameters: user id number
	 * 	Returns:	returns an array of all the data on a user
	 */
	 
	function get_account_by_uid($uid){
		$this->load->database();
		$data = array(
			$uid
		);
		$query = $this->db->query('SELECT * from users WHERE uid = ? LIMIT 1', $data);
		
		return $query->row_array();
		
	}
	function get_temp_account($email, $password){	
		$this->load->database();
		$data = array(
			$email,
			$password
		);
		$query = $this->db->query('SELECT * from tempusers WHERE email = ? AND password = ? LIMIT 1', $data);
		
		return $query->row();
		
	}
	
	function get_temp_account_by_tuid($tuid){	
		$this->load->database();
		$data = array(
			$tuid
		);
		$query = $this->db->query('SELECT * from tempusers WHERE tuid = ? LIMIT 1', $data);
		
		return $query->row_array();
		
	}
	
	function get_temp_accounts(){	
		$this->load->database();
		$query = $this->db->query('SELECT * from tempusers ');
		
		return $query->result_array();
		
	}
	
	function purge_temp_accounts($email){	
		$this->load->database();
		$data = array(
			$email
		);
		$query = $this->db->query('DELETE FROM tempusers WHERE email = ? ', $data);
		
		return $query;
		
	}
	
	function login(){
		$this->load->database();
		$data = array(
			$this->input->post('email',TRUE),
			Accountmodel::password_hash($this->input->post('password'))
		);
		$user = $this->db->query('SELECT * from users WHERE email = ? AND password = ?  LIMIT 1', $data);
		
		$data = array(
			$this->input->ip_address(),
			$this->input->post('email',TRUE),
			Accountmodel::password_hash($this->input->post('password'))
		);
		$query = $this->db->query('UPDATE users SET logincount=logincount+1, lastip = ?, lastlogin = NOW(), badattemptcount=0 WHERE email = ? AND password = ?  LIMIT 1', $data);
		
		return $user->row_array();
	
	}
	
	function bad_login(){
		$this->load->database();
		$data = array(
			$this->input->post('email')
		);
		$user = $this->db->query('SELECT * from users WHERE email = ?  LIMIT 1', $data);
		$row = $user->row_array();
		
		if(isset($row['badattemptcount']) && $row['badattemptcount'] > 5){}
		
		$data = array(
			$this->input->ip_address(),
			$this->input->post('email')
		);
		$query = $this->db->query('UPDATE users SET badattemptcount=badattemptcount+1, lastbadip = ?, lastbadattempt = NOW() WHERE email = ?  LIMIT 1', $data);
		
		//return $error;
		
		 
	
	}
	
	function register(){
		$this->load->database();
		$str = "
            INSERT INTO `tempusers` 
            (
		   		`firstname`,
				`lastname`,
				`gender`,
				`class`,
				`email`,
				`password`,
				`lastip`,
				`verificationsent`
			) VALUES (
                ? , 
                ? ,
                ? , 
                ? , 
                ? , 
                ? , 
                ? , 
                NOW()
            );
        ";
		
		$name = $this->input->post('name',TRUE);
		$name = explode(" ",$name,2);
		$firstname = $name[0];
		if(count($name)==2)
			$lastname = $name[1];
		else
			$lastname = "";
		
		$data = array(
			$firstname,
			$lastname,
			$this->input->post('lastname',TRUE),
			$this->input->post('gender',TRUE),
			$this->input->post('class',TRUE),
			$this->input->post('email',TRUE),
			Accountmodel::password_hash($this->input->post('password')),
			$this->input->ip_address()
			
		);
		$query = $this->db->query($str, $data);
		
		return $this->db->affected_rows();
	}
	
	function verify($temp){
		//$temp = Accountmodel::get_temp_account_by_tuid($tuid);
		
		$str = "
            INSERT INTO `users` 
            (
		   		`firstname`,
				`lastname`,
				`gender`,
				`class`,
				`email`,
				`password`,
				`membersince`,
				`lastip`
			) VALUES (
                ? , 
                ? ,
                ? , 
                ? , 
                ? , 
                ? , 
                NOW() , 
                ?
            );
        ";
		$data = array(
			$temp['firstname'],
			$temp['lastname'],
			$temp['gender'],
			$temp['class'],
			$temp['email'],
			$temp['password'],
			$this->input->ip_address()
			
		);
		$query = $this->db->query($str, $data);
		
		Accountmodel::purge_temp_accounts($temp['email']);
		
		//return $this->db->affected_rows();
		
	}
	
	
	function is_unregistered(){
		$this->load->database();
		$query = $this->db->query('SELECT * from tempusers WHERE email = ? AND password = ?  LIMIT 1', array($this->input->post('email'),Accountmodel::password_hash($this->input->post('password'))));
		
		if($query->row())
			return true;
		return false;
	}
	
	function is_registered(){
		$this->load->database();
		$query = $this->db->query('SELECT * from users WHERE email = ? LIMIT 1', array($this->input->post('email')));
		
		if($query->row())
			return true;
		return false;
	}
	
	function password_hash($password) {
        $salt = "zing22";
        return hash("sha512", $password.$salt);
    }
	
	function verification_code($email,$password,$verificationsent) {
        $salt = "zing22";
        return hash("sha256", $password.$email.$verificationsent);
    }
	
	function numusers(){
		$this->load->database();
		$query = $this->db->query('SELECT count(*) as numusers from users ');
		
		return $query->row_array();
		
	}
	
	function numtempusers(){
		$this->load->database();
		$query = $this->db->query('SELECT count(*) as numusers from tempusers ');
		
		return $query->row_array();
		
	}
	
	
	function json_token($table, $id, $name, $term){
		$data = array(
			"%".$term."%"
		);
		
		$query = $this->db->query("SELECT * FROM $table WHERE $name LIKE ?",$data);
		$query = $query->result_array();
		$stuff = array();
		foreach($query as $i){
			array_push($stuff,	
				array(
					"id" => $i[$id],
					"name" => $i[$name]
				)
			);
		}
		return json_encode($stuff);
	}
	
	function update_personal_info($form){
		
		$query = $this->db->query("DELETE FROM has_nationality WHERE uid = ?",array($this->session->userdata('uid')));
		$nats = array();
		$vals = array();
		foreach($form['nationalities'] as $i){
			array_push($nats,$this->session->userdata('uid'));
			array_push($nats, $i);
			array_push($vals,"( ?, ?)");
		}
		$query = $this->db->query("INSERT IGNORE INTO has_nationality (uid,nid) VALUES ".implode(" , ",$vals),$nats);
		//return $this->db->affected_rows();
		
		$query = $this->db->query("DELETE FROM speaks_language WHERE uid = ?",array($this->session->userdata('uid')));
		$langs = array();
		$vals = array();
		foreach($form['languages'] as $i){
			array_push($langs,$this->session->userdata('uid'));
			array_push($langs, $i);
			array_push($vals,"( ?, ?)");
		}
		$query = $this->db->query("INSERT IGNORE INTO speaks_language (uid,langid) VALUES ".implode(" , ",$vals),$langs);
		//return $this->db->affected_rows();
		
		$query = $this->db->query("DELETE FROM has_dorm WHERE uid = ?",array($this->session->userdata('uid')));
		if($form['dorm']!=""){
			$dormid = $this->db->query("SELECT dormid FROM dorms WHERE name = ?",array($form['dorm']));
			if($dormid->num_rows()>0){
				$dormid = $dormid->row_array();
				$dormid = $dormid['dormid'];
			}else{
				$query = $this->db->query("INSERT INTO dorms (name) VALUES (?)",array($form['dorm']));	
				$dormid = $this->db->query("SELECT dormid FROM dorms WHERE name = ?",array($form['dorm']));
				$dormid = $dormid->row_array();
				$dormid = $dormid['dormid'];
			}
			$query = $this->db->query("INSERT IGNORE INTO has_dorm (uid,dormid) VALUES (?, ?)",array($this->session->userdata('uid'),$dormid));	
		}
		
		
		$query = $this->db->query("DELETE FROM has_highschool WHERE uid = ?",array($this->session->userdata('uid')));
		if($form['highschool']!=""){
			$dormid = $this->db->query("SELECT hid FROM highschool WHERE name = ?",array($form['highschool']));
			if($dormid->num_rows()>0){
				$dormid = $dormid->row_array();
				$dormid = $dormid['hid'];
			}else{
				$query = $this->db->query("INSERT INTO highschool (name) VALUES (?)",array($form['highschool']));	
				$dormid = $this->db->query("SELECT hid FROM highschool WHERE name = ?",array($form['highschool']));
				$dormid = $dormid->row_array();
				$dormid = $dormid['hid'];
			}
			$query = $this->db->query("INSERT IGNORE INTO has_highschool (uid,hid) VALUES (?, ?)",array($this->session->userdata('uid'),$dormid));
		}
		
		
		
		$update = array(
			$form['firstname'],
			$form['lastname'],
			$form['gender'],
			$form['interested_in'],
			$form['relationship_status'],
			$form['class_year'],
			$form['religious_views'],
			$form['political_views'],
			$this->session->userdata('uid')
		);
		$result = $this->db->query("UPDATE users SET firstname=?, lastname=?, gender=?, interested_in=?, relationship_status=?, class=?, religious_views=?, political_views=? WHERE uid = ?",$update);
		
		
	}
	
	function get_personal_info($uid){
			$data = array( $uid );
			$query = $this->db->query(
				"SELECT dorms.dormid, dorms.name 
				 FROM dorms,has_dorm 
				 WHERE dorms.dormid=has_dorm.dormid 
					AND has_dorm.uid=?",
			$data);
			$dorm = $query->row_array();
			
			$query = $this->db->query(
				"SELECT highschool.hid, highschool.name 
				 FROM highschool,has_highschool 
				 WHERE highschool.hid=has_highschool.hid 
					AND has_highschool.uid=?",
			$data);
			$highschool = $query->row_array();
			
			$query = $this->db->query(
				"SELECT languages.langid, languages.language 
				 FROM languages,speaks_language 
				 WHERE languages.langid = speaks_language.langid 
					AND speaks_language.uid=?",
			$data);
			$languages = $query->result_array();
			
			$query = $this->db->query(
				"SELECT nationalities.nid, nationalities.nationality 
				 FROM nationalities,has_nationality 
				 WHERE nationalities.nid = has_nationality.nid 
					AND has_nationality.uid=?",
			$data);
			$nationalities = $query->result_array();
			
			$user = Accountmodel::get_account_by_uid($uid);
			
			$result = array(
				"dorm" => $dorm,
				"highschool" => $highschool,
				"languages" => $languages,
				"nationalities" => $nationalities,
				"user" => $user
			);
			
			return $result;
				
	}
	
}

?>