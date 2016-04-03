// update base url ( http://localhost/savsoftquiz/ ). include slash at end
var base_url = 'http://'+window.location.host+window.location.pathname.split('/').slice(0,window.location.pathname.split('/').indexOf('quiz')+1).join('/')+'/';

var comnt_id="0";
$(document).ready(function(){
	$('#did').click(function (){
	var did = $('#did').val();
	var cid = $('#cid').val();
	$.ajax({
		url: base_url + "index.php/qbank/get_level_question/" + did + "/" + cid,
		success: function(data){
		
			var output = "<select name = 'no_of_questions[]' id='cnoq' >";
			if(data=="0"){
			output += "<option value = '0'>0</option>";
			}else{
			
				for(var i = 0; i <= data; i++){
					output += "<option value = '"+  i +"'>";
						output += i;
					output += "</option>";
					}
				}
			output += "</select>"; 
			 
			$("#no_of_question").html(output);
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	});
});


var qtime=0;
var answered = new Array();
var reviewed = new Array();

$(document).ready( function(){
if(document.getElementById('noq')){
var noq=document.getElementById('noq').value;
	for(x=0; x <= noq; x++){
	answered[x]=0;
	reviewed[x]=0;
	}
	}
});


	
function showquestion_afterquiz(id){

	var noq=document.getElementById('noq').value;
	
	for(var x=0; x<=noq; x++){
	var qid="ques"+x;
	document.getElementById(qid).style.display="none";
	document.getElementById(qid).style.visibility="hidden";
	}
	var qid="ques"+id;
	document.getElementById(qid).style.display="block";
	document.getElementById(qid).style.visibility="visible";

	}
	
function update_answer(oid){
var cq=document.getElementById('current_question').value;
	var aurl=base_url+"index.php/quiz/update_answer/"+cq+"/"+oid+"";
	$.ajax({
		url: aurl
		
		});		
}	


function answered_color(){
var cq=document.getElementById('current_question').value;
var nq="nq"+cq;
document.getElementById(nq).style.background="#267B02";
document.getElementById(nq).style.color="#ffffff";
answered[cq]=1;



}	

function reviewlater(q_type){

var cq=document.getElementById('current_question').value;
var nq="nq"+cq;
if(reviewed[cq]=="0"){
document.getElementById(nq).style.background="#FFD800";
document.getElementById(nq).style.color="#ffffff";
reviewed[cq]=1;
}else{
	reviewed[cq]=0;
showquestion(cq,q_type);

}
}

var firstquestionofcategory=0;

function changecategory(id){
document.getElementById('current_cate').value=id;
hideqnobycate();
}

function hideqnobycate(){
var jsonvar=document.getElementById('json_category_range').value;
var arrobj = $.parseJSON(jsonvar);
var current_cate=document.getElementById('current_cate').value;
var total_cate=document.getElementById('total_cate').value;
for( var j=0; j <= total_cate; j++){
var cateid="cate-"+j;

if(j != current_cate){
arrobj[j].forEach(hideqnobyarr);
document.getElementById(cateid).style.background="#d4e0ed";
document.getElementById(cateid).style.color="#000000";

}else{
arrobj[j].forEach(showqnobyarr);
document.getElementById(cateid).style.background="#2f72b7";
document.getElementById(cateid).style.color="#ffffff";

showquestion(firstquestionofcategory);
}
}
var categorydivid="cate-"+current_cate;
var categorynametxt=document.getElementById(categorydivid).innerHTML;
document.getElementById('category_name_view').innerHTML="You are viewing <b>"+categorynametxt+"</b> section";
}

function hideqnobyarr(element, index, array){
var nq="nq"+element;
document.getElementById(nq).style.display="none";
}

function showqnobyarr(element, index, array){
if(index == 0){
firstquestionofcategory=element;
}
var nq="nq"+element;
document.getElementById(nq).style.display="block";
document.getElementById(nq).innerHTML=(index+1);

}



function clearresponse(){
var current_question=document.getElementById('current_question').value;
for(var op=0; op <= 3; op++){
var opn="op-"+current_question+"-"+op;
document.getElementById(opn).checked = false;

}



}



function submitform(){
document.getElementById('testform').submit();
}

function changetabqselection(id,ids,qsel){
document.getElementById(id).style.display="block";
document.getElementById(id).style.visibility="visible";
document.getElementById('qselect').value=qsel;

document.getElementById(ids).style.display="none";
document.getElementById(ids).style.visibility="hidden";

if(id=="qman"){
document.getElementById('qmanbtn').style.background="#2f72b7";
document.getElementById('qmanbtna').style.color="#ffffff";
document.getElementById('qautobtn').style.background="#e4edf7";
document.getElementById('qautobtna').style.color="#212121";
}else{

document.getElementById('qautobtn').style.background="#2f72b7";
document.getElementById('qautobtna').style.color="#ffffff";
document.getElementById('qmanbtn').style.background="#e4edf7";
document.getElementById('qmanbtna').style.color="#212121";

}


}




function questionselection(quid,qname,limi,cid){
		document.getElementById('qbank').style.display="block";
		document.getElementById('qbank').style.visibility="visible";
		var vall="<center><img src='"+base_url+"images/processing.gif'></center>";
$("#qbank").html(vall);
	$.ajax({
		url: base_url + "index.php/qbank/select_questions/"+quid+"/"+qname+"/"+limi+"/"+cid,
		success: function(data){
		$("#qbank").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
}

function questionselection_search(quid,qname,limi){
var search_type=document.getElementById('search_type').value;
var searchval=document.getElementById('search').value;
		document.getElementById('qbank').style.display="block";
		document.getElementById('qbank').style.visibility="visible";
		var vall="<center><img src='"+base_url+"images/processing.gif'></center>";
$("#qbank").html(vall);
var formData = {search_type:search_type,search:searchval};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/qbank/select_questions/"+quid+"/"+qname+"/"+limi,
		success: function(data){
		$("#qbank").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
}


function closeqselection(quid){
		document.getElementById('qbank').style.display="none";
		document.getElementById('qbank').style.visibility="hidden";
		window.location=base_url+"index.php/quiz/edit_quiz/"+quid;
}

function addquestion(quid,qid){
	$.ajax({
		url: base_url + "index.php/quiz/add_question/"+quid+"/"+qid,
		success: function(data){
		},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
}

function qadded(id){
document.getElementById(id).innerHTML="Added";
}


function postclass_content(id){
var cont=document.getElementById('page').innerHTML;
var formData = {content:cont};
document.getElementById('page_res').innerHTML="Sending data...";
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/insert_content/"+id,
		success: function(data){
				var d = new Date();
		var dt=d.toString();
		var gt=dt.replace("GMT+0530 (India Standard Time)","");
		document.getElementById('page_res').innerHTML="Sent : "+gt;

		},
		error: function(xhr,status,strErr){
			document.getElementById('page_res').innerHTML="Sending failed!";
			}	
		});

}


function get_liveclass_content(id){

	$.ajax({
		url: base_url + "index.php/liveclass/get_class_content/"+id,
		success: function(data){
		var d = new Date();
var dt=d.toString();
var gt=dt.replace("GMT+0530 (India Standard Time)","");
document.getElementById('page').innerHTML=data;
		document.getElementById('page_res').innerHTML="Last updated on "+gt;
setTimeout(function(){
get_liveclass_content(id);
},5000);
		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_liveclass_content(id);
},5000);
			}	
		});
		
	document.getElementById("page").scrollTop = document.getElementById("page").scrollHeight;
	
}



function get_liveclass_content_2(id){

	$.ajax({
		url: base_url + "index.php/liveclass/get_class_content/"+id,
		success: function(data){
		var d = new Date();
var dt=d.toString();
var gt=dt.replace("GMT+0530 (India Standard Time)","");
document.getElementById('page').innerHTML=data;
		document.getElementById('page_res').innerHTML="Last updated on "+gt;

		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_liveclass_content(id);
},5000);
			}	
		});
		
	document.getElementById("page").scrollTop = document.getElementById("page").scrollHeight;
	
}



var class_id;
function get_ques_content(id){
class_id=id;
	$.ajax({
		url: base_url + "index.php/liveclass/get_ques_content/"+id,
		success: function(data){
		//alert(data);
		document.getElementById('comment_box').innerHTML=data;
		
setTimeout(function(){
get_ques_content(id);
},5000);
		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_ques_content(id);
},5000);
			}	
		});
		document.getElementById("comment_box").scrollTop = document.getElementById("comment_box").scrollHeight;

}

function get_ques_content_2(id){
class_id=id;
	$.ajax({
		url: base_url + "index.php/liveclass/get_ques_content/"+id,
		success: function(data){
		//alert(data);
		document.getElementById('comment_box').innerHTML=data;
		

		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_ques_content(id);
},5000);
			}	
		});
		document.getElementById("comment_box").scrollTop = document.getElementById("comment_box").scrollHeight;

}


