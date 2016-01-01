<?php 
if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 
 <div style="margin-top:10px;">
<a href="<?php echo site_url('user_data/add_new');?>" class="btn btn-success">Add new</a>
 <a href="javascript:showhiddendiv('searchbox');" class="btn btn-warning">Search</a>
 <div class="searchbox form-group" id="searchbox">
 <form method="post" action="<?php echo site_url('user_data');?>">
  <select name="search_type" class="form-control" style="width:150px;float:left;">
<option value="users.id">ID</option>
<option value="users.username">Username</option>
<option value="users.first_name">First Name</option>
<option value="users.last_name">Last Name</option>
<option value="users.email">Email</option>
</select> 
<input type="text" name="search" class="form-control" style="width:150px;float:left;margin-left:10px;" value=""> 
<input type="submit" value="Search"  class="btn btn-default" style="float:left;margin-left:10px;"></form>
<div style="clear:both;"></div>
</div>

</div>


<div class="row" style="margin-top:10px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if($title){ echo $title; } ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Username</th>
                                             <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
								<?php
								if($result==false){
								?>
								<tr>
								<td colspan="6">
								No record foud!
								</td>
								</tr>
								<?php

								}else{
								foreach($result as $row){
								?>
								<tr>
								<td  data-th="ID"><?php echo $row->id;?></td>
								<td  data-th="Username"><?php echo $row->username;?></td>
								<td data-th="First Name"><?php echo $row->first_name;?></td>
								<td  data-th="Last Name"><?php echo $row->last_name;?></td>
								<td  data-th="Email"><?php echo $row->email;?></td>
								<td  data-th="Action"><a href="javascript: if(confirm('Do you really want to remove this user?')){ window.location='<?php echo site_url('user_data/remove_user/'.$row->id );?>'; }" class="btn btn-danger btn-xs">Remove</a> 
								<a href="<?php echo site_url('user_data/edit_user/'.$row->id );?>" class="btn btn-info btn-xs">Edit</a>
								<a href="<?php echo site_url('user_data/login_user_by_admin/'.$row->id );?>" class="btn btn-warning btn-xs">Login</a></td>
								</tr>
								<?php
								}
								}
								?>


 
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->

                <!-- /.col-lg-6 -->
</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('user_data/index/'.$back);?>"  class="btn btn-primary">Back</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('user_data/index/'.$next);?>"  class="btn btn-primary">Next</a>




















