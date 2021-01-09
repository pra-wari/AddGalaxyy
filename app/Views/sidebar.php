<div class="sidebar-block gray-box mobile-spacing">
    <div class="sidebar-box listing-box cat1 mb-40">
        <span class="opener plus"></span>
        <div class="main_title sidebar-title">
            <h3><span>Categories:</span></h3>
        </div>
        <div class="sidebar-contant">
            <!-- subcategory list start -->
            <div class="panel-group" id="accordion">
                <?php 
                foreach($categories as $k9=>$v9){ 
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading <?php if($mainCategory[0]['name']==$v9['name']){ echo 'selected'; }?>">
                        <h4 class="panel-title icon">
                            <a class="cat_icon" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $v9['id'];?>">
                                <i class="fa fa-caret-right"></i></a>
                        </h4>
                        <h4 class="panel-title alink" data-url="<?php echo base_url('/category/view/'.$v9['id']);?>">
                                <a class="cat_list" href="<?php echo base_url('/category/view/'.$v9['id']);?>">
                                    <span style="<?php if($v9['current']==true){ echo 'color: #fd8539;';}?>padding-left:10px;"><?php echo $v9['name'];?><span>(
                                            <?php echo $v9['count'];?> )</span></span></a>
                        </h4>
                    </div>
                    <div id="<?php echo $v9['id'];?>"
                        class="panel-collapse collapse <?php if($v9['current']==true){ echo 'in';}?>">
                        <div class="panel-body">
                            <ul>
                                <?php foreach($v9['subCategory'] as $k10=>$v10){ 
                            if($v10['current']==true){
                        ?>
                                <li><span class="icon12"><i class="fa fa-angle-double-right"></i></span> <a
                                        class="cat_list current" href="<?php echo base_url('/subcategory/view/'.$v10['id']);?>"><span
                                            style="color:#fd8539;padding-left:10px;"><?php echo $v10['name'];?> <span>
                                                <?php echo $v10['count'];?> </span></span></a></li>
                                <?php
                        }else{
                        ?>
                                <li><span class="icon12"><i class="fa fa-angle-double-right"></i></span> <a
                                        class="cat-inac"
                                        href="<?php echo base_url('/subcategory/view/'.$v10['id']);?>"><?php echo $v10['name'];?><span><?php echo $v10['count'];?></span></a>
                                </li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- subcategory list end -->
        </div>
    </div>
</div>
<?php if(count($attributes)>0){ ?>  
<div class="sidebar-block gray-box">
    <div class="sidebar-box filter-sidebar mb-40">
        <span class="opener plus"></span>
        <div class="main_title sidebar-title">
            <h3>Refine Search</h3>
        </div>
        <div class="sidebar-contant">
            <form name="refine_search" id="refine_search" action="<?php echo base_url();?>" method="post">
            <?php 
            if(!$hideSlider){
                ?>
                 <input class="price-txt" name="price" type="hidden" id="amount" readonly="" value="₹0 - ₹10000">
                    <input name="mainCategoryId" type="hidden" id="mainCategoryId"
                        value="<?php echo $mainCategory[0]['id'];?>">
                    <input name="sub_category_cat_id" type="hidden" id="sub_cat_id" value="<?php echo $mainCategory[0]['id'];?>">
                    <input name="parent_id" type="hidden" id="parent_id" value="<?php echo $mainCategory[0]['parent_id'];?>">
                    <input type="hidden" value="0" name="fromRupees" class="fromRupees" min="0" max="10000">
                    <input type="hidden" value="10000" name="toRupees" class="toRupees" min="0" max="10000">
                    <input type="hidden" value="" name="attributesArray" id="attributesArray" class="attributesArray">
                            
                    <div class="price-slider">
                        <div class="row"><span>from
                                <input type="number" value="0" min="0" max="10000"> to
                                <input type="number" value="10000" min="0" max="10000"></span></div>

                        <input value="0" min="0" max="10000" step="50" type="range" onchange="return refineSearch();">
                        <input value="10000" min="0" max="10000" step="50" type="range" onchange="return refineSearch();">
                        <svg width="100%" height="24">
                            <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12" stroke-dasharray="1 28">
                            </line>
                        </svg>
                    </div>
                <?php
            }
            ?>
                        
                <?php
                $txtname = '';
                $txtname1 = '';
                foreach ($attributes as $key => $value) {
                    $txtname1 = str_replace(" ", "_", strtolower($value['attribute_name']));
                    if($value['type']=='dropdown'){
                ?>

                <div class="filter-inner-box mb-20">
                    <div class="inner-title"><?php echo $value['attribute_name'];?></div>
                    <select name="<?php echo $txtname1;?>" class="form-control" id="<?php echo $txtname1;?>"
                        onchange="return refineSearch();">
                        <option value="">Select <?php echo $value['attribute_name'];?></option>
                        <?php 
                                    foreach($value['option'] as $a9=>$at9){
                            $i=0;
                                        // print_r($at9);
                        ?>
                        <option value="<?php echo $at9['id'];?>"><?php echo $at9['option_name'];?></option>
                        <?php 
                        $i++;
                        } 
                        ?>
                    </select>
                </div>
                <?php
                }else if($value['type']=='listing'){
                ?>
                <div class="filter-inner-box mb-20">
                    <div class="inner-title"><?php echo $value['attribute_name'];?></div>
                    <div class="listing">
                        <?php 
                    foreach($value['option'] as $a9=>$at9){
                    ?>
                        <input type="checkbox" name="<?php echo $txtname1;?>[]" id="<?php echo $txtname1;?>"
                            value="<?php echo $at9['id'];?>" onchange="return refineSearch();">
                        <?php echo $at9['option_name'];?><br />
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <?php    
                        }else if($value['type']=='radio'){
                        ?>
                <div class="filter-inner-box mb-20">
                    <div class="inner-title"><?php echo $value['attribute_name'];?></div>
                    <?php 
                                    foreach($value['option'] as $a9=>$at9){
                            $i=0;
                                ?>
                    <label><input type="radio" name="<?php echo $txtname1;?>[]" id="<?php echo $txtname1;?>"
                            value="<?php echo $at9['id'];?>" onchange="return refineSearch();">&nbsp;&nbsp;
                        <?php echo $at9['option_name'];?></label>
                    <?php $i++;
                            } ?>
                </div>



                <?php
                            }else if($value['type']=='checkbox'){

                            ?>
                <div class="filter-inner-box mb-20">
                    <div class="inner-title"><?php echo $value['attribute_name'];?></div>
                    <?php 
                                    foreach($value['option'] as $a9=>$at9){
                            $i=0;
                        ?>
                    <label><input type="checkbox" name="<?php echo $txtname1;?>[]" id="<?php echo $txtname1;?>"
                            value="<?php echo $at9['id'];?>" onchange="return refineSearch();">&nbsp;&nbsp;
                        <?php echo $at9['option_name'];?></label>
                    <?php $i++;
                        } ?>
                </div>
                <?php
                    }
                    $txtname.= $txtname1.",";
                    }
                    $txtname = rtrim($txtname, ',');
                    if(count($attributes)>0){
                    ?>
                    <div class="filter-inner-box mb-20">
                        <div class="inner-title">Images</div>
                        <label><input type="checkbox" name="images[]" id="<?php echo $txtname1;?>"
                                value="1" onchange="return refineSearch();">&nbsp;&nbsp;
                            With Images</label>
                        <label><input type="checkbox" name="images[]" id="<?php echo $txtname1;?>"
                            value="0" onchange="return refineSearch();">&nbsp;&nbsp;
                        Without Images</label>
                    </div>
                    <?php } ?>
                <input type="hidden" name="allattname" value="<?php echo $txtname; ?>">
            </form>
        </div>
    </div>
</div>
<?php } ?>
<script>
    function refineSearch() {
        var myform = document.getElementById("refine_search");
        var fd = new FormData(myform);
        $.ajax({
            url: "<?php echo base_url();?>/Subcategory/filter/",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (dataofconfirm) {
                // console.log(dataofconfirm);
                $('#listing_div').html(dataofconfirm);
                return false;
            }
        });

        return false;

    }
    $(document).ready(function(){
        console.log($('a.current').parent().parent().parent().parent().parent().addClass('active'));
        setTimeout(function(){ 
            $('.active .panel-collapse').addClass('in');
        }, 500);
    });

    jQuery(document).ready(function(){
        jQuery('.alink').click(function(){
            console.log('click',$(this).attr('data-url'));
            var url = $(this).attr('data-url');
            if(url){
                window.location = url;
            }
        });
    });
</script>
