<?php
Class Category extends CI_Model
{
 function category_dropdown()
 {
   //$nor=$this->config->item('number_of_rows');
   $query = $this -> db -> query("select * from question_category");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

// get alll category
function category_list($limit)
 {
 	$institute_id  = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
   $this -> db -> select('cid, category_name');
   $this -> db -> from('question_category');
   $this -> db -> limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by("cid", "desc"); 
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

 function remove_category($cid)
 {
   $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);

   if($this->db->delete('question_category', array('cid' => $cid)) )
   {
     return true;
   }
   else
   {
     return false;
   }
 }

 // insert category
	 function insert_category(){
	 $institute_id = $this->session->userdata('institute_id');
			$insert_category = array(
			'category_name' => $this->input->post('categoryname'),
			'institute_id' => $institute_id
			);
			
			if($this->db->insert('question_category',$insert_category)){
			return "Category added successfully";
			}else{
			return "Unable to add category";
			}
			
			}
	
	 // get particular category detail		
	function get_category($cid){
		$institute_id = $this->session->userdata('institute_id');
	$query = $this->db->get_where('question_category',array('cid' => $cid,'institute_id' => $institute_id));
		return $query->row_array();
		}
		
	// update category detail
 	function update_category($cid){
 	
 		$categoryname = $_POST['categoryname'];
 		$category_detail = array(
	 		'category_name' => $categoryname,
	 		);
	 	$institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);

	 	$this->db->where('cid', $cid);
 		$this->db->update('question_category',$category_detail);
 		return "Category updated";
 		}
 		
}
?>

