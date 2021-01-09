<?php echo view('header');
//print_r($categories);
//echo view('search-bar');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mobile-spacing">
            <div class="col-md-12">
                <h1>Post an AD </h1>
                <p class="lead"></p>
                <form name="ad-form" id="ad-form" method="post" action="<?php echo base_url('/users/submitad');?>"
                    role="form" enctype="multipart/form-data" onsubmit="return submitPost();">
                    <div class="messages"></div>
                    <input type="hidden" name="tid" id="tid" readonly />
                    <div class="controls">
                        <div class="row">
                            <script>
                                //jQuery(document).load(function(){
                                function getCat(catid) {
                                    $.ajax({
                                        url: "<?php echo base_url('/users/fetchpostaddata');?>",
                                        method: "POST",
                                        data: {
                                            id: catid
                                        },
                                        success: function (data) {
                                            var result = JSON.parse(data);
                                            var html='';
                                            $.each(result.subCategory, function (index, v1) {
                                                html += '<option value="' + v1.id +
                                                    '">' + v1.name + '</option>';
                                            });
                                            $('#subcategory').html(html);
                                            var i1=0;
                                            $.each(result.attributes, function (index, v2) {
                                                console.log(v2);
                                                var htmlcontent = '';
                                                var rhtml = '';
                                                $.each(v2.option, function (i, v3) {
                                                    rhtml = rhtml +
                                                        '<input type="radio" name="name[' +
                                                        v2.id + ']" value="' + v3.id +
                                                        '">&nbsp;' + v3.option_name +
                                                        '<br>';
                                                    
                                                });
                                                console.log(v2.attribute_name);
                                                if(v2.attribute_name=='Brand'){
                                                    htmlcontent =
                                                    '<div class="filter-inner-box mb-20"><div class="inner-title">' +
                                                    v2.attribute_name + '</div><div class="listing" style="border: 2px solid #ccc;">' + rhtml +
                                                    '</div></div>';
                                                }else{
                                                    i1++;
                                                    htmlcontent =
                                                    '<div class="col-sm-3"><div class="inner-title">' +
                                                    v2.attribute_name + '</div><div class="listing" style="border: 2px solid #ccc;">' + rhtml +
                                                    '</div></div>';
                                                }
                                                

                                                $('#attributes').append(htmlcontent);
                                            });
                                            if(i1==3){
                                                $('#attributes').append('<div class="col-sm-3"></div>');
                                            }
                                        }
                                    });
                                }
                                //});
                            </script>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_name">Category *</label>
                                    <select id="category" name="category" class="form-control" required="required"
                                        data-error="Category is required." onchange="getCat(this.value);">
                                        <option value="">Select Category</option>
                                        <?php foreach($categories as $key => $value) {?>
                                        <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
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
                                    <label for="form_name">Sub Category *</label>
                                    <select id="subcategory" name="subcategory" class="form-control" required="required"
                                        data-error="Sub Category is required." onchange="getPackage();">
                                        <option value="">Select Subcategory</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Title *</label>
                                    <input id="title" type="text" maxlength="65" name="title" class="form-control"
                                        placeholder="Please enter a title *" required="required"
                                        data-error="Title should be atleast 10 chars long">
                                    <div class="help-block with-errors" id="titleerrorid"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Description *</label>
                                    <textarea rows="10" col="200" id="desc" name="desc" class="form-control"
                                        placeholder="Please enter the description of your add *" required="required"
                                        data-error="Description should be atleast 100 chars long"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div id="attributes" class="row">

                        </div>






                        <!-- JObs Category End -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email" id="priceLabel">Price *</label>

                                    <input type="text" value="" id="price" name="price" class="form-control"
                                        placeholder="0 *" required="required"
                                        data-error="Price should be greater than 0">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Country *</label>
                                    <select id="country" name="country" class="form-control" required="required"
                                        data-error="Select Country" onchange="getState1(this.value);">
                                        <option value="">Select Country</option>
                                        <?php foreach($countries as $k1 => $v1) {?>
                                        <option value="<?php echo $v1['id'];?>"><?php echo $v1['name'];?></option>
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
                                    <select id="state" name="state" class="form-control" required="required"
                                        data-error="Select State" onchange="getCity1(this.value);">
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
                        </div>
                        <!--<div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">ZIP Code</label>
                                    <input id="zipcode" type="text" name="zipcode" class="form-control"
                                        placeholder="Please enter a Valid Zip "
                                        data-error="Zip does not match to selected city">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Meta Keywords (optional)</label>
                                    <input id="keywords" type="text" name="keywords" class="form-control"
                                        placeholder="Please enter few keywords">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group plan_group" >
                                    <label for="form_name">Choose Plan *</label>
                                    <br>
                                    <div class="pricing-wrapper clearfix packagemob">
                                        <input type="hidden" id="selectedDuration" name="selectedDuration" value="4">
                                        <input type="hidden" id="plantype" name="plantype" value="free">
                                        <!-- ======= Pricing Table ============-->
                                        <?php
                                        $ci = 1;
                                        foreach ($plans as $key => $value) {
                                            
                                            if($ci==1){
                                                $title_calss = "pricing-title";
                                            }else{
                                                $title_calss = "pricing-title".$ci;

                                            }
                                        ?>

                                        <div class="pricing-table">
                                            <h3 class="<?php echo $title_calss;?>"><?php echo $value['plan_name'];?>
                                            </h3>
                                            <ul class="table-list">
                                                <li>
                                                    <select id="duration<?php echo $value['id'];?>" name="duration[]"
                                                        class="form-control"
                                                        onchange="getPrice(this.value, <?php echo $value['id'];?>,'<?php echo $value['type'];?>');">
                                                        <option value="">Select Duration</option>
                                                        <?php /*foreach ($value['meta'] as $key1 => $value1) {?>
                                                        <option
                                                            value="<?php echo $value1['plan_price']?>-<?php echo $value1['id']?>" 
                                                            <?php if($key==0 && $key1==0){ echo 'selected';}?>>
                                                            <?php echo $value1['plan_duration']?></option>
                                                        <?php }*/ ?>
                                                    </select>
                                                </li>
                                                <li>
                                                    <div class="form-text">
                                                        <label for="night" class="static-value-price">Price</label>
                                                        <span class="price-icon"><i class="fa fa-inr"></i></span>
                                                        <input style="width:50%" type="text" name="plan_price[]"
                                                            disabled="true" Class="package_price"
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Meta Description (optional)</label>
                                    <textarea rows="10" id="metadesc" name="metadesc" class="form-control"
                                        placeholder="Please enter the description for entered keywords "></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Upload Images(
                                        <font style="color:#ec0c0c"> Maximum 10 images can be uploaded </font>)
                                        *</label>
                                    <div id="maindiv">
                                        <div id="formdiv">
                                            <div class="">
                                                <form enctype="multipart/form-data" action="#" method="post">
                                                    <div id="imageDiv"> </div>
                                                    <div id="imagetop">
                                                    <input type="hidden" value="0" id="post_img_count">
                                                        <div id="filediv" style="">
                                                            <input name="file[]" type="file" id="file" multiple />
                                                        </div>
                                                    </div>
                                                    <div id="bottom">
                                                        <input type="button" id="add_more_images" class="upload"
                                                            value="Add More Files" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="image-help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row1">
                                <div class="col-md-12"
                                    style="padding-left: 0px; float: left; position: relative; margin-top: 20px;">
                                    <div class="col-md-12" style="padding-left: 0px;">
                                        <div class="col-md-4">
                                        <?php echo reCaptcha2('reCaptcha2', ['id' => 'recaptcha_v2'], ['theme' => 'dark']); ?>
                                        <!--<img src="<?php //echo view('captcha_code');?>">
                                            <div id="captcha"></div>
                                            <input type="text" class="form-control" placeholder="Enter the text here."
                                                id="cpatchaTextBox" required>-->
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-success btn-send"
                                        style="margin: 15px 10px; position: relative;" value="Create Add">
                                </div>
                            </div>
                            <p class="text-muted"><strong>*</strong> These fields are required.</p>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assests/js/contact.js"></script>
<style>
    .states1 {
        color: #337ab7 !important;
    }
    .zoomstate {
        font-size: 20px !important;
    }
</style>
<?php echo view('footer',$extras);?>
<script>
    jQuery(document).ready(function(){
        $('#add_more_images').click(function(){
            if($('#filediv input').length<10){
                $('#filediv').append('<input name="file[]" type="file" id="file" multiple />');
            }else{
                $('.image-help-block').text('Maximum 10 images can be uploaded');
            }
            
        });
    });
    function submitPost() {
        if(grecaptcha.getResponse().length==0){
            alert('Please Validate Captcha');
            return false;
        }
        
    }

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
        // return false;
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/admin/getPostCity",
            data: {
                'con': val
            },
            success: function (data) {
                //console.log(data);
                $("#city").html(data);
                // $("#hidden").html(con2);
            },
        });
        //location.reload();
    }

    function getRegion1(val) {
        // return false;
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/admin/getPostRegion",
            data: {
                'con': val
            },
            success: function (data) {
                //console.log(data);
                $("#region-sel").html(data);
                // $("#hidden").html(con2);
            },
        });
        //location.reload();
    }

    $(document).ready(function(){
        $(document).on('change','#region-sel',function(){
            var selectedId=$(this).val();
            //console.log('change',selectedId);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>/admin/getplanbyRegion",
                data: {
                    'con': selectedId
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    $.each(res, function(key, value) {
                        var html='<option value="">Select Duration</option>';
                        $.each(value.plan, function(key1, value1) {
                            console.log('meta=',value1);
                            html += '<option value="'+value1.plan_price+'-'+value1.id+'">'+value1.plan_duration+'</option>';
                        });
                        $("#duration"+value.id).html(html);
                    });
                },
            });
        });
        $(document).on('change','#state',function(){
            var selectedId=$(this).val();
            console.log('change',selectedId);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>/admin/getplanbyState",
                data: {
                    'con': selectedId
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    $.each(res, function(key, value) {
                        var html='<option value="">Select Duration</option>';
                        $.each(value.plan, function(key1, value1) {
                            console.log('meta=',value1);
                            html += '<option value="'+value1.plan_price+'-'+value1.id+'">'+value1.plan_duration+'</option>';
                        });
                        $("#duration"+value.id).html(html);
                    });
                },
            });
        });
    });

    function selectdays(id) {
        // console.log(id);
    }

    function getPrice(selected, id, type) {
        // console.log(price+"  "+id);
        var res = selected.split('-');
        console.log('===>1',res);
        console.log('===>1',type);
        if(res[0]==0){
            $("#plan_price" + id).val('Free');
        }else{
            $("#plan_price" + id).val(res[0]);
        }
        $("#selectedDuration").val(res[1]);
        $("#plantype").val(type);
    }
</script>