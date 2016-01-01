<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_controller extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
   $this->load->model('category','',TRUE);
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
   $data['result'] = $this->category->category_list($limit);
	$data['title']="category list";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/category_list',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }


function remove_category($cid){
	$this->category->remove_category($cid);
	redirect('category_controller', 'refresh');
}

// add new category form
function add_new(){
	$data['title']="Add Category";
	$this->load->view($this->session->userdata('web_view').'/header',$data);
	$this->load->view($this->session->userdata('web_view').'/add_category',$data);
	$this->load->view($this->session->userdata('web_view').'/footer',$data);
	}

// insert group into database
function insert_category(){
	//echo "<pre>"; print_r($_POST);
	// form validation rules
	$this->form_validation->set_rules('categoryname', 'Category Name', 'required');
	if ($this->form_validation->run() == FALSE)
		{
			$this->add_new();
		}
		else
		{
		$data['title']="Add Category";
		$data['resultstatus'] = $this->category->insert_category();
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/add_category',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
	}
	
	// edit the category form
	public function edit_category($cid,$resultstatus=''){
		$data['title']="Edit category";
		$data['category'] = $this->category->get_category($cid);
		$data['cid'] = $cid;
		$data['resultstatus'] = $resultstatus;
		$this->load->view($this->session->userdata('web_view').'/header',$data);
		$this->load->view($this->session->userdata('web_view').'/edit_category',$data);
		$this->load->view($this->session->userdata('web_view').'/footer',$data);
		}
		
		
	// update category in database
	function update_category($cid){
		// form validations
		$this->form_validation->set_rules('categoryname', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE){
			$this->edit_category($cid);
			}
		else{
			$resultstatus = $this->category->update_category($cid);
			$this->edit_category($cid,$resultstatus);
			}
		}	
}

?>


















