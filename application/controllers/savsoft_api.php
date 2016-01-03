<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Savsoft_api extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model("check_institute_id");
   
   
   // if api key not defined!
   if($this->config->item('savsoft_api_key')==""){
   exit('API key empty! Please define in application/config/config.php');
   }
   
   
		// if api key not posted then exit
	if(!$this->input->post('savsoft_api_key')){
	exit('API key missing!');

	}
	// if api key invalid then exit
	if($this->input->post('savsoft_api_key') != $this->config->item('savsoft_api_key')){
	exit('Invalid API key');

	}


   		
 $this->load->model('savsoft_api_model','',TRUE);
 }

 function index()
 {

 }

	
// register user into database
function register_user(){

 $this->load->helper(array('form', 'url'));
 $this->load->library('form_validation');
  
	//echo "<pre>"; print_r($_POST);
	// form validation rules
	$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]');
	$this->form_validation->set_rules('user_password', 'Password', 'required');
	$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|is_unique[users.email]');
	if ($this->form_validation->run() == FALSE)
		{
		echo validation_errors();
		}
		else
		{
		
		echo $this->savsoft_api_model->register_user();
		
		}
	}
	

	function user_list(){
	if($this->input->post('limit')){
	$limit=$this->input->post('limit');
	}else{
	$limit=0;
	}
	  $data= $this->savsoft_api_model->user_list($limit);
	  print_r(json_encode($data));
	}
	
// register user into database
function update_user(){
$user_id=$this->input->post('id');
 $this->load->helper(array('form', 'url'));
 $this->load->library('form_validation');
  $data = $this->savsoft_api_model->update_user($user_id);
		  print_r($data);	
	
	}


	function remove_user(){
	$user_id=$this->input->post('id');
	  $data= $this->savsoft_api_model->remove_user($user_id);
	  print_r(json_encode($data));
	}


	function login_user(){
	$user_id=$this->input->post('id');
   $result = $this->savsoft_api_model->login_user($user_id);

  
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'id' => $row->id,
         'username' => $row->username,
         'gid'=> $row->gid,
         'su'=> $row->su
       );
	  
      $this->session->set_userdata('logged_in', $sess_array);
	   echo "user logged in";
	   }
	}





// results

	function result_list(){
	if($this->input->post('limit')){
	$limit=$this->input->post('limit');
	}else{
	$limit=0;
	}
	  $data= $this->savsoft_api_model->result_list($limit);
	  print_r(json_encode($data));
	}

	// quiz 

	function quiz_list(){
	if($this->input->post('limit')){
	$limit=$this->input->post('limit');
	}else{
	$limit=0;
	}
	  $data= $this->savsoft_api_model->quiz_list($limit);
	  print_r(json_encode($data));
	}

	function remove_quiz(){
		$quid=$this->input->post('id');
	  $data= $this->savsoft_api_model->remove_quiz($quid);
	  print_r(json_encode($data));
	}

	
	
	// question
	function question_list(){
	if($this->input->post('limit')){
	$limit=$this->input->post('limit');
	}else{
	$limit=0;
	}
	  $data= $this->savsoft_api_model->question_list($limit);
	  print_r(json_encode($data));
	}

	function remove_question(){
		$qid=$this->input->post('id');
	  $data= $this->savsoft_api_model->remove_question($qid);
	  print_r(json_encode($data));
	}












	
	
}

?>
