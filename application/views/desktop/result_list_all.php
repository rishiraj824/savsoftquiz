<?php
$logged_in=$this->session->userdata('logged_in');
if($logged_in['su']=="1"){

?><br>
<a href="javascript:showhiddendiv('searchbox');" class="btn btn-warning">Search</a>
<a href="javascript:showhiddendiv('reportbox');" class="btn btn-success">Report</a>
<div class="searchbox" id="reportbox">
 
<form method="post" action="<?php echo site_url('result/get_report');?>">
<span style="float:left;margin-left:10px;">Generate report </span>
 <select name="file_format"  class="form-control"   style="width:150px;float:left;margin-left:10px;"  >
<option value="pdf">PDF</option>
<option value="csv">CSV</option>
</select> <select name="gid"   class="form-control"   style="width:150px;float:left;margin-left:10px;"  >
<option value="0">Select Group</option>
<?php foreach($group_list as $value){ ?>
<option value="<?php echo $value['gid'];?>"><?php echo $value['group_name'];?></option>
<?php } ?>
</select>  &nbsp;
 <select name="quid"  class="form-control"   style="width:150px;float:left;margin-left:10px;"  >
<option value="0">Select Quiz</option>
<?php foreach($quiz_list as $value){ ?>
<option value="<?php echo $value['quid'];?>"><?php echo $value['quiz_name'];?></option>
<?php } ?>
</select> 
<input type="submit" name="generate" value="Generate"  class="btn btn-default" style="float:left;margin-left:10px;">

</form>
 <div style="clear:both;"></div>
 
</div>

<?php
}
?>
<div class="searchbox" id="searchbox">
 <form method="post" action="<?php echo site_url('result');?>">
 <select name="search_type" class="form-control"   style="width:150px;float:left;" >
<option value="quiz_result.rid">ID</option>
<option value="users.username">Username</option>
<option value="users.first_name">First Name</option>
<option value="users.last_name">Last Name</option>
<option value="quiz.quiz_name">Quiz Name</option>
<option value="quiz_result.score">Score</option>
<option value="quiz_result.percentage">Percentage</option>
</select> 
<input type="text" name="search" value="" class="form-control"   style="width:150px;float:left;margin-left:10px;" > 
<input type="submit" value="Search"  class="btn btn-default" style="float:left;margin-left:10px;" ></form>  <div style="clear:both;"></div>
</div>
<div class="row" style="margin-top:10px;">
                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if($title){ echo $title; } ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
									<tr><th >Id</th>
									<th>Username</th>
									<th>First name</th>
									<th>Last name</th>
									<th>Quiz name</th>
									<th>Score</th>
									<th>Percentage</th>
									<th>Result</th>
									<th>Action</th></tr>
                                    </thead>
                                    <tbody>
<?php
if($result==false){
?>
<tr>
<td colspan="5">
No record foud!
</td>
</tr>
<?php

}else{
foreach($result as $row){
?>									
									
									<tr>
<td data-th="ID"><?php echo $row->rid;?></td>
<td data-th="Username"><?php echo $row->username;?></td>
<td data-th="First Name"><?php echo $row->first_name;?></td>
<td data-th="Last Name"><?php echo $row->last_name;?></td>
<td data-th="Quiz Name"><?php echo $row->quiz_name;?></td>
<td data-th="Score"><?php echo $row->score;?></td>
<td data-th="Percentage"><?php echo substr($row->percentage , 0, 5 );?>%</td>
<td data-th="Result"><?php if($row->q_result == "1"){  echo "Pass"; }else if($row->q_result == "0"){ echo "Fail"; }else{ echo "Pending"; } ?> </td>
<td data-th="Action">
<a href="<?php echo site_url('result/view/'.$row->rid.'/'.$row->quid);?>" class="btn btn-warning btn-xs">View</a>
<?php
if($logged_in['su']=="1" && $logged_in['id']=="1"){
?>
<a href="<?php echo site_url('result/remove_result/'.$row->rid);?>" class="btn btn-danger btn-xs">Remove</a>
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

<?php
if($logged_in['su']=="1"){
?>
<a href="<?php echo site_url('result/index/'.$back);?>"   class="btn btn-primary">Back</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('result/index/'.$next);?>"   class="btn btn-primary">Next</a>
<?php
}else{
?>
<a href="<?php echo site_url('result/user/'.$back);?>"   class="btn btn-primary">Back</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('result/user/'.$next);?>"  class="btn btn-primary">Next</a>
<?php
}
?> 
									
									
									
									
									
									
									
									
									
									
									