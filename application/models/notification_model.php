<?php
Class Notification_model extends CI_Model
{

function notification_list($limit)
 {
 $institute_id = $this->session->userdata('institute_id');
 	
   $nor=$this->config->item('number_of_rows');
$query = $this -> db -> query("select * from notifications  order by nid desc limit $limit, $nor");
	
   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 function add_new(){
 $data=array(
 'title'=>$this->input->post('title'),
 'message'=>$this->input->post('message'),
 'noti_date'=>time()
 );
 $this->db->insert('notifications',$data);
 
 }
 
 
 function get_gcm_ids(){
 $query=$this->db->get('gcm_ids');
 return $query->result_array();

 }
 
 function get_notification(){
 
 $this->db->limit('1');
 $this->db->order_by('nid',"desc");
 $query=$this->db->get('notifications');
 return $query->row_array();
 }

function remove_notification($nid){

  if($this->db->delete('notifications', array('nid' => $nid)))
   {
 	 	return true;
   }
   else
   {
     return false;
   }
   
}


}
?>

