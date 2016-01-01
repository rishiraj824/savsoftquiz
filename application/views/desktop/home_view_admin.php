<div id="content" class="copy"  >
<h1> </h1><br>


<div class="alert alert-warning">
         
Great! You have installed Savsoft Quiz Successfully. You can <a href="http://savsoftquiz.com/" class="alert-link" ><u>Contact us</u></a> for customization service.  <br>
  Please like our <a href="https://www.facebook.com/savsoftquiz" class="alert-link" target="fb_page"><u>facebook page</u></a>, it will help us to keep it free and open source.
</div>
 

<div class="row">

<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_users;?></div>
                                    <div>Number of User Registered</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url('user_data');?>">
                            <div class="panel-footer">
                                <span class="pull-left">User List</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
</div>

<div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-question-circle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_qbank;?></div>
                                    <div>Questions  in Question Bank</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url('qbank');?>">
                            <div class="panel-footer">Question Bank</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
</div>


<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-line-chart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $num_result;?></div>
                                    <div>Quiz Attempted </div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo site_url('result');?>">
                            <div class="panel-footer">Results</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
</div>


</div>
 

<div style="clear:both;"></div><br><br>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["columnchart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($user_group);?>);

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 400, height: 240, is3D: true, title: 'Users registered in groups'});
      }
    </script>
	
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["columnchart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $value;?>);

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, {width: 400, height: 240, is3D: true, colors:[{color:'#e3301d', darker:'#b01808'}],axisFontSize:12,title: 'Last 10 Results'});
      }
    </script>
	<div id="chart_div2" style="float:left;width:700px;height:300px;margin-right:20px;">

	</div>
	
	<div id="chart_div" style="float:left;"></div>
	
		 
<div style="clear:both;"></div><br><br>
		 <br>
<h2 style="color:#666666">Steps for Quick Start</h2>

1) Go to Settings -> Create User Groups, Question Categories and Difficulty level.<br>
2) Add user -> User can register directly from link provided at login page or you can add user manually.<br>
3) Go to question Bank and add questions<br>
4) Go to Quiz and create new quiz, add question from question bank. <br> 

</div>