function comment(id){
var comnt=document.getElementById('comment_send').value;

var formData = {content:comnt};
document.getElementById('comment_send').value="Sending data...";
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/insert_comnt/"+id,
		success: function(data){
				document.getElementById('comment_send').value="";
		},
		error: function(xhr,status,strErr){
			document.getElementById('comment_send').innerHTML="Sending failed!";
			}	
		});

}
var publish="0";
 function show_options(id,p){
comnt_id=id;
publish=p;
if(publish=="0"){
document.getElementById('pub').innerHTML="Unpublish";
}else{
document.getElementById('pub').innerHTML="Publish";

}
$("#comnt_optn").fadeIn();

}
function hide_options(){
$("#comnt_optn").fadeOut();
}
 
  function publish_comment(){

	var formData = {id:comnt_id,pub:publish};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/publish_comnt/",
		success: function(data){
				$("#comnt_optn").fadeOut();
				 get_ques_content(class_id);
		},
		});
 
 
 }
 
 function delete_comment(){
 //alert(comnt_id);
	var formData = {id:comnt_id};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/del_comnt/",
		success: function(data){
				$("#comnt_optn").fadeOut();
				 get_ques_content(class_id);
		},
		});
 
 
 }
 function get_ques_type(val){
 //alert(base_url +'index.php/qbank/add_new');
 window.location =base_url +'index.php/qbank/add_new/'+val;

 }

