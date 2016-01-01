<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_data extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
   $this->load->model('user','',TRUE);
   $this->load->model('group_model','',TRUE);
   if(!$this->session->userdata('logged_in'))
   {
   redirect('login');
   }
 }

 function index($limit='0')
 {
 $logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
   $data['result'] = $this->user->user_list($limit);
	$data['title']="User list";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/user_list',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }


 
  function login_user_by_admin($id){
   $logged_in=$this->session->userdata('logged_in');
  if($logged_in['su']!="1"){
	exit('Permission denied');
	return;
	}	
   $result = $this->user->login_user_by_admin($id);

  
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
	   
	   }
	   redirect('home');
	  
  
  }
  
  
  
  
function remove_user($id){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

			$this->user->remove_user($id);
			
	redirect('user_data', 'refresh');
}

// add new user form
function add_new(){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
	$data['title']="Add User";
	//get the list of the groups
	$data['allgroups'] = $this->group_model->get_allgroups();
	$this->load->view($this->session->userdata('web_view').'/header',$data);
	$this->load->view($this->session->userdata('web_view').'/add_user',$data);
	$this->load->view($this->session->userdata('web_view').'/footer',$data);
	}



// insert user into database
function insert_user(){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

	//echo "<pre>"; print_r($_POST);
	// form validation rules
	$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[users.username]');
	$this->form_validation->set_rules('user_password', 'Password', 'required|matches[confirm_password]');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
	$this->form_validation->set_rules('first_name', 'First Name', 'required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'required');
	$this->form_validation->set_rules('user_credit', 'Credit', 'required');
	$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|is_unique[users.email]');
	if ($this->form_validation->run() == FALSE)
		{
			$this->add_new();
		}
		else
		{
		$data['title']="Add User";
		$data['resultstatus'] = $this->user->insert_user();
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/add_user',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
	}
	
	// edit the user form
	public function edit_user($user_id,$resultstatus=''){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
	$logged_in=$this->session->userdata('logged_in');
		$data['title']="Edit User";
					$institute_id =$this->session->userdata('institute_id');
			$data['user'] = $this->user->get_user($user_id,$institute_id);
	$data['allgroups'] = $this->group_model->get_allgroups();
		$data['user_id'] = $user_id;
		$data['resultstatus'] = $resultstatus;
		$data['su']=$logged_in['su'];
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/edit_user',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
		
	// edit the user form
	public function my_account($resultstatus=''){
		$data['title']="Edit User";
		$logged_in=$this->session->userdata('logged_in');
		$user_id=$logged_in['id'];
		$institute_id =$this->session->userdata('institute_id');
		$data['user'] = $this->user->get_user($user_id,$institute_id);
		$data['allgroups'] = $this->group_model->get_allgroups();
		$data['user_id'] = $user_id;
		$data['resultstatus'] = $resultstatus;
		$data['su']=$logged_in['su'];
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/edit_user',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
		
		
	// update user in database
	function update_user($user_id){
		// form validations
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']=="0"){
		$user_id=$logged_in['id'];
		}
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('user_credit', 'Credit', 'required');
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('user_password', 'Password', 'matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password','matches[user_password]');

		if ($this->form_validation->run() == FALSE){
			if($logged_in['su']=="0"){
				$this->my_account();
			}else{
			$this->edit_user($user_id);
			}
			}else{
			$resultstatus = $this->user->update_user($user_id);
			//$this->edit_user($user_id,$resultstatus);
				if($logged_in['su']=="0"){
			$this->my_account($resultstatus);
			}else{
			$this->edit_user($user_id,$resultstatus);

				}
	
				}
		}	
}

?>


















