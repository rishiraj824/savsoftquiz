









    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default black-panel">
                    <div class="panel-heading">
                        <h1 class="panel-title">Log In</h1>
                    </div>

    <center style="background: #333; padding-bottom: 5px;">
<img src="<?php echo base_url();?>logo/<?php echo $logo; ?>" title="Logo">
</center>
               


                    <div class="panel-body">
                     <?php if(validation_errors()){ 
                        ?>
                        <div class="alert alert-danger">
                      <?php echo validation_errors(); ?>
                     </div>
                     <?php } ?>
                        <?php echo form_open('verifylogin/'); ?>
                            <fieldset>
                                <div class="form-group">
                               <input class="form-control" placeholder="Username" name="username" type="text" autofocus  AutoComplete=off >
                                </div>
                                <div class="form-group">
                              <input class="form-control" placeholder="Password" name="password" type="password"  autocomplete=off  value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                       <!--
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        -->
                                   

                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
