function add_score(qid,rid,opn_id){
	var div_id='essay_score'+opn_id;
	var div_id2='scorebtn'+opn_id;
	//alert(div_id);
	var op_id=document.getElementById(div_id).value;
	//alert(op_id);
	var formData = {q_id:qid,r_id:rid,opn:op_id};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/result/add_score/",
		success: function(data){
				if((data.trim())=="1"){
					
					alert("Score added");
					document.getElementById(div_id).style.display="none";
					document.getElementById(div_id2).style.display="none";
				}else{
					alert("Unable to add score please try again");
					
				}
		},
		});

	
}


function showquestion(id,q_type){
//alert(id);

var check_color_qus="0";
	var noq=document.getElementById('noq').value;
	var cq=document.getElementById('current_question').value;
	var qtt="question_type"+cq;
	var q_type=document.getElementById(qtt).value;
	
	
	
			
	
	
	
	
	if(q_type==0 && reviewed[cq]=="0")
	{
		var s="answers"+cq;
		var opt_checked = document.getElementsByName(s);
		
			for(var i = 0; i < opt_checked.length; i++)
			{
				if(opt_checked[i].checked)
				{
					var nq="nq"+cq;
					document.getElementById(nq).style.background="#267B02";
					document.getElementById(nq).style.color="#ffffff";
					break;
					
				}else{
					var nq="nq"+cq;
					document.getElementById(nq).style.background="#D0380E";
					document.getElementById(nq).style.color="#ffffff";
					
				}
			}
		
		
		
	}
	
	//For multiple answer question
	if(q_type=="1" && reviewed[cq]=="0")
	{
		var s="answers"+cq+"[]";
		var checkboxes = document.getElementsByName(s);
		
		
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
				
			  if (checkboxes[i].checked) 
			  {
				  var nq="nq"+cq;
					document.getElementById(nq).style.background="#267B02";
					document.getElementById(nq).style.color="#ffffff";
					check_color_qus="1";
					//alert("green");
					break;
			  }
			  
			  
		}
		if(check_color_qus=="0"){
				var nq="nq"+cq;
							document.getElementById(nq).style.background="#D0380E";
							document.getElementById(nq).style.color="#ffffff";
							//alert("red");
				}
		
		
	}
	
	//For fillups question
	if((q_type=="2" || q_type=="3" || q_type=="4") && reviewed[cq]=="0")
	{
				
			var s2="answers"+cq;
			
			var optn_value_user = document.getElementsByName(s2)[0].value;
			if (optn_value_user!="") 
			  {
				  var nq="nq"+cq;
					document.getElementById(nq).style.background="#267B02";
					document.getElementById(nq).style.color="#ffffff";
					
			  }else{
					var nq="nq"+cq;
					document.getElementById(nq).style.background="#D0380E";
					document.getElementById(nq).style.color="#ffffff";
					
				}
			
	}
	
	//For essay question
	
	//For match the column
	if(q_type=="5" && reviewed[cq]=="0")
	{
		
		var s="answers"+cq+"[]";
		var checkboxes = document.getElementsByName(s);
		
		//alert(checkboxes[0].value+checkboxes[1].value+checkboxes[2].value+checkboxes[3].value);
		var check_color_qus="0";
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
				
			  
				   if (checkboxes[i].value!="") 
			  {
				  
				  var nq="nq"+cq;
					document.getElementById(nq).style.background="#267B02";
					document.getElementById(nq).style.color="#ffffff";
					check_color_qus="1";
					break;
			  }
			  
		}
		if(check_color_qus=="0"){
		var nq="nq"+cq;
					document.getElementById(nq).style.background="#D0380E";
					document.getElementById(nq).style.color="#ffffff";
		}
		//alert(vals);
	//var checkboxes = document.getElementsByName(s);
	
	
	}
	
	
	for(var x=0; x<=noq; x++){
			var qid="ques"+x;
			document.getElementById(qid).style.display="none";
			document.getElementById(qid).style.visibility="hidden";
			}
			var qid="ques"+id;
			document.getElementById(qid).style.display="block";
			document.getElementById(qid).style.visibility="visible";
			document.getElementById('current_question').value=id;
			var rurl=base_url+"index.php/quiz/update_time/"+cq+"/"+qtime+"";
			$.ajax({
				url: rurl
				
				});
			qtime=0;	
	
	
	
	
	}

