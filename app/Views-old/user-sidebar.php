<?php $user_id = session()->get('id');  ?>
<div class="col-md-3 col-sm-4 mb-xs-30 mobile-spacing">
    <div class="sidebar-block gray-box">
        <div class="sidebar-box listing-box cat1 mb-40">
            <span class="opener plus"></span>
            <div class="main_title sidebar-title">
                <h3><span>Dashboard</span></h3>
            </div>
            <div class="sidebar-contant">
                <!-- subcategory list start -->
                <div class="panel-group" id="adminaccordion">
                    <a class="cat_list" href="<?php echo base_url('/dashboard');?>">
                        <div class="panel panel-default ">
                            <div class="panel-heading  <?php if(!$currentpage){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">My Ads</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/users/updatepassword/'.$user_id);?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='updatepassword'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Update Password</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/users/editprofile/'.$user_id);?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='editprofile'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Edit Profile</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/users/messages/'.$user_id);?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Messages</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/users/invoices/'.$user_id);?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Invoice/bill</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/users/logout/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Logout</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- subcategory list end -->

            </div>
        </div>
    </div>
</div>