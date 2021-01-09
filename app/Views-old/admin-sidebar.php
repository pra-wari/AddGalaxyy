<?php $user_id = session()->get('id');  
$usertype=session()->get('usertype');
if($usertype=='admin'){
    $type = "/admin";
}else{
    $type = '/users';
}
?>
<div class="col-md-3 col-sm-4 mb-xs-30 mobile-spacing">
    <div class="sidebar-block gray-box">
        <div class="sidebar-box listing-box cat1 mb-40">
            <span class="opener plus"></span>
            <div class="main_title sidebar-title">
                <h3><span>Dashboard</span></h3>
            </div>
            <div class="sidebar-contant">

                <div class="panel-group" id="adminaccordion">
                    <?php if($type=='user'){?>
                    <a class="cat_list" href="<?php echo base_url($type);?>">
                        <div class="panel panel-default ">
                            <div class="panel-heading  <?php if(!$currentpage){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">My Ads</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url('/admin/allads/');?>">    
                    <div class="panel panel-default">
                        <div class="panel-heading <?php if($currentpage=='allads'){ echo 'selected'; }?>">
                            <h4 class="panel-title">
                                <span style="padding-left:10px;">All Ads</span>
                                <i class="fa fa-caret-right"></i>
                            </h4>
                        </div>
                    </div>
                    </a>
                    <?php } ?>
                    <a class="cat_list" href="<?php echo base_url($type.'/updatepassword/'.$user_id);?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='updatepassword'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Update Password</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url($type.'/editprofile/'.$user_id);?>">
                    <div class="panel panel-default">
                        <div class="panel-heading <?php if($currentpage=='editprofile'){ echo 'selected'; }?>">
                            <h4 class="panel-title">
                                <span style="padding-left:10px;">Edit Profile</span>
                                <i class="fa fa-caret-right"></i>
                            </h4>
                        </div>
                    </div>
                    </a>
                    <!--<div class="panel panel-default">
                        <div class="panel-heading <?php if($currentpage=='messages'){ echo 'selected'; }?>">
                            <h4 class="panel-title">
                                <a href="#2">
                                    <a class="cat_list" href="<?php echo base_url($type.'/messages/'.$user_id);?>">
                                        <span style="padding-left:10px;">Messages</span>
                                    </a>
                                    <i class="fa fa-caret-right"></i>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading <?php if($currentpage=='invoices'){ echo 'selected'; }?>">
                            <h4 class="panel-title">
                                <a href="#2">
                                    <a class="cat_list" href="<?php echo base_url($type.'/invoices/'.$user_id);?>">
                                        <span style="padding-left:10px;">Invoice/bill</span>
                                    </a>
                                    <i class="fa fa-caret-right"></i>
                                </a>
                            </h4>
                        </div>
                    </div>-->
                    <?php 
                    if($usertype=='admin'){ ?>
                    <a class="cat_list" href="<?php echo base_url('/admin/allpages/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='allpages'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Pages</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/statics/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='statics'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Statics</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/settings/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='settings'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Settings</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/parentcategories/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='parentcategories'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Parent Categories</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/childcategories/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='childcategories'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Child Categories</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/localities/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='localities'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Localities</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/allPlans/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='allPlans'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Plans</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/allattributes/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='allattributes'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Attributes</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/allusers/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='allusers'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Users</span>
                                        <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/allinvoices/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='allinvoices'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">All Invoices</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <a class="cat_list" href="<?php echo base_url('/admin/enquiries/');?>">
                        <div class="panel panel-default">
                            <div class="panel-heading <?php if($currentpage=='enquiries'){ echo 'selected'; }?>">
                                <h4 class="panel-title">
                                    <span style="padding-left:10px;">Messages</span>
                                    <i class="fa fa-caret-right"></i>
                                </h4>
                            </div>
                        </div>
                    </a>
                    <?php
                    }
                    ?>
                    <a class="cat_list" href="<?php echo base_url($type.'/logout/');?>">
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