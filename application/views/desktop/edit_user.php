
                     <?php if(validation_errors()){ 
                        ?>
                        <div class="alert alert-danger">
                      <?php echo validation_errors(); ?>
                     </div>
                     <?php } ?>

<?php 
if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 

<div class="row" style="margin-top:10px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if($title){ echo $title; } ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                  <form method="post" action="<?php echo site_url('user_data/update_user/'.$user_id);?>">

                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" type="text" name="username"  value="<?php echo $user['username']; ?>"  value="<?php echo $user['username']; ?>"  value="<?php echo $user['username']; ?>"  autocomplete="off">
										 </div>
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input class="form-control" type="text" name="first_name"  value="<?php echo $user['first_name']; ?>"  value="<?php echo $user['username']; ?>"  value="<?php echo $user['username']; ?>"   autocomplete="off">
										 </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" name="last_name"   value="<?php echo $user['last_name']; ?>"  value="<?php echo $user['username']; ?>"  autocomplete="off">
										 </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" name="user_email"   value="<?php echo $user['email']; ?>"  autocomplete="off">
										 </div>
                                    
                                        <div class="form-group">
                                            <label>Password (Optional) </label>
                                            <input class="form-control" type="password" name="user_password"  autocomplete="off">
										 </div>
                                    
                                        <div class="form-group">
                                            <label>Confirm Password (Optional)</label>
                                            <input class="form-control" type="password" name="confirm_password"  autocomplete="off">
										 </div>
                                    
                                        <div class="form-group">
                                            <label>Credit</label> 
                                            <input class="form-control" value="0"  readonly='readonly'  type="text" name="user_credit"  autocomplete="off" >
										 </div>
                                    
             							 <div class="form-group">
                                            <label>Group </label>
                                          	<select class="form-control" name="user_group">
											<?php foreach($allgroups as $key => $group){ ?>
											<option value="<?php echo $group['gid']; ?>"  <?php if($user['gid'] == $group['gid']){ echo "selected"; } ?> ><?php echo $group['group_name']; ?></option>
											<?php } ?>
											</select>
										 </div>
                         
        								 <div class="form-group">
                                            <label>Account type </label>
                                         <select class="form-control" name="account_type">
										<option value="0"  <?php if($user['su'] == "0"){ echo "selected"; } ?> >User</option>
										<option value="1"  <?php if($user['su'] == "1"){ echo "selected"; } ?> >Administrator</option>
										</select>
									    </div>
                         
                                       <div class="form-group">
                                            <label> </label>
                             				<input type="submit" value="Submit" class="btn btn-default">
										 </div>
 

                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>






















 







