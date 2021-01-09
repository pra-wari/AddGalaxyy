<?php echo view('header'); 
$session = session()->get();
$data['currentpage']=$currentpage;
$type=$session['usertype']=='admin'?'admin':'users';
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
                                    <h1>Update Password</h1>
                                    <p class="lead"></p>
                                    <form name="ad-form" id="ad-form" method="post" action="<?php echo base_url($type.'/changepassword');?>" role="form"
                                        enctype="multipart/form-data" onsubmit="return checkTitle();">
                                        <div class="messages"></div>
                                        <input type="hidden" name="uid" id="uid" readonly="" value="<?php echo $session['id'];?>">
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">Password *</label>
                                                        <input id="password" type="text" maxlength="65" name="password"
                                                            class="form-control" placeholder="Please enter password"
                                                            required="required" value="">
                                                        <div class="help-block with-errors" id="titleerrorid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="confirm_password">Confirm Password *</label>
                                                        <input id="confirm_password" type="text" maxlength="65" name="confirm_password"
                                                            class="form-control" placeholder="Please enter confirm password *"
                                                            required="required" value="">
                                                        <div class="help-block with-errors" id="titleerrorid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-success btn-send"
                                                            style="margin: 15px 10px; position: relative;"
                                                            value="Submit">
                                                        <div class="help-block with-errors" id="titleerrorid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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