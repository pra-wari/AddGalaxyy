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
            <form action="<?php echo base_url('users/SendEnquiry');?>" method="post" accept-charset="utf-8">
                <fieldset>
                    <legend class="text-center">Contact us</legend>
                    <!-- username -->
                    <div class="form-group">
                        <div class="row colbox">
                            <label for="txt_username" class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row colbox">
                            <label for="txt_username" class="control-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row colbox">
                            <label for="txt_username" class="control-label">Subject</label>
                            <textarea id="subject" class="form-control" name="subject" rows="3"></textarea>
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

                    <?php if (isset($message) && $message!=''): ?>
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <?= $message; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </fieldset>
            </form>
        </div>
        <!--ends sign up--->
        <div class="col-md-1">
            <!-- right col -->
        </div>
        <div class="col-md-5">
        <h3>Our Address</h3>
        <br />
        <?php echo $extras['hotlinks'][8]['option_value'];?>

        <div id="location">
            <iframe src="https://www.google.com/maps?q=<?php echo $extras['hotlinks'][8]['option_value'];?>&output=embed"
                width="100%" height="450" frameborder="0" style="border:0"></iframe>
                            </div>
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