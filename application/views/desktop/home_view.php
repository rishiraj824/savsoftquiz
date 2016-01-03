<div id="content" class="testd">
<h1> </h1><br>
<?php
if($value !='[["Quiz Name","Percentage (%)"]]'){
?>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $value;?>);

        var options = {
          title: 'Last 10 quiz results',
          hAxis: {title: 'Quiz vs Percentage', titleTextStyle: {color: 'blue'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
		 <div class="container-outer">
   <div class="container-inner" style="left:0;right:0;">
        <div id="chart_div" style="width: 850px; height: 500px;"></div>
   </div>
</div>
<style type="text/css">
.container-outer { width: 100%; height: 650px; overflow-x: auto;    overflow-y: hidden;}
.container-inner { width: 900px; }
::-webkit-scrollbar-track
{
 -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
 border-radius: 10px;
 background-color: #F5F5F5;
}
::-webkit-scrollbar
{
 width: 12px;
 background-color: #F5F5F5;
}
::-webkit-scrollbar-thumb
{
 border-radius: 10px;
 -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
 background-color: #555;
}
</style>
		 <?php
		 }else{
		 ?>
		 No result found to plot chart!
		 
		 <?php
		 
		 }
		 ?>
</div>
