
<?php
if($this->uri->segment(2) != "access_test"){
?>
<br><br>

<div class="col-lg-12 col-sm-12 col-xs-12" style="text:align:right;"><a href="javascript:fontsize();" title="Change Font Size"><img src="<?php echo base_url();?>images/font-size.gif"></a>Powered by<body></body><a href='http://savsoftquiz.com'style="color:black;"><b>Savsoft Quiz</b></a> </div>



<?php
}
?>


    <?php
 if($this->session->userdata('logged_in'))
   {
   $logged_in=$this->session->userdata('logged_in');
   ?>
 	</div>
	</div>
	</div>

</div>

<?php 
}
?>

<script>
var fsizecookie=getCookie("f-size");

    if (fsizecookie!="") {
       var fsize=fsizecookie;
    		}else{
       var fsize=3;
			}
			
function fontsize(){
 if(fsize==1){
 	$("body").css('font-size','15px');
 	
 	setCookie('f-size',fsize,'1');
 	fsize=2;
 }else if(fsize==2){
 	$("body").css('font-size','18px');
 	
 	setCookie('f-size',fsize,'1');
 	fsize=3;
 }else if(fsize==3){
 	 	$("body").css('font-size','13px');
 	
 	setCookie('f-size',fsize,'1');
 	fsize=1;
 }

}

//$( document ).ready(function() {
	
 if(fsize==1){
 var fffsize="15px";
 fsize=2;	 
 }else if(fsize==2){
 var fffsize="18px"; 
 fsize=3;	 
 }else if(fsize==3){
	var fffsize="13px";
	fsize=1;
 }
    $("body").css('font-size',fffsize);
//});


</script>



<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url();?>bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url();?>bootstrap/bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>bootstrap/dist/js/sb-admin-2.js"></script>


 </body>
</html>
