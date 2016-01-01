<script type="text/javascript" src="<?php echo base_url();?>js/basic.js"></script>
<div class="row" style="margin-top:10px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <?php if($title){ echo $title; } ?>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                               <a href="<?php echo site_url('result/view/'.$id.'/'.$result->quid);?>"  class="btn btn-danger">Back</a>
                               
							   
							   
							   
							   <?php 
$fill=0;
$short_ans=0;
$essay_ans=0;
$match_ans=0;
$short_ans_pos_not_attempted=array();
	foreach($assigned_question[2] as $valuew_fil){
		if($valuew_fil['q_type']=="2"){
		//print_r($valuew_fil);
			$given_ans_fillups[]=$valuew_fil['essay_cont'];
			
		}
		if($valuew_fil['q_type']=="3"){
		//print_r($valuew_fil);
			$given_ans_short[]=$valuew_fil['essay_cont'];
			
		}
		if($valuew_fil['q_type']=="0"){
		//print_r($valuew_fil);
			$given_ans_essay[]=$valuew_fil['essay_cont'];
			$essay_status[]=$valuew_fil['essay_status'];
			
		}
		if($valuew_fil['q_type']=="5"){
		//print_r($valuew_fil);
			$given_ans_match[]=$valuew_fil['essay_cont'];
			
			
		}
	}
	
	
	//print_r($essay_status);
