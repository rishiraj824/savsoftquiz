<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result extends CI_Controller {

 function __construct()
 {
   parent::__construct();
     $this->load->model('result_model','',TRUE);
    if(!$this->session->userdata('logged_in'))
   {
   redirect('login');
   }

 }

 function index($limit='0')
 {
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']!="1"){
exit('Permission denied');
return;
}		

   $data['result'] = $this->result_model->result_list_all($limit);
	$data['group_list'] = $this->result_model->group_list();
	$data['quiz_list'] = $this->result_model->quiz_list();
	$data['title']="Result";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/result_list_all',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
  	
 }

function get_report(){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit('Permission denied');
	return;
	}	
	if($this->input->post('generate')){
  	$file_format=$this->input->post('file_format');
  	$gid=$this->input->post('gid');
  	$quid=$this->input->post('quid');
  	$data['report']=$this->result_model->report($gid,$quid);
if($file_format=="pdf"){
	$this->load->library('pdf');
	$this->pdf->load_view($this->session->userdata('web_view').'/get_report',$data);
	$this->pdf->render();
	$filename=date('Y-M-d_H:i:s',time()).".pdf";
	$this->pdf->stream($filename);
	}else if($file_format=="csv"){
			$this->load->helper('download');
		
		$csvdata="Username,First name,Last name, Email, Group, Quiz Name, Score, Percentage, Result \r\n";
		foreach($data['report'] as $key=>$val){
if($val->q_result =="1"){
	$csvdata.=$val  ->username  .",".$val  ->first_name  .",".$val  ->last_name  .",".$val  ->email  .",".$val  ->group_name  .",".$val  ->quiz_name  .",".$val  ->score  .",".$val  ->percentage  ."%,Pass\r\n";
		}else{
			$csvdata.=$val  ->username  .",".$val  ->first_name  .",".$val  ->last_name  .",".$val  ->email  .",".$val  ->group_name  .",".$val  ->quiz_name  .",".$val  ->score  .",".$val  ->percentage  ."%,Fail\r\n";
	
		}
		}
		$filename=time().'.csv';
force_download($filename, $csvdata);

	}
	
  	}else{
  	redirect('result');
  	}		

	}
	
	
	
 function user($limit='0')
 {
$logged_in=$this->session->userdata('logged_in');
$user_id=$logged_in['id'];

   $data['result'] = $this->result_model->result_list_all($limit,$user_id);
	$data['title']="Result";
   $data['limit']=$limit;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/result_list_all',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }


 
 function view($id,$quid='')
 {
 $logged_in=$this->session->userdata('logged_in');
    // getting the last ten result of all users of particular quiz
   $last_ten_result = $this->result_model->last_ten_result($quid);
   $value=array();
     $value[]=array('Quiz Name','Percentage (%)');
     foreach($last_ten_result as $val){
     $value[]=array($val['username'].' ('.$val['first_name']." ".$val['last_name'].')',intval($val['percentage']));
     }
     $data['value']=json_encode($value);
    if($logged_in['su']=="1"){
   $data['result'] = $this->result_model->result_view($id);
   //print_r($data['result']->essay_ques);exit;
   if($data['result']->essay_ques=="1"){
   $data['result2'] = $this->result_model->result_view_essay($id);
   }
   $correct_score=explode(",",$data['result']->correct_score);
   
   $incorrect_score=explode(",",$data['result']->incorrect_score);
   //print_r($data['result']['essay_ques']);exit;
   }else{
   $user_id=$logged_in['id'];
   $data['result'] = $this->result_model->result_view($id,$user_id);
      $correct_score=explode(",",$data['result']->correct_score);
   
   $incorrect_score=explode(",",$data['result']->incorrect_score);
 
   }
	$correct_incorrect=explode(",",$data['result']->score_ind);
 $data['percentile'] = $this->result_model->get_percentile($quid, $data['result']->uid, $data['result']->score);
 

   
   $t_category_name=explode(",",$data['result']->category_name );
   $cct=array();
   $cct_per=array();
   $cct_per_total=array();
   $oids=explode(",",$data['result']->oids);
    foreach(explode(",",$data['result']->qids_range) as $rkey => $rval){
	if(!isset($cct[$t_category_name[$rkey]])){
	$cct[$t_category_name[$rkey]]=0;
	}
	$jj=explode("-",$rval);
	$j=$jj[0];
	$k=$jj[1];
		for($i=$j; $i<=$k; $i++){
		   foreach(explode(",",$data['result']->time_spent_ind) as $ckey => $cval){
				if($ckey==$i){
					$cct[$t_category_name[$rkey]] +=$cval;
					//echo $correct_incorrect[$ckey]."<br>";
					if($correct_incorrect[$ckey] >= 0.1 ){
					$cct_per[$t_category_name[$rkey]]+=$correct_incorrect[$ckey];
					}else if($oids[$ckey] == "0"){
					$cct_per[$t_category_name[$rkey]]+=0;
					}else{
					$cct_per[$t_category_name[$rkey]]+=$correct_incorrect[$ckey];
					}
					
					if(isset($correct_score[$ckey])){
					$cct_per_total[$t_category_name[$rkey]]+=$correct_score[$ckey];
					}else{
					$cct_per_total[$t_category_name[$rkey]]+=$correct_score['0'];
					}
					
				}
			
			}
		}
	}
	//print_r($cct_per_total);
   // getting the individual question time
     $oidss=explode(",",$data['result']->oids);
   $qtime=array();
   $ctime=array();
     $ctime[]=array('Subject','Time in Seconds');
     $qtime[]=array('Question Number','Time in Seconds');
     foreach(explode(",",$data['result']->time_spent_ind) as $key => $val){
       if($correct_incorrect[$key]>="0.1"){
	 $qtime[]=array("Q ".($key+1).") - Correct/Partially Correct",intval($val));
	 }else if($correct_incorrect[$key]==0 && $oidss[$key]!=0 ){
	  $qtime[]=array("Q ".($key+1).") - Wrong ",intval($val));
	 }else{
	  $qtime[]=array("Q ".($key+1).") - UnAttempted ",intval($val));
	 }
	 
     }
	 foreach($cct as $cck => $cckval){
	 $ctime[]=array($cck.' - Score: '.number_format((float)(($cct_per[$cck]/$cct_per_total[$cck])*100), 2, '.', '')."%",intval($cckval));
	 }
	
     $data['qtime']=json_encode($qtime);
    $data['ctime']=json_encode($ctime);
   $data['cct_per']=$cct_per;
   $data['cct_per_total']=$cct_per_total;
   
	$data['title']="Result #".$id;
 
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/result_view',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }

 
 function remove_result($rid){
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']=="1" && $logged_in['id']=="1"){
	$this->result_model->remove_result($rid);
	redirect('result');
	}else{

	exit('Permission denied!');
	}

}

 function view_answer($id)
 {
   $data['result'] = $this->result_model->result_view($id);
	$data['assigned_question'] = $this->result_model->get_question($id);
	$data['title']="Result"; 
	$data['id']=$id;
     $data['correct_incorrect']=explode(",",$data['result']->score_ind);
 
	$this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/view_answer',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }

 function add_score(){
	 	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
		exit;
		
	}
	
	 $q_id=$_POST['q_id'];
	 $r_id=$_POST['r_id'];
	 $opn=$_POST['opn'];
	 $data = array(
               'essay_score' => $opn,
               'essay_status' => "1"
            );

$this->db->where('q_id', $q_id);
$this->db->where('r_id', $r_id);
if($this->db->update('essay_qsn', $data)){
	
	$this->db->query("update quiz_result set score=(score+$opn) where rid='$r_id'");
	
	$this->db->where("quiz_result.rid",$r_id);
	$this->db->join("quiz","quiz.quid=quiz_result.quid");
	$qr=$this->db->get("quiz_result");
	$result=$qr->row_array();
	$correct_marks=explode(",",$result['correct_score']);
	$qids=explode(",",$result['qids']);
	$score=$result['score'];
	$score_ind=explode(",",$result['score_ind']);
	$min_per=$result['pass_percentage'];
	
	$noq=count($qids);
	$qids=array_flip($qids);
	$score_ind[$qids[$q_id]]=$opn;
	$score_ind=implode(",",$score_ind);
	if(count($correct_marks) > "1"){
	$perct=($score/(array_sum($correct_marks)))*100;
	}else{
	$perct=($score/($correct_marks['0']*$noq))*100;
	}
	
	$data1 = array(
               'percentage' => $perct,
               'score_ind' => $score_ind
            );
		$this->db->where('r_id', $r_id);
		$this->db->where('essay_status', '0');
		$this->db->where('q_type', '0');
		$queryrr=$this->db->get('essay_qsn');
		
		if($queryrr->num_rows()=="0"){
		if($perct >= $min_per){
		$data1['q_result']="1";
		}else{
		$data1['q_result']="0";
		}
		}
			
	$this->db->where('rid', $r_id);
if($this->db->update('quiz_result', $data1)){

	echo "1";
}else{
	
	echo "0";
}
}else{
	
	echo "0";
}
 
 }
 


}

?>
