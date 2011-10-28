<?php

class Accountmodel extends CI_Model{
	
	/*$tables = array(
		"nationalities" => array()
	);*/
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
	 
	 
	function get_user_pic($uid){
		$data = array(
			$uid
		);
		$query = $this->db->query("SELECT * FROM userimages WHERE uid=? LIMIT 1",$data);
		$result = $query->row_array();
		
		return $result;
	}
	
	function set_user_pic($image_path){
		$query = $this->db->query("DELETE FROM userimages WHERE uid=?",array($this->session->userdata('uid')));
		
		$data= array(
			$this->session->userdata('uid'),
			$image_path
		);
		
		$query = $this->db->query("INSERT INTO userimages (uid,filename,date_uploaded) VALUES (?,?,NOW())",$data);
		
		return $this->db->affected_rows();
	}
	 
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
	
	function update_static($reltable,$idfield, $idarray){
		$query = $this->db->query("DELETE FROM $reltable WHERE uid = ?",array($this->session->userdata('uid')));
		if($idarray[0]!=""){
			$nats = array();
			$vals = array();
			foreach($idarray as $i){
				array_push($nats,$this->session->userdata('uid'));
				array_push($nats, $i);
				array_push($vals,"( ?, ?)");
			}
			$query = $this->db->query("INSERT IGNORE INTO $reltable (uid,$idfield) VALUES ".implode(" , ",$vals),$nats);
		}
		
	}
	
	function update_new_single($table, $reltable,$idfield, $namefield, $namearray){
		$query = $this->db->query("DELETE FROM $reltable WHERE uid = ?",array($this->session->userdata('uid')));
		if($namearray!=""){
			$dormid = $this->db->query("SELECT $idfield FROM $table WHERE $namefield = ?",array($form[$table]));
			if($dormid->num_rows()>0){
				$dormid = $dormid->row_array();
				$dormid = $dormid[$idfield];
			}else{
				$query = $this->db->query("INSERT INTO $table ($namefield) VALUES (?)",array($form[$table]));	
				$dormid = $this->db->query("SELECT $idfield FROM $table WHERE $namefield = ?",array($form[$table]));
				$dormid = $dormid->row_array();
				$dormid = $dormid[$idfield];
			}
			$query = $this->db->query("INSERT IGNORE INTO $reltable (uid,$idfield) VALUES (?, ?)",array($this->session->userdata('uid'),$dormid));
		}
	}
	
	function update_new_multi($table, $reltable,$idfield, $name, $data){
		$query = $this->db->query("DELETE FROM $reltable WHERE uid = ?",array($this->session->userdata('uid')));
		if($data[0]!=""){
			foreach($data as $i){
				$query = $this->db->query("SELECT $idfield FROM $table WHERE $name = ?",array($i));
				if($query->num_rows()>0){
					$result = $query->row_array();
					$id = $result["$idfield"];
				}else{
					$query = $this->db->query("INSERT INTO $table ($name) VALUES (?)",array($i));	
					$query = $this->db->query("SELECT $idfield FROM $table WHERE $name = ?",array($i));
					$result = $query->row_array();
					$id = $result["$idfield"];
				}
				$query = $this->db->query("INSERT IGNORE INTO $reltable (uid,$idfield) VALUES (?, ?)",array($this->session->userdata('uid'),$id));	
			}
		}
	}
	
	function update_organizations($form){
		Accountmodel::update_new_multi("organizations","is_member_of_organization","oid","name",$form['organizations']);
		Accountmodel::update_new_multi("greeks","is_member_of_greek","greek_id","name",$form['greeks']);
		Accountmodel::update_new_multi("workplaces","works_at","wid","name",$form['workplaces']);
	}
	
	function update_interests($form){
		Accountmodel::update_new_multi("favorite_music_artists","has_favorite_music_artist","artist_id","artist_name",$form['favorite_music_artists']);
		Accountmodel::update_new_multi("favorite_heroes","has_favorite_hero","fhid","name",$form['favorite_heroes']);
		Accountmodel::update_new_multi("favorite_movies","has_favorite_movie","movie_id","movie_title",$form['favorite_movies']);
		Accountmodel::update_new_multi("favorite_tvshows","has_favorite_tvshow","tvshow_id","tvshow_title",$form['favorite_tvshows']);
		Accountmodel::update_new_multi("favorite_sports_teams","has_favorite_sports_team","team_id","team_name",$form['favorite_sports_teams']);
		Accountmodel::update_new_multi("favorite_video_games","has_favorite_video_game","video_game_id","video_game_title",$form['favorite_video_games']);
		Accountmodel::update_new_multi("favorite_books","has_favorite_book","book_id","book_title",$form['favorite_books']);
		Accountmodel::update_new_multi("favorite_foods","has_favorite_food","ffid","name",$form['favorite_foods']);
	}
	
