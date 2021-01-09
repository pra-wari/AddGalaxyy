<?php echo view('header'); 
$session = session()->get();
$data['currentpage']=$currentpage;
?>
<div class="search-bar center-xs">
    <div class="container-fluid">
        <div class="bread-crumb center-xs">
        </div>
    </div>
</div>
<section class="pb-95" id="desktop-view">
    <div class="container-fluid">
        <div class="row">
        <?php if($module=='users'){
                echo view('user-sidebar');
            }else{
                echo view('admin-sidebar',$data);
            }?>
            <div class="col-md-6 col-sm-8" id="product-de">
                <div class="product-listing1">
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <h1>Edit Profile</h1>
                                    <p class="lead"></p>
                                    <form name="ad-form" id="ad-form" method="post" action="<?php if($module=="admin"){ echo base_url('admin/updateprofile');}else{ echo base_url('users/updateProfile');}?>"
                                        role="form" enctype="multipart/form-data" onsubmit="return checkUser();">
                                        <fieldset>
                                            <input type="hidden" name="uid" value="<?php echo $user['id'];?>">
                                            <!-- employee name -->
                                            <div class="form-group">
                                                <div class="row colbox">
                                                    <div class="col-xs-12 col-md-6">
                                                        <label for="sfirstname" class="control-label">First Name</label>
                                                        <input class="form-control" id="sfirstname" name="sfirstname" placeholder="First Name"
                                                            value="<?php echo $user['firstname'];?>" type="text" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <label for="slastname" class="control-label">Last Name</label>
                                                        <input class="form-control" id="slastname" name="slastname" placeholder="Last name"
                                                            type="text" value="<?php echo $user['lastname'];?>" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- employee email -->
                                            <div class="form-group">
                                                <div class="row colbox">
                                                    <div class="col-xs-12 col-md-6">
                                                        <label for="email" class="control-label">Email</label>
                                                        <input class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user['email'];?>"
                                                            type="email" />
                                                        <span class="text-danger"></span>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <label for="mobile" class="control-label">Mobile</label>
                                                        <input class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="<?php echo $user['mobile'];?>"
                                                            type="number" />
                                                        <span class="text-danger"></span>
                                                    </div>        
                                                </div>
                                            </div>
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
                                                                class="btn btn-primary btn-block" value="Update" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                    <!-- /.8 -->
                                    <div class="col-md-3">
                                        <!--<img src="http://addgalaxy.com/assests\home\images\sidebar.jpg" width="800px" height "2000px"> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#total_ads_count').text('9');
                                $('.total_ads_countnew').text('9');
                            });
                        </script>
                    </div>
                    <div class="col-md-6 col-sm-8" id="textImage" style="display:none">
                        <div class="container">
                            <div class="row">
                                <div class="">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><span id="ad_with_img_count">0 </span><span> Results for your
                                                        search</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $("#ad_with_img_count").text('0 ')
                    </script>


                    <div class="col-xs-12" id="text2Image" style="display:none">
                        <div class="container">
                            <div class="row">
                                <div class="">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><span id="ad_without_img_count">0 </span><span> Results for your
                                                        search</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $("#ad_without_img_count").text('0 ')
                    </script>
                </div>
            </div>

            <!-- Right side Gallery-->
            <div class="col-md-3 col-sm-3 mb-xs-30" id="right-side-gallery" style="padding-left: 0px;">
                <div class="sidebar-block right-side-color graybox1">

                </div>
            </div>
        </div>
        <!-- Right side gallery end -->


    </div>

</section>
<?php echo view('footer',$extras);?>