//update answer

function update_curr_ans(key,q_type,qid){
	if(typeof(qid)==='undefined') qid ="";
	//for single answer question
	if(q_type=="0")
	{
		var s="answers"+key;
		var opt_checked = document.getElementsByName(s);
		var oid;
			for(var i = 0; i < opt_checked.length; i++)
			{
				if(opt_checked[i].checked)
				{
					oid = opt_checked[i].value;
					var cq=document.getElementById('current_question').value;
					cq=cq-1;
					//alert(cq);
					var aurl=base_url+"index.php/quiz/update_answer/"+cq+"/"+oid+"";
					$.ajax({
						url: aurl
						
						});		
					
				}
			}
		
	}
	//For multiple answer question
	if(q_type=="1")
	{
		var s="answers"+key+"[]";
		var checkboxes = document.getElementsByName(s);
		var vals = "";
		var first=0;
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
				
			  if (checkboxes[i].checked) 
			  {
				  if(first==0){
					  
					  vals += checkboxes[i].value;
					  first++;
					  
				  }else{
					vals += "-"+checkboxes[i].value;
					
				  }
			  }
		}
		var cq=document.getElementById('current_question').value;
		cq=cq-1;
					//alert(cq);
					var aurl=base_url+"index.php/quiz/update_answer/"+cq+"/"+vals+"";
					$.ajax({
						url: aurl
						
						});	
		//alert(vals);
		
	}
	
	//For fillups question
	if(q_type=="2" || q_type=="3")
	{
				var s="fill_blank"+key;
			var s2="answers"+key;
			var oid = document.getElementsByName(s)[0].value;
			var optn_value_user = document.getElementsByName(s2)[0].value;
			var cq=document.getElementById('current_question').value;
					cq=cq-1;
					//alert(qid);
					var aurl=base_url+"index.php/quiz/update_answer/"+cq+"/"+oid+"";
					$.ajax({
						url: aurl
						
						});	
						//var aurl=base_url+"index.php/quiz/update_fillups/"+qid+"/"+optn_value_user+"";
							var formData = {q_id:qid,optn_value_user:optn_value_user,q_type:q_type};
								$.ajax({
									type: "POST",
									data : formData,
									url: base_url + "index.php/quiz/update_fillups/",
									success: function(data){
											
									},
									});
			
	}
	
	//For essay question
	if(q_type=="4")
	{
				
			var s2="answers"+key;
			var optn_value_user = document.getElementsByName(s2)[0].value;
			//alert(optn_value_user);
			//var cq=document.getElementById('current_question').value;
					
						//var aurl=base_url+"index.php/quiz/update_fillups/"+qid+"/"+optn_value_user+"";
							var formData = {q_id:qid,optn_value_user:optn_value_user,q_type:q_type};
								$.ajax({
									type: "POST",
									data : formData,
									url: base_url + "index.php/quiz/update_fillups/",
									success: function(data){
											
									},
									});
			
	}
	//For match the column
	if(q_type=="5")
	{
		
		var s="question_option"+key+"[]";
		var checkboxes = document.getElementsByName(s);
		//alert(checkboxes[0].value+checkboxes[1].value+checkboxes[2].value+checkboxes[3].value);
	var user_options="answers"+key+"[]";
	var q_options="question_option_val"+key+"[]";
	var correct_ans="question_correct"+key+"[]";
	var user_options_v = document.getElementsByName(user_options);
	var q_options_v = document.getElementsByName(q_options);
	var correct_ans = document.getElementsByName(correct_ans);
	var vals = "";
	
		for (var i=0, n=checkboxes.length;i<n;i++) 
		{
				
			  
				  if(i==0){
					  
					  oid = checkboxes[i].value;
					 
					  
				  }else{
					oid += "-"+checkboxes[i].value;
					
				  }
			  
		}
		//alert(vals);
	//var checkboxes = document.getElementsByName(s);
	var cq=document.getElementById('current_question').value;
					cq=cq-1;
					var aurl=base_url+"index.php/quiz/update_answer/"+cq+"/"+oid+"";
					$.ajax({
						url: aurl
						
						});	
						for (var i=0, n=user_options_v.length;i<n;i++) {
							if(i==0){
							var user_ans=q_options_v[i].value+"="+user_options_v[i].value;
							//alert(user_ans+"--"+correct_ans[i].value);
							}else{
								user_ans+=","+q_options_v[i].value+"="+user_options_v[i].value;
								
							}
							}
						
						var formData = {q_id:qid,optn_value_user:user_ans,q_type:q_type};
								$.ajax({
									type: "POST",
									data : formData,
									url: base_url + "index.php/quiz/update_fillups/",
									success: function(data){
											
									},
									});
	
	}
	
	
}




