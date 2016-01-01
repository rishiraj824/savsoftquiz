<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Difficultlevel extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
   $this->load->model('difficult_level','',TRUE);
   if(!$this->session->userdata('logged_in'))
   {
   redirect('login');
   }
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

 }

 function index($limit='0')
 {
   $data['result'] = $this->difficult_level->level_list($limit);
	$data['title']="Level list";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/level_list',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }


function remove_level($did){
	$this->difficult_level->remove_level($did);
	redirect('difficultlevel', 'refresh');
}

// add new level form
function add_new(){
	$data['title']="Add Level";
	$this->load->view($this->session->userdata('web_view').'/header',$data);
	$this->load->view($this->session->userdata('web_view').'/add_level',$data);
	$this->load->view($this->session->userdata('web_view').'/footer',$data);
	}

// insert group into database
function insert_level(){
	//echo "<pre>"; print_r($_POST);
	// form validation rules
	$this->form_validation->set_rules('levelname', 'Level Name', 'required');
	if ($this->form_validation->run() == FALSE)
		{
			$this->add_new();
		}
		else
		{
		$data['title']="Add Level";
		$data['resultstatus'] = $this->difficult_level->insert_level();
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/add_level',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
	}
	
	// edit the level form
	public function edit_level($did,$resultstatus=''){
		$data['title']="Edit Level";
		$data['level'] = $this->difficult_level->get_level($did);
		$data['did'] = $did;
		$data['resultstatus'] = $resultstatus;
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/edit_level',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
		
		
	// update level in database
	function update_level($did){
		// form validations
		$this->form_validation->set_rules('levelname', 'Level Name', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->edit_level($did);
			}
		else{
			$resultstatus = $this->difficult_level->update_level($did);
			$this->edit_level($did,$resultstatus);
			}
		}	
}

?>


