foreach($assigned_question[0] as $key => $question){
	//echo $question['q_type'];
	
if($question['q_type']=="0"){
?>

<table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
<tr><td >Question <?php echo $key+1; ?></td></tr>
<tr><td> <?php echo $question['question'];?></td></tr>
<?php
if($question['description']!=""){
?>
<tr><td><b>Description</b><br> <?php echo $question['description'];?></td></tr>
<?php
} 
$oids=explode(",",$result->oids);
foreach($assigned_question[1] as $keys => $option){
if($option['qid']==$question['qid']){
?>
<tr><td><table>
<tr><td style="width:10px; border:0px;"> <input type="radio" name="answers<?php echo $key;?>" value="<?php echo $option['oid'];?>" <?php if(in_array($option['oid'],$oids)){ echo "checked"; } ?> ></td>
<td style="border:0px;width:750px;"> <?php echo $option['option_value'];?> </td>
<td valign="top"><?php if($option['score']=="1"){ ?><img src="<?php echo base_url();?>images/tick-icon.png"><?php } ?></td></tr></table>
</td></tr>
<?php
}
}
?>
<tr><td> 
<?php
if($key >="1"){
?>
<input type="button" value="Back"  onClick="showquestion_afterquiz('<?php echo $key-1;?>');" class="button-warning pure-button">
<?php
}

if($key!=(count($assigned_question['0'])-1)){
?>
<input type="button" value="Next"  onClick="showquestion_afterquiz('<?php echo $key+1;?>');" class="button-warning pure-button">
<?php
}
?></td></tr>

</table>

<?php
}else if($question['q_type']=="1"){?>
	
	
<table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
<tr><td >Question <?php echo $key+1; ?></td></tr>
<tr><td> <?php echo $question['question'];?></td></tr>
<?php
if($question['description']!=""){
?>
<tr><td><b>Description</b><br> <?php echo $question['description'];?></td></tr>
<?php
} 
$oid_r=str_replace('-',',',$result->oids);
$oids=explode(",",$oid_r);
foreach($assigned_question[1] as $keys => $option){
	
if($option['qid']==$question['qid']){
?>
<tr><td><table>
<tr><td style="width:10px; border:0px;"> <input type="checkbox" name="answers<?php echo $key;?>" value="<?php echo $option['oid'];?>" <?php if(in_array($option['oid'],$oids)){ echo "checked"; } ?> ></td>
<td style="border:0px;width:750px;"> <?php echo $option['option_value'];?> </td>
<td valign="top"><?php if($option['score']>"0"){ ?><img src="<?php echo base_url();?>images/tick-icon.png"><?php } ?></td></tr></table>
</td></tr>
<?php
}
}
?>
<tr><td> 
<?php
if($key >="1"){
?>
<input type="button" value="Back"  onClick="showquestion_afterquiz('<?php echo $key-1;?>');" class="button-warning pure-button">
<?php
}

if($key!=(count($assigned_question['0'])-1)){
?>
<input type="button" value="Next"  onClick="showquestion_afterquiz('<?php echo $key+1;?>');" class="button-warning pure-button">
<?php
}
?></td></tr>

</table>

	
	
	<?php
}else if($question['q_type']=="2"){
	
	?>
	
<table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
<tr><td >Question <?php echo $key+1; ?></td></tr>
<tr><td> <?php echo $question['question'];?></td></tr>
<?php
if($question['description']!=""){
?>
<tr><td><b>Description</b><br> <?php echo $question['description'];?></td></tr>
<?php
} 
$oids=explode(",",$result->oids);
foreach($assigned_question[1] as $keys => $option){
if($option['qid']==$question['qid']){
	
?>
<tr><td><table>
<tr><td style="width:10px; border:0px;"> </td>
<td style="border:0px;width:750px;"> <?php echo "Correct answer=".$option['option_value']."<br>Your Answer=".$given_ans_fillups[$fill];?> </td>
<td valign="top"><?php if(strip_tags($option['option_value'])==$given_ans_fillups[$fill]){ ?><img src="<?php echo base_url();?>images/tick-icon.png"><?php } ?></td></tr></table>
</td></tr>
<?php
}

}
$fill+=1;
?>
<tr><td> 
<?php
if($key >="1"){
?>
<input type="button" value="Back"  onClick="showquestion_afterquiz('<?php echo $key-1;?>');" class="button-warning pure-button">
<?php
}

if($key!=(count($assigned_question['0'])-1)){
?>
<input type="button" value="Next"  onClick="showquestion_afterquiz('<?php echo $key+1;?>');" class="button-warning pure-button">
<?php
}
?></td></tr>

</table>
	
	<?php
}else if($question['q_type']=="3"){
	
	?>
	
<table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
<tr><td >Question <?php echo $key+1; ?></td></tr>
<tr><td> <?php echo $question['question'];?></td></tr>
<?php
if($question['description']!=""){
?>
<tr><td><b>Description</b><br> <?php echo $question['description'];?></td></tr>
<?php
} 
$oids=explode(",",$result->oids);
foreach($assigned_question[1] as $keys => $option){
if($option['qid']==$question['qid']){
?>
<tr><td><table>
<tr><td style="width:10px; border:0px;"> </td>
<td style="border:0px;width:750px;"> <?php echo "Correct answers=".$option['option_value']."<br>Your Answer=".$given_ans_short[$short_ans];?> </td>
<?php if($given_ans_short[$short_ans]!=""){?>
<td valign="top"><?php if(strpos(strip_tags($option['option_value']),$given_ans_short[$short_ans])!== false){ ?><img src="<?php echo base_url();?>images/tick-icon.png"><?php } ?></td>

<?php }else{
	
	echo "<td>NOT ATTEMPTED</td>";
	
}?>
</tr></table>
</td>
</tr>
<?php
if($given_ans_short[$short_ans] ==""){
$short_ans_pos_not_attempted[]=$key;
}
}
}
$short_ans+=1;

?>
<tr><td> 
<?php
if($key >="1"){
?>
<input type="button" value="Back"  onClick="showquestion_afterquiz('<?php echo $key-1;?>');" class="button-warning pure-button">
<?php
}

if($key!=(count($assigned_question['0'])-1)){
?>
<input type="button" value="Next"  onClick="showquestion_afterquiz('<?php echo $key+1;?>');" class="button-warning pure-button">
<?php
}
?></td></tr>

</table>
	<?php
	
}else if($question['q_type']=="4"){
	
	?>
<table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
<tr><td >Question <?php echo $key+1; ?></td></tr>
<tr><td> <?php echo $question['question'];?></td></tr>
<?php
if($question['description']!=""){
?>
<tr><td><b>Description</b><br> <?php echo $question['description'];?></td></tr>
<?php
} 

?>
<tr><td><table>
<tr><td style="width:10px; border:0px;"> <td style="border:0px;width:750px;"> <?php echo "Answer:<br>".$given_ans_essay[$essay_ans];?> </td></td></tr></table>
</td></tr><tr>
<td>
<?php
	$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']=="1"){
if($essay_status[$essay_ans]=="0"){?>
	
<input type="text" id="essay_score<?php echo $essay_ans;?>" placeholder="Enter the score">
<span id="scorebtn<?php echo $essay_ans;?>"  ><input type="button" value="ADD SCORE"  onClick="add_score('<?php echo $question['qid'];?>','<?php echo $id;?>','<?php echo $essay_ans;?>');"  class="btn btn-default"></span>	
<?php	
}
	}
?>
</td>
</tr>
<tr>
<td> 
<?php
$essay_ans+=0;
if($key >="1"){
?>
<input type="button" value="Back"  onClick="showquestion_afterquiz('<?php echo $key-1;?>');" class="button-warning pure-button">
<?php
}

if($key!=(count($assigned_question['0'])-1)){
?>
<input type="button" value="Next"  onClick="showquestion_afterquiz('<?php echo $key+1;?>');" class="button-warning pure-button">
<?php
}
?></td></tr>

</table>
	<?php
}else if($question['q_type']=="5"){
	
	?>
<table id="ques<?php echo $key;?>" class="<?php if($key=='0'){ echo 'showquestion'; }else{ echo 'hidequestion'; } ?>">
<tr><td >Question <?php echo $key+1; ?></td></tr>
<tr><td> <?php echo $question['question'];?></td></tr>
<?php
if($question['description']!=""){
?>
<tr><td><b>Description</b><br> <?php echo $question['description'];?></td></tr>
<tr>
<td>
<b>Correct Match</b>
</td>
</tr>
<?php
} 
$oids=explode(",",$result->oids);
$user_options=str_replace('=','    =    ',$given_ans_match[$match_ans]);
$user_options=str_replace(',','<br><br>',$user_options);

foreach($assigned_question[1] as $keys => $option){
	
if($option['qid']==$question['qid']){
?>
<tr><td><table>
<tr><td style="width:10px; border:0px;"> </td>
<td style="border:0px;width:750px;"> <?php echo str_replace('=','   =   ',$option['option_value']);?> </td>
<td valign="top"><?php if($option['score']=="1"){ ?><img src="<?php echo base_url();?>images/tick-icon.png"><?php } ?></td></tr></table>
</td></tr>
<?php
}
}
?>
<tr>
<td>
<b>User Selected Options</b>
<p style="margin-left:30px;"><?php echo $user_options;?></p> 
</td>
</tr>
<?php
$match_ans+=1;
?>
<tr><td> 
<?php
if($key >="1"){
?>
<input type="button" value="Back"  onClick="showquestion_afterquiz('<?php echo $key-1;?>');" class="button-warning pure-button">
<?php
}

if($key!=(count($assigned_question['0'])-1)){
?>
<input type="button" value="Next"  onClick="showquestion_afterquiz('<?php echo $key+1;?>');" class="button-warning pure-button">
<?php
}
?></td></tr>

</table>
<?php	
}


