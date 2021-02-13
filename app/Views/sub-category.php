<?php echo view('header');
//print_r($categories);
echo view('search-bar',$extras);
?>
<div class="search-bar center-xs">
  <div class="container-fluid">
    <div class="bread-crumb center-xs">
      <div class="page-title"><?php echo $mainBreadcrumb[0]['child_cat'];?></div>
        <div class="bread-crumb-inner right-side float-none-xs" style="">
          <ul>
            <li><a href="<?php echo base_url();?>">Home</a><i class="fa fa-angle-right"></i></li>
            <?php foreach ($mainBreadcrumb as $key => $value){ ?>
              <li><a href="<?php echo base_url('/category/view/'.$value['parent_id'])?>"><?php echo $value['parent_cat'];?></a><i class="fa fa-angle-right"></i></li>
              <li><span><?php echo $value['child_cat'];?></span></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
</div>
<section class="ptb-95">
  <div class="container-fluid">
    <div class="product-slider owl-slider">
      <div class="row m-0">
        <div class="product-slider-main position-r">
          <div class="owl-carousel pro_cat_slider" style="opacity: 0;">
            <?php foreach($featured as $k=>$v){ ?>
            <div class="rt-container items <?php if($k==0) echo'slider-container';?>">
              <div class="col-xs-12 col-md-12 p-l-r-0 imgMainWrapper">
                <div class="imgWrapper">
                  <a href="<?php echo base_url('/ads/view/'.$v['id']);?>">
                    <img class="ad-img-s img-responsive pro-image-listview" src="<?php echo base_url($v['images']);?>"
                      alt="">
                  </a>
                </div>
              </div>
              <div class="col-xs-12 col-md-12">
                <a href="<?php echo base_url('/ads/view/'.$v['id']);?>">
                  <div class="product-item-details product-a">
                    <div class="row">
                      <div class="col-md-12 col-xs-12 p-mobile">
                        <div class="product-item-name slider-product-name" id="product-mobile-view"
                          style="margin-bottom:0px">
                          <a href="<?php echo base_url('/ads/view/'.$v['id']);?>"><b><?php echo $v['title'];?></b></a>
                        </div><!-- end title -->
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7">
                      </div>
                      <!--<div class="col-md-5 col-xs-12">
                        <div class="price-box slider-price" id="price-phone">
                          <span class="price"><i class="fa fa-rupee"></i> <?php echo $v['price'];?></span>
                        </div>
                      </div>-->
                    </div>
                    <!--<div class="row">
                      <div class="col-md-12 col-xs-12">

                        <ul class="product-item-details-inner" id="product-inner">
                          <li><i class="fa fa-th-large fa-fw hidden-xs"></i><span class="hidden-xs">
                              <?php foreach ($v['categories'] as $ckey => $cat) {
                                            if($cat['parent_cat']){
                                              ?>
                              <span class="padding_cats hidden-xs"><a
                                  href="<?php echo base_url();?>"><?php echo $cat['parent_cat'];?></a></span> /
                              <?php
                                            }
                                            if($cat['child_cat']){
                                              ?>
                              <span class="padding_cats hidden-xs"><a
                                  href="<?php echo base_url();?>"><?php echo $cat['child_cat'];?></a></span>
                              <?php
                                            }
                                          }?>

                            </span>
                          </li>
                        </ul>
                      </div>
                    </div>-->
                    <div class="row featuredadsspace">
                    <?php if($v['front_attributes']){ 
                        $j=0;
                      ?>
                        <div class="row">
                          <div class="col-md-12">
                            <?php foreach ($v['front_attributes'] as $key1 => $value1) {
                                if($value1['attribute_name']=='Brand' || $value1['attribute_name']=='Action'){
                                  ?>
                                    <div class="col-md-6 col-xs-12 front-attribute c1">
                                      <span><b><?php echo $value1['attribute_name'];?></b> :
                                        <?php echo $value1['option_name'];?></span>
                                    </div>
                                  <?php
                                }}
                                ?>
                          </div>
                        </div>
                    <?php } ?>
                    </div>
                    <!--<div class="row">
                      <div class="col-md-12 col-xs-12">
                        <ul class="product-item-details-inner slider-date" id="product-inner">
                          <li><i class="fa fa-clock-o fa-fw"></i><span><?php echo explode(" ",$v['date'])[0];?></span>
                          </li> 
                        </ul>
                      </div>
                    </div>-->
                  </div>
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
  </div>
</section>
<!--  Featured Products Slider Block End  -->
<section class="pb-95" id="desktop-view">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-sm-4 mb-xs-30">
        <!--  Featured Products Slider Block End  -->
        <?php echo view('sidebar');?>
      </div>
      <div class="col-md-7 col-sm-8" id="product-de">
        <div class="product-listing1">
          <div class="row" id="filterResult1">
            <!--pagination div -->
            <div class="container1">
              <div class="col-md-12">
                <div class="row gallery-ads-mobile">
                <?php 
                  foreach ($sgallery as $ks => $vs) {
                   ?>
                    <div class="col-xs-4">
                      <div class="">
                        <img class="ad-img-s img-responsive pro-image-listview"
                          src="<?php echo base_url($vs['images']);?>">
                      </div>
                      <div class="ads-detail">
                        <span class="adstext-mobile"><?php echo $vs['title'];?></span>
                      </div>
                    </div>
                   <?php
                  }
                  ?>
                </div>
                <div id="listing_div" class="" style="overflow:hidden;">
                  <div class="top-bar">
                    <div class="top-bar-left">
                      <span>Total Ads - </span><span
                        id="total_ads_count"><?php echo count($listing)+count($premiumlisting);?></span>
                    </div>
                    <div class="top-bar-right">
                      
                    </div>
                  </div>
                  <?php foreach($premiumlisting as $k1=>$v1){?>
                  <div class="row freeadd">
                    <div class="col-xs-12 col-md-12">
                      <div class="" style="margin-bottom:10px">
                        <div class="rt-container">
                          <div class="col-xs-4 col-md-4 p-l-r-0 imgMainWrapper">
                            <div class="imgWrapper">
                              <a href="<?php echo base_url('ads/view/'.$v1['id']);?>">
                                <img class="ad-img-s img-responsive pro-image-listview"
                                  src="<?php echo base_url($v1['images']);?>" alt="">
                              </a>
                            </div>
                          </div>
                          <div class="col-xs-8 col-md-8">
                            <?php 
                              if($v1['premium']=='1'){
                                  ?>
                            <!--<div class="badge">
                              <span>Premium</span>
                            </div>-->
                            <div class="wrapper">
                              <div class="badge-premium">
                                  <i class="left"></i>
                                  <i class="right"></i>
                                  PREMIUM
                              </div>
                            </div>
                            <?php
                              }
                              ?>
                            <!--<a href="<?php echo base_url('ads/view/'.$v1['id']);?>">-->
                            <div class="product-item-details product-a">
                              <div class="row">
                                <div class="col-md-12 col-xs-12 p-mobile">
                                  <div class="product-item-name" id="product-mobile-view" style="margin-bottom:0px">
                                    <a
                                      href="<?php echo base_url('ads/view/'.$v1['id']);?>"><b><?php echo $v1['title'];?></b></a>
                                  </div><!-- end title -->
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 col-xs-12">
                                <p class="description-mobile">
                                    <?php 
                                    echo implode(' ', array_slice(explode(' ', $v1['description']), 0, 3))."..\n"; 
                                    //echo $v1['description'];
                                    ?></p>
                                  <p class="description">
                                    <?php 
                                    echo implode(' ', array_slice(explode(' ', $v1['description']), 0, 20))."..\n"; 
                                    //echo $v1['description'];
                                    ?></p><!-- description -->
                                </div>
                              </div>

                              <!--<div class="row">
                                <div class="col-md-7">
                                  <div class="price-box" id="price-phone">
                                    <span class="price"><i class="fa fa-rupee"></i><?php echo $v1['price'];?></span>
                                  </div>
                                  <ul class="product-item-details-inner" id="product-inner">
                                    <li><i class="fa fa-th-large fa-fw hidden-xs"></i><span class="hidden-xs">
                                        <?php foreach ($v1['categories'] as $ckey => $cat) {
                                            if($cat['parent_cat']){
                                              ?>
                                        <span class="padding_cats hidden-xs"><a
                                            href="<?php echo base_url();?>"><?php echo $cat['parent_cat'];?></a></span>
                                        /
                                        <?php
                                            }
                                            if($cat['child_cat']){
                                              ?>
                                        <span class="padding_cats hidden-xs"><a
                                            href="<?php echo base_url();?>"><?php echo $cat['child_cat'];?></a></span>
                                        <?php
                                            }
                                          }?>

                                      </span>
                                    </li> 
                                  </ul>
                                </div>
                                <div class="col-md-5 col-xs-12">
                                 
                                </div>
                              </div>-->
                              <?php if($v1['front_attributes']){ 
                                $j=0;
                                ?>
                            <div class="row">
                              <div class="col-md-12">
                                <?php foreach ($v1['front_attributes'] as $key1 => $value1) {
                                    $j++;
                                    ?>
                                <div class="col-md-4 col-xs-12 front-attribute c<?php echo $j;?>">
                                  <span><b><?php echo $value1['attribute_name'];?></b> :
                                    <?php echo $value1['option_name'];?></span>
                                </div>
                                <?php 
                                    if($j%2==0){
                                      echo '</div><div class="col-md-12 c'.$j.'">';
                                    }
                                    ?>
                                <?php } ?>
                              </div>
                            </div>
                            <?php } ?>
                              <!--<div class="row">
                                <div class="col-md-7">
                                  <ul class="product-item-details-inner" id="product-inner">
                                    <li> <i
                                        class="fa fa-clock-o fa-fw"></i><span><?php //echo explode(" ",$v1['date'])[0];?></span>
                                    </li>
                                  </ul>
                                </div>
                              </div>-->
                            </div>
                            <!--</a>-->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php foreach($listing as $k2=>$v2){
                         ?>
                  <div class="row freeadd">
                    <div class="col-xs-12 col-md-12">
                      <div class="" style="margin-bottom:10px">
                        <div class="rt-container">
                          <div class="col-xs-4 col-md-4 p-l-r-0 imgMainWrapper">
                            <div class="imgWrapper">
                              <a href="<?php echo base_url('ads/view/'.$v2['id']);?>">
                                <img class="ad-img-s img-responsive pro-image-listview"
                                  src="<?php echo base_url($v2['images']);?>" alt="">
                              </a>
                            </div>
                          </div>
                          <div class="col-xs-8 col-md-8">
                            <!--a href="<?php echo base_url('ads/view/'.$v2['id']);?>">-->
                            <div class="product-item-details product-a" style="height:147px;">
                              <div class="row">
                                <div class="col-md-12 col-xs-12 p-mobile">
                                  <div class="product-item-name" id="product-mobile-view" style="margin-bottom:0px">
                                    <a
                                      href="<?php echo base_url('ads/view/'.$v2['id']);?>"><b><?php echo $v2['title'];?></b></a>
                                  </div><!-- end title -->
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12 col-xs-12">
                                <p class="description-mobile">
                                    <?php 
                                    echo implode(' ', array_slice(explode(' ', $v2['description']), 0, 8))."..\n"; 
                                    //echo $v1['description'];
                                    ?></p>
                                  <p class="description">
                                    <?php 
                                      echo implode(' ', array_slice(explode(' ', $v2['description']), 0, 20))."..\n"; 
                                      //echo $v2['description'];
                                    ?></p><!-- description -->
                                </div>
                              </div>
                              <?php if($v2['front_attributes']){ 
                                $i=0;
                                ?>
                              <div class="row">
                                <div class="col-md-12">
                                  <?php foreach ($v2['front_attributes'] as $key1 => $value1) {
                                      $i++;
                                      ?>
                                  <div class="col-md-4 col-xs-12 front-attribute c<?php echo $i;?>">
                                    <span><b><?php echo $value1['attribute_name'];?></b> :
                                      <?php echo $value1['option_name'];?></span>
                                  </div>
                                  <?php 
                                      if($i%2==0){
                                        echo '</div><div class="col-md-12 c'.$i.'">';
                                      }
                                      ?>
                                  <?php } ?>
                                </div>
                              </div>
                              <?php } ?>
                            </div>
                            
                            <!--<div class="row">
                                  <div class="col-md-7">
                                    <ul class="product-item-details-inner" id="product-inner">
                                      <li> <i
                                          class="fa fa-clock-o fa-fw"></i><span><?php echo explode(" ",$v2['date'])[0];?></span>
                                      </li>
                                    </ul>
                                  </div>
                                </div>-->
                          </div>
                          <!--</a>-->
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right side Gallery-->
    <div class="col-md-2 col-sm-3 mb-xs-30" id="right-side-gallery" style="padding-left: 0px;">
      <div class="sidebar-block right-side-color graybox1">
      <?php 
        foreach ($sgallery as $ks => $vs) {
          ?>
              <div class="rt-container singleAds">
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <img class="ad-img-s img-responsive pro-image-listview" src="<?php echo base_url($vs['images']);?>">
                  </div>
                  <div class="col-xs-12 col-md-12 ads-detail">
                    <span class="adstext"><?php echo $vs['title'];?></span>
                  </div>
                </div>
              </div>
              <?php
          }
        ?>
      </div>
    </div>
  </div>
  </div>
</div>
</section>
<style>
  .states1 {
    color: #337ab7 !important;
  }

  .zoomstate {
    font-size: 20px !important;
  }
</style>
<?php echo view('footer',$extras);?>