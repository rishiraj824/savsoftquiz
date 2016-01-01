	<script>
	function sortby(limi,cid){
window.location="<?php echo site_url();?>/qbank/index/0/"+cid;
}
	</script>
	<script type="text/javascript" src="<?php echo base_url();?>/js/basic.js"></script>

<?php 
if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 
 
<form method="post" action="<?php echo site_url('quiz/edit_quiz/'.$result->quid);?>">

<div class="row" style="margin-top:10px;">
                <div class="col-lg-9 col-sm-12 col-xs-12 col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if($title){ echo $title; } ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                   
                                        <div class="form-group">
                                            <label>Quiz Name</label>
		                                         <input type='text'  class="form-control"  name='quiz_name'  value="<?php echo $result->quiz_name;?>">

                                         </div>

	                                       <div class="form-group">
                                            <label>Quiz Description</label>
		                                      <textarea name="description"  ><?php echo $result->description;?></textarea> 
                                         </div>

	                                       <div class="form-group">
                                            <label>Quiz Duration in Minutes</label>
		                                        <input type='text' name='quiz_time_duration'  class="form-control"  value="<?php echo $result->duration;?>" > 
                                         </div>

	                                       <div class="form-group">
                                            <label>Start Time ( YYYY/MM/DD HH:MM:SS  )</label>
		                                          <input type='text' name='test_start_time'  class="form-control" value="<?php echo date('Y/m/d',$result->start_time);?>">  
                                         </div>

		                                       <div class="form-group">
                                            <label>End Time ( eg. 2014/10/31 23:59:59 )</label>
		                                          <input type='text' name='test_end_time'  class="form-control" value="<?php echo date('Y/m/d',$result->end_time);?>">  
                                         </div>

										 
	                                       <div class="form-group">
                                            <label>Percentage required to pass</label>
		                                        <select name="pass_percentage"  class="form-control">
												<?php for($i = 0;$i <= 100;$i++){ ?>
													<option value="<?php echo $i;  ?>"  <?php if($result->pass_percentage == $i){ echo "selected";}?> ><?php echo $i;  ?>%</option>
												<?php } ?>
											</select>
                                         </div>

										 
	                                       <div class="form-group">
                                            <label>Assign to Groups</label>
		                                          <?php
													$group_counter = 1; 
													foreach($groups as $key => $group){ ?>
														<?php echo $group['group_name']; ?><input type="checkbox" name="assigned_groups[]" value="<?php echo $group['gid']; ?>" <?php if(in_array($group['gid'],$assigned_gids)){ echo "checked";} ?> > &nbsp;&nbsp;
													<?php if($group_counter%5 == 0){ echo "</br>"; } $group_counter++; }  ?>
                                         </div>

										 
	                                       <div class="form-group">
                                            <label>Test type </label>
		                                         <input type='radio' name='test_type' value='0'  checked='checked'    >  Free
		<input type="hidden" name="test_charges" value="0"> 
                                         </div>

										 
	                                       <div class="form-group">
                                            <label>Allow to View Answer </label> &nbsp;&nbsp;
		                                          		<input type='radio' name='view_answer' value='1'  <?php if($result->view_answer == "1"){ echo "checked";}?> >Yes &nbsp;&nbsp;&nbsp;
														<input type='radio' name='view_answer' value='0'  <?php if($result->view_answer == "0"){ echo "checked";}?>  >No  
                                         </div>

									  <div class="form-group">
                                            <label>Maximum Attempts </label>
		                                          <select name="max_attemp"  class="form-control">
												<?php for($i = 1;$i <= 1000;$i++){ ?>
													<option value="<?php echo $i;  ?>" <?php if($result->max_attempts == $i){ echo "selected";}?> ><?php echo $i;  ?></option>
												<?php } ?>
												</select>
		
                                         </div>
	                                       <div class="form-group">
                                            <label>Quiz Type </label>
		                                         <select name="qiz_type" class="form-control">
													<option value="0" <?php if($result->pract_test == "0"){ echo "selected";}?> >Exam</option>
													<option value="1" <?php if($result->pract_test == "1"){ echo "selected";}?> >Practice</option>
												
											</select>  
                                         </div>
	                                       <div class="form-group">
                                            <label>Correct answer score</label>
		                                          <input type='text' name='correct_answer_score' value="1"    class="form-control" value="<?php echo $result->correct_score;?>" > 
                                         </div>
	                                       <div class="form-group">
                                            <label>Incorrect answer score</label>
		                                          <input type='text' name='incorrect_answer_score' value="0"    class="form-control"  value="<?php echo $result->incorrect_score;?>" >
                                         </div>
	                                       <div class="form-group">
                                            <label>Accessible to IPs (comma separated)</label>
		                                          <input type='text' name='ip_address' value=""   class="form-control"  value="<?php echo $result->ip_address;?>"  >

                                         </div>
	                                   
