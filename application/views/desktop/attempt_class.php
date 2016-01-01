<head>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/basic.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/dropzone.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dropzone.css">
</head>
<div id="content" class="testd">
<h3><?php if($title){ echo $title; } ?></h3><br>
<form action="<?php echo site_url(); ?>/liveclass/fileupload" class="dropzone" id="dropzone">
  <div class="fallback">
    <input name="file" type="file" multiple />
  </div>
</form>
<div class="class_text_board">
	<div class="class_heading">
		Notes <img title="Attach file" style="margin-left:20px;cursor:pointer;" src="<?php echo base_url();?>images/attachment.png" onClick="show_drop();">
 <div id="page_res" ></div>
	</div>
	<div id="page" contenteditable="true"  onKeyup="javascript: if (event.keyCode=='13') postclass_content('<?php echo $class_id;?>');">
		<?php echo $result['content'];?>
	</div>
	
</div>
<div class="class_comment_board" >
Comments<br>
<div id="comnt_optn" style="border:2px groove #eee;background:#F9FFF9;border-radius:10px;display:none;width:200px;position:absolute;margin-top:50px;margin-left:20px;padding:10px;" >
<img OnClick="hide_options()" title="Minimize" style="width:12px;height:12px;float:right;cursor:pointer;" src="<?php echo base_url();?>images/cross.png"><br><br>
<a href="javascript:delete_comment();" class="button-error pure-button"   >
Delete
</a> &nbsp;&nbsp;
<a id="pub" href="javascript:publish_comment();"  class="button-success pure-button"  >
Publish/Unpublish
</a>
</div>
<div id="comment_box"></div><br>
<input type="text" id="comment_send" name="class_cont" placeholder="Enter your comment" onKeyup="javascript: if (event.keyCode=='13') comment('<?php echo $class_id;?>');" >
</div>

<div style="clear:both;"></div>
Tips: Enter key will send data to your users.
<br><br>
<a href="<?php echo site_url('liveclass/close_class/'.$class_id);?>"  class="btn btn-danger btn-xs">Close This Class</a>

</div>

<script>
var class_id="<?php echo $class_id;?>";
$( "#page" ).focusin(function() {
 document.getElementById('page_res').innerHTML="You are typing...";
});
$( "#page" ).focusout(function() {
 document.getElementById('page_res').innerHTML="";
});

get_ques_content('<?php echo $class_id;?>');

</script>


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
	function addattachment(filename){
	var res = filename.split(".");
	var alen=res.length;
	var ext=res[(parseInt(alen)-parseInt(1))];
	if(ext=="png" || ext=="gif" || ext=="jpeg" || ext=="jpg"){
	var val="<div contentEditable='false'><a href='<?php echo base_url();?>classfiles/"+filename+"' target='new' style='cursor:pointer;' ><img src='<?php echo base_url();?>classfiles/"+filename+"' style='max-width:400px;max-height:400px;' ></a></div><br>";
	}else{
		var val="<div contentEditable='false'><a href='<?php echo base_url();?>classfiles/"+filename+"' target='new' style='cursor:pointer;' style='max-width:400px;max-height:400px;'>"+filename+"</a></div><br>";
	}
	
	
	$('#page').append(val);
	postclass_content(class_id);
	}
	
	function show_drop(){
		if(document.getElementById("dropzone").style.display=="none"){
		document.getElementById("dropzone").style.display = 'block';
		}else{
		document.getElementById("dropzone").style.display = 'none';
		}
	}
	document.getElementById("dropzone").style.display = 'none'
</script>
