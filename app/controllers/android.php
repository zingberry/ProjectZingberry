<?php


class Android extends CI_Controller{

	function index(){
		if ($this->input->post("apikey") != "444a2b83e3ce652e24a97ec8616fe758"){
			die('unauthorized access bro.');
		}
		
		$this->load->model('stats');
		
		$payload = $_POST['payload'];
		$payloadObj = json_decode($payload);

		switch($payloadObj->action)
		{
			case "usercount":

				$usercount = $this->stats->numusers();

				$outputArray =
				array(	"success" => true,
						"usercount" => $usercount
				);

				echo json_encode($outputArray);
				break;
			case "stats":
				$data = array(
					"success" => true,
					"stats" => array(
						3,
						array(
							"label" => "Verified user count",
							"value" => $this->stats->numusers()
						),
						array(
							"label" => "Unverified user count",
							"value" => $this->stats->numtempusers()
						),
						array(
							"label" => "Users active in the last 7 days",
							"value" => $this->stats->user_activity("7")
						)
					)
				);
				echo json_encode($data);
				break;
		}
	}



}

?>
