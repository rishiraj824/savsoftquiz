<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap Core CSS -->

    <link href="<?php echo base_url();?>bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>bootstrap/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>bootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>bootstrap/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>bootstrap/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>bootstrap-material-design-master/dist/css/bootstrap-material-design.css" rel="stylesheet">
    <link href="<?php echo base_url();?>bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/css/bootstrap-material-design.css.map" rel="stylesheets">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/css/bootstrap-material-design.min.css" rel="stylesheets">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/js/material.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/js/material.min.js" type="text/javascript"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/js/ripples.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/js/ripples.min.js" type="text/javascript"></script>



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


<title><?php if($title){ echo $title; } ?></title>

     <!-- Favicons -->
     <link rel="shortcut icon" href="<?php echo base_url();?>logo/favicon.ico">

<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen"/>


<script type="text/javascript" src="<?php echo base_url();?>editor/tiny_mce.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>

 

<script type="text/javascript" src="<?php echo base_url();?>/js/basic.js?rd=<?php echo time();?>"></script>
 


    <?php
 if($this->session->userdata('logged_in'))
   {
   $logged_in=$this->session->userdata('logged_in');
   ?>
   <div id="wrapper">

<?php 
if($this->uri->segment(2) != "access_test"){ 
?>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="http://savsoftquiz.com/" >
                  <img src="<?php echo base_url();?>logo/logo.png" style="margin-top: -6px;height: 38px;" title="Logo">
                  </a> 
              </div>
              <!-- /.navbar-header -->

              <ul class="nav navbar-top-links navbar-right">
                

                  <!-- /.dropdown -->
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                          <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-messages">
                          <li>

                        <a href="<?php echo site_url('user_data/my_account');?>"><i class="fa fa-user fa-fw"></i> My Account</a>


                          </li>
                          <li class="divider"></li>
                          <li><a href="<?php echo site_url('home/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                          </li>
                      </ul>
                      <!-- /.dropdown-user -->
                  </li>
                  <!-- /.dropdown -->
              </ul>
              <!-- /.navbar-top-links -->

              <div class="navbar-default sidebar" role="navigation" >
                  <div class="sidebar-nav navbar-collapse" aria-expanded="false" >
                      <ul class="nav in" id="side-menu">
                          
                          <li>
                              <a href="<?php echo site_url('home');?>"  ><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                          </li>

                          <?php 
                         if($logged_in['su']=="1"){ ?>
                         <li>
                         <a href="<?php echo site_url('user_data');?>" ><i class="fa fa-users fa-fw"></i> Users</a>
                         </li>
                         <?php
                         }
                         ?>
                          <?php 
                         if($logged_in['su']=="1"){ ?>
                          <li>
                              <a href="<?php echo site_url('qbank');?>"  ><i class="fa fa-question fa-fw"></i> Question Bank</a>
                          </li>
                          <?php 
                        }
                        ?>
                          <li>
                              <a href="<?php echo site_url('quiz');?>" ><i class="fa fa-check fa-fw"></i> Quiz</a>
                          </li>
                          <li>
                          <?php 
                         if($logged_in['su']=="1"){ ?>
                             <a href="<?php echo site_url('result/');?>"  ><i class="fa fa-line-chart fa-fw"></i> Result</a>
                          <?php 
                        }else{
                          ?>
                            <a href="<?php echo site_url('result/user');?>"  ><i class="fa fa-line-chart fa-fw"></i> Result</a>
 
                          <?php 
                        }
                        ?>
                        </li>

                         <li>
                         <a href="<?php echo site_url('liveclass');?>" ><i class="fa fa-desktop fa-fw"></i> Live Classroom</a>
                         </li>

                          <?php 
                         if($logged_in['su']=="1"){ ?>
                          <li>
                              <a href="<?php echo site_url('home/setting');?>"  ><i class="fa fa-cog fa-fw"></i> Setting</a>
                          </li>
                          <?php 
                        }
                        ?>
 
                      </ul>
                  </div>
                  <!-- /.sidebar-collapse -->
              </div>
              <!-- /.navbar-static-side -->
     </nav>

<?php 
}
?>


      <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
          


<?php 
}
?>