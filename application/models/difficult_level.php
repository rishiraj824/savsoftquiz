<?php
Class Difficult_level extends CI_Model
{

 function level_dropdown()
 {
   //$nor=$this->config->item('number_of_rows');
   $institute_id = $this->session->userdata('institute_id');
   $query = $this -> db -> query("select * from difficult_level where institute_id = '$institute_id'");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

// get all available level to show a group list in admin side
	function level_list($limit)
 {
 	$institute_id = $this->session->userdata('institute_id');

   $this -> db -> select('did, level_name');
   $this -> db -> from('difficult_level');
   $this -> db -> limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by("did", "desc"); 
	$this->db->where('institute_id',$institute_id);
   $query = $this -> db -> get();

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 

 function remove_level($did)
 {
   $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
   if($this->db->delete('difficult_level', array('did' => $did)) )
   {
     return true;
   }
   else
   {
     return false;
   }
 }

	// insert level
	 function insert_level(){
			$institute_id = $this->session->userdata('institute_id');
			$insert_level = array(
			'level_name' => $this->input->post('levelname'),
			'institute_id' => $institute_id
			);
			
			if($this->db->insert('difficult_level',$insert_level)){
			return "Level added successfully";
			}else{
			return "Unable to add level";
			}
			}
			
	// get particular level detail		
	function get_level($did){
	$institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
 	$this->db->where('did',$did);
		$query = $this->db->get('difficult_level');
		return $query->row_array();
		}
 
	// update level detail
 	function update_level($did){
 		$levelname = $_POST['levelname'];
 		$level_detail = array(
	 		'level_name' => $levelname,
	 		);
	 	$institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
	 	$this->db->where('did', $did);
 		$this->db->update('difficult_level',$level_detail);
 		return "Level updated";
 		}
 		
}
?>














