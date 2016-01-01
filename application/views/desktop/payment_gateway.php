<div id="content" class="testd"><br>
<h3><?php if($title){ echo $title; } ?></h3><br>

<?php 
if($resultstatus){ echo "<div id='result'>".$resultstatus."</div>"; }
 ?>
<div class="wite">

<?php
if(($this->config->item('payment_gateway_paypal')) && $payment_gateway=="paypal"){

?>
&nbsp;&nbsp;&nbsp; <?php echo $this->config->item('no_credit');?> credit in $<?php echo $this->config->item('paypal_amount');?> USD

<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $this->config->item('paypal_receiver');?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="Quiz Credit">
<input type="hidden" name="notify_url" value="<?php echo site_url('payment_gateway/paypal_ipn');?>">
<input type="hidden" name="custom" value="<?php echo $user_id;?>">
<input type="hidden" name="return" value="<?php echo site_url('payment_gateway/success');?>">
<input type="hidden" name="cancel_return" value="<?php echo site_url('payment_gateway/cancel');?>">
<input type="hidden" name="amount" value="<?php echo $this->config->item('paypal_amount');?>">
<input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<?php
}
?>


<?php
if(($this->config->item('payment_gateway_payu')) && $payment_gateway=="PayU"){
?>
<?php
// Merchant key here as provided by Payu
$MERCHANT_KEY = $this->config->item('payu_merchant_key');

// Merchant Salt as provided by Payu
$SALT =  $this->config->item('payu_salt');
$txnid = $user['username'].'-'.$user['id'];
$hash_string = $MERCHANT_KEY."|".$txnid."|".$_POST['credit']."|Clatgurukul Credit|".$user['first_name']."|".$user['email']."|".$user['id']."||||||||||".$SALT;
$hash = hash('sha512', $hash_string);
    //print_r( $hash_string);
	//echo"<br>";
	//print_r($hash);
?>
<form method="POST" action="https://secure.payu.in/_payment">

 <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY; ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash; ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid; ?>" />
     
	 
	 
	 
	 <table>
        <tr>
          <td>Amount </td>
          <td><?php echo $_POST['credit'];?> INR</td></tr><tr>
          <td>First Name: </td>
          <td><?php echo $user['first_name'];?></td>
        </tr>
		<tr>
          <td>Last Name: </td>
          <td><?php echo $user['last_name'];?></td>
        </tr>
       <tr>
          <td>Phone: </td>
          <td><?php echo $_POST['phone'];?></td>
        </tr>
     <table>
	<input type="hidden" name="amount" value="<?php echo $_POST['credit'];?>" />
	<input type="hidden" name="phone" value="<?php echo $_POST['phone'];?>" />
	<input type="hidden" name="firstname" id="firstname" value="<?php echo $user['first_name'];?>" >
	<input type="hidden"  name="email" id="email" value="<?php echo $user['email'];?>"  />
	 <input type="hidden"  name="productinfo" value="Clatgurukul Credit">
		  <input type="hidden"  name="surl" value="<?php echo site_url('payment_gateway/success/payu');?>" size="64" />
		  <input type="hidden"  name="furl" value="<?php echo site_url('payment_gateway/cancel');?>" size="64" />
		  <input type="hidden"   name="service_provider" value="payu_paisa" size="64" />
<input  type="hidden"  name="udf1" value="<?php echo $user['id'];?>">
 
 <input type="submit" value="Proceed to Payment Gateway" class="btn btn-success" >
</form>

<br><br>



<?php
}
?>
<br>
<br><br>

</div>
</div>















