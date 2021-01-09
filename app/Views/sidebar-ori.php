<div class="sidebar-block gray-box">
    <div class="sidebar-box listing-box cat1 mb-40">
        <span class="opener plus"></span>
        <div class="main_title sidebar-title">
            <h3><span>Categories:</span></h3>
        </div>
        <div class="sidebar-contant">
            <!-- subcategory list start -->
            <div class="panel-group" id="accordion">
                <?php foreach($categories as $k9=>$v9){
            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#2">
                                <i class="fa fa-caret-right"></i>
                                <a class="cat_list" href="<?php echo base_url('/category/view/'.$v9['id']);?>">
                                    <span
                                        style="<?php if($v9['current']==true){ echo 'color: #fd8539;';}?>padding-left:10px;"><?php echo $v9['name'];?><span>(
                                            <?php echo $v9['count'];?> )</span></span></a>
                            </a>
                        </h4>
                    </div>
                    <div id="2" class="panel-collapse collapse <?php if($v9['current']==true){ echo 'in';}?>">
                        <div class="panel-body">
                            <ul>
                                <?php foreach($v9['subCategory'] as $k10=>$v10){ 
                        if($v10['current']==true){
                            ?>
                                <li><span class="icon12"><i class="fa fa-angle-double-right"></i></span> <a
                                        class="cat_list" href="../homes/5.html"><span
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
<div class="sidebar-block gray-box">
    <div class="sidebar-box filter-sidebar mb-40">
        <span class="opener plus"></span>
        <div class="main_title sidebar-title">
            <h3>Refine Search</h3>
        </div>
        <div class="sidebar-contant">
            <form action="<?php echo base_url();?>" method="post">
                <input class="price-txt" name="price" type="hidden" id="amount" readonly="" value="₹0 - ₹10000">

                <input name="catgory_id" type="hidden" id="cat_id" value="9">
                <input name="sub_category_cat_id" type="hidden" id="sub_cat_id" value="37">
                <input type="hidden" value="0" name="fromRupees" class="fromRupees" min="0" max="50000000">
                <input type="hidden" value="50000000" name="toRupees" class="toRupees" min="0" max="50000000">

                <div class="price-slider">
                    <div class="row"><span>from
                            <input type="number" value="0" min="0" max="50000000"> to
                            <input type="number" value="50000000" min="0" max="50000000"></span></div>
                    <input value="0" min="0" max="50000000" step="500" type="range">
                    <input value="50000000" min="0" max="50000000" step="500" type="range">
                    <svg width="100%" height="24">
                        <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12" stroke-dasharray="1 28">
                        </line>
                    </svg>
                </div>

                <div class="filter-inner-box mb-20">
                    <div class="inner-title">Property Type</div>
                    <select name="property_type" class="form-control" id="property">
                        <option value="">Select Property Type </option>
                        <option value="house">House</option>
                        <option value="multistory apartment">Multistory Apartment</option>
                        <option value="builder floor">Builder Floor</option>
                        <option value="plot">Plot</option>
                        <option value="villa">villa</option>
                        <option value="penta house">Penta House</option>
                        <option value="studio apartment">Studio Apartment</option>
                        <option value="commercial office space">Commercial Office Space</option>
                        <option value="IT park office">IT Park Office</option>
                        <option value="commercial shop">Commercial Shop</option>
                        <option value="commercial showroom">Commercial Showroom</option>
                        <option value="commercial land">Commercial Land</option>
                        <option value="industrial building">Istrial Building</option>
                        <option value="industrial shed">Industrial Shed</option>
                        <option value="agricultural land">Agricultural Land</option>
                        <option value="farm house">Farm house</option>
                    </select>
                </div>
                <div class="filter-inner-box mb-20">
                    <div class="inner-title">Property for</div>
                    <label><input type="checkbox" name="property_for[]" value="'sell'">&nbsp; &nbsp; Sell</label>
                    <label><input type="checkbox" name="property_for[]" value="'rent'">&nbsp; &nbsp; Rent</label>
                    <label><input type="checkbox" name="property_for[]" value="'pg'">&nbsp; &nbsp; PG</label>
                </div>
                <div class="filter-inner-box mb-20">
                    <div class="inner-title">Posted By</div>
                    <label><input type="checkbox" name="rs_posted_by[]" value="'owner'">&nbsp;&nbsp; Owner</label>
                    <label><input type="checkbox" name="rs_posted_by[]" value="'broker'">&nbsp;&nbsp; Broker</label>
                    <label><input type="checkbox" name="rs_posted_by[]" value="'builder'">&nbsp;&nbsp; Builder</label>

                </div>
                <div class="filter-inner-box mb-20" id="bedroom" style="display:none;">
                    <div class="inner-title">BHK</div>
                    <label><input type="checkbox" name="bhk[]" value="1">&nbsp;&nbsp; 1</label>
                    <label><input type="checkbox" name="bhk[]" value="2">&nbsp;&nbsp; 2</label>
                    <label><input type="checkbox" name="bhk[]" value="3">&nbsp;&nbsp; 3</label>
                    <label><input type="checkbox" name="bhk[]" value="4">&nbsp;&nbsp; 4</label>
                    <label><input type="checkbox" name="bhk[]" value="5">&nbsp;&nbsp; 5</label>
                </div>
                <div class="filter-inner-box mb-20" id="kitchen" style="display:none;">
                    <div class="inner-title">Kitchen</div>
                    <label><input type="checkbox" name="kitchen[]" value="1">&nbsp;&nbsp; 1</label>
                    <label><input type="checkbox" name="kitchen[]" value="2">&nbsp;&nbsp; 2</label>
                    <label><input type="checkbox" name="kitchen[]" value="3">&nbsp;&nbsp; 3</label>
                    <label><input type="checkbox" name="kitchen[]" value="4">&nbsp;&nbsp; 4</label>
                    <label><input type="checkbox" name="kitchen[]" value="5">&nbsp;&nbsp; 5</label>
                </div>
                <div class="filter-inner-box mb-20" id="furnished" style="display:none;">
                    <div class="inner-title">Furnished</div>
                    <label><input type="checkbox" name="furnished[]" value="'yes'">&nbsp;&nbsp; Full</label>
                    <label><input type="checkbox" name="furnished[]" value="'semi'">&nbsp;&nbsp; Semi</label>
                    <label><input type="checkbox" name="furnished[]" value="'no'">&nbsp;&nbsp; No</label>

                </div>
                <div class="filter-inner-box mb-20">
                    <div class="inner-title">Images</div>
                    <input type="hidden" name="image" value="3">
                    <label><input type="checkbox" name="image" value="1" class="image_check">&nbsp;&nbsp; With
                        Image</label><br>
                    <label style="width: 120px"><input type="checkbox" name="image" value="0"
                            class="image_check">&nbsp;&nbsp; Without Image</label><br>
                    <label><input type="checkbox" name="image" value="2" class="image_check">&nbsp;&nbsp; Both</label>

                </div>
                <script>
                    $(".image_check").change(function () {
                        $(".image_check").prop('checked', false);
                        $(this).prop('checked', true);
                    });
                    $(".screen_size").change(function () {
                        $(".screen_size").prop('checked', false);
                        $(this).prop('checked', true);
                    });
                </script>
            </form>
        </div>
    </div>
</div>