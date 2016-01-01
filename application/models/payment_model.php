<?php
Class Payment_model extends CI_Model
{
 function get_ipn($transaction_id)
 {
   //$nor=$this->config->item('number_of_rows');
   $query = $this -> db -> query("select * from paypal_ipn where transaction_id='$transaction_id' ");

   return $query -> num_rows();
 }

function add_ipn($transaction_id,$payerid,$firstname,$payeremail,$mdate, $paymentstatus,$otherstuff){

 $this -> db -> query("INSERT INTO ipn_table
            (itransaction_id,ipayerid,iname,iemail,itransaction_date, ipaymentstatus,ieverything_else)
            VALUES
            ('$transaction_id','$payerid','$firstname','$payeremail','$mdate', '$paymentstatus','$otherstuff')");

}
 	

function update_credit($user_id,$credit){
  
  $this -> db -> query("update users set credit=( credit + $credit ) where id='$user_id' ");



}
function verify_coupan($c_code){

$this->db->where('c_code', $c_code); 
$query = $this->db->get('dis_coupon');
if ($query->num_rows() == 1)
{
return $query->row_array();
}else{ 
return 0;
}
}
	
}
?>