	function update_personal_info($form){
		if($form['nationalities'][0]!=""){
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
		}
		
		//print_r($form['languages']);
		if($form['languages'][0]!=""){
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
		}
		
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
	
	
	function update_academics($form){

		$query = $this->db->query("DELETE FROM is_taking_course WHERE uid = ?",array($this->session->userdata('uid')));
		if($form['courses'][0]!=""){
			foreach($form['courses'] as $i){
				$query = $this->db->query("SELECT courseid FROM courses WHERE course_name = ?",array($i));
				if($query->num_rows()>0){
					$result = $query->row_array();
					$id = $result['courseid'];
				}else{
					$query = $this->db->query("INSERT INTO courses (course_name) VALUES (?)",array($i));	
					$query = $this->db->query("SELECT courseid FROM courses WHERE course_name = ?",array($i));
					$result = $query->row_array();
					$id = $result['courseid'];
				}
				$query = $this->db->query("INSERT IGNORE INTO is_taking_course (uid,courseid) VALUES (?, ?)",array($this->session->userdata('uid'),$id));	
			}
		}
		
		
		$query = $this->db->query("DELETE FROM has_major WHERE uid = ?",array($this->session->userdata('uid')));
		if($form['majors'][0]!=""){
			$langs = array();
			$vals = array();
			foreach($form['majors'] as $i){
				array_push($langs,$this->session->userdata('uid'));
				array_push($langs, $i);
				array_push($vals,"( ?, ?)");
			}
			$query = $this->db->query("INSERT IGNORE INTO has_major (uid,mid) VALUES ".implode(" , ",$vals),$langs);
		}
		
		
		
		
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
	
	function get_academics($uid){
			$data = array( $uid );
			$query = $this->db->query(
				"SELECT courses.courseid, courses.course_name
				 FROM courses, is_taking_course
				 WHERE courses.courseid=is_taking_course.courseid
				 	AND is_taking_course.uid=?",
			$data);
			$courses = $query->result_array();
			
			$query = $this->db->query(
				"SELECT majors.mid, majors.major 
				 FROM majors,has_major 
				 WHERE majors.mid=has_major.mid 
					AND has_major.uid=?",
			$data);
			$majors = $query->result_array();
			
			
			$result = array(
				"courses" => $courses,
				"majors" => $majors
			);
			
			return $result;
				
	}
	
	function get_organizations($uid){
			$data = array( $uid );
			$query = $this->db->query(
				"SELECT organizations.oid, organizations.name
				 FROM organizations, is_member_of_organization
				 WHERE organizations.oid=is_member_of_organization.oid
				 	AND is_member_of_organization.uid=?",
			$data);
			$organizations = $query->result_array();
			
			$query = $this->db->query(
				"SELECT workplaces.wid, workplaces.name 
				 FROM workplaces,works_at 
				 WHERE workplaces.wid=works_at.wid 
					AND works_at.uid=?",
			$data);
			$workplaces = $query->result_array();
			
			$query = $this->db->query(
				"SELECT greeks.greek_id, greeks.name 
				 FROM greeks,is_member_of_greek 
				 WHERE greeks.greek_id=is_member_of_greek.greek_id 
					AND is_member_of_greek.uid=?",
			$data);
			$greeks = $query->result_array();
			
			
			$result = array(
				"organizations" => $organizations,
				"workplaces" => $workplaces,
				"greeks" => $greeks
			);
			
			return $result;
				
	}
	
	function get_relations($table,$reltable,$id,$name,$uid){
		$data = array($uid);
		$query = $this->db->query(
			"SELECT $table.$id, $table.$name
			 FROM $table, $reltable
			 WHERE $table.$id=$reltable.$id
				AND $reltable.uid=?",
		$data);
		return $query->result_array();
	}
	
	function get_relations_values($table,$reltable,$id,$name,$uid){
		$data = array($uid);
		$query = $this->db->query(
			"SELECT $table.$name
			 FROM $table, $reltable
			 WHERE $table.$id=$reltable.$id
				AND $reltable.uid=?",
		$data);
		$result = $query->result_array();
		
		$values = array();
		
		foreach($result as $i){
			array_push($values, $i["$name"]);
		}
		
		return $values;
	}
	function get_interests($uid){
		$result = array(
			"favorite_music_artists" => Accountmodel::get_relations("favorite_music_artists","has_favorite_music_artist","artist_id","artist_name",$uid),
			"favorite_heroes" => Accountmodel::get_relations("favorite_heroes","has_favorite_hero","fhid","name",$uid),
			"favorite_movies" => Accountmodel::get_relations("favorite_movies","has_favorite_movie","movie_id","movie_title",$uid),
			"favorite_tvshows" => Accountmodel::get_relations("favorite_tvshows","has_favorite_tvshow","tvshow_id","tvshow_title",$uid),
			"favorite_sports_teams" => Accountmodel::get_relations("favorite_sports_teams","has_favorite_sports_team","team_id","team_name",$uid),
			"favorite_video_games" => Accountmodel::get_relations("favorite_video_games","has_favorite_video_game","video_game_id","video_game_title",$uid),
			"favorite_books" => Accountmodel::get_relations("favorite_books","has_favorite_book","book_id","book_title",$uid),
			"favorite_foods" => Accountmodel::get_relations("favorite_foods","has_favorite_food","ffid","name",$uid)
		);
		
		return $result;
				
	}
	
	
	function get_profile_by_uid($uid){
		$result = array(
			"favorite_music_artists" => Accountmodel::get_relations_values("favorite_music_artists","has_favorite_music_artist","artist_id","artist_name",$uid),
			"favorite_heroes" => Accountmodel::get_relations_values("favorite_heroes","has_favorite_hero","fhid","name",$uid),
			"favorite_movies" => Accountmodel::get_relations_values("favorite_movies","has_favorite_movie","movie_id","movie_title",$uid),
			"favorite_tvshows" => Accountmodel::get_relations_values("favorite_tvshows","has_favorite_tvshow","tvshow_id","tvshow_title",$uid),
			"favorite_sports_teams" => Accountmodel::get_relations_values("favorite_sports_teams","has_favorite_sports_team","team_id","team_name",$uid),
			"favorite_video_games" => Accountmodel::get_relations_values("favorite_video_games","has_favorite_video_game","video_game_id","video_game_title",$uid),
			"favorite_books" => Accountmodel::get_relations_values("favorite_books","has_favorite_book","book_id","book_title",$uid),
			"favorite_foods" => Accountmodel::get_relations_values("favorite_foods","has_favorite_food","ffid","name",$uid),
			
			"organizations" => Accountmodel::get_relations_values("organizations","is_member_of_organization","oid","name",$uid),
			"workplaces" => Accountmodel::get_relations_values("workplaces","works_at","wid","name",$uid),
			"greeks" => Accountmodel::get_relations_values("greeks","is_member_of_greek","greek_id","name",$uid),
			
			"courses" => Accountmodel::get_relations_values("courses","is_taking_course","courseid","course_name",$uid),
			"majors" => Accountmodel::get_relations_values("majors","has_major","mid","major",$uid),
			
			"highschool" => Accountmodel::get_relations_values("highschool","has_highschool","hid","name",$uid),
			"languages" => Accountmodel::get_relations_values("languages","speaks_language","langid","language",$uid),
			"nationalities" => Accountmodel::get_relations_values("nationalities","has_nationality","nid","nationality",$uid),
			
			"user" => Accountmodel::get_account_by_uid($uid),
			
			"pic" => Accountmodel::get_user_pic($uid)
		);
		
		
		
		return $result;
	}
	
	function get_random_uids($limit){
		$data = array(
			$limit
		);
		$query = $this->db->query("SELECT uid FROM users WHERE uid >= (SELECT FLOOR( MAX(uid) * RAND()) FROM users ) ORDER BY uid LIMIT ?",$data);
		
		$result = array();
		foreach($query->result_array() as $i){
			array_push($result, $i['uid']);
		}
		
		return $result;
	}
	
}

?>