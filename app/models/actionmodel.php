<?php

class Actionmodel extends CI_Model{


    function get_zings_to($uid){
        $data = array( $uid );
        $query = $this->db->query("SELECT
                    U.firstname,
                    U.lastname,
                    U.uid,
                    G.date_sent
                FROM has_zinged G,
                    users U
                WHERE U.uid = sender_uid
                    AND target_uid=?
                ORDER BY date_sent"
        ,$data);

        return $query->result_array();
    }

    function get_zings_from($uid){
        $data = array( $uid );
        $query = $this->db->query("SELECT
                    U.firstname,
                    U.lastname,
                    U.uid,
                    G.date_sent
                FROM has_zinged G,
                    users U
                WHERE U.uid = target_uid
                    AND sender_uid=?
                ORDER BY date_sent"
        ,$data);

        return $query->result_array();
    }

    function zing($suid,$tuid){
        $data = array(
            $suid,
            $tuid
        );
        $query = $this->db->query("INSERT IGNORE INTO has_zinged (sender_uid, target_uid, date_sent) VALUES (?, ?, NOW())", $data);

        return $this->db->affected_rows();
    }


	function get_props_to($uid){
		$data = array( $uid );
		$query = $this->db->query("SELECT 
					U.firstname, 
					U.lastname, 
					U.uid, 
					G.date_sent 
				FROM gives_props G, 
					users U 
				WHERE U.uid = sender_uid 
					AND target_uid=? 
				ORDER BY date_sent"
		,$data);
		
		return $query->result_array();
	}
	
	function get_props_from($uid){
		$data = array( $uid );
		$query = $this->db->query("SELECT 
					U.firstname, 
					U.lastname, 
					U.uid, 
					G.date_sent 
				FROM gives_props G, 
					users U 
				WHERE U.uid = target_uid 
					AND sender_uid=? 
				ORDER BY date_sent"
		,$data);
		
		return $query->result_array();
	}
	
	function give_props($suid,$tuid){
		$data = array(
			$suid,
			$tuid
		);
		$query = $this->db->query("INSERT IGNORE INTO gives_props (sender_uid, target_uid, date_sent) VALUES (?, ?, NOW())", $data);
		
		return $this->db->affected_rows();
	}
	
    //Needs to be optimized
    function get_random_zing(){
        $query = $this->db->query("SELECT
                                    U1.firstname as s_firstname,
                                    U1.uid as s_uid,
                                    U2.firstname as t_firstname,
                                    U2.uid as t_uid,
                                    G.date_sent
                                FROM
                                    has_zinged G,
                                    users U1,
                                    users U2
                                WHERE
                                    U1.firstname != ''
                                    AND U2.firstname != ''
                                    AND G.sender_uid = U1.uid
                                    AND G.target_uid = U2.uid"
        );

        //in the sql query, it does checks to see if the firstname is empty

        $result = $query->result_array();
        return $result[array_rand($result)];

    }

	//Needs to be optimized
	function get_random_props(){
		$query = $this->db->query("SELECT 
									U1.firstname as s_firstname,
									U1.uid as s_uid,
									U2.firstname as t_firstname,
									U2.uid as t_uid,
									G.date_sent
								FROM
									gives_props G,
									users U1,
									users U2
								WHERE
									U1.firstname != ''
									AND U2.firstname != ''
									AND	G.sender_uid = U1.uid
									AND G.target_uid = U2.uid"
		);
		
		//in the sql query, it does checks to see if the firstname is empty
				
		$result = $query->result_array();
		return $result[array_rand($result)];
											
	}
	
}
