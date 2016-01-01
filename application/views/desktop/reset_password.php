









    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Reset Password</h3>
                    </div>

    <center>
<img src="<?php echo base_url();?>logo/logo.png" title="Logo">
</center>
               


                    <div class="panel-body">
                     <?php if(validation_errors()){ 
                        ?>
						
                        <div class="alert alert-danger">
                      <?php echo validation_errors(); ?>
                     </div>
                     <?php } ?>
					 
					 
 <?php 
if($this->session->flashdata('result')){ $result_r=$this->session->flashdata('result'); echo "<div class='alert alert-danger' >".$result_r."</div>"; }
 ?>
 
 
 
                    	
	
   <?php echo form_open('login/forgot/'); ?>



                            <fieldset>
                                <div class="form-group">
                               <input class="form-control" name="user_email" placeholder=" Registered Email ID" type="text" autofocus  AutoComplete=off >
                                </div>
                              
                                <div class="checkbox">
                                    <label>
                                       <!--
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        -->
                                   
 <a href="<?php echo site_url('login/');?>">Login</a> &nbsp;&nbsp;&nbsp;&nbsp;

 <?php
if($this->config->item('user_reg')){

?>
<span style="float:right;margin-right:20px;"><a href="<?php echo site_url('login/register/');?>">Sign up</a></span>
<?php
}
?>
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">Send new password</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

















	
	
