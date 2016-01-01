

<?php 
$logged_in=$this->session->userdata('logged_in');

if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 
 <div style="margin-top:10px;">
<?php
if($logged_in['su']=="1"){
?>
 <a href="<?php echo site_url('quiz/add_new');?>" class="btn btn-success">Add new</a>
<?php 
}
?>
<a href="javascript:showhiddendiv('searchbox');" class="btn btn-warning">Search</a>
  <div class="searchbox form-group" id="searchbox">
<form method="post" action="<?php echo site_url('quiz');?>">
 <select name="search_type" class="form-control"   style="width:150px;float:left;"  >
<option value="quiz.quid">ID</option>
<option value="quiz.quiz_name">Quiz Name</option>
<option value="quiz.start_time">Start time</option>
<option value="quiz.end_time">End time</option>
<option value="quiz.duration">Duration</option>
</select>  
<input type="text" name="search" class="form-control" style="width:150px;float:left;margin-left:10px;" value=""> 
<input type="submit"   value="Search"  class="btn btn-default" style="float:left;margin-left:10px;"></form>
 <div style="clear:both;"></div></div><div style="clear:both;"></div>
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
                            <form method="post" action="<?php echo site_url('qbank/remove_qids/'.$limit);?>" id="removeqids">
                                <table class="table table-hover">
                                    <thead>
                                        <tr><th>Id</th><th>Quiz name</th><th>Start time</th><th>End time</th><th>Duration</th><th>Action</th></tr>

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
<td  data-th="Id"><?php echo $row->quid;?></td><td  data-th="Quiz Name"><?php echo $row->quiz_name;?></td>
<td data-th="Start Time"><?php echo date('Y/m/d',$row->start_time);?></td>
<td  data-th="End Time"><?php echo date('Y/m/d',$row->end_time);?></td>
<td  data-th="Duration"><?php echo $row->duration;?> Min. </td>
<td data-th="Action">
<a href="<?php echo site_url('quiz/attempt/'.$row->quid);?>"  class="btn btn-warning btn-xs">Attempt</a>
&nbsp;&nbsp;
<?php
if($logged_in['su']=="1"){
?>
<a href="javascript: if(confirm('Do you really want to remove this quiz?')){ window.location='<?php echo site_url('quiz/remove_quiz/'.$row->quid );?>'; }" class="btn btn-danger btn-xs">Remove</a> <a href="<?php echo site_url('quiz/edit_quiz/'.$row->quid );?>"  class="btn btn-info btn-xs">Edit</a>
<?php
}
?>
</td>
</tr>
								<?php
								}
								}

								?>






								


 
                                    </tbody>
                                </table></form>
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

<a href="<?php echo site_url('quiz/index/'.$back);?>" class="btn btn-primary">Back</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('quiz/index/'.$next);?>" class="btn btn-primary">Next</a>




