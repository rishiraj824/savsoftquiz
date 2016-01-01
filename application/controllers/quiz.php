<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('quiz_model','',TRUE);
   $this->load->model('group_model','',TRUE);
   if(!$this->session->userdata('logged_in'))
   {
   redirect('login');
   }
 }

 function index($limit='0')
 {
 $logged_in=$this->session->userdata('logged_in');
if($logged_in['su']=="1"){
   $data['result'] = $this->quiz_model->quiz_list($limit);
   }else{
   $gid=$logged_in['gid'];
   $data['result'] = $this->quiz_model->quiz_list($limit,$gid);
   }
	$data['title']="Quiz/Test";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/quiz_list',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }
 
 
 
function photo_upload(){

if(isset($_FILES['webcam'])){
			$targets = 'photo/';
			$filename=time().'.jpg';
			$targets = $targets.''.$filename;
			if(move_uploaded_file($_FILES['webcam']['tmp_name'], $targets)){
			
				$this->session->set_flashdata('photoname', $filename);
				}
				}
}


 function add_new()
 {
 
 $logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

 	$this->load->model('category','',TRUE);
  	$data['category'] = $this->category->category_dropdown();
	$this->load->model('difficult_level','',TRUE);
	$data['groups'] = $this->group_model->get_allgroups();
	
  	$data['difficult_level'] = $this->difficult_level->level_dropdown();
	if($this->input->post('submit_quiz')){
	$data['resultstatus'] = $this->quiz_model->add_quiz();
	$qselect=$this->input->post('qselect');
	redirect('quiz/edit_quiz/'.$data['resultstatus'].'/'.$qselect);
	}	
	$data['title']="Add new quiz";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   
   $this->load->view($this->session->userdata('web_view').'/new_quiz',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }


 function edit_quiz($id,$qselect='1')
 {
 $logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

 	$this->load->model('category','',TRUE);
  	$data['category'] = $this->category->category_dropdown();
	$this->load->model('difficult_level','',TRUE);
	$data['groups'] = $this->group_model->get_allgroups();
	
  	$data['difficult_level'] = $this->difficult_level->level_dropdown();
	if($this->input->post('submit_quiz')){
	$data['resultstatus'] = $this->quiz_model->edit_quiz($id);
	}	
	$data['result'] = $this->quiz_model->quiz_detail($id);
	
		$data['assigned_gids'] = $this->quiz_model->assigned_groups($id);
if($data['result']->qselect=="1"){
	$data['assigned_questions'] = $this->quiz_model->assigned_questions($id);
	}else{
	$data['assigned_questions'] = $this->quiz_model->assigned_questions_manually($id);
	
	}
	$data['qselect']=$qselect;
	$data['title']="Edit quiz";
   	$this->load->view($this->session->userdata('web_view').'/header',$data);
   
   	$this->load->view($this->session->userdata('web_view').'/edit_quiz',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }



	function remove_quiz($id){
	$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

$data['resultstatus']=$this->quiz_model->remove_quiz($id);
	redirect('quiz', 'refresh');
	}

	 function attempt($id)
 	{
		$data['result'] = $this->quiz_model->quiz_detail($id);
		$data['title']=$data['result']->quiz_name;
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/quiz_detail',$data);
	  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
	}
	
	
	// update individual question time spent
	function update_time($id,$qtime){
	$this->quiz_model->update_time($id,$qtime);
	}
	
	
	// update answer
	function update_answer($id,$oid){
	$this->quiz_model->update_answer($id,$oid);
	}
	function update_fillups(){
	$this->quiz_model->update_fillups();
	}
	
	function add_question($quid,$qid){
	$this->quiz_model->add_question($quid,$qid);
	}
	
	function remove_question_quiz($quid,$qid){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit('Permission denied');
	return;
	}		
	$this->quiz_model->remove_question_quiz($quid,$qid);
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	
	
	function up_question($quid,$qid,$not='1'){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit('Permission denied');
	return;
	}		
	for($i=1; $i <= $not; $i++){
	$this->quiz_model->up_question($quid,$qid);
	}
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	function down_question($quid,$qid,$not='1'){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit('Permission denied');
	return;
	}	
			for($i=1; $i <= $not; $i++){
	$this->quiz_model->down_question($quid,$qid);
	}
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	
	
	
	 function access_test($id)
 	{
 	$this->load->helper('cookie');
 	
		$data['resultstatus'] = $this->quiz_model->quiz_verify($id);
		$data['quiz_id']=$id;
		$data['result'] = $this->quiz_model->quiz_detail($id);
		$data['title']=$data['result']->quiz_name;
		if($data['resultstatus'] == "1"){
		if(!$this->input->cookie('rid', TRUE)){
		redirect('quiz/access_test/'.$id, 'refresh');
		}
		$rid=$this->input->cookie('rid', TRUE);
		//get the question answer 
		$data['user_answer']=$this->quiz_model->get_user_answer($rid);
		$question_user_ans=array();
		
		foreach($data['user_answer'] as $val_ans){
			$question_user_ans[$val_ans['q_id']]=$val_ans['essay_cont'];
			
		}
		
		$data['question_user_ans']=$question_user_ans;
		// get assignied questions
		$data['assigned_question']=$this->quiz_model->get_question($rid);
		// get time information
		$data['time_info']=$this->quiz_model->get_time_info($rid);
		
		// time remaining in seconds
		// total time - time spent
		$data['seconds']=(($data['result']->duration)*60) - ($data['time_info']['time_spent']);
		
		// get quiz data like quiz duration, title
		$data['quiz_data']=$this->quiz_model->get_quiz_data($id);
		
		// load quiz access page
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/quiz_access',$data);
	  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
		
		
		}else{
		// load quiz detail page with error
		$data['result'] = $this->quiz_model->quiz_detail($id);
		$data['title']=$data['result']->quiz_name;
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/quiz_detail',$data);
	  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
		
	}
	
	function close_practice(){
	 $result_id=$this->input->cookie('rid', TRUE);
	 $this->db->where('rid', $result_id);
if($this->db->delete('quiz_result')){
	$this->load->helper('cookie');
	delete_cookie("rid");
	 redirect('/quiz/', 'refresh');
} 
	 
	 
 } 


	function submit_quiz($id){
		
		$this->load->helper('cookie');
 	
		$data['resultstatus']=$this->quiz_model->quiz_submit($id);
		$data['result'] = $this->quiz_model->quiz_detail($id);
		$data['title']=$data['result']->quiz_name;
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/quiz_detail',$data);
	  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
		
	
	}

}

?>
