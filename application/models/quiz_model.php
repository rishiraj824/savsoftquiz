<?php
Class quiz_model extends CI_Model
{

 function quiz_list($limit,$gid='')
 {
 	$institute_id = $this->session->userdata('institute_id');
   $nor=$this->config->item('number_of_rows');
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
  
   
	if($gid!=""){
  $query = $this -> db -> query("select quiz.* from quiz join quiz_group on quiz.quid=quiz_group.quid where quiz_group.gid='$gid' and $search_type like '%$search%' and quiz.institute_id = '$institute_id' order by quid desc limit $limit, $nor");
	}else{
	$query = $this -> db -> query("select quiz.* from quiz where $search_type like '%$search%' and quiz.institute_id = '$institute_id' order by quid desc limit $limit, $nor");
	}
	
	
	
   }else{
 if($gid!=""){
  $query = $this -> db -> query("select quiz.* from quiz join quiz_group on quiz.quid=quiz_group.quid where quiz_group.gid='$gid' and quiz.institute_id = '$institute_id' order by quid desc limit $limit, $nor");
	}else{
	$query = $this -> db -> query("select quiz.* from quiz where quiz.institute_id = '$institute_id' order by quid desc limit $limit, $nor");
	}
	
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
 
 // add new quiz
 function add_quiz(){
	$institute_id = $this->session->userdata('institute_id');

	$insert_data = array(
			'quiz_name' => $this->input->post('quiz_name'),
			'description' => $this->input->post('description'),
			'start_time' => strtotime($this->input->post('test_start_time')),
			'end_time' => strtotime($this->input->post('test_end_time')),
			'duration' => $this->input->post('quiz_time_duration'),
			'pass_percentage' => $this->input->post('pass_percentage'),
			'test_type' => $this->input->post('test_type'),
			'qselect' => $this->input->post('qselect'),
			'credit' => $this->input->post('test_charges'),
			'view_answer' => $this->input->post('view_answer'),
			'max_attempts' => $this->input->post('max_attemp'),
			'correct_score' => $this->input->post('correct_answer_score'),
			'incorrect_score' => $this->input->post('incorrect_answer_score'),
			'ip_address' => $this->input->post('ip_address'),
			'camera_req' => $this->input->post('camera_req'),
			'pract_test' => $this->input->post('qiz_type'),
			'institute_id' => $institute_id
			);
	
 	$qselect=$this->input->post('qselect');
	
			if($this->db->insert('quiz',$insert_data)){
			$quid=$this->db->insert_id();
			foreach($_POST['assigned_groups'] as $value){
			$insert_data = array(
			'quid'	=>	$quid,
			'gid'	=>	$value,
			'institute_id' => $institute_id
			);
		
 
			$this->db->insert('quiz_group',$insert_data);
			}
			if($qselect=="1"){
			$noq=$this->input->post('no_of_questions');
			$insert_data = array(
			'quid'	=>	$quid,
			'cid'	=>	$this->input->post('cid'),
			'did'	=>	$this->input->post('did'),
			'no_of_questions'	=>	$noq['0'],
			'institute_id' => $institute_id
			);
			
 
			$this->db->insert('quiz_qids',$insert_data);
			}
			return $quid;
			}else{
			return "Unable to add quiz";
			}
	}
 
 // update individual question time spent
 function update_time($id,$qtime){
 $institute_id = $this->session->userdata('institute_id');
  	$rid=$this->input->cookie('rid', TRUE);
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and institute_id = '$institute_id'");
	$row=$query->row_array();
	$time_spent_ind=explode(",",$row['time_spent_ind']);
	foreach($time_spent_ind as $key => $val){
	if($key==$id){
	$time_spent_ind[$key]+=$qtime;
	}
	}
	$time_spent_ind=implode(",",$time_spent_ind);
	$this->db->query("update quiz_result set time_spent_ind='$time_spent_ind' where institute_id = '$institute_id' and rid='$rid' ");
  
 
 }
 
// update answer
 function update_answer($id,$oid){
 $institute_id = $this->session->userdata('institute_id');
 	
  	$rid=$this->input->cookie('rid', TRUE);
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and institute_id = '$institute_id'");
	$row=$query->row_array();
	$oids=explode(",",$row['oids']);
	foreach($oids as $key => $val){
	if($key==$id){
	$oids[$key]=$oid;
	}
	}
	$oids=implode(",",$oids);
	$this->db->query("update quiz_result set oids='$oids' where rid='$rid' and institute_id = '$institute_id'");
  
 
 }
 
 //update fillups
 function update_fillups(){
	 $rid=$this->input->cookie('rid', TRUE);
	 $q_type=$this->input->post("q_type");
	 $qid=$this->input->post("q_id");
	 $optn_value_user=$this->input->post("optn_value_user");
	 $insert_data = array(
			'q_id'	=>	$qid,
			'r_id'	=>	$rid,
			'essay_cont'	=>	$optn_value_user,
			'q_type'	=>	$q_type,
			'essay_score'	=>	'0'
			);
			$this->db->where('q_id',$qid);
			$this->db->where('r_id',$rid);
		$query=$this->db->get('essay_qsn');
		//print_r($query->num_rows()); exit;
if($query->num_rows()==0){
$this->db->insert('essay_qsn', $insert_data);
}else{
	$data_user1 = array(
   'essay_cont' => $optn_value_user
);
	$this->db->where('r_id',$rid);
	$this->db->where('q_id',$qid);
	$this->db->update('essay_qsn', $data_user1);
	
} 

 }
 
 
  // add new quiz
 function edit_quiz($id){
 $institute_id = $this->session->userdata('institute_id');
 	//echo "<pre>";
	//print_r($_POST);
 	//echo "</pre>";
	$insert_data = array(
			'quiz_name' => $this->input->post('quiz_name'),
			'description' => $this->input->post('description'),
			'start_time' => strtotime($this->input->post('test_start_time')),
			'end_time' => strtotime($this->input->post('test_end_time')),
			'duration' => $this->input->post('quiz_time_duration'),
			'pass_percentage' => $this->input->post('pass_percentage'),
			'test_type' => $this->input->post('test_type'),
			'qselect' => $this->input->post('qselect'),
			'credit' => $this->input->post('test_charges'),
			'view_answer' => $this->input->post('view_answer'),
			'max_attempts' => $this->input->post('max_attemp'),
			'correct_score' => $this->input->post('correct_answer_score'),
			'incorrect_score' => $this->input->post('incorrect_answer_score'),
			'ip_address' => $this->input->post('ip_address'),
			'camera_req' => $this->input->post('camera_req'),
			'pract_test' => $this->input->post('qiz_type'),
			'institute_id' => $institute_id
			);
			$quid=$id;
			$this->db->where('institute_id',$institute_id);
			$this->db->where('quid',$quid);
			if($this->db->update('quiz',$insert_data)){
			
			// delete existing gids and re insert new one
		
 			$this->db->where('institute_id',$institute_id);
			$this->db->where('quid', $quid);
			$this->db->delete('quiz_group');
			foreach($_POST['assigned_groups'] as $value){
			$insert_data = array(
			'quid'	=>	$quid,
			'gid'	=>	$value,
			'institute_id' => $institute_id
			);
			$this->db->insert('quiz_group',$insert_data);
			}
			// delete existing no of question record and insert new one.
			
 			$this->db->where('institute_id',$institute_id);
			$this->db->where('quid', $quid);
			$this->db->delete('quiz_qids');
			foreach($_POST['cid'] as $qkey => $value){
			if($_POST['no_of_questions'][$qkey] >= "1"){
			$insert_data = array(
			'quid'	=>	$quid,
			'cid'	=>	$_POST['cid'][$qkey],
			'did'	=>	$_POST['did'][$qkey],
			'no_of_questions'	=>	$_POST['no_of_questions'][$qkey],
			'institute_id' => $institute_id
			);
		
			$this->db->insert('quiz_qids',$insert_data);
			}
			}
			return "Quiz added successfully";
			}else{
			return "Unable to add quiz";
			}
	}
 
 
 
  function assigned_groups($id)
 {
 $institute_id = $this->session->userdata('institute_id');

   $query = $this -> db -> query("select quiz_group.* from quiz_group where quid='$id' and institute_id = '$institute_id' ");

   if($query -> num_rows() >= 1)
   {
     $resultdata=$query->result();
     $gids=array();
     foreach($resultdata as $value){
     $gids[]=$value->gid;
     }
     return $gids;
   }
   else
   {
     return false;
   }
 }
 

  function assigned_questions($id)
 {
   $institute_id = $this->session->userdata('institute_id');
 	
	$query = $this -> db -> query("select quiz_qids.* from quiz_qids where quid='$id' and institute_id = '$institute_id' ");
	return $query -> result_array();

 
 }
 
 
 function add_question($quid,$qid){
 $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
 	$this->db->where('quid',$quid);
 	$query=$this->db->get('quiz');
 	$result=$query->row_array();
 	$qids=$result['qids_static'];
 	if($qids==""){
 	$qids=array();
 	}else{
 	$qids=explode(",",$qids);
 	}
 	$qids[]=$qid;
 	$qids=array_filter(array_unique($qids));
 	$qids=implode(",",$qids);
 	$userdata=array(
 	'qids_static'=>$qids
 	);
 		$this->db->where('quid',$quid);
	$this->db->update('quiz',$userdata);
 }


function assigned_questions_manually($quid){
 $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
 	$this->db->where('quid',$quid);
 	$query=$this->db->get('quiz');
 	$result=$query->row_array();
 	$qids=$result['qids_static'];
 	
 	if($qids!=""){
 	$qrr="SELECT qbank.*,question_category.*,difficult_level.level_name FROM qbank JOIN question_category ON qbank.cid = question_category.cid JOIN difficult_level on qbank.did=difficult_level.did where  qid in ($qids) ORDER BY FIELD(qbank.qid, $qids ) ";
 		$query = $this -> db -> query($qrr);
 	
	return $query->result();
	}else{
	return false;
	}
}

function remove_question_quiz($quid,$qid){
 $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
 	$this->db->where('quid',$quid);
 	$query=$this->db->get('quiz');
 	$result=$query->row_array();
 	$qids=$result['qids_static'];
 	if($qids==""){
 	$qids=array();
 	}else{
 	$qids=explode(",",$qids);
 	}
 	$qids_new=array();
 	foreach($qids as $k => $qval){
 	if($qval != $qid){
 	$qids_new[]=$qval;
 	}
 	}
 	
 	$qids=array_filter(array_unique($qids_new));
 	$qids=implode(",",$qids);
 	$userdata=array(
 	'qids_static'=>$qids
 	);
 		$this->db->where('quid',$quid);
	$this->db->update('quiz',$userdata);

}

function up_question($quid,$qid){
 $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
 	$this->db->where('quid',$quid);
 	$query=$this->db->get('quiz');
 	$result=$query->row_array();
 	$qids=$result['qids_static'];
 	if($qids==""){
 	$qids=array();
 	}else{
 	$qids=explode(",",$qids);
 	}
 	$qids_new=array();
 	foreach($qids as $k => $qval){
 	if($qval == $qid){

 	$qids_new[$k-1]=$qval;
	$qids_new[$k]=$qids[$k-1];
	
 	}else{
	$qids_new[$k]=$qval;
 	
	}
 	}
 	
 	$qids=array_filter(array_unique($qids_new));
 	$qids=implode(",",$qids);
 	$userdata=array(
 	'qids_static'=>$qids
 	);
 		$this->db->where('quid',$quid);
	$this->db->update('quiz',$userdata);

}



function down_question($quid,$qid){
 $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
 	$this->db->where('quid',$quid);
 	$query=$this->db->get('quiz');
 	$result=$query->row_array();
 	$qids=$result['qids_static'];
 	if($qids==""){
 	$qids=array();
 	}else{
 	$qids=explode(",",$qids);
 	}
 	$qids_new=array();
 	foreach($qids as $k => $qval){
 	if($qval == $qid){

 	$qids_new[$k]=$qids[$k+1];
$kk=$k+1;
	$kv=$qval;
 	}else{
	$qids_new[$k]=$qval;
 	
	}

 	}
 	$qids_new[$kk]=$kv;
	
 	$qids=array_filter(array_unique($qids_new));
 	$qids=implode(",",$qids);
 	$userdata=array(
 	'qids_static'=>$qids
 	);
 		$this->db->where('quid',$quid);
	$this->db->update('quiz',$userdata);

}



  function remove_quiz($id)
 {
   $institute_id = $this->session->userdata('institute_id');
 	$this->db->where('institute_id',$institute_id);
   if($this->db->delete('quiz', array('quid' => $id)))
   {

 	$this->db->where('institute_id',$institute_id);
   $this->db->delete('quiz_qids', array('quid' => $id));

 	$this->db->where('institute_id',$institute_id);
   $this->db->delete('quiz_group', array('quid' => $id));
     return true;
   }
   else
   {
     return false;
   }
 }

 function get_quiz_data($id){
 $institute_id = $this->session->userdata('institute_id');
  $query = $this -> db -> query("select quiz.* from quiz where quid='$id' and institute_id = '$institute_id'");
	return $query->row_array();
  }
  
 function get_question($rid){
 $institute_id = $this->session->userdata('institute_id');
 	
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and institute_id='$institute_id'");
	$row=$query->row_array();
	$qids=$row['qids'];

	$query = $this -> db -> query("SELECT * FROM  `qbank` JOIN question_category ON qbank.cid = question_category.cid WHERE qbank.qid IN ( $qids ) and qbank.institute_id ='$institute_id'  ORDER BY FIELD(qid, $qids )");
	$questions=$query->result_array();
	$query = $this -> db -> query("SELECT * FROM  q_options WHERE qid IN ( $qids )  and institute_id = '$institute_id'");
	$options=$query->result_array();
	$dataarr=array($questions,$options);
	return $dataarr;
  }
 
 function get_user_answer($rid){
	 $this->db->where('r_id',$rid);
	 $query = $this->db->get("essay_qsn");
	 return $query->result_array();
	 
 }
  function get_time_info($rid){
  $institute_id = $this->session->userdata('institute_id');
 	
  $current_time=time();
  $this->db->query("update quiz_result set time_spent=($current_time-start_time) where rid='$rid' and institute_id = '$institute_id' ");
  
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and institute_id ='$institute_id'");
	return $query->row_array();
	}


 function quiz_detail($id)
 {
 $institute_id = $this->session->userdata('institute_id');
   $query = $this -> db -> query("select quiz.* from quiz where quid='$id' and institute_id = '$institute_id' ");

   if($query -> num_rows() >= 1)
   {
     return $query->row();
   }
   else
   {
     return false;
   }
 }
 
 
 function quiz_verify($id){
 	$institute_id = $this->session->userdata('institute_id');
	if($this->input->cookie('rid', TRUE)){
 	//check if there is any test already started
	$rid=$this->input->cookie('rid', TRUE);
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and institute_id ='$institute_id'");
	$row=$query->row_array();
	$time_spent=$row['time_spent'];
 	$quid=$row['quid'];
	$query = $this -> db -> query("select quiz.* from quiz where quid='$quid' and institute_id ='$institute_id'");
	$row=$query->row_array();
	$start_time=$row['start_time'];
	$end_time=$row['end_time'];
	$duration=$row['duration'];
	// check quiz end time
	if($end_time <= time()){
	return "Quiz not available. Available time has been passed  ";
	}
	if($time_spent >= ($duration * 60 )){
	return "Time over";
	}
	return "1";
 }else{
 // check for new test attempt
	$query = $this -> db -> query("select quiz.* from quiz where quid='$id' and institute_id = '$institute_id'");
	$row=$query->row_array();
	$quid=$row['quid'];
	$userdata=$this->session->userdata('logged_in');
 	$uid=$userdata['id'];
 	$gid=$userdata['gid'];
	$query = $this -> db -> query("select users.* from users where id='$uid' and institute_id = '$institute_id'");
	$row2=$query->row_array();
	// if quiz assign to user group
	$query = $this -> db -> query("select quiz_group.* from quiz_group where gid='$gid' and quid='$quid' and institute_id = '$institute_id' ");
	$assigngid=$query -> num_rows();
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	if($assigngid!="1"){
	return "This quiz is not assigned to your group";
	}
	}
	// check quiz start time
	if($row['start_time'] >= time()){
	return "Quiz is not available yet!";
	}
	// check quiz end time
	if($row['end_time'] <= time()){
	return "Quiz not available. Available time has been passed  ";
	}
	// check maximum attempts
	$query = $this -> db -> query("select quiz_result.* from quiz_result where uid='$uid' and quid='$quid' and institute_id = '$institute_id'");
	$attempted=$query -> num_rows();
	if($attempted >= $row['max_attempts']){
	return "You have been reached maximum attempts available for this quiz";
	}
	// valid ip address 
	$ip_address=$row['ip_address'];
	if($ip_address !=""){
	$ip_address=explode(",",$ip_address);
	$myip=$_SERVER['REMOTE_ADDR'];
	if(!in_array($myip,$ip_address)){
	return "Permission declined for your IP Address '".$myip."'";
	
	}
	}
	// check if user have sufficient credit
	if($row2['credit'] < $row['credit']){
	return "You don't have sufficient credit to attempt this quiz";
	}else{
		$rcq=$row['credit'];
	$query = $this -> db -> query("update users set credit=( credit - $rcq ) where id='$uid' ");

	}
	if($row['qselect']=="0"){
	$assignqids=$row['qids_static'];
		$qids=array();
	$category_names=array();
	$qids_range=array();
$rng=array();
		$query = $this -> db -> query("SELECT qbank.*,question_category.* FROM qbank JOIN question_category ON qbank.cid = question_category.cid where  qbank.institute_id = '$institute_id' and qid in ($assignqids) ORDER BY FIELD(qbank.qid, $assignqids ) ");
	$qidarr=$query->result_array();
	
	foreach($qidarr as $key => $qid){
	$qids[]=$qid['qid'];
	$category_names[]=$qid['category_name'];
	
	
	}
$rngarr=array();
$cateselected=array();
foreach($category_names as $key => $cval){
if(in_array($cval,$cateselected)){
$rngarr[$cval]+=1;
}else{
$cateselected[]=$cval;
$rngarr[$cval]=1;
}
}
$category_names=array();
$ii=0;
foreach($rngarr as $rk => $rval){
$category_names[]=$rk;
$rng[]=$ii."-".($ii+$rval-1);
$ii+=$rval;
}
$qids_range=$rng;

	}else{
	// fetch assigned quids
	$qids=array();
	$category_names=array();
	$qids_range=array();
	$query = $this -> db -> query("select quiz_qids.* from quiz_qids where quid='$quid' and institute_id = '$institute_id' ");
	$result=$query -> result_array();
	$rng=0;
	foreach($result as $key => $val ){
	$cid=$val['cid'];
	$did=$val['did'];
	$noq=$val['no_of_questions'];
	$query = $this -> db -> query("SELECT qbank.*,question_category.* FROM qbank JOIN question_category ON qbank.cid = question_category.cid where qbank.cid='$cid' and qbank.did='$did' and qbank.institute_id = '$institute_id' ORDER BY RAND() limit $noq ");
	$qidarr=$query->result_array();
	
	foreach($qidarr as $key => $qid){
	$qids[]=$qid['qid'];
	}
	$category_names[]=$qid['category_name'];
	$qids_range[]=$rng."-".($key+$rng);
	$rng=$rng+$key+1;
	}
	}
	
	
	$time_Spent_ind=array();
	$roids=array();
	for($x=1; $x <=count($qids); $x++){
	$time_Spent_ind[]="0";
	$roids[]="0";
	}
	$time_Spent_ind=implode(",",$time_Spent_ind);
	$qids=implode(",",$qids);
	$roids=implode(",",$roids);
	$category_names=implode(",",$category_names);
	$qids_range=implode(",",$qids_range);
	$photo="";
	if($this->session->flashdata('photoname')){
	$photo=$this->session->flashdata('photoname');
	}
	$insert_data = array(
			'uid' => $uid,
			'quid' => $quid,
			'oids' => $roids,
			'qids' => $qids,
			'category_name' => $category_names,
			'qids_range' => $qids_range,
			'start_time' => time(),
			'last_response' => time(),
			'time_spent' => '0',
			'time_spent_ind' => $time_Spent_ind,
			'institute_id' => $institute_id,
			'photo'=>$photo
			);
			
			if($this->db->insert('quiz_result',$insert_data)){
			$rid=$this->db->insert_id();
			$cookie = array(
			'name'   => 'rid',
			'value'  => $rid,
			'expire' => '86500'
			);

			$this->input->set_cookie($cookie);
			return "1";
	}
  
     
  	
 }
 }
 
 
 
 
 
 function quiz_submit($id){
 
 $institute_id =$this->session->userdata('institute_id');
 
 // result id
 $rid=$this->input->cookie('rid', TRUE);
 $this->db->where('rid',$rid);
 $query=$this->db->get('quiz_result');
 $result=$query->row_array();
 $r_qids=$result['qids'];
	$fillups=array();	
	$match_options=array();
$question_option_val[]=array();
$ans_val[]=array();	
$noq=$_POST['noq'];
$essay_question="0";
$oids=array();
for($x=0; $x<=$noq; $x++){
if(($_POST['q_type'.$x])=="0"){
if($_POST['answers'.$x]){
$oids[$x]=$_POST['answers'.$x];
}else{
$oids[$x]=0;
}
}
if(($_POST['q_type'.$x])=="1"){
if($_POST['answers'.$x]){
	
$oids[$x]=implode("-",$_POST['answers'.$x]);
	
}else{
$oids[$x]=0;
}
}

if(($_POST['q_type'.$x])=="2" || ($_POST['q_type'.$x])=="3"){
	$r_qids_q=explode(",",$r_qids);
if(isset($_POST['answers'.$x])){
	 $data_user = array(
   'r_id' => $rid ,
   'q_id' => $r_qids_q[$x] ,
   'essay_cont' => $_POST['answers'.$x] ,
   'q_type' => $_POST['q_type'.$x]
);
$this->db->where('q_id',$r_qids_q[$x]);
$this->db->where('r_id',$rid);
$query=$this->db->get('essay_qsn');
if($query->num_rows()==0){
$this->db->insert('essay_qsn', $data_user);
}else{
	$data_user1 = array(
   'essay_cont' => $_POST['answers'.$x] 
);
	$this->db->where('r_id',$rid);
	$this->db->where('q_id',$r_qids_q[$x]);
	$this->db->update('essay_qsn', $data_user1);
	
} 
$oids[$x]=$_POST['fill_blank'.$x];
	$fillups[]=$_POST['answers'.$x];
}else{
$oids[$x]=0;
}
}
if(($_POST['q_type'.$x])=="4"){
	$r_qids_q=explode(",",$r_qids);
if($_POST['answers'.$x]){
	$oids[$x]="0";
 //echo $_POST['answers'.$x];
 $data = array(
   'r_id' => $rid ,
   'q_id' => $r_qids_q[$x] ,
   'essay_cont' => $_POST['answers'.$x]
);

$this->db->insert('essay_qsn', $data); 
	$essay_question="1";
}else{
$oids[$x]=0;
}
}

if(($_POST['q_type'.$x])=="5"){
	//print_r($_POST['answers'.$x]);
	//echo count($_POST['answers'.$x])."<br>";
if($_POST['answers'.$x]){
	$chek_att="0";
	foreach($_POST['answers'.$x] as $vlll){
		if($vlll!=""){
			
			$chek_att="1";
		}
		
	}
	if($chek_att=="1"){
$oids[$x]=implode("-",$_POST['question_option'.$x]);
$_POST['question_option_val'.$x];
$_POST['answers'.$x];

 $no_match_answer=count($_POST['question_option_val'.$x]);
		for($x1=0; $x1<$no_match_answer; $x1++){
			//echo $question_option_val[$x1];
		
		$match_options[]=$_POST['question_option_val'.$x][$x1]."=".$_POST['answers'.$x][$x1];
		}
		
		$r_qids_q=explode(",",$r_qids);
		$data = array(
   'r_id' => $rid ,
   'q_id' => $r_qids_q[$x] ,
   'essay_cont' => implode(",",$match_options) ,
   'q_type' => $_POST['q_type'.$x]
);

$this->db->insert('essay_qsn', $data); 
	


}else{
$oids[$x]=0;
}
}
}


}

//  implode array of selected option ids
$oid=implode(",",$oids);
 
// fetch quiz detail
 	$query = $this -> db -> query("select quiz.* from quiz where quid='$id' and institute_id = '$institute_id'");
	$quiz=$query->row_array();
  	$correct_score=explode(",",$quiz['correct_score']);
  	$incorrect_score=explode(",",$quiz['incorrect_score']);
  	$min_percentage=$quiz['pass_percentage'];
  	// fetch options score
	$oid_r=str_replace('-',',',$oid);
  	$query = $this -> db -> query("SELECT q_options.*, qbank.* FROM  q_options, qbank WHERE q_options.oid IN ( $oid_r ) and q_options.qid=qbank.qid order by field(q_options.qid,$r_qids) ");
	$options=$query->result_array();
	$flip_r_qids=array_flip(explode(",",$r_qids));
	
	$score=0;
	// calculate score
	$fill=0;
	$match_column=0;
	$score_ind=array();
	$fliped_oidr=array();
	foreach(explode(",",$r_qids) as $xord => $xvord){
	$score_ind[$xord]=0;
	$fliped_oidr[$xvord]=$xord;
	}
	
	foreach($options as $value){
		if(!isset($pre_qid)){
		$score_ind_i=0;
			}else{
			if($pre_qid != $value['qid']){
			$score_ind[$fliped_oidr[$oid_pre_qid]]=$score_ind_i;
			$score_ind_i=0;
			 
			}
			
			}
		if($value['q_type']=="0"|| $value['q_type']=="1"){
		
	if($value['score'] > "0"){
		if(isset($correct_score[$flip_r_qids[$value['qid']]])){
			$score+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$value['score'] * $correct_score['0'];
			$score_ind_i+=$value['score'] * $correct_score['0'];
		}
	
	}else{
			if(isset($incorrect_score[$flip_r_qids[$value['qid']]])){
			$score+=$incorrect_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$incorrect_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$incorrect_score['0'];
			$score_ind_i+=$incorrect_score['0'];
			
		}
		

	}
	
	}
	if($value['q_type']=="2"){
	
		//echo $value['option_value']."---".$fillups[$fill];
	if(strtoupper(trim($value['option_value']))==strtoupper(trim($fillups[$fill]))){
		
		if(isset($correct_score[$flip_r_qids[$value['qid']]])){
			$score+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$value['score'] * $correct_score['0'];
			$score_ind_i+=$value['score'] * $correct_score['0'];
		}
	}else if($fillups[$fill] ==""){
	
	}else{
				if(isset($incorrect_score[$flip_r_qids[$value['qid']]])){
			$score+=$incorrect_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$incorrect_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$incorrect_score['0'];
			$score_ind_i+=$incorrect_score['0'];
		}	
	}
	
	$fill+=1;
	}
	
	if($value['q_type']=="3"){
		
	 if($fillups[$fill] !=""){
		$Short_answer = explode(",", $value['option_value']);
		$s_a_check="0";
	
		$no_Short_answer=count($Short_answer);
		
		for($x=0; $x<$no_Short_answer; $x++){
			
	if(strtoupper(trim($Short_answer[$x]))==strtoupper(trim($fillups[$fill]))){
		//echo "<br>".$fillups[$fill]."---".$Short_answer[$x];
			if(isset($correct_score[$flip_r_qids[$value['qid']]])){
			$score+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$value['score'] * $correct_score['0'];
			$score_ind_i+=$value['score'] * $correct_score['0'];
		}
	$s_a_check="1";
	}
		}
		if($s_a_check=="0"){
						if(isset($incorrect_score[$flip_r_qids[$value['qid']]])){
			$score+=$incorrect_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$incorrect_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$incorrect_score['0'];
			$score_ind_i+=$incorrect_score['0'];
		}
			
		}
	}
	
	$fill+=1;
	}
	
	
	
	if($value['q_type']=="5"){
	
		//echo "<br>".$match_options[$match_column]."---".$value['option_value'];
	 if(in_array($value['option_value'],$match_options)){
		
			if(isset($correct_score[$flip_r_qids[$value['qid']]])){
			$score+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
			$score_ind_i+=$value['score'] * $correct_score[$flip_r_qids[$value['qid']]];
		}else{
			$score+=$value['score'] * $correct_score['0'];
			$score_ind_i+=$value['score'] * $correct_score['0'];
		}
	}else{
				if(isset($incorrect_score[$flip_r_qids[$value['qid']]])){
			$score+=$incorrect_score[$flip_r_qids[$value['qid']]]/count($match_options);
			$score_ind_i+=$incorrect_score[$flip_r_qids[$value['qid']]]/count($match_options);
		}else{
			$score+=$incorrect_score['0']/count($match_options);
			$score_ind_i+=$incorrect_score['0']/count($match_options);
		}
	//$score+=$incorrect_score/count($match_options);	
	}
	$match_column+=1;
	
	//exit;
	}
	
	$pre_qid=$value['qid'];
	$oid_pre_qid=$value['qid'];
	
	}
	$score_ind[$fliped_oidr[$value['qid']]]=$score_ind_i;
		 
	// calculate percentage
	$query = $this -> db -> query("select quiz_result.* from quiz_result where rid='$rid' and institute_id = '$institute_id'");
	$qr=$query->row_array();
  	//( obtained score /(number of question * correct score) )*100
  	if(count($correct_score) >= "2"){
	$percentage=($score / (	array_sum($correct_score) ))* 100;
	}else{
	$percentage=($score / (count(explode(",",$qr['qids'])) * 	$correct_score['0'] ))* 100;
	}
  	// user pass or fail
  	if($percentage >= $min_percentage){
  	$q_result="1";
  	}else{
  	$q_result="0";
  	}
  	$time_spent=time()-$qr['start_time'];
	$score_ind=implode(",",$score_ind);
	if($essay_question >="1"){
	$q_result="2";
	}
	$insert_data = array(
			'oids'=>$oid,
			'end_time'=>time(),
			'score'=>$score,
			'percentage'=>$percentage,
			'q_result'=>$q_result,
			'time_spent'=>$time_spent,
			'essay_ques'=>$essay_question,
			'score_ind'=>$score_ind,
			'status' => '1'
			);
			
			$this->db->where('institute_id', $institute_id);
		$this->db->where('rid', $rid);
	if($this->db->update('quiz_result',$insert_data)){

	if($this->config->item('allow_result_email')){
	$this->load->library('email');
	$query = $this -> db -> query("select quiz_result.*,users.*,quiz.* from quiz_result, users, quiz where users.id=quiz_result.uid and quiz.quid=quiz_result.quid and quiz_result.rid='$rid'");
	$qrr=$query->row_array();
  		if($this->config->item('protocol')=="smtp"){
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = $this->config->item('smtp_hostname');
			$config['smtp_user'] = $this->config->item('smtp_username');
			$config['smtp_pass'] = $this->config->item('smtp_password');
			$config['smtp_port'] = $this->config->item('smtp_port');
			$config['smtp_timeout'] = $this->config->item('smtp_timeout');
			$config['mailtype'] = $this->config->item('smtp_mailtype');
			$config['starttls']  = $this->config->item('starttls');
			
			$this->email->initialize($config);
		}
			$toemail=$qrr['email'];
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject=$this->config->item('result_subject');
			$message=$this->config->item('result_message');
			
			$subject=str_replace('[username]',$qrr['username'],$subject);
			$subject=str_replace('[email]',$qrr['email'],$subject);
			$subject=str_replace('[first_name]',$qrr['first_name'],$subject);
			$subject=str_replace('[last_name]',$qrr['last_name'],$subject);
			$subject=str_replace('[quiz_name]',$qrr['quiz_name'],$subject);
			$subject=str_replace('[score_obtained]',$qrr['score'],$subject);
			$subject=str_replace('[percentage_obtained]',$qrr['percentage'],$subject);
			$subject=str_replace('[current_date]',date('Y-M-d H:i:s',time()),$subject);
			if($qrr['status']=="1"){
			$rstatus="Passed";
			}else{
			$rstatus="Failed";
			}
			$subject=str_replace('[result_status]',$rstatus,$subject);
			
			$message=str_replace('[username]',$qrr['username'],$message);
			$message=str_replace('[email]',$qrr['email'],$message);
			$message=str_replace('[first_name]',$qrr['first_name'],$message);
			$message=str_replace('[last_name]',$qrr['last_name'],$message);
			$message=str_replace('[quiz_name]',$qrr['quiz_name'],$message);
			$message=str_replace('[score_obtained]',$qrr['score'],$message);
			$message=str_replace('[percentage_obtained]',$qrr['percentage'],$message);
			$message=str_replace('[current_date]',date('Y-M-d H:i:s',time()),$message);
			$message=str_replace('[result_status]',$rstatus,$message);
			
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 //print_r($this->email->print_debugger());
			
			}
	}
			delete_cookie("rid");
			return "Quiz submitted successfully. <a href='".site_url('result/view/'.$rid.'/'.$id)."'>Click here</a> to view result";
			
			}else{
			
			return "Unable to submit quiz";
			}
 
 
 }
 
 
}
?>
