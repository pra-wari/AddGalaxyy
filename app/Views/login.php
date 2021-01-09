<?php echo view('header');?>
<script>
    function show() {
        //document.getElementById("ad-form").action = "Login_Controller.html";
        //document.getElementById("ad-form").submit();
    }

    function check_forgot() {
        $('#postModal').modal();
        return false;
    }
</script>
<div class="container mobile-spacing">
    <div class="row" style="background-color: #f5f5f5;">
        <br>
        <div class="col-md-12">
            <?php if (session()->get('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('success') ?>
                <?php endif; ?>
            </div>
        </div>
        <div class=" col-md-5 col-xs-12  well ">
            <!-- session message -->
            <!-- session message end -->
            <form action="<?php echo base_url('users/login');?>" method="post" accept-charset="utf-8">
                <fieldset>
                    <legend class="text-center">Login Form</legend>
                    <!-- username -->
                    <div class="form-group">
                        <div class="row colbox">
                            <label for="txt_username" class="control-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email"
                                value="<?= set_value('email'); ?>">
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <!-- password -->
                    <div class="form-group">
                        <div class="row colbox ">
                            <label for="txt_password" class="control-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" value="">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <br>
                    <?php if (isset($validation)): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $validation->listErrors() ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($message) && $message!=''): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $message; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- signin button -->
                    <div class="form-gruop">
                        <div class="row colbox text-center">
                            <input type="submit" id="btn_login" name="btn_login" value="Login"
                                class="btn btn-color btn-block" />
                        </div>
                    </div>
                </fieldset>
            </form>
            <div class="text-center">
                <br />
                <a href="<?php echo base_url('/users/forgotpassword');?>" id="forgot-link">Forgot password</a>
                <div id="forgot" style="display:none;">
                    <div class="col-md-12 col-sm-12 col-xs-12 f-col">
                        <div class="footer-static-block">
                            <div class="newsletter footer-block-contant">
                                <form name="ad-form" id="ad-form" action="http://addgalaxy.com/home/forgot_password"
                                    method="post" onsubmit="return check_forgot();">
                                    <div class="newsletter-inner">
                                        <input name="email" type="email" placeholder="Enter your email address">
                                        <button title="Subscribe" class="btn-color">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
        <div class=" col-md-6 col-xs-12  well col-md-offset-1">
            <form name="ad-form" id="ad-form" method="post" action="<?php echo base_url('users/register');?>"
                role="form" enctype="multipart/form-data" onsubmit="return checkUser();">
                <fieldset>
                    <legend class="text-center">User Registration</legend>
                    <!-- employee name -->
                    <div class="form-group">
                        <div class="row colbox">
                            <div class="col-xs-12 col-md-6">
                                <label for="sfirstname" class="control-label">First Name</label>
                                <input class="form-control" id="sfirstname" name="sfirstname" placeholder="First Name"
                                    value="" type="text" />
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="email" class="control-label">Email</label>
                                <input class="form-control" id="email" name="email" placeholder="Email" value=""
                                    type="email" />
                                <span class="text-danger"></span>
                            </div>
                            <!--<div class="col-xs-12 col-md-6">
                                <label for="slastname" class="control-label">Last Name</label>
                                <input class="form-control" id="slastname" name="slastname" placeholder="Last name"
                                    type="text" value="" />
                                <span class="text-danger"></span>
                            </div>-->
                        </div>
                    </div>

                    <!-- employee email -->
                    <!--<div class="form-group">
                        <div class="row colbox">
                            <div class="col-xs-12 col-md-6">
                                <label for="email" class="control-label">Email</label>
                                <input class="form-control" id="email" name="email" placeholder="Email" value=""
                                    type="email" />
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="mobile" class="control-label">Mobile</label>
                                <input class="form-control" id="mobile" name="mobile" placeholder="Mobile" value=""
                                    type="number" />
                                <span class="text-danger"></span>
                            </div>        
                        </div>
                    </div>-->

                    <!-- employee Password -->
                    <div class="form-group">
                        <div class="row colbox">
                            <div class="col-xs-12 col-md-6">
                                <label for="password" class="control-label">Password</label>
                                <input class="form-control" id="password" name="password" placeholder="Password"
                                    type="password" value="" />
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="password_confirm" class="control-label">Confirm Password</label>
                                <input class="form-control" id="password_confirm" name="password_confirm"
                                    placeholder="Confirm Password" type="password" value="" />
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php if (isset($validationSignup)): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $validationSignup->listErrors() ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- sigup button -->
                    <div class="text-center">
                        <div class="form-gruop">
                            <div class="row colbox">
                                <div class="col-xs-12 .col-md-4">
                                    <input id="btn_signup" name="btn_signup" type="submit"
                                        class="btn btn-primary btn-block" value="Signup" />
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </form>
            <div class="text-center">
                <br>
                <!--<a href="http://addgalaxy.com//Login_Controller/" >Already signed up? Login</a>-->
            </div>

        </div>

        <!--ends sign up--->

        <div class="col-md-3">
            <!-- right col -->
        </div>
    </div>
</div>
<style>
    .states1 {
        color: #337ab7 !important;
    }

    .zoomstate {
        font-size: 20px !important;
    }
</style>
<?php echo view('footer',$extras);?>