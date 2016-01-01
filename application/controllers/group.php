<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
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
   $data['result'] = $this->group_model->group_list($limit);
	$data['title']="Group list";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/group_list',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }


function remove_group($gid){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
	$this->group_model->remove_group($gid);
	redirect('group', 'refresh');
}

// add new group form
function add_new(){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
	$data['title']="Add Group";
	$this->load->view($this->session->userdata('web_view').'/header',$data);
	$this->load->view($this->session->userdata('web_view').'/add_group',$data);
	$this->load->view($this->session->userdata('web_view').'/footer',$data);
	}

// insert group into database
function insert_group(){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
	//echo "<pre>"; print_r($_POST);
	// form validation rules
	$this->form_validation->set_rules('groupname', 'Group Name', 'required');
	if ($this->form_validation->run() == FALSE)
		{
			$this->add_new();
		}
		else
		{
		$data['title']="Add Group";
		$data['resultstatus'] = $this->group_model->insert_group();
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/add_group',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
	}
	
	// edit the group form
	public function edit_group($gid,$resultstatus=''){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
		$data['title']="Edit Group";
		$data['group'] = $this->group_model->get_group($gid);
		$data['gid'] = $gid;
		$data['resultstatus'] = $resultstatus;
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/edit_group',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
		
		
	// update group in database
	function update_group($gid){
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		
		// form validations
		$this->form_validation->set_rules('groupname', 'Group Name', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->edit_group($gid);
			}
		else{
			$resultstatus = $this->group_model->update_group($gid);
			$this->edit_group($gid,$resultstatus);
			}
		}	
}

?>


















