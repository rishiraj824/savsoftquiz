<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model("check_institute_id");
 }

 function index($web_view='desktop')
 {
 
 
 $this->load->helper('Mobile-Detect-master/mobile_detect');
 $detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
if($deviceType == "tablet" || $deviceType == "phone"){
$web_view="mobile";
}
if($web_view=="mobile"){
$web_view="desktop";
}
 if(!$this->session->userdata('web_view')){
 $this->session->set_userdata('web_view', $web_view);
 redirect('login/index/'.$web_view);
 }else{
 $this->session->set_userdata('web_view', $web_view);
 }

if($this->session->userdata('logged_in')){
 redirect('home');
 }

	$institute_id = "1";
	$result = $this->check_institute_id->check_ins_id($institute_id);

	if($result == 0){ 
		$this->load->view('invalid_url');
	 }
	 else{
	 	if($result['status'] == 0){ 
		redirect('login/status_deactivate');
	 }
	 $this->session->set_userdata('institute_id', $institute_id);
	 $this->session->set_userdata('organization_name', $result['organization_name']);
	 $this->session->set_userdata('contact_info', $result['contact_info']);
	 $this->session->set_userdata('logo', $result['logo']);
	 
	 $data['logo'] = $result['logo'];
	 $data['organization_name'] = $result['organization_name'];
    $data['contact_info'] = $result['contact_info'];
   
   $this->load->helper(array('form'));
   $data['title']="Login";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/login_view',$data);
  $this->load->view($this->session->userdata('web_view').'/footer',$data);
  }
 }
 function status_deactivate(){
 	$this->load->view($this->session->userdata('web_view').'/status_deactive');
 	}
	
	
	function register(){
	
$this->session->set_userdata('institute_id', $institute_id);
	 $this->session->set_userdata('organization_name', $result['organization_name']);
	 $this->session->set_userdata('contact_info', $result['contact_info']);
	 $this->session->set_userdata('logo', $result['logo']);
	 
	 $data['logo'] = $result['logo'];
	 $data['organization_name'] = $result['organization_name'];
    $data['contact_info'] = $result['contact_info'];
   
  $this->load->model('group_model','',TRUE);
   $data['allgroups'] = $this->group_model->get_allgroups();
   $this->load->helper(array('form'));
   $data['title']="Register new account";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
    $this->load->view($this->session->userdata('web_view').'/register',$data);
  $this->load->view($this->session->userdata('web_view').'/footer',$data);

	
	}
	
	
		
	function forgot(){
	if($this->input->post('user_email')){
	$user_email=$this->input->post('user_email');
	$this->load->model('user','',TRUE);
	$result=$this->user->reset_password($user_email);
		$this->session->set_flashdata('result', $result);
	redirect('login/forgot');
	}
	
   $this->load->helper(array('form'));
   $data['title']="Reset Password";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
    $this->load->view($this->session->userdata('web_view').'/reset_password',$data);
  $this->load->view($this->session->userdata('web_view').'/footer',$data);

	
	}
	
	
	
	function verify($vcode){
	$this->load->model('user','',TRUE);
 if($this->user->verify_code($vcode)){
	 $data['title']="Email address verified successfully";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
    $this->load->view($this->session->userdata('web_view').'/verify_code',$data);
  $this->load->view($this->session->userdata('web_view').'/footer',$data);

	}else{
	 $data['title']="Invalid verification link";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
    $this->load->view($this->session->userdata('web_view').'/verify_code',$data);
  $this->load->view($this->session->userdata('web_view').'/footer',$data);

	}
	}
	
	// register user into database
function register_user(){
if(!$this->config->item('user_reg')){
exit('Permission denied');
return;
}		
 $this->load->model('user','',TRUE);
 $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
  
	//echo "<pre>"; print_r($_POST);
	// form validation rules
	$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]');
	$this->form_validation->set_rules('user_password', 'Password', 'required|matches[confirm_password]');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
	$this->form_validation->set_rules('first_name', 'First Name', 'required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'required');
	$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|is_unique[users.email]');
	if ($this->form_validation->run() == FALSE)
		{
		$this->session->set_flashdata('result', validation_errors());
			redirect('login/register');
		}
		else
		{
		
		$rr = $this->user->register_user();
		$this->session->set_flashdata('result', $rr);
		redirect('login/register');
		}
	}
}

?>
