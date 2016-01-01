<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gcm_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
    $this->load->database();
  } 
  
  
  
  
   public function register_gcm($regId)
			 {
			 
			 $regid=$regId;
			 $this->db->where('gcm_regid',$regid);
			 $query=$this->db->get('gcm_ids');
			 if($query->num_rows() == '0' ){
				$userdata=array('gcm_regid'=>$regid);
				$this->db->insert('gcm_ids',$userdata);
				}
				
			 }	
  
  
  
  
  
  
  
  
  }?>
