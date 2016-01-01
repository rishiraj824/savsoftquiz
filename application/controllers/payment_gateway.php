<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_gateway extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->helper(array('form', 'url'));
   $this->load->library('form_validation');
   $this->load->model('payment_model','',TRUE);
  $this->load->model('user','',TRUE);
   
 }

 function index($pg,$uid='')
 {
			$data['user'] = $this->user->get_user($uid,'1');
	$data['title']="Buy credit";
   $data['payment_gateway']=$pg;
   $data['uid']=$uid;
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/payment_gateway',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }
function success($pg='')
 {
 if($pg=="payu"){
	 if($_POST['status']=="success" && $_POST['key']==$this->config->item('payu_merchant_key')){
	 
	 $user_id=$_POST['udf1'];
	 $credit_paid=$_POST['amount'];
	 $credit=$credit_paid;



	$this->payment_model->update_credit($user_id,$credit);
redirect('payment_gateway/success_message');
	}
 }

 }
 
 
 public function success_message(){
 	$data['title']="Payment completed";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/payment_success',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }
 
 
function cancel()
 {
	$data['title']="";
   $this->load->view($this->session->userdata('web_view').'/header',$data);
   $this->load->view($this->session->userdata('web_view').'/payment_cancel',$data);
  	$this->load->view($this->session->userdata('web_view').'/footer',$data);
 }

 function paypal_ipn(){
 $paypalmode = '';  
  if($_POST)
{
        if($paypalmode=='sandbox')
        {
            $paypalmode     =   '.sandbox';
        }
        $req = 'cmd=' . urlencode('_notify-validate');
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www'.$paypalmode.'.sandbox.paypal.com'));
        $res = curl_exec($ch);
        curl_close($ch);

        if (strcmp ($res, "VERIFIED") == 0)
        {
            $transaction_id = $_POST['txn_id'];
            $payerid = $_POST['payer_id'];
            $firstname = $_POST['first_name'];
            $lastname = $_POST['last_name'];
            $payeremail = $_POST['payer_email'];
            $paymentdate = $_POST['payment_date'];
            $paymentstatus = $_POST['payment_status'];
            $payment_amount   = $_POST['mc_gross'];
            $mdate= date('Y-m-d h:i:s',strtotime($paymentdate));
            $otherstuff = json_encode($_POST);
			$user_id=$_POST['custom'];
			$fullname=$firstname.' '.$lastname;
   $result = $this->payment_model->get_ipn($transaction_id);
	
if($result >= "1"){
// it is duplicate id
exit;
}
            // insert in our IPN record table
			$this->payment_model->add_ipn($transaction_id,$payerid,$fullname,$payeremail,$mdate,$paymentstatus,$otherstuff);
           // update credit
			$credit=$this->config->item('no_credit');
			$this->payment_model->update_credit($user_id,$credit);

        }
}



 }
 
function verify_coupon($credit,$c_code){
$coupon = $this->payment_model->verify_coupan($c_code);
if($coupon != 0 ){
$C_amnt=$coupon['c_amount'];
$C_percent=$coupon['c_percent'];
if($C_amnt==0){
$Dis_per=$C_percent;
}else if($C_percent==0){
$Dis_per=($C_amnt/$credit)*100;
}

if($Dis_per > "100"){
$Dis_per="100";
}

$payable=$credit-(($Dis_per*$credit)/100);
$sess_array = array(
         'id' => $coupon['c_id'],
         'C_amnt' => $credit,
         'payable' => $payable
       );
       $this->session->set_userdata('coupon_sess', $sess_array);
      echo $payable;
}else{
echo "invalid";
}
}
 
 
 

 
}

?>


















