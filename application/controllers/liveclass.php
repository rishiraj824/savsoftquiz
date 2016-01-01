<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Liveclass extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
   $this->load->model('liveclass_model','',TRUE);
		

 }

	 function index($limit='0')
	 {
		  $data['result'] = $this->liveclass_model->active_classroom($limit);
	 
			$data['title']="Active or Upcoming Classes";
		   $this->load->view($this->session->userdata('web_view').'/header',$data);
		   $this->load->view($this->session->userdata('web_view').'/active_classes',$data);
		  $this->load->view($this->session->userdata('web_view').'/footer',$data);
	 }



	 
	 function closed_classes($limit='0')
	 {
		  $data['result'] = $this->liveclass_model->closed_classroom($limit);
	 
			$data['title']="Closed Classes";
		   $this->load->view($this->session->userdata('web_view').'/header',$data);
		   $this->load->view($this->session->userdata('web_view').'/closed_classes',$data);
		  $this->load->view($this->session->userdata('web_view').'/footer',$data);
	 }

	 
	 function add_new()
	 {
	 	 $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		

		    $this->load->model('group_model','',TRUE);
			if($this->input->post('submit_class')){
			 $data['result'] = $this->liveclass_model->insert_classroom();
			 redirect('liveclass/edit_class/'.$data['result']);
			}
			$data['groups'] = $this->group_model->get_allgroups();
	
			$data['title']="Initiate new class";
		   $this->load->view($this->session->userdata('web_view').'/header',$data);
		   $this->load->view($this->session->userdata('web_view').'/add_class',$data);
		  $this->load->view($this->session->userdata('web_view').'/footer',$data);
	 }
	 
	 
	 function edit_class($class_id)
	 {
	 	 $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		

		    $this->load->model('group_model','',TRUE);
			if($this->input->post('submit_class')){
			 $this->liveclass_model->update_classroom($class_id);
			 redirect('liveclass/edit_class/'.$class_id);
			}
			$data['class_id']=$class_id;
			$data['groups'] = $this->group_model->get_allgroups($class_id);
			$data['result'] = $this->liveclass_model->get_class($class_id);
			$data['assigned_gids'] = $this->liveclass_model->assigned_groups($class_id);
			$data['title']="Edit class";
		   $this->load->view($this->session->userdata('web_view').'/header',$data);
		   $this->load->view($this->session->userdata('web_view').'/edit_class',$data);
		  $this->load->view($this->session->userdata('web_view').'/footer',$data);
	 }
	 
	  
	 function remove_class($class_id)
	 {
	 $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		
	 $this->liveclass_model->remove_classroom($class_id);
	 redirect('liveclass');
	}
	
	
		 function close_class($class_id)
	 {
	 $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		
	 $this->liveclass_model->close_classroom($class_id);
	 redirect('liveclass');
	}
	
	
	
	 function insert_content($class_id)
	 {
	 $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		
	 $this->liveclass_model->insert_content($class_id);
	
	}
	 
	 
	 function insert_comnt($class_id){
	 $this->liveclass_model->insert_comnt($class_id);
	
	 }
	 
	 
	 
	 function fileupload(){
	 
	
	 
	 $target_dir = "./classfiles/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
	 
	 
	 
	 
	 
	 
	 }
	 
	 function attempt($class_id)
	 {
		    $this->load->model('group_model','',TRUE);
			$data['groups'] = $this->group_model->get_allgroups($class_id);
			$data['result'] = $this->liveclass_model->get_class($class_id);
			$data['class_id']=$class_id;
			$data['title']=$data['result']['class_name'];
		   $this->load->view($this->session->userdata('web_view').'/header',$data);
		$logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']=="1" && $data['result']['initiated_by']==$logged_in['id']){
		  $this->load->view($this->session->userdata('web_view').'/attempt_class',$data);
		  }else{
		    $this->load->view($this->session->userdata('web_view').'/attempt_class_reader',$data);
				  
		  }
		  $this->load->view($this->session->userdata('web_view').'/footer',$data);
	 }
	 
	 function view($class_id)
	 {
		    $this->load->model('group_model','',TRUE);
			$data['groups'] = $this->group_model->get_allgroups($class_id);
			$data['result'] = $this->liveclass_model->get_class($class_id);
			$data['comments'] = $this->liveclass_model->get_coment($class_id);
			$data['class_id']=$class_id;
			$data['title']=$data['result']['class_name'];
		   $this->load->view($this->session->userdata('web_view').'/header',$data);
		$logged_in =$this->session->userdata('logged_in');
		
		    $this->load->view($this->session->userdata('web_view').'/view_class',$data);
		
		  $this->load->view($this->session->userdata('web_view').'/footer',$data);
	 }


	function get_class_content($class_id){

$result=$this->liveclass_model->get_class($class_id);
print_r($result['content']);

	}
	 
	 
	 function get_ques_content($class_id){
	 $data['result']=$this->liveclass_model->get_coment($class_id);
	 $this->load->view($this->session->userdata('web_view').'/comnt_data',$data);
	 
	 }
	 
	 function del_comnt(){
	 $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		
	 $this->liveclass_model->del_coment();
	 
	 }
	  function publish_comnt(){
	  $logged_in =$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
		exit('Permission denied!');
		}		
	 $this->liveclass_model->publish_comnt();
	 
	 }
	 
}

?>


