<?php 
		if($this->config->item('webcam_plugin') == false){
		?><input type="hidden" name="camera_req" value="0"> <?php
		}
		?>
	  
<?php
if($this->config->item('webcam_plugin')){
?> <div class="form-group">
                                            <label>
 Capture Photo </label>
		<input type='radio' name='camera_req' value='1'  <?php if($result->camera_req == "1"){ echo "checked"; } ?> >Yes
		<input type='radio' name='camera_req' value='0'  <?php if($result->camera_req == "0"){ echo "checked"; } ?>  >No 
	    </div>
<?php
}
?>
									





<hr>

 
<?php
if($result->qselect == "1"){
?> <label>Add questions </label><br>
 
<?php
foreach($assigned_questions as $key => $val){
?>
<div class="form-group">
 Category:  
	 <select name="cid[]" >
	 
	<?php foreach($category as $value){ ?>
	<option value="<?php echo $value->cid; ?>" <?php if($val['cid']==$value->cid ){ echo "selected"; } ?> ><?php echo $value->category_name; ?></option>
	<?php } ?></select>  ,  
 Level: 
 <select name="did[]" >
 
	<?php foreach($difficult_level as $value){ ?>
<option value="<?php echo $value->did; ?>"  <?php if($val['did']==$value->did ){ echo "selected"; } ?> ><?php echo $value->level_name; ?></option>
<?php } ?></select> , 
	 No. of Question added: <select name="no_of_questions[]" style="width:60px;">
	<option value="0" >0</option>
	<option value="<?php echo $val['no_of_questions']; ?>" selected ><?php echo $val['no_of_questions']; ?></option>
	</select> 
	</div>
<?php
}
?>
<div class="form-group">
  Category:   <select name="cid[]" id='cid'>
	<option value="0">Select Category</option>
	<?php foreach($category as $value){ ?>
	<option value="<?php echo $value->cid; ?>"><?php echo $value->category_name; ?></option>
	<?php } ?></select>  , 
	 Level:  <select name="did[]" id='did'>
<option value="0">Select Difficult Level</option>
	<?php foreach($difficult_level as $value){ ?>
<option value="<?php echo $value->did; ?>"><?php echo $value->level_name; ?></option>
<?php } ?></select>  No. of Ques to add in test <span id="no_of_question">
		
	</span>
</div>
<?php
}
?>
 
 <div class="form-group">
<input type="hidden" value="<?php echo $result->qselect;?>" name="qselect" id="qselect">
 <input type="submit" value="Submit Quiz" name="submit_quiz" class="btn btn-default">   




</div> 
								
								</div>
							</div>
						</div>
					</div>
				</div>
</div>
 </form>












   
