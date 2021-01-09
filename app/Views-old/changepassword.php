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
            <form action="<?php echo base_url('users/updatenewpassword');?>" method="post" accept-charset="utf-8">
                <fieldset>
                    <legend class="text-center">Enter New Password</legend>
                    <input type="hidden" name="userid" value="<?php echo $currentid;?>">
                    <!-- username -->
                    <div class="form-group">
                        <div class="row colbox">
                            <label for="txt_username" class="control-label">Password</label>
                            <input type="text" class="form-control" name="password" id="password">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row colbox">
                            <label for="txt_username" class="control-label">Confirm Password</label>
                            <input type="text" class="form-control" name="cpassword" id="cpassword">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <!-- signin button -->
                    <div class="form-gruop">
                        <div class="row colbox text-center">
                            <input type="submit" id="btn_login" name="btn_login" value="Submit"
                                class="btn btn-color btn-block" />
                        </div>
                    </div>
                </fieldset>
            </form>
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