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
	
	

	
	 
	function set_forgot_password($email){
		$query = $this->db->query("SELECT * FROM users WHERE email=?",array($email));
		
		if($query->num_rows() == 0)
			return false;
			
		$row = $query->row_array();
		
		//print_r($row);
		
		$reset_code = sha1($row['email'].time().$row['password']);
		$query = $this->db->query("UPDATE users SET password_reset_code=? WHERE uid=? LIMIT 1", array($reset_code,$row['uid']));
		
		/*if($this->db->affected_rows()!=1)
			return false;*/
		
		return array(
				"uid" => $row['uid'],
				"reset_code" => $reset_code
				);
		
	}

	/*****************************************
	 *	reset_password (should be reset_forgot_password)
	 *	- takes in reset code, email, and new password
	 *  - resets users password accordingly
	 */
	
	function reset_password($email, $password, $reset_code){
		$query = $this->db->query("SELECT uid FROM users WHERE email=? AND password_reset_code=? LIMIT 1",array($email,$reset_code));
		
		if($query->num_rows() == 0) //if the user doesnt exist, return false
			return false;
		
		$row = $query->row_array();
		$pass = Accountmodel::password_hash($password);
		$query = $this->db->query("UPDATE users SET password=?, password_reset_code=NULL WHERE uid=?",array($pass,$row['uid']));
		
		if($this->db->affected_rows()!=1) // is the password wasnt changed, return false
			return false;
			
		return true;
		
	}
	 
	function get_user_pic($uid){
		$data = array(
			$uid
		);
		$query = $this->db->query("SELECT * FROM userimages WHERE uid=? LIMIT 1",$data);
		$result = $query->row_array();
		
		return $result;
	}
	

	/**************************************
	 *	Deletes any picture for the currently logged in user
	 *	sets the users Display Picture
	 *	- image_path is technically just the image name
	 *
	 */

	function set_user_pic($image_path){
		$query = $this->db->query("DELETE FROM userimages WHERE uid=?",array($this->session->userdata('uid')));
		
		$data= array(
			$this->session->userdata('uid'),
			$image_path
		);
		
		$query = $this->db->query("INSERT INTO userimages (uid,filename,date_uploaded) VALUES (?,?,NOW())",$data);
		
		return $this->db->affected_rows();
	}
	 
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
	 * 	Returns:	returns an array of all the data for that user from the users table only
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
		
		return $query->row_array();
		
	}
	
	function get_temp_account_by_tuid($tuid){	
		$this->load->database();
		$data = array(
			$tuid
		);
		$query = $this->db->query('SELECT * from tempusers WHERE tuid = ? LIMIT 1', $data);
		
		return $query->row_array();
		
	}
	
	/*
	 *	Returns all data from the tempusers table
	 */
	
	function get_temp_accounts(){	
		$this->load->database();
		$query = $this->db->query('SELECT * from tempusers ');
		
		return $query->result_array();
		
	}
	
	/*
	 *	Deletes all duplicate entries from the tempusers table with the provided email address
	 *
	 */
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
				`email`,
				`password`,
				`membersince`,
				`lastip`
			) VALUES (
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
			$temp['email'],
			$temp['password'],
			$this->input->ip_address()
			
		);
		$query = $this->db->query($str, $data);
		
		Accountmodel::purge_temp_accounts($temp['email']);
		
		//return $this->db->affected_rows();
		
	}
	
	/* 	MODIFY - make $email and $password parameters
	 *	DONT PULL FROM POST DATA
	 *
	 */
	
	function is_unregistered(){
		$this->load->database();
		$query = $this->db->query('SELECT * from tempusers WHERE email = ? AND password = ?  LIMIT 1', array($this->input->post('email'),Accountmodel::password_hash($this->input->post('password'))));
		
		if($query->row())
			return true;
		return false;
	}
	
	/* 	MODIFY - make $email a parameter 
	 * 	DONT PULL FROM POST DATA
	 *
	 *
	 *
	 */
	
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
	
	function update_new_single($table, $reltable,$idfield, $namefield, $value){
		$query = $this->db->query("DELETE FROM $reltable WHERE uid = ?",array($this->session->userdata('uid')));
		if($value!=""){
			$dormid = $this->db->query("SELECT $idfield FROM $table WHERE $namefield = ?",array($value));
			if($dormid->num_rows()>0){
				$dormid = $dormid->row_array();
				$dormid = $dormid[$idfield];
			}else{
				$query = $this->db->query("INSERT INTO $table ($namefield) VALUES (?)",array($value));	
				$dormid = $this->db->query("SELECT $idfield FROM $table WHERE $namefield = ?",array($value));
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

		Accountmodel::update_static("has_nationality",'nid', $form['nationalities']);	
		Accountmodel::update_static("speaks_language",'langid', $form['languages']);
		
		Accountmodel::update_new_single('dorms','has_dorm','dormid','name',$form['dorm']);
		Accountmodel::update_new_single('highschool','has_highschool','hid','name',$form['highschool']);
		
		
		
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

		Accountmodel::update_new_multi("courses","is_taking_course","courseid","course_name",$form['courses']);
		Accountmodel::update_static('has_major','mid',$form['majors']);
		
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
	
	
	
	function search_by_category($category, $term){
		if($category == 'class'){
			$data=array(
				$this->session->userdata('uid'),
				$term
			
			);
			$query_string = "SELECT uid FROM users WHERE uid != ? AND class = ? ";
			
			$query = $this->db->query($query_string,$data);
			
			
		} else {
			$rel_tables = Accountmodel::rel_tables();
			$data=array(
				$this->session->userdata('uid')
			);
			$a = $rel_tables[$category]['table'];
			$b = $rel_tables[$category]['rel_table'];
			$id = $rel_tables[$category]['id'];
			$query_string = "SELECT uid FROM $a,$b WHERE uid != ? AND $a.$id = $b.$id ";
			
			$terms = explode(" ", $term);
			
			foreach($terms as $t){
				$query_string .= " AND (".$rel_tables[$category]['name']." LIKE ?) ";
				array_push($data,"%".$t."%");
			}
			
			$query_string .= " GROUP BY uid";
			
			$query = $this->db->query($query_string,$data);
		}


		$result = array();
		foreach($query->result_array() as $i){
			array_push($result, $i['uid']);
		}		
		return $result;
		
			
	}
	
	function get_random_uids($limit){
		$data = array(
			$this->session->userdata('uid'),
			/*$limit*/
		);
		
		//randomizer query? kinda works for larger sets only...
		//$query = $this->db->query("SELECT uid FROM users WHERE uid != ? AND uid >= (SELECT FLOOR( MAX(uid) * RAND()) FROM users ) ORDER BY uid LIMIT ?",$data);
		
		//standard query
		//$query = $this->db->query("SELECT uid FROM users WHERE uid != ? LIMIT ?",$data);

		$query = $this->db->query("SELECT uid FROM users WHERE uid != ?",$data);
		
		$result = array();
		foreach($query->result_array() as $i){
			array_push($result, $i['uid']);
		}
		
		shuffle($result);
		if(count($result) > $limit)
			$result = array_slice($result,0,$limit);
		                    
		
		return $result;
	}
	
	function rel_tables(){
		return array(
			"favorite_music_artists" => array(
				"table" => "favorite_music_artists",
				"rel_table" => "has_favorite_music_artist",
				"id" => "artist_id",
				"name" => "artist_name"
			),
			"favorite_heroes" => array(
				"table" => "favorite_heroes",
				"rel_table" => "has_favorite_hero",
				"id" => "fhid",
				"name" => "name"
			),
			"favorite_movies" => array(
				"table" => "favorite_movies",
				"rel_table" => "has_favorite_movie",
				"id" => "movie_id",
				"name" => "movie_title"
			),
			"favorite_tvshows" => array(
				"table" => "favorite_tvshows",
				"rel_table" => "has_favorite_tvshow",
				"id" => "tvshow_id",
				"name" => "tvshow_title"
			),
			"favorite_sports_teams" => array(
				"table" => "favorite_sports_teams",
				"rel_table" => "has_favorite_sports_team",
				"id" => "team_id",
				"name" => "team_name"
			),
			"favorite_video_games" => array(
				"table" => "favorite_video_games",
				"rel_table" => "has_favorite_video_game",
				"id" => "video_game_id",
				"name" => "video_game_title"
			),
			"favorite_books" => array(
				"table" => "favorite_books",
				"rel_table" => "has_favorite_book",
				"id" => "book_id",
				"name" => "book_title"
			),
			"favorite_foods" => array(
				"table" => "favorite_foods",
				"rel_table" => "has_favorite_food",
				"id" => "ffid",
				"name" => "name"
			),
			"organizations" => array(
				"table" => "organizations",
				"rel_table" => "is_member_of_organization",
				"id" => "oid",
				"name" => "name"
			),
			"workplaces" => array(
				"table" => "workplaces",
				"rel_table" => "works_at",
				"id" => "wid",
				"name" => "name"
			),
			"greeks" => array(
				"table" => "greeks",
				"rel_table" => "is_member_of_greek",
				"id" => "greek_id",
				"name" => "name"
			),
			"courses" => array(
				"table" => "courses",
				"rel_table" => "is_taking_course",
				"id" => "courseid",
				"name" => "course_name"
			),
			"majors" => array(
				"table" => "majors",
				"rel_table" => "has_major",
				"id" => "mid",
				"name" => "major"
			),
			"highschool" => array(
				"table" => "highschool",
				"rel_table" => "has_highschool",
				"id" => "hid",
				"name" => "name"
			),
			"languages" => array(
				"table" => "languages",
				"rel_table" => "speaks_language",
				"id" => "langid",
				"name" => "language"
			),
			"nationalities" => array(
				"table" => "nationalities",
				"rel_table" => "has_nationality",
				"id" => "nid",
				"name" => "nationality"
			)
		);
	}
}

?>
