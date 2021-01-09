<?php echo view('header'); 
$user_id = session()->get('id');
$d = array('page'=> $module);
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
        <?php echo view('admin-sidebar');?>
            <div class="col-md-9 col-sm-8" id="product-de">
                <div class="product-listing1">
                    <div class="row">
                        <div class="container1">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <!--<a href="<?php //echo base_url('/admin/generateInvoice');?>">
                                    <button type="button" class="btn btn-secondary btn-sm btn-block">Generate Invoice</button>
                                </a>-->
                            </div>
                        </div>
                    </div>
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="" style="overflow:hidden;">
                                    <div class="col-md-12">
                                        <h1>Settings</h1>
                                        <p class="lead"></p>
                                        <form name="ad-form" id="ad-form" method="post"
                                            action="<?php echo base_url('/admin/updatesettings');?>" role="form"
                                            enctype="multipart/form-data" onsubmit="return checkTitle();">
                                            <div class="messages"></div>
                                            <div class="controls">
                                            <?php 
                                            foreach ($settings as $key => $value) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="form_email"><?php echo $value['option_name'];?>: </label>
                                                        <input id="title" type="text" maxlength="65" name="<?php echo $value['icon_path'];?>"
                                                            class="form-control"
                                                            placeholder="Please enter a Url *" required="required"
                                                            data-error="Title should be atleast 10 chars long"
                                                            value="<?php echo $value['option_value'];?>">
                                                        <div class="help-block with-errors" id="titleerrorid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <div class="row1">
                                                <div class="col-md-12"
                                                    style="padding-left: 0px; float: left; position: relative; margin-top: 20px;">
                                                    <input type="submit" class="btn btn-success btn-send"
                                                        style="margin: 15px 10px; position: relative;"
                                                        value="Submit">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php echo view('footer',$extras);?>