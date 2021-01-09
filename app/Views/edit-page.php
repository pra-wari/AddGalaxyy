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
                                            action="<?php echo base_url('/admin/updatepage');?>" role="form"
                                            enctype="multipart/form-data" onsubmit="return checkTitle();">
                                            <div class="messages"></div>
                                            <input type="hidden" name="planid" id="planid" value="<?php echo $page[0]['id'];?>" readonly />
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Page Name: </label>
                                                            <input id="title" type="text" maxlength="65" name="name"
                                                                class="form-control"
                                                                placeholder="Please enter a title *" required="required"
                                                                data-error="Title should be atleast 10 chars long" 
                                                                value="<?php echo $page[0]['page_name'];?>">
                                                            <div class="help-block with-errors" id="titleerrorid"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="controls">
                                                
                                                <?php 
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="form_email">Page By Location: </label>
                                                            <textarea class='editor' name='content'>
                                                                <?php if(isset($page[0]['content'])){ echo $page[0]['content']; } ?> 
                                                            </textarea> 
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
                                tinymce.init({
                                    selector: "textarea",
                                    menubar: false,
                                    plugins: [
                                        "advlist autolink lists link image charmap print preview anchor",
                                        "searchreplace visualblocks code fullscreen",
                                        "insertdatetime media table contextmenu paste"
                                    ],
                                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontselect fontsizeselect",
                                    fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt"
                                });
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