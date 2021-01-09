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
                                        <h1>Edit Attribute</h1>
                                        <p class="lead"></p>
                                        <form name="ad-form" id="ad-form" method="post"
                                            action="<?php echo base_url('/admin/updateAttribute');?>" role="form"
                                            enctype="multipart/form-data" onsubmit="return checkTitle();">
                                            <div class="messages"></div>
                                            <input type="hidden" name="attrid" id="attrid" value="<?php echo $attribute[0]['id'];?>" readonly />
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Attribute Name: </label>
                                                            <input id="title" type="text" maxlength="65" name="name"
                                                                class="form-control"
                                                                placeholder="Please enter a title *" required="required"
                                                                data-error="Title should be atleast 10 chars long" 
                                                                value="<?php echo $attribute[0]['attribute_name'];?>">
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Display type: </label>
                                                            <select id="display_type" name="display_type" class="form-control"
                                                                required="required" data-error="Display Type is required.">
                                                                <option value="dropdown" <?php if($attribute[0]['type']=='dropdown'){ echo 'selected';} ?>>Drop Down</option>
                                                                <option value="radio" <?php if($attribute[0]['type']=='radio'){ echo 'selected';} ?>>Radio</option>
                                                                <option value="checkbox" <?php if($attribute[0]['type']=='checkbox'){ echo 'selected';} ?>>Check box</option>
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Attribute type: </label>
                                                            <select id="attr_type" name="attr_type" class="form-control"
                                                                required="required" data-error="Attribute is required.">
                                                                <option value="tags" <?php if($attribute[0]['attribute_type']=='tags'){ echo 'selected';} ?>>Tags</option>
                                                                <option value="attribute" <?php if($attribute[0]['attribute_type']=='attribute'){ echo 'selected';} ?>>Attributes</option>
                                                                
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Show in Listing: </label>
                                                            <select id="attr_show" name="attr_show" class="form-control"
                                                                required="required" data-error="Attribute is required.">
                                                                <option value="1" <?php if($attribute[0]['show_in_listing']=='1'){ echo 'selected';} ?>>Yes</option>
                                                                <option value="0" <?php if($attribute[0]['show_in_listing']=='0'){ echo 'selected';} ?>>No</option>
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Category: </label>
                                                            <select id="category" name="category" class="form-control"
                                                                required="required">
                                                                <?php foreach ($categories as $k2 => $v2) { ?>
                                                                    <option value="<?php echo $v2['id'];?>" <?php if($attribute[0]['parent_category_id']==$v2['id']){ echo 'selected';} ?>><?php echo $v2['name'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Plan Details: </label>
                                                            <div class="table-responsive">  
                                                                <table class="table table-bordered" id="dynamic_field">  
                                                                        <tr>  
                                                                            <th>Attribute option</td>  
                                                                            <th>Action</td>  
                                                                        </tr> 
                                                                        <?php foreach ($attribute[0]['meta'] as $key => $value) {?> 
                                                                        <tr id="row<?php echo $key;?>">  
                                                                            <td><input type="hidden" name="details[<?php echo $key;?>][id]" value="<?php echo $value['id'];?>"><input type="text" name="details[<?php echo $key;?>][name]" placeholder="Enter option Name" class="form-control name_list" value="<?php echo $value['option_name'];?>" /></td>  
                                                                            <?php if($key==0){?>
                                                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td> 
                                                                            <?php }else{ ?>
                                                                                <td><button type="button" name="remove" id="<?php echo $key;?>" class="btn btn-danger btn_remove">X</button></td> 
                                                                            <?php } ?> 
                                                                        </tr> 
                                                                        <?php } ?>  
                                                                </table>  
                                                            </div>  
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
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
                                                </div>
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
                                var i=<?php echo count($attribute[0]['meta'])-1; ?>;  
                                $('#add').click(function(){  
                                    i++;  
                                    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="hidden" name="details['+i+'][id]"><input type="text" name="details['+i+'][name]" placeholder="Enter option Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
                                });  
                                $(document).on('click', '.btn_remove', function(){  
                                    var button_id = $(this).attr("id");   
                                    $('#row'+button_id+'').remove();  
                                });  
                                $('#submit').click(function(){            
                                    $.ajax({  
                                            url:"name.php",  
                                            method:"POST",  
                                            data:$('#add_name').serialize(),  
                                            success:function(data)  
                                            {  
                                                alert(data);  
                                                $('#add_name')[0].reset();  
                                            }  
                                    });  
                                });  
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