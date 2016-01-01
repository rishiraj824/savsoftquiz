<?php
Class result_model extends CI_Model
{

 function result_list_all($limit,$user_id='')
 {
 $institute_id =$this->session->userdata('institute_id');
 // Number of rows per page
 	$nor=$this->config->item('number_of_rows');
 	if($user_id!=""){
 	$condi="and users.id='".$user_id."'";
 	}else{
 	$condi="";
 	}
 // to search
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
  $query = $this -> db -> query("SELECT * FROM  `quiz_result` JOIN users ON quiz_result.uid = users.id JOIN quiz ON quiz_result.quid = quiz.quid where $search_type like '%$search%' $condi and quiz_result.institute_id = '$institute_id' order by quiz_result.rid desc limit $limit, $nor");

 
 }else{
   $query = $this -> db -> query("SELECT * FROM  `quiz_result` JOIN users ON quiz_result.uid = users.id JOIN quiz ON quiz_result.quid = quiz.quid $condi  and quiz_result.institute_id = '$institute_id' order by quiz_result.rid desc limit $limit, $nor");

}
   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
  function get_percentile($quid,$uid,$score){
  $logged_in =$this->session->userdata('logged_in');
$gid= $logged_in['gid'];
$res=array();
	$this->db->where("quiz_result.quid",$quid);
	//$this->db->where("users.gid",$gid);
	$this->db->group_by("quiz_result.uid");
	//$this->db->join("users","users.id=quiz_result.uid");
	$this->db->order_by("quiz_result.score",'DESC');
	$query = $this -> db -> get('quiz_result');
	$res[0]=$query -> num_rows();

	
	$this->db->where("quiz_result.quid",$quid);
	$this->db->where("quiz_result.uid !=",$uid);
	$this->db->where("quiz_result.score <=",$score);
	$this->db->group_by("quiz_result.uid");
	//$this->db->join("users","users.id=quiz_result.uid");
	$this->db->order_by("quiz_result.score",'DESC');
	$querys = $this -> db -> get('quiz_result');
	$res[1]=$querys -> num_rows();
		
   return $res;
  
  
 }
 
  function remove_result($rid){

  if($this->db->delete('quiz_result', array('rid' => $rid)))
   {
     return true;
   }
   else
   {
     return false;
   }
 }
 
 
 function report($gid,$quid){
 $institute_id =$this->session->userdata('institute_id');
 $condi="";
 if($gid!="0"){
 $condi="users.gid='".$gid."'";
 }
 
 if($quid!="0"){
 if($condi!=""){
 $condi="and ".$condi;
 }
 $condi="quiz.quid='".$quid."'";
 }
 if($condi!=""){
 $condi="where ".$condi;
 }
  $query = $this -> db -> query("SELECT * FROM  `quiz_result` JOIN users ON quiz_result.uid = users.id JOIN quiz ON quiz_result.quid = quiz.quid JOIN user_group ON user_group.gid = users.gid $condi and quiz_result.institute_id = '$institute_id' order by quiz_result.rid desc ");
   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 

 function result_view($id,$user_id='')
 {
 $institute_id =$this->session->userdata('institute_id');
   if($user_id!=""){
   $condi="and users.id='".$user_id."'";
 	}else{
 	$condi="";
 	}
  $query = $this -> db -> query("SELECT * FROM  `quiz_result` JOIN users ON quiz_result.uid = users.id JOIN quiz ON quiz_result.quid = quiz.quid where quiz_result.rid='$id' and quiz_result.institute_id = '$institute_id' $condi");

   if($query -> num_rows() >= 1)
   {
     return $query->row();
   }
   else
   {
     return false;
   }
 }
 function result_view_essay($id,$essay_chek){
	 
		 $this->db->where('essay_status', 0); 
		 $this->db->where('q_type', 0); 
		 $this->db->where('r_id', $id); 
		$query = $this->db->get('essay_qsn'); 
		 if($query -> num_rows() >= 1)
   {
     return true;
   }else{
	   
	 return false;  
   }
	 
	 
	 
 }
 
 
 	// get all available groups to show a group list in admin side
	function group_list()
 {
 $institute_id =$this->session->userdata('institute_id');
   $this -> db -> select('gid, group_name');
   $this -> db -> from('user_group');
   $this->db->where('institute_id',$institute_id);
   $this->db->order_by("gid", "desc"); 
   $query = $this -> db -> get();

   if($query -> num_rows() >= 1)
   {
     return $query->result_array();
   }
   else
   {
     return false;
   }
 }

	function quiz_list()
 {
 $institute_id =$this->session->userdata('institute_id');
   $this -> db -> select('quid, quiz_name');
   $this -> db -> from('quiz');
   $this->db->where('institute_id',$institute_id);
   $this->db->order_by("quid", "desc"); 
   $query = $this -> db -> get();

   if($query -> num_rows() >= 1)
   {
     return $query->result_array();
   }
   else
   {
     return false;
   }
 }

function correct_incorrect($qids,$oids){
$ans=array();
//print_r($oids);
foreach(explode(",",$oids) as $k => $oi){

$query = $this -> db -> query("SELECT * FROM  q_options WHERE oid='$oi' ");
	$result=$query->row_array();

	if($query->num_rows() == 1 ){
		if($result['score'] >="0.01"){
		$ans[]=1;
		}else{
		$ans[]=0;
		}
	}else{
		$ans[]=0;
	}
	}
	
	return $ans;
}


  function get_question($rid){
  $institute_id =$this->session->userdata('institute_id');
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and quiz_result.institute_id = '$institute_id'");
	$row=$query->row_array();
	$qids=$row['qids'];

	$query = $this -> db -> query("SELECT * FROM  `qbank` JOIN question_category ON qbank.cid = question_category.cid WHERE qbank.qid IN ( $qids ) and qbank.institute_id = '$institute_id'  ORDER BY FIELD(qbank.qid, $qids ) ");
	$questions=$query->result_array();
	
	$query = $this -> db -> query("SELECT * FROM  `essay_qsn` WHERE q_id IN ( $qids ) and r_id = '$rid'  ORDER BY FIELD(essay_qsn.q_id, $qids ) ");
	$questions_opt=$query->result_array();
	
	$query = $this -> db -> query("SELECT * FROM  q_options WHERE qid IN ( $qids ) and institute_id = '$institute_id'  ORDER BY FIELD(q_options.qid, $qids ) ");
	$options=$query->result_array();
	$dataarr=array($questions,$options,$questions_opt);
	return $dataarr;
  }
 
 
 function user_last_ten_results($user_id='0'){
 $institute_id =$this->session->userdata('institute_id');
 	//$this->db->select('quiz.quiz_name,quiz_result.percentage');
 	$this->db->join('quiz','quiz.quid = quiz_result.quid');
 $this->db->join('users','users.id = quiz_result.uid');
 
 	$this->db->order_by("rid", "desc"); 
 	$this->db->limit(10);
 		$this->db->where('quiz_result.institute_id',$institute_id);
 	if($user_id !="0"){
	$this->db->where('uid',$user_id);
	}
	$query = $this->db->get('quiz_result');
 	$result = $query->result_array();
 	return $result;
 	}
 
 // get the last ten results of this quiz of all users
 function last_ten_result($quid){
 	$institute_id =$this->session->userdata('institute_id');
 	$this->db->join('users','users.id = quiz_result.uid');
 	$this->db->join('quiz','quiz.quid = quiz_result.quid');
 	$this->db->where('quiz.institute_id',$institute_id);
	$this->db->where('quiz.quid',$quid);
	$this->db->order_by('rid','desc');
	$this->db->limit('10');
	$query = $this->db->get('quiz_result');
	$result = $query->result_array();
	return $result;
 }
 
 
}
?>
