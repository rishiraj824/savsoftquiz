<table style="font-size:10px;font-family:arial;" border="1px;">
<tr><th width="30px;">Id</th><th width="70px;">Username</th><th width="150px;">Full name</th><th width="80px;">Email</th><th width="100px;">Group</th><th width="100px;">Quiz name</th><th width="40px;">Score</th><th width="40px;">Percentage</th><th width="60px;">Result</th></tr>
<?php
if($report==false){
?>
<tr>
<td colspan="8">
No record foud!
</td>
</tr>
<?php

}else{
foreach($report as $row){
?>
<tr>
<td><?php echo $row->rid;?></td><td><?php echo $row->username;?></td><td><?php echo $row->first_name;?> <?php echo $row->last_name;?></td><td><?php echo $row->email;?></td><td><?php echo $row->group_name;?></td><td><?php echo $row->quiz_name;?></td><td><?php echo $row->score;?></td><td><?php echo substr($row->percentage , 0, 5 );?>%</td><td><?php if($row->q_result == "1"){  echo "Pass"; }else{ echo "Fail"; } ?> </td></tr>
<?php
}
}
?>


</table>
