<?php echo view('header');
echo view('search-bar',$extras);
?>
<section class="custom-padding categories ptb-95">
    <div class="container current<?php echo $currentpage;?>">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="row">
                <?php foreach ($categories as $key => $value) {
                    ?>
                        <div class="col-md-3 col-sm-6 <?php //if($key==0){echo 'mobile-spacing';}?>" style="margin-bottom:30px;">
                            <div class="category-list" style="float:left;width:275px;overflow-y: auto;overflow-x: hidden; height:250px;margin-bottom:10px">
                                <span class="opener minus"></span>
                                <a></a><div class="category-list-icon" style="height:55px"><a>
                                        <i style="padding:2px 10px 2px 10px;"><img src="<?php echo base_url($value['icon_path']); ?>"></i>
                                        </a><div class="category-list-title"><a>
                                            </a><h5><a></a><a style="padding:0px" href="<?php echo base_url('/category/view/'.$value['id']);?>"><?php echo $value['name'];?> ( <?php echo $value['count']; ?> )</a>
                                            </h5>
                                        </div>
                                    </div>
                                <div class="category-block-contant" style="display:block">
                                <?php if(count($value['subCategory'])>0){?>
                                    <ul class="category-list-data" style="display:inline-block;">
                                    <?php foreach ($value['subCategory'] as $k => $v) {
                                        if(isset($v['id'])){
                                        ?>
                                        <li><a id="subcat_link" href="<?php echo base_url('/subcategory/view/'.$v['id']);?>"><?php echo $v['name'];?><span class="subcat_counter" style="width:25px"><?php echo $v['count']; ?></span></a></li>
                                        <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                <?php } ?>
                                    <div class="clearfix"></div>
                                    <!-- <div class="traingle"></div> -->
                                </div>
                            </div>
                            <div class="post-tag-section clearfix">
                                <a href="<?php echo base_url('/category/view/'.$value['id']);?>">
                                    <div class="cat-all">View All</div>
                                </a>
                            </div>
                        </div>
                    <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo view('footer',$extras);?>