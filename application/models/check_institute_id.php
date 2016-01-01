<?php
Class Check_institute_id extends CI_Model
{

 function check_ins_id($institute_id){
	$query = $this->db->get_where("institute_data",array("su_institute_id" => $institute_id));
	$result = $query->num_rows();
	if($result == '0'){
		return '0';
		}
	else{
		return $query->row_array();
		}	
	
	}
}

?>
