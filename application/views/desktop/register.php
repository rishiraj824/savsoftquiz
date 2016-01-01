









    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register new account</h3>
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
 
 
 
                    	
	<form method="post" action="<?php echo site_url('login/register_user');?>">



                            <fieldset>
                                <div class="form-group">
								<label>Username</label>
                               <input class="form-control" name="username"  type="text" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
								<label>First Name</label>
                               <input class="form-control" name="first_name"  type="text" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
								<label>Last Name</label>
                               <input class="form-control" name="last_name"  type="text" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
								<label>Email</label>
                               <input class="form-control" name="user_email"  type="text" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
								<label>Password</label>
                               <input class="form-control" name="user_password"  type="password" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
								<label>Confirm Password</label>
                               <input class="form-control" name="confirm_password"  type="password" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
								<label>Group</label>
                                <select name="user_group" class="form-control">
					<?php foreach($allgroups as $key => $group){ ?>
						<option value="<?php echo $group['gid']; ?>"><?php echo $group['group_name']; ?></option>
					<?php } ?>
				</select>
				
				</div>
                              
                                <div class="checkbox">
                                    <label>
                                       <!--
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        -->
                                   
 <a href="<?php echo site_url('login/');?>">Already Registered ? Login Now</a> &nbsp;&nbsp;&nbsp;&nbsp;

                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">Submit</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>









