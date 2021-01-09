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
            <div class="col-md-9 col-sm-8" id="product-de">
                <div class="product-listing1">
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="" style="overflow:hidden;">
                                    <div class="col-md-12">
                                        <h1>Edit Plan</h1>
                                        <p class="lead"></p>
                                        <form name="ad-form" id="ad-form" method="post"
                                            action="<?php echo base_url('/admin/updateplan');?>" role="form"
                                            enctype="multipart/form-data" onsubmit="return checkTitle();">
                                            <div class="messages"></div>
                                            <input type="hidden" name="planid" id="planid" value="<?php echo $plan[0]['id'];?>" readonly />
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Plan Name: </label>
                                                            <input id="title" type="text" maxlength="65" name="name"
                                                                class="form-control"
                                                                placeholder="Please enter a title *" required="required"
                                                                data-error="Title should be atleast 10 chars long" 
                                                                value="<?php echo $plan[0]['plan_name'];?>">
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group table-responsive">
                                                            <table class="table table-bordered">  
                                                                <tr>  
                                                                    <th>Default Price</td>  
                                                                    <th>Default Duration</td>  
                                                                    <th>Default Days</td>  
                                                                </tr>
                                                                <?php foreach ($default as $key1 => $value1) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><input id="dprice" type="text" maxlength="65" name="dprice"
                                                                        class="form-control"
                                                                        placeholder="Please enter a title *" required="required"
                                                                        data-error="Title should be atleast 10 chars long" 
                                                                        value="<?php echo $value1['plan_price'];?>"></td>
                                                                            <td><input id="dduration" type="text" maxlength="65" name="dduration"
                                                                        class="form-control"
                                                                        placeholder="Please enter a title *" required="required"
                                                                        data-error="Title should be atleast 10 chars long" 
                                                                        value="<?php echo $value1['plan_duration'];?>"></td>
                                                                            <td><input id="ddays" type="text" maxlength="65" name="ddays"
                                                                        class="form-control"
                                                                        placeholder="Please enter a title *" required="required"
                                                                        data-error="Title should be atleast 10 chars long" 
                                                                        value="<?php echo $value1['planindays'];?>"></td>
                                                                        </tr> 
                                                                    <?php
                                                                }
                                                                ?>
                                                            </table>
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Plans By Location: </label>
                                                            <div class="table-responsive">  
                                                                <table class="table table-bordered" id="dynamic_field">  
                                                                        <tr>  
                                                                            <th>Country</td>  
                                                                            <th>State</td>  
                                                                            <th>City</td>  
                                                                            <th>Region</td>  
                                                                            <th>Duration</td>  
                                                                            <th>Price</td>  
                                                                            <th>Days</td>  
                                                                            <th>Action</td>  
                                                                        </tr> 
                                                                        <?php foreach ($plan[0]['meta'] as $key => $value) {
                                                                            if($value['plan_type']=='main'){ ?> 
                                                                                <tr id="row<?php echo $key;?>">
                                                                                    <td>
                                                                                        <select name="details[<?php echo $key;?>][countries]" class="myCountries">
                                                                                            <?php foreach ($countries as $kc1 => $vc1) {?>
                                                                                                <option <?php if($vc1['id']==$value['country_id']){ echo 'selected';}?> value="<?php echo $vc1['id'];?>"><?php echo $vc1['name'];?></option> 
                                                                                                <?php
                                                                                            } ?>
                                                                                        </select> 
                                                                                    </td>  
                                                                                    <td>
                                                                                        <select id="myStates<?php echo $key;?>" name="details[<?php echo $key;?>][states]" class="myStates"> 
                                                                                            <option value="">Select States</option>
                                                                                            <?php foreach ($value['states'] as $ks1 => $vs1) {?>
                                                                                                <option <?php if($vs1['id']==$value['state_id']){ echo 'selected';}?> value="<?php echo $vs1['id'];?>"><?php echo $vs1['name'];?></option> 
                                                                                                <?php
                                                                                            } ?> 
                                                                                        </select> 
                                                                                    </td>    
                                                                                    <td>
                                                                                        <select id="myCities<?php echo $key;?>" name="details[<?php echo $key;?>][cities]" class="myCities"> 
                                                                                            <option value="">Select Cities</option>
                                                                                            <?php foreach ($value['cities'] as $ks1 => $vs2) {
                                                                                                ?>
                                                                                                <option <?php if($vs2['id']==$value['city_id']){ echo 'selected';}?> value="<?php echo $vs2['id'];?>"><?php echo $vs2['name'];?></option> 
                                                                                                <?php
                                                                                            } ?>  
                                                                                        </select> 
                                                                                    </td>    
                                                                                    <td>
                                                                                        <select id="myRegion<?php echo $key;?>" name="details[<?php echo $key;?>][region]" class="myRegion"> 
                                                                                            <option value="">Select Region</option>
                                                                                            <?php foreach ($value['region'] as $ks1 => $vs3) {
                                                                                                ?>
                                                                                                <option <?php if($vs3['id']==$value['region_id']){ echo 'selected';}?> value="<?php echo $vs3['id'];?>"><?php echo $vs3['name'];?></option> 
                                                                                                <?php
                                                                                            } ?>  
                                                                                        </select>
                                                                                    </td>    
                                                                                    <td>
                                                                                        <input type="hidden" name="details[<?php echo $key;?>][id]" value="<?php echo $value['id'];?>">
                                                                                        <input type="text" name="details[<?php echo $key;?>][name]" placeholder="Enter Duration" class="form-control name_list" value="<?php echo $value['plan_duration'];?>" />
                                                                                    </td>  
                                                                                    <td><input type="text" name="details[<?php echo $key;?>][price]" placeholder="Enter Price" class="form-control name_list" value="<?php echo $value['plan_price'];?>" /></td>
                                                                                    <td><input type="text" name="details[<?php echo $key;?>][days]" placeholder="Enter Price" class="form-control name_list" value="<?php echo $value['planindays'];?>" /></td>
                                                                                    <?php if($key==0){?>
                                                                                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td> 
                                                                                    <?php }else{ ?>
                                                                                        <td><button type="button" name="remove" id="<?php echo $key;?>" class="btn btn-danger btn_remove">X</button></td> 
                                                                                    <?php } ?> 
                                                                                </tr> 
                                                                            <?php }
                                                                        } ?>  
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
                                $(document).on('change','.myCountries',function(e){
                                    var selectedId=$(this).val();
                                    var parent_id=$(this).parent().parent().attr('id');
                                    parent_id=parent_id.replace("row", "");
                                    $.ajax({
                                        type: 'POST',
                                        url: "<?php echo base_url();?>/home/getStateforplan",
                                        data: {
                                            'con': selectedId
                                        },
                                        success: function(data) {
                                            $("#myStates"+parent_id).html(data);
                                        }
                                    });
                                });
                                $(document).on('change','.myStates',function(e){
                                    var selectedId=$(this).val();
                                    var parent_id=$(this).parent().parent().attr('id');
                                    parent_id=parent_id.replace("row", "");
                                    console.log(parent_id);
                                    $.ajax({
                                        type: 'POST',
                                        url: "<?php echo base_url();?>/home/getcitiesforplan",
                                        data: {
                                            'con': selectedId
                                        },
                                        success: function(data) {
                                            $("#myCities"+parent_id).html(data);
                                        }
                                    });
                                });

                                $(document).on('change','.myCities',function(e){
                                    var selectedId=$(this).val();
                                    var parent_id=$(this).parent().parent().attr('id');
                                    parent_id=parent_id.replace("row", "");
                                    $.ajax({
                                        type: 'POST',
                                        url: "<?php echo base_url();?>/home/getRegionforplan",
                                        data: {
                                            'con': selectedId
                                        },
                                        success: function(data) {
                                            //console.log(data);
                                            $("#myRegion"+parent_id).html(data);
                                        }
                                    });
                                });

                                $('#total_ads_count').text('9');
                                $('.total_ads_countnew').text('9');
                                $('#add').click(function(){  
                                    var i = $('#dynamic_field tr').length-1;
                                    console.log(i);
                                    var html='<tr id="row'+i+'"><td><select name="details['+i+'][countries]" class="myCountries">';  
                                    //$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="details['+i+'][name]" placeholder="Enter your Name" class="form-control name_list" /></td><td><input type="text" name="details['+i+'][price]" placeholder="Enter Price" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
                                    $.ajax({
                                        type: 'POST',
                                        url: "<?php echo base_url();?>/home/getcountry",
                                        data: {
                                            'con': 0
                                        },
                                        success: function(data) {
                                            console.log(data);
                                            html +=data;
                                            html +='</select></td><td><select id="myStates'+i+'" name="details['+i+'][states]" class="myStates"><option value="">Select States</option></select></td><td><select id="myCities'+i+'" name="details['+i+'][cities]" class="myCities"><option value="">Select City</option></select></td><td><select id="myRegion'+i+'" name="details['+i+'][region]" class="myRegion"><option value="">Select Region</option></select></td><td><input type="hidden" name="details['+i+'][id]" value=""><input type="text" name="details['+i+'][name]" placeholder="Enter Duration" class="form-control name_list" value="" /></td><td><input type="text" name="details['+i+'][price]" placeholder="Enter Price" class="form-control name_list" value="" /></td><td><input type="text" name="details['+i+'][days]" placeholder="Enter Price" class="form-control name_list" value="" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>';
                                            $('#dynamic_field').append(html); 
                                            //$("#myRegion"+parent_id).html(data);
                                        }
                                    });
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