<?php
if($result->qselect == "0"){
?><br> <br> 
<a href="javascript:questionselection('<?php echo $result->quid;?>','<?php echo $result->quiz_name;?>','0','0');"  class="btn btn-success" >Add Questions Manually </a><br> <br> 
<?php

if($assigned_questions ==false){
?>

<?php

}else{
?>


<div class="row" style="margin-top:10px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Questions Added
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                               <table class="table table-hover">
                                    <thead>
<tr><th>Id</th>
<th>Question</th>
<th>Category</th>
<th>Level</th>
<th>Question Type</th>
<th>Action</th>
</tr>
     </thead>
                                    <tbody>
<?php
foreach($assigned_questions as $key=> $row){
if($row->q_type=="0"){
$type="Multiple Choice - single answers";
}
if($row->q_type=="1"){
$type="Multiple Choice - multiple answers";
}
if($row->q_type=="2"){
$type="Fill in the Blank";
}
if($row->q_type=="3"){
$type="Short Answer";
}
if($row->q_type=="4"){
$type="Essay";
}
if($row->q_type=="5"){
$type="Matching";
}
?>
<tr>
<td  data-th="ID"><?php echo $key+1;?></td>
<td data-th="Question"><?php echo substr(strip_tags($row->question),"0","50");?></td>
<td data-th="Category"><?php echo $row->category_name;?></td>
<td data-th="Level"><?php echo $row->level_name;?></td>
<td data-th="Type"><?php echo $type;?></td>
<td data-th="Action"><a href="<?php echo site_url('qbank/edit_question/'.$row->qid.'/'.$row->q_type );?>" class="btn btn-info btn-xs"  target="edit_question">Edit</a>
<a href="<?php echo site_url('quiz/remove_question_quiz/'.$result->quid.'/'.$row->qid );?>"  class="btn btn-danger btn-xs">Remove from Quiz</a>
<?php if($key!="0"){ ?>
<a href="javascript:cancelmove('Up','<?php echo $result->quid;?>','<?php echo $row->qid;?>','<?php echo $key+1;?>');"><img src="<?php echo base_url();?>images/up.png" title="Up"></a>
<?php }else{ ?>
<img src="<?php echo base_url();?>images/empty.png" >
<?php } 
if($key==(count($assigned_questions)-1)){
?>
<img src="<?php echo base_url();?>images/empty.png" >

<?php
}else{
?>
<a href="javascript:cancelmove('Down','<?php echo $result->quid;?>','<?php echo $row->qid;?>','<?php echo $key+1;?>');"><img src="<?php echo base_url();?>images/down.png" title="Down"></a>
<?php
}
?>

</td>
</tr>
<?php
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




<br><br>
Note: Arrange question category wise. you can use up or down icon to arrange it.
<br>
Eg. All questions of category A should be togather then category B etc..<br><br>
<b>Right Method</b><br>
1-5 question from category A then 6-10 questions from category B<br>
<br><b>Wrong Method</b></br>
1-2 questions from category A then 2-6 from category B then 7-10 again category A<br> 
<?php
}
?>

<?php
}
?>
 
</div>

<div id="qbank"></div>

<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
<center><b>To which position you want to move this question? </b><br><input type="text" style="width:30px" id="qposition" value=""><br><br>
<a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;">Cancel</a> &nbsp; &nbsp; &nbsp; &nbsp;
<a href="javascript:movequestion();"   class="btn btn-info"  style="cursor:pointer;">Move</a>

</center>
</div>
</div>
<?php

if($qselect=="0"){
?>
<script type="text/javascript">
questionselection('<?php echo $result->quid;?>','<?php echo $result->quiz_name;?>','0','0');

</script>
<?php
}
?>

<script type="text/javascript">
 
			tinyMCE.init({
	
    mode : "textareas",
		theme : "advanced",
		relative_urls:"false",
	 plugins: "jbimages",
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
 
	
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "jbimages,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		
		
	});
	 
</script>



<script language="javascript">
var position_type="Up";
var global_quid="0";
var global_qid="0";
var global_opos="0";

function cancelmove(position_t,quid,qid,opos){

position_type=position_t;
global_quid=quid;
global_qid=qid;
global_opos=opos;

if((document.getElementById('warning_div').style.display)=="block"){
document.getElementById('warning_div').style.display="none";
}else{
document.getElementById('warning_div').style.display="block";
if(position_type=="Up"){
var upos=parseInt(global_opos)-parseInt(1);
}else{
var upos=parseInt(global_opos)+parseInt(1);
}
document.getElementById('qposition').value=upos;

}

}


function movequestion(){

var pos=document.getElementById('qposition').value;

if(position_type=="Up"){
var npos=parseInt(global_opos)-parseInt(pos);
window.location="<?php echo site_url('quiz/up_question');?>/"+global_quid+"/"+global_qid+"/"+npos;
}else{
var npos=parseInt(pos)-parseInt(global_opos);
window.location="<?php echo site_url('quiz/down_question');?>/"+global_quid+"/"+global_qid+"/"+npos;
}
}
</script>