function check_question(key){
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var s="answers"+key;
	var rates = document.getElementsByName(s);
var optn_value;
for(var i = 0; i < rates.length; i++){
    if(rates[i].checked){
        optn_value = rates[i].value;
		var opt_check=optn_value.split("-");
		if(opt_check[1]>0){
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
			
	}else{
		
		document.getElementById(div_exp_id).style.display="none";
		document.getElementById(div_exp_id_wrong).style.display="block";
	}
    }
	
	
	
	
}
	
	
	
}

function check_question_fill(key,q){
	if(typeof(q)==='undefined') q = 1;
	//alert(q);
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var s="fill_blank"+key;
	var s2="answers"+key;
	var optn_value = document.getElementsByName(s)[0].value;
	var optn_value_user = document.getElementsByName(s2)[0].value;
	var match_check="0"

var opt_check=optn_value.split("-");
 if(q=="3"){
	 
	 var opt_check=opt_check[1].split(",");
	 //alert(opt_check[1]);
	 for(var i = 0; i < opt_check.length; i++){
		if(opt_check[i]==optn_value_user){
			match_check="1";
	}
    
	
	
	
	
}

if(match_check=="1"){
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
			
	}else{
		
		document.getElementById(div_exp_id).style.display="none";
		document.getElementById(div_exp_id_wrong).style.display="block";
	}
    

	 
 }else{
		if(opt_check[1]==optn_value_user){
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
			
	}else{
		
		document.getElementById(div_exp_id).style.display="none";
		document.getElementById(div_exp_id_wrong).style.display="block";
	}
 }  
	
	
	
	

	
	
	
}
function check_question_chekbox(key){
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var s="answers"+key+"[]";
	var checkboxes = document.getElementsByName(s);
var vals = "";
for (var i=0, n=checkboxes.length;i<n;i++) {
  if (checkboxes[i].checked) 
  {
  vals += checkboxes[i].value+",";
  }
}
var opt_check=vals.split(",");
	//alert(opt_check.length);
	for (var i=0, n=opt_check.length-1;i<n;i++) {
		var opt_check_score=opt_check[i].split("-");
		if(opt_check_score[1]=="0"){
			
			document.getElementById(div_exp_id).style.display="none";
		document.getElementById(div_exp_id_wrong).style.display="block";
		break;
		}else{
			
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
		}
		
	}
	
}
function check_question_match(key){
	var match_check="0";
	var div_exp_id="div_exp_id"+key
	var div_exp_id_wrong="div_exp_id_wrong"+key
	var user_options="answers"+key+"[]";
	var q_options="question_option_val"+key+"[]";
	var correct_ans="question_correct"+key+"[]";
	var user_options_v = document.getElementsByName(user_options);
	var q_options_v = document.getElementsByName(q_options);
	var correct_ans = document.getElementsByName(correct_ans);
	//var checkboxes = document.getElementsByName(s);
	
	for (var i=0, n=user_options_v.length;i<n;i++) {
	var user_ans=q_options_v[i].value+"="+user_options_v[i].value;
	//alert(user_ans+"--"+correct_ans[i].value);
	if(user_ans!=correct_ans[i].value){
		match_check="1";
		break;
	}
	}
	
	if(match_check=="0"){
			document.getElementById(div_exp_id_wrong).style.display="none";
			document.getElementById(div_exp_id).style.display="block";
			
	}else{
		
		document.getElementById(div_exp_id).style.display="none";
		document.getElementById(div_exp_id_wrong).style.display="block";
	}
	
	
}




function showhiddendiv(id){

if(document.getElementById(id).style.display=="block"){
document.getElementById(id).style.display="none";
}else{
document.getElementById(id).style.display="block";
}

}





function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}