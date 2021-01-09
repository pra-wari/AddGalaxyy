<?php echo view('header'); 
$parentCategory = $listing[0]['parentcategoriesData'][0]['id'];
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
                                <div class="col-md-12">
                                    <h1>Edit Listing</h1>
                                    <p class="lead"></p>
                                    <form name="ad-form" id="ad-form" method="post" action="<?php echo base_url('/admin/updatelisting');?>" role="form"
                                        enctype="multipart/form-data" onsubmit="return checkTitle();">
                                        <div class="messages"></div>
                                        <input type="hidden" name="tid" id="tid" value="<?php echo $listing[0]['id'];?>" readonly="">
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="form_name">Category *</label>
                                                        <select id="category" name="category" class="form-control"
                                                            required="required" data-error="Category is required."
                                                            onchange="getCat(this.value);getPackage();">
                                                            <option value="">Select Category</option>
                                                            <?php foreach ($categories as $key => $value) {
                                                               ?>
                                                            <option value="<?php echo $value['id'];?>"
                                                                <?php if($value['id']==$parentCategory){ echo 'selected';}?>>
                                                                <?php echo $value['name'];?></option>
                                                            <?php
                                                            }?>
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="form_name">Sub Category *</label>
                                                        <select id="subcategory" name="subcategory" class="form-control"
                                                            required="required" data-error="Sub Category is required."
                                                            onchange="getPackage();">
                                                            <option value="">Select Subcategory</option>
                                                            <?php foreach ($listing[0]['subcategories'] as $key => $value) {
                                                               ?>
                                                            <option value="<?php echo $value['id'];?>"
                                                                <?php if($value['id']==$listing[0]['category_id']){ echo 'selected';}?>>
                                                                <?php echo $value['name'];?></option>
                                                            <?php
                                                            }?>
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="form_email">Title *</label>
                                                        <input id="title" type="text" maxlength="65" name="title"
                                                            class="form-control" placeholder="Please enter a title *"
                                                            required="required"
                                                            data-error="Title should be atleast 10 chars long"
                                                            value="<?php echo $listing[0]['title'];?>">
                                                        <div class="help-block with-errors" id="titleerrorid"></div>
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
                                                            data-error="Description should be atleast 100 chars long"><?php echo $listing[0]['description'];?></textarea>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="attributes" class="row">
                                                <?php 
                                                if(count($listing[0]['attributes'])>0){
                                                    foreach($listing[0]['attributes'] as $k1=>$v1){
                                                        if($v1['attribute_name']=='Brand'){
                                                            ?>
                                                        <div class="filter-inner-box mb-20">
                                                            <div class="inner-title"><?php echo $v1['attribute_name'];?></div>
                                                            <div class="listing" style="border: 2px solid #ccc;">
                                                                <?php 
                                                                    foreach ($v1['options'] as $k2 => $v2) {
                                                                        ?>
                                                                <input type="radio" name="name[<?php echo $v1['id'];?>]"
                                                                    value="<?php echo $v2['id'];?>"
                                                                    <?php 
                                                                        if (in_array($v2['id'], $listing[0]['selectedAttribute'])){
                                                                            echo 'checked';
                                                                        }
                                                                    ?>
                                                                    >&nbsp;<?php echo $v2['option_name'];?><br>
                                                                <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }else{
                                                            ?>
                                                        <div class="col-sm-3">
                                                            <div class="inner-title"><?php echo $v1['attribute_name'];?></div>
                                                            <div class="listing" style="border: 2px solid #ccc;"><?php 
                                                                    foreach ($v1['options'] as $k2 => $v2) {
                                                                        ?>
                                                                <input type="radio" name="name[<?php echo $v1['id'];?>]"
                                                                    value="<?php echo $v2['id'];?>"
                                                                    <?php 
                                                                        if (in_array($v2['id'], $listing[0]['selectedAttribute'])){
                                                                            echo 'checked';
                                                                        }
                                                                    ?>
                                                                    >&nbsp;<?php echo $v2['option_name'];?><br>
                                                                <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email" id="priceLabel">Price *</label>

                                                    <input type="text" value="<?php echo $listing[0]['price'];?>"
                                                        id="price" name="price" class="form-control" placeholder="0 *"
                                                        required="required" data-error="Price should be greater than 0">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">Country *</label>
                                                    <select id="country" name="country" class="form-control"
                                                        required="required" data-error="Select Country"
                                                        onchange="getState1(this.value);">
                                                        <option value="">Select Country</option>
                                                        <?php foreach($countries as $k1 => $v1) {?>
                                                        <option value="<?php echo $v1['id'];?>">
                                                            <?php echo $v1['name'];?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">State *</label>
                                                    <select id="state" name="state" class="form-control"
                                                        required="required" data-error="Select State"
                                                        onchange="getCity1(this.value);">
                                                        <option value="">Select State</option>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">City *</label>
                                                    <select id="city" name="city" class="form-control"
                                                        data-error="Select City" onchange="getRegion1(this.value);">
                                                        <option value="">Select City *</option>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">Locality</label>
                                                    <select id="region-sel" name="region" class="form-control"
                                                        data-error="Select Region">
                                                        <option value="">Select Region *</option>
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>-->
                                        <?php 
                                        $key1 = array();
                                        $keywords='';                
                                        foreach ($listing[0]['keywords'] as $key => $value) {
                                            $key1[]=$value['keywords'];
                                        }
                                        if(count($key1)>0){
                                            $keywords=implode(',',$key1);
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">Meta Keywords (optional)</label>
                                                    <input id="keywords" type="text" name="keywords"
                                                        class="form-control" value="<?php echo $keywords;?>" placeholder="Please enter few keywords">
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group plan_group">
                                                    <label for="form_name">Choose Plan *</label>
                                                    <br>
                                                    <div class="pricing-wrapper clearfix ">
                                                        <input type="hidden" id="selectedDuration"
                                                            name="selectedDuration" value="4">
                                                        <input type="hidden" id="plantype" name="plantype" value="free">
                                                       
                                                        <?php
                                                        $ci = 1;
                                                        foreach ($plans as $key => $value) {
                                                            
                                                            if($ci==1){
                                                                $title_calss = "pricing-title";
                                                            }else{
                                                                $title_calss = "pricing-title".$ci;
                                                            }
                                                        ?>

                                                        <div class="pricing-table" style="width:23%;">
                                                            <h3 class="<?php echo $title_calss;?>">
                                                                <?php echo $value['plan_name'];?>
                                                            </h3>
                                                            <ul class="table-list">
                                                                <li>
                                                                    <select id="duration<?php echo $value['id'];?>"
                                                                        name="duration[]" class="form-control"
                                                                        onchange="getPrice(this.value, <?php echo $value['id'];?>,'<?php echo $value['type'];?>');">
                                                                        <option value="">Select Duration</option>
                                                                        <?php foreach ($value['meta'] as $key1 => $value1) {
                                                                            ?>
                                                                        <option
                                                                            value="<?php echo $value1['plan_price']?>-<?php echo $value1['id']?>">
                                                                            <?php echo $value1['plan_duration'];?>
                                                                        </option>
                                                                        <?php
                                                                        }?>
                                                                    </select>
                                                                </li>
                                                                <li>
                                                                    <div class="form-text">
                                                                        <label for="night"
                                                                            class="static-value-price">Price</label>
                                                                        <span class="price-icon"><i
                                                                                class="fa fa-inr"></i></span>
                                                                        <input style="width:50%" type="text"
                                                                            name="plan_price[]" disabled="true"
                                                                            Class="package_price"
                                                                            id="plan_price<?php echo $value['id'];?>"
                                                                            value="<?php echo $ci==1?'Free':0;?>"
                                                                            readonly="true">
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <?php 
                                                        $ci++;
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">Meta Description (optional)</label>
                                                    <textarea rows="10" id="metadesc" name="metadesc"
                                                        class="form-control"
                                                        placeholder="Please enter the description for entered keywords "><?php echo $listing[0]['description'];?></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">Upload Images(
                                                        <font style="color:#ec0c0c"> Maximum 10 images can be
                                                            uploaded </font>) *</label>
                                                    <div id="maindiv">
                                                        <div id="formdiv">
                                                            <div class="col-md-12">
                                                            <style>
                                                            .AClass{
                                                                right:0px;
                                                                position: absolute;
                                                            }
                                                            </style>
                                                            <?php 
                                                                if(count($listing[0]['images'])>0){
                                                                    $iflg=1;
                                                                    foreach ($listing[0]['images'] as $imgkey => $imgvalue) {
                                                                        ?>
                                                                        <div id="img<?php echo $imgvalue['id'];?>" class="col-md-3">
                                                                                <div style="position:relative;">
                                                                                    <button data-id="<?php echo $imgvalue['id'];?>" type="button" class="close AClass">
                                                                                    <span>&times;</span>
                                                                                    </button>
                                                                                    <img width="100" height="100" src="<?php echo base_url($imgvalue['image_path']);?>"/>
                                                                                </div>
                                                                        </div>
                                                                        <?php
                                                                        if($iflg%4==0){
                                                                            echo '</div><div class="col-md-12">';
                                                                        }
                                                                        $iflg++;
                                                                    }
                                                                }
                                                            ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <form enctype="multipart/form-data" action="#"
                                                                    method="post">
                                                                    <div id="imageDiv"> </div>
                                                                    <div id="imagetop">
                                                                        <input type="hidden" value="0"
                                                                            id="post_img_count">
                                                                        <div id="filediv" style="">
                                                                            <input name="file[]" type="file" id="file"
                                                                                multiple />
                                                                        </div>
                                                                    </div>
                                                                    <div id="bottom">
                                                                        <input type="button" id="add_more_images"
                                                                            class="upload" value="Add More Files" />
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
                                                        value="Update Add">
                                                </div>
                                            </div>
                                            <p class="text-muted"><strong>*</strong> These fields are required.</p>
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
    <script>
        $(document).ready(function () {
            $(document).on('change', '#region-sel', function () {
                var selectedId = $(this).val();
                //console.log('change',selectedId);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url();?>/admin/getplanbyRegion",
                    data: {
                        'con': selectedId
                    },
                    success: function (data) {
                        var res = JSON.parse(data);
                        $.each(res, function (key, value) {
                            var html = '<option value="">Select Duration</option>';
                            $.each(value.plan, function (key1, value1) {
                                console.log('meta=', value1);
                                html += '<option value="' + value1
                                    .plan_price + '-' + value1.id + '">' +
                                    value1.plan_duration + '</option>';
                            });
                            $("#duration" + value.id).html(html);
                        });
                    },
                });
            });
            $(document).on('click','.AClass',function(){
                var selectedId = $(this).attr('data-id');
                console.log(selectedId);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url();?>/admin/deleteimagebyid",
                    data: {
                        'con': selectedId
                    },
                    success: function (data) {
                        console.log(data);
                        $('#img'+selectedId).hide();
                    },
                });
            });
            $(document).on('change', '#state', function () {
                var selectedId = $(this).val();
                console.log('change', selectedId);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url();?>/admin/getplanbyState",
                    data: {
                        'con': selectedId
                    },
                    success: function (data) {
                        var res = JSON.parse(data);
                        $.each(res, function (key, value) {
                            var html = '<option value="">Select Duration</option>';
                            $.each(value.plan, function (key1, value1) {
                                console.log('meta=', value1);
                                html += '<option value="' + value1
                                    .plan_price + '-' + value1.id + '">' +
                                    value1.plan_duration + '</option>';
                            });
                            $("#duration" + value.id).html(html);
                        });
                    },
                });
            });
            $('#add_more_images').click(function () {
                if ($('#filediv input').length < 10) {
                    $('#filediv').append('<input name="file[]" type="file" id="file" multiple />');
                } else {
                    $('.image-help-block').text('Maximum 10 images can be uploaded');
                }

            });
        });

        function getState1(id) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>/admin/getPostState",
                data: {
                    'con': id
                },
                success: function (data) {
                    $("#state").html(data);
                }
            });
        }

        function getCity1(val) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>/admin/getPostCity",
                data: {
                    'con': val
                },
                success: function (data) {
                    $("#city").html(data);
                },
            });
        }

        function getRegion1(val) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>/admin/getPostRegion",
                data: {
                    'con': val
                },
                success: function (data) {
                    $("#region-sel").html(data);
                },
            });
        }

        function getPrice(selected, id, type) {
            // console.log(price+"  "+id);
            var res = selected.split('-');
            console.log('===>1', res);
            console.log('===>1', type);
            if (res[0] == 0) {
                $("#plan_price" + id).val('Free');
            } else {
                $("#plan_price" + id).val(res[0]);
            }
            $("#selectedDuration").val(res[1]);
            $("#plantype").val(type);
        }
    </script>

    </div>

</section>
<?php echo view('footer',$extras);?>