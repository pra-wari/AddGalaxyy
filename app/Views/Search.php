<?php echo view('header');
//print_r($categories);
//echo view('search-bar');
?>
<section class="ptb-95">
  <div class="container-fluid">
    <div class="product-slider owl-slider">
      <div class="row m-0">
        <div class="product-slider-main position-r">
          <div class="owl-carousel pro_cat_slider" style="opacity: 0;">
            <?php 
                foreach($featured as $k=>$v){
                    ?>
            <div class="rt-container <?php if($k==0) echo'slider-container';?>">
              <div class="col-xs-12 col-md-12 p-l-r-0 imgMainWrapper">
                <div class="imgWrapper">
                  <a href="<?php echo base_url();?>">
                    <img class="ad-img-s img-responsive pro-image-listview" src="<?php echo base_url($v['images']);?>"
                      alt="">
                  </a>
                </div>
              </div>
              <div class="col-xs-12 col-md-12">
                <a href="<?php echo base_url();?>">
                  <div class="product-item-details product-a">
                    <div class="row">
                      <div class="col-md-12 col-xs-12 p-mobile">
                        <div class="product-item-name slider-product-name" id="product-mobile-view"
                          style="margin-bottom:0px">
                          <a href="<?php echo base_url();?>"><b><?php echo $v['title'];?></b></a>
                        </div><!-- end title -->
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7">
                      </div>
                      <div class="col-md-5 col-xs-12">
                        <div class="price-box slider-price" id="price-phone">
                          <span class="price"><i class="fa fa-rupee"></i> <?php echo $v['price'];?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">

                        <ul class="product-item-details-inner" id="product-inner">
                          <li> <i class="fa fa-th-large fa-fw hidden-xs"></i><span class="hidden-xs">
                              <?php if(count($parentCategory)!=0){ ?>
                              <span class="padding_cats hidden-xs"><a
                                  href="<?php echo base_url();?>"><?php echo $parentCategory[0]['name'];?></a></span>
                              /<span class="padding_cats hidden-xs"><a
                                  href="<?php echo base_url();?>"><?php echo $mainCategory[0]['name'];?></a></span>
                              <?php }else{ ?>
                              <span class="padding_cats hidden-xs"><a
                                  href="<?php echo base_url();?>"><?php echo $mainCategory[0]['name'];?> </a></span>
                              <?php } ?>
                            </span> </li>
                        </ul>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                        <ul class="product-item-details-inner slider-date" id="product-inner">
                          <li> <i class="fa fa-clock-o fa-fw"></i><span><?php echo explode(" ",$v['date'])[0];?></span>
                          </li> <!-- city name -->
                        </ul>
                      </div>
                    </div>
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
      <div class="col-md-6 col-sm-8" id="product-de">
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
                <div class="listing_div" style="overflow:hidden;">
                  <div class="top-bar">
                    <div class="top-bar-left">
                      <span>Total Ads - </span><span id="total_ads_count"><?php echo count($listing);?></span>
                    </div>
                    <div class="top-bar-right">
                      
                    </div>
                  </div>
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
                            <?php 
                              if($v2['premium']=='1'){
                                  ?>
                            <div class="badge">
                              <span>Premium</span>
                            </div>
                            <?php
                              }
                              ?>
                            <a href="<?php echo base_url('ads/view/'.$v2['id']);?>">
                              <div class="product-item-details product-a">
                                <div class="row">
                                  <div class="col-md-12 col-xs-12 p-mobile">
                                    <div class="product-item-name" id="product-mobile-view" style="margin-bottom:0px">
                                      <a href="<?php echo base_url('ads/view/'.$v2['id']);?>"><b><?php echo $v2['title'];?></b></a>
                                    </div><!-- end title -->
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12 col-xs-12">
                                    <p class="description"><?php echo $v2['description'];?></p><!-- description -->
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-7">
                                    <div class="price-box" id="price-phone">
                                      <span class="price"><i class="fa fa-rupee"></i><?php echo $v2['price'];?></span>
                                    </div>
                                    <ul class="product-item-details-inner" id="product-inner">
                                      <li> <i class="fa fa-th-large fa-fw hidden-xs"></i><span class="hidden-xs">
                                          <?php if(count($parentCategory)!=0){ ?>
                                          <span class="padding_cats hidden-xs"><a
                                              href="<?php echo base_url();?>"><?php echo $parentCategory[0]['name'];?></a></span>
                                          /<span class="padding_cats hidden-xs"><a
                                              href="<?php echo base_url();?>"><?php echo $mainCategory[0]['name'];?></a></span>
                                          <?php }else{ ?>
                                          <span class="padding_cats hidden-xs"><a
                                              href="<?php echo base_url();?>"><?php echo $mainCategory[0]['name'];?>
                                            </a></span>
                                          <?php } ?> </span> </li> <!-- cat- title-->
                                    </ul>
                                  </div>
                                  <div class="col-md-5 col-xs-12">
                                    <!-- price end -->
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-7">
                                    <ul class="product-item-details-inner" id="product-inner">
                                      <li> <i
                                          class="fa fa-clock-o fa-fw"></i><span><?php echo explode(" ",$v2['date'])[0];?></span>
                                      </li> <!-- city name -->
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                     }   
                     ?>


                </div>
              </div>
            </div>
            <script>
              $(document).ready(function () {
                //$('#total_ads_count').text('9'); 
                //$('.total_ads_countnew').text('9');
              });


              //                 $(document).ready(function(){
              //                     if('9'>=100)
              //                 {
              //                   $('#total_ads_count').text('99+');  
              //                 }
              //                 else
              // {
              //                   $('#total_ads_count').text('9');  
              // }
              //                 });
            </script>
          </div>

          <div class="col-md-6 col-sm-8" id="textImage" style="display:none">
            <div class="container">
              <div class="row">
                <div class="">
                  <table class="table">
                    <thead>
                      <tr>
                        <th><span id="ad_with_img_count">0 </span><span> Results for your search</span></th>
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
                        <th><span id="ad_without_img_count">0 </span><span> Results for your search</span></th>
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
          <div class="rt-container singleAds">
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <img class="ad-img-s img-responsive pro-image-listview"
                  src="<?php echo base_url('public/images/default-image.png');?>">
              </div>
              <div class="col-xs-12 col-md-12 ads-detail">
                <span class="adstext">Testing Gallery Ads</span>
              </div>
            </div>
          </div>
          <div class="rt-container singleAds">
            <div class="row singleAds">
              <div class="col-xs-12 col-md-12">
                <img class="ad-img-s img-responsive pro-image-listview"
                  src="<?php echo base_url('public/images/default-image.png');?>">
              </div>
              <div class="col-xs-12 col-md-12 ads-detail">
                <span class="adstext">Testing Gallery Ads</span>
              </div>
            </div>
          </div>
          <div class="rt-container singleAds">
            <div class="row singleAds">
              <div class="col-xs-12 col-md-12">
                <img class="ad-img-s img-responsive pro-image-listview"
                  src="<?php echo base_url('public/images/default-image.png');?>">
              </div>
              <div class="col-xs-12 col-md-12 ads-detail">
                <span class="adstext">Testing Gallery Ads</span>
              </div>
            </div>
          </div>
          <div class="rt-container singleAds">
            <div class="row singleAds">
              <div class="col-xs-12 col-md-12">
                <img class="ad-img-s img-responsive pro-image-listview"
                  src="<?php echo base_url('public/images/default-image.png');?>">
              </div>
              <div class="col-xs-12 col-md-12 ads-detail">
                <span class="adstext">Testing Gallery Ads</span>
              </div>
            </div>
          </div>
          <div class="rt-container singleAds">
            <div class="row singleAds">
              <div class="col-xs-12 col-md-12">
                <img class="ad-img-s img-responsive pro-image-listview"
                  src="<?php echo base_url('public/images/default-image.png');?>">
              </div>
              <div class="col-xs-12 col-md-12 ads-detail">
                <span class="adstext">Testing Gallery Ads</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Right side gallery end -->


  </div>

</section>
<!--<iframe src="./assets/portal-v2.html" id="st_gdpr_iframe" title="GDPR Consent Management" style="width: 0px; height: 0px; position: absolute; left: -5000px;"></iframe>-->

<style>
  .states1 {
    color: #337ab7 !important;
  }

  .zoomstate {
    font-size: 20px !important;
  }
</style>
<?php echo view('footer',$extras);?>