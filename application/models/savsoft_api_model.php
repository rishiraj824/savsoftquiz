<?php
Class Savsoft_api_model extends CI_Model
{
 
			
function register_user(){

			$insert_data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('user_password')),
			'email' => $this->input->post('user_email'),
			'su' => '0',
			'veri_code' => '0',
			'institute_id' => '1'
			);
			if($this->input->post('first_name')){
			$insert_data['first_name']=$this->input->post('first_name');
			}else{
			$insert_data['first_name']="";
			}
			if($this->input->post('last_name')){
			$insert_data['last_name']=$this->input->post('last_name');
			}else{
			$insert_data['last_name']="";
			}
			if($this->input->post('credit')){
			$insert_data['credit']=$this->input->post('credit');
			}else{
			$insert_data['credit']="";
			}
			if($this->input->post('user_group')){
			$insert_data['gid']=$this->input->post('user_group');
			}else{
			$insert_data['gid']="9";
			}
			if($this->db->insert('users',$insert_data)){

			return "Account Registered successfully";
			
			}else{
			return "Unable to register";
			}


}


 function user_list($limit)
 {
   $this -> db -> select('id,username,first_name,last_name,email,group_name,credit');
   $this -> db -> from('users');
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
 	$this -> db -> where($search_type,$search);
 	}
	$this->db->join('user_group','users.gid=user_group.gid');
 	$this -> db -> limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by("id", "desc"); 
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
			

			
 	// update user detail
 	function update_user($user_id){
 				$insert_data = array(
			
			);
			if($this->input->post('first_name')){
			$insert_data['first_name']=$this->input->post('first_name');
			}else{
			$insert_data['first_name']="";
			}
			if($this->input->post('password')){
			$insert_data['password']=md5($this->input->post('password'));
			}
			if($this->input->post('last_name')){
			$insert_data['last_name']=$this->input->post('last_name');
			}else{
			$insert_data['last_name']="";
			}
			if($this->input->post('credit')){
			$insert_data['credit']=$this->input->post('credit');
			}else{
			$insert_data['credit']="";
			}
			if($this->input->post('user_group')){
			$insert_data['gid']=$this->input->post('user_group');
			}else{
			$insert_data['gid']="9";
			}
 			$this->db->where('id', $user_id);
 			$this->db->update('users',$insert_data);
 			return "User updated";
 		}
		
	 function remove_user($id)
 {
  
   $query=$this->db->query("select * from users where id='$id'  ");
	 $result=$query->row_array();
	 if($result['main_su_admin']!="1"){
   if($this->db->delete('users', array('id' => $id)) )
   {
     return "Removed";
   }
   else
   {
     return "Unable to remove";
   }
   }else{
   return "You can not remove main Administrator";
   }
 }	
 
 
 function login_user($id){

 $this -> db -> select('id, username, password, gid, su');
   $this -> db -> from('users');
   $this -> db -> where('id', $id);
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
   
}

 
 
 
  function result_list($limit)
 {
   $this -> db -> select('rid,username,first_name,last_name,email,group_name,quiz_name,score,percentage,q_result,time_spent');
   $this -> db -> from('quiz_result');
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
 	$this -> db -> where($search_type,$search);
 	}
	$this->db->join('users','quiz_result.uid=users.id');
	$this->db->join('quiz','quiz.quid=quiz_result.quid');
	$this->db->join('user_group','users.gid=user_group.gid');
 	$this -> db -> limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by("rid", "desc"); 
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
 
 
   function quiz_list($limit)
 {
   $this -> db -> select('quid,quiz_name,description,start_time,end_time,duration,pass_percentage,max_attempts,correct_score,incorrect_score,ip_address,');
   $this -> db -> from('quiz');
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
 	$this -> db -> where($search_type,$search);
 	}
	$this -> db -> limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by("quid", "desc"); 
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
 
 
   function question_list($limit)
 {

   $this -> db -> select('qid,question,description,q_type');
   $this -> db -> from('qbank');
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
 	$this -> db -> where($search_type,$search);
 	}
	$this -> db -> limit($this->config->item('number_of_rows'),$limit);
	$this->db->order_by("qid", "desc"); 
   $query = $this -> db -> get();

   if($query -> num_rows() >= 1)
   {
   $data_q=array();
     foreach($query->result_array() as $key=> $val){
	 
	 if($val['q_type']=="0"){
	 $val['q_type']="Multiple Choice - Single Answer";
	 }else if($val['q_type']=="1"){
	 $val['q_type']="Multiple Choice - Multiple Answer";
	 }else if($val['q_type']=="2"){
	 $val['q_type']="Fill in the Blank";
	 }else if($val['q_type']=="3"){
	 $val['q_type']="Short Answer";
	 }else if($val['q_type']=="4"){
	 $val['q_type']="Essay";
	 }else if($val['q_type']=="5"){
	 $val['q_type']="Matching";
	 }
	 
	$data_q[$key]['question']=$val;
	
   $this -> db -> select('oid,option_value,score');
   $this -> db -> from('q_options');
	$this -> db -> where('qid',$val['qid']);
	$queryo = $this -> db -> get();
	
	$data_q[$key]['options']=$queryo->result_array();
	 }
	 
	 return  $data_q;
   }
   else
   {
     return false;
   }
 }
 
 
 
		
	 function remove_quiz($quid)
 {
  

   if($this->db->delete('quiz', array('quid' => $quid)))
   {
   $this->db->delete('quiz_group', array('quid' => $quid));
     return "Removed";
   }
   else
   {
     return "Unable to remove";
   }
 
 }
 
 
 	 function remove_question($qid)
 {
  

   if($this->db->delete('qbank', array('qid' => $qid)))
   {
   $this->db->delete('q_options', array('qid' => $qid));
     return "Removed";
   }
   else
   {
     return "Unable to remove";
   }
 
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

}












?>