//end for each
}
?>
<input type="hidden" name="noq" id="noq" value="<?php echo $key;?>">





							   
							   			   
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
			<input type="hidden" name="noq" id="noq" value="<?php echo $key;?>">

 
<?php
$oidss=explode(",",$result->oids);

?>
<div id="left_div" style="padding:10px;">
<?php 
  
foreach($assigned_question[0] as $key => $question){
 if($correct_incorrect[$key]!=1){ 
  
 }
?>
<div class="count_btn" onClick="showquestion_afterquiz('<?php echo $key;?>');"   <?php   if($correct_incorrect[$key]>="0.1"){ ?> style="background:#267B02;"  <?php }else if($correct_incorrect[$key]<='0' && $oidss[$key]!=0 ){  if(!in_array($key,$short_ans_pos_not_attempted)){ ?>style="background:#D03800;"    <?php } }  ?> ><?php echo $key+1;?></div>
<?php
}
?>
</div>

<div style="clear:both"></div>
 
<br><br>
<table>
<tr><td><div class="count_btn" style="background:#267B02;">&nbsp;</div> Correct</td></tr>
<tr><td><div class="count_btn" style="background:#D03800;">&nbsp;</div> Wrong</td></tr>
<tr><td><div class="count_btn" style="background:#212121;">&nbsp;</div> Not Attempted</td></tr>
</table>
									
					