		<?php 
$logged_in=$this->session->userdata('logged_in');

if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 	
<div class="row" style="margin-top:10px;">
                <div class="col-lg-9 col-sm-12 col-xs-12 col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <?php if($title){ echo $title; } ?>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                               
                               
							   
							   
							   
                                <table class="table table-hover">
                                    
                                    <tbody>
                                       
<tr><th >Quiz Name</th><td><b><?php echo $result->quiz_name;?></b></td></tr>
<tr><td valign="top" colspan="2"><b>Description / Instructions</b> <?php echo $result->description;?></td></tr>
<tr><th valign="top">Duration</th><td><?php echo $result->duration;?> Minutes</td></tr>
<tr><th valign="top">Start time</th><td><?php echo date("Y-m-d",$result->start_time);?></td></tr>
<tr><th valign="top">End time</th><td><?php echo date("Y-m-d",$result->end_time);?></td></tr>
<tr><th valign="top">Percentage required to pass</td><td><?php echo $result->pass_percentage;?>%</td></tr>
<tr><th valign="top">Test type</th><td><?php if($result->test_type=="1"){ echo "Paid ( credit require: ".$result->credit.")"; }else{ echo "Free"; } ?>
<tr><th valign="top">Maximum Attempts</th><td><?php echo $result->max_attempts;?> </td></tr>
<tr><th valign="top">Correct answer score</th><td><?php echo $result->correct_score;?> </td></tr>
<tr><th valign="top">Incorrect answer score</th><td><?php echo $result->incorrect_score;?> </td></tr>
<tr><td valign="top" colspan="2">
<?php
if($this->config->item('webcam_plugin') == true && $result->camera_req == "1"){
?>
<div id='result'>Quiz required web cam to capture your photo. <br>Make sure you have web cam connected to your system.<br>
 Please click on "Allow" button ( if any ) visible on your screen.<br>
  Then adjust your camera to get clear photo in below black box.<br>
  Then click on "Capture my photo and Start Test" Button. <br>
  Note: Look at camera while pressing "Capture my photo and Start Test" button</div>
<div id="my_photo" style="width:500px;height:500px;background:#212121;padding:2px;border:1px solid #666666;color:red"></div>
<?php
}
?><br>
</td></tr>
<tr><td valign="top">

<input type="checkbox" name="agree" id="agree"> Tick this checkbox , if you have read all instructions <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and ready to attempt quiz / test.
<div id="warning_checkbox"  class="arrow_box" style="display:none;color:#ffffff;background:#D03800;padding:2px; width:150px;">Tick above check box ! </div>
</td><td>
<input type="button" id="starttestbtn" Value="<?php if($this->config->item('webcam_plugin') == true && $result->camera_req == '1'){ echo 'Capture my photo and '; } ?> Start Test" onClick="javascript:checkbox_validate();"   class="btn btn-success" style="cursor:pointer;">
<?php
if($this->config->item('webcam_plugin') == true && $result->camera_req == "1"){
?>
<div id='result'>Please look at camera while pressing above button</div>
<?php
}
?>
</td></tr>

</td></tr>



                                    </tbody>
</table>





							   
							   
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
			
			

			
			

<?php
if($this->config->item('webcam_plugin')){
?>
<script type="text/javascript" src="<?php echo base_url();?>/js/webcamjs/webcam.js"></script>
	<script language="JavaScript">
		Webcam.set({
			width: 500,
			height: 500,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
		Webcam.attach( '#my_photo' );

		
		 function take_snapshot() {
		 document.getElementById('starttestbtn').value="Please wait....";
            Webcam.snap( function(data_uri) {
                document.getElementById('my_photo').innerHTML = '<img src="'+data_uri+'"/>';
            } );
        }
		
		function upload_photo(){
		Webcam.snap( function(data_uri) {

    Webcam.upload( data_uri, '<?php echo site_url('quiz/photo_upload');?>',function(code, text) {
        // Upload complete!
        // 'code' will be the HTTP response code from the server, e.g. 200
        // 'text' will be the raw response content
		gototest();
    });
	});
	
	}
	
	function gototest(){
	window.location='<?php echo site_url('quiz/access_test/'.$result->quid);?>';
	}
	</script>
	
	
	
<?php
}
?>

<script>
	function checkbox_validate(){

	if(document.getElementById('agree').checked==true){
		<?php if($this->config->item('webcam_plugin') == true && $result->camera_req == '1'){ ?>void(take_snapshot());upload_photo();<?php }else{ ?>window.location='<?php echo site_url('quiz/access_test/'.$result->quid);?>';<?php } ?>
		}else{
	document.getElementById('warning_checkbox').style.display="block";
		}
	
	}
	
</script>


	
