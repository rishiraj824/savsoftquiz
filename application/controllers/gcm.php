<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gcm extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
   $this->load->model('gcm_model','',TRUE);
		

 }

 function index($regId='')
 {
 
 if($regId != ""){
   
   $this->gcm_model->register_gcm($regId);
   
   }
 
 }

}

?>


















