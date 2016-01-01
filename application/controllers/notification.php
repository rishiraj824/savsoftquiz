<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Notification extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('notification_model','','TRUE');
  
 }

 function index($limit=0)
 {
     $data['result'] = $this->notification_model->notification_list($limit);
	$data['title'] = "Notifications";
   $data['limit'] = $limit;
    	$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/notification_list', $data);
     $this->load->view($this->session->userdata('web_view').'/footer',$data);
    
 }
 



 
 function add_new($limit=0)
 {
     if($this->input->post('title')){
	$this->notification_model->add_new();
	
	// post to GCM
	$gcmids=$this->notification_model->get_gcm_ids();
	$message=array(
	'title'=>$this->input->post('title'),
	'message'=>$this->input->post('message')
	);
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
		$rrgids=array();
 foreach($gcmids as $key => $val){
      $rrgids[]=$val['gcm_regid'];
	}
	
	$registration_ids=$rrgids;
	  $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,
        );
 $gcmkey=$this->config->item('gcm_key');
        $headers = array(
            'Authorization: key='.$gcmkey,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
	// GCM ends
	
	
	redirect('notification');
	 }
	$data['title'] = "Create Notifications";
    	$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/add_notification', $data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
    
 }

 
 function get_new()
 {
     $data['notification'] = $this->notification_model->get_notification();
echo json_encode($data['notification']);
 }

 function remove($nid)
 {
     if($this->notification_model->remove_notification($nid)){
	 
	 
	 }
	 redirect('notification');
 }

 
}

?>


