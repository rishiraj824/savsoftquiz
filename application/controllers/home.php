<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('result_model','','TRUE');
   $this->load->model('user','','TRUE');
   if(!$this->session->userdata('logged_in'))
   {
   redirect('login', 'refresh');
   }
 }

 function index()
 {
    $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['username'];
     if($session_data['su']!="1"){
     $user_id=$session_data['id'];
     $result = $this->result_model->user_last_ten_results($user_id);
     $value=array();
     $value[]=array('Quiz Name','Percentage (%)');
     foreach($result as $val){
     $value[]=array($val['quiz_name'],intval($val['percentage']));
     }
     	$data['title'] = "Home";
    	$data['value']=json_encode($value);
    	$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/home_view', $data);
     $this->load->view($this->session->userdata('web_view').'/footer',$data);
     
     
     }else{
	 $this->session->set_userdata('web_view', 'desktop');
     	$data['num_users'] = $this->user->num_users();
     	$data['num_qbank'] = $this->user->num_qbank();
     	$data['num_result'] = $this->user->num_result();
     	$data['user_group'] = $this->user->user_by_group();
     $result = $this->result_model->user_last_ten_results();
     $value=array();
     $value[]=array('Quiz Name','Percentage (%)');
     foreach($result as $val){
     $value[]=array($val['quiz_name'].'('.$val['username'].')',intval($val['percentage']));
     }
     	$data['title'] = "Home";
    	$data['value']=json_encode($value);
    	$this->load->view('desktop/header',$data);
		$this->load->view('desktop/home_view_admin', $data);
     $this->load->view('desktop/footer',$data);
     
     
     }
	 
	  	 
    
 }

 function setting()
 {
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
  
     $session_data = $this->session->userdata('logged_in');
     $data['username'] = $session_data['username'];
     $data['title'] = "Setting";
     $this->load->view($this->session->userdata('web_view').'/header',$data);
	$this->load->view($this->session->userdata('web_view').'/setting', $data);
     $this->load->view($this->session->userdata('web_view').'/footer',$data);
 }

 function logout()
 {
 $this->load->helper('cookie');
   $this->session->unset_userdata('logged_in');
   $institute_id = $this->session->userdata('institute_id');
   $this->session->sess_destroy();
   session_destroy();
   delete_cookie("rid");
   redirect('login/index/', 'refresh');
   
 }

}

?>


