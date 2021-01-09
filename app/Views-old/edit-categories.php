<?php echo view('header'); 
$user_id = session()->get('id');
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
            <div class="col-md-6 col-sm-8" id="product-de">
                <div class="product-listing1">
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="" style="overflow:hidden;">
                                    <div class="col-md-12">
                                        <h1>Edit Category <?php echo $currentpage;?></h1>
                                        <p class="lead"></p>
                                        <form name="ad-form" id="ad-form" method="post"
                                            action="<?php echo base_url('/admin/editcategories');?>" role="form"
                                            enctype="multipart/form-data" onsubmit="return checkTitle();">
                                            <div class="messages"></div>
                                            <input type="hidden" name="cid" id="cid"
                                                value="<?php echo $category[0]['id'];?>" readonly />
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Category Name: </label>
                                                            <input id="title" type="text" maxlength="65" name="name"
                                                                class="form-control"
                                                                placeholder="Please enter a title *" required="required"
                                                                data-error="Title should be atleast 10 chars long"
                                                                value="<?php echo $category[0]['name'];?>">
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Category Slug: </label>
                                                            <input id="title" type="text" maxlength="65" name="slug"
                                                                class="form-control"
                                                                placeholder="Please enter a title *" required="required"
                                                                data-error="Title should be atleast 10 chars long"
                                                                value="<?php echo $category[0]['slug'];?>">
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_name">parent Category </label>
                                                            <select id="category" name="category" class="form-control"
                                                                required="required" data-error="Category is required."
                                                                onchange="getCat(this.value);getPackage();">
                                                                <option value="0"
                                                                    <?php if($category[0]['parent_id']==0){ echo 'selected';} ?>>
                                                                    Main Category</option>
                                                                <?php foreach ($categories as $key => $value) { ?>
                                                                <option value="<?php echo $value['id'];?>"
                                                                    <?php if($category[0]['parent_id']==$value['id']){ echo 'selected';} ?>>
                                                                    <?php echo $value['name'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Description *</label>
                                                            <textarea rows="10" col="200" id="desc" name="desc"
                                                                class="form-control"
                                                                placeholder="Please enter the description of your add *"
                                                                required="required"
                                                                data-error="Description should be atleast 100 chars long"><?php echo $category[0]['description'];?></textarea>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Upload Images(
                                                                <font style="color:#ec0c0c"> Maximum 10 images can be
                                                                    uploaded </font>)
                                                                *</label>
                                                            <div id="maindiv">
                                                                <div id="formdiv">
                                                                    <div class="">
                                                                        <form enctype="multipart/form-data" action="#"
                                                                            method="post">
                                                                            <div id="imageDiv"> </div>
                                                                            <div id="filediv" style="">
                                                                                <input name="file[]" type="file"
                                                                                    id="file" multiple />
                                                                                <input type="hidden" value="0"
                                                                                    id="post_img_count">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="row1">
                                                        <div class="col-md-12"
                                                            style="padding-left: 0px; float: left; position: relative; margin-top: 20px;">
                                                            <input type="submit" class="btn btn-success btn-send"
                                                                style="margin: 15px 10px; position: relative;"
                                                                value="Submit">
                                                        </div>
                                                    </div>
                                                    <p class="text-muted"><strong>*</strong> These fields are required.
                                                    </p>
                                                </div>
                                        </form>
                                    </div>
                                    <div class="col-md-3">
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
<?php echo view('footer',$extras); ?>