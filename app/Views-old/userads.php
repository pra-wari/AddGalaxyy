<?php echo view('header');
echo view('search-bar',$extras);
?>
<section class="ptb-95">
  <div class="container-fluid">
    <div class="product-slider owl-slider">

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
                    <div class="col-xs-3">
                      <div class="col-xs-12">
                        <img class="ad-img-s img-responsive pro-image-listview"
                          src="<?php echo base_url($vs['images']);?>">
                      </div>
                      <div class="col-xs-12 col-md-12 ads-detail">
                        <span class="adstext-mobile"><?php echo $vs['title'];?></span>
                      </div>
                    </div>
                   <?php
                  }
                  ?>
                </div>
                <div id="listing_div" style="overflow:hidden;">
                  <div class="top-bar">
                    <div class="top-bar-left">
                      <span>Total Ads - </span><span id="total_ads_count"><?php echo $totalads;?></span>
                    </div>
                    <div class="top-bar-right">
                      
                    </div>
                  </div>
                  
                  <?php foreach($listing as $k2=>$v2){?>
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
                            <!--<a href="<?php echo base_url('ads/view/'.$v2['id']);?>">-->
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
                                    <p class="description">
                                    <?php 
                                      //echo $v2['description'];
                                      echo implode(' ', array_slice(explode(' ', $v2['description']), 0, 5))."\n";
                                    ?></p><!-- description -->
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-7">
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
                            <!--</a>-->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                     }   
                     ?>
                  <div class="d-flex justify-content-end">
                      <?php if ($pager) :?>
                      <?php $pagi_path='admin/adsbyuser/'.$userid; ?>
                      <?php $pager->setPath($pagi_path); ?>
                      <?= $pager->links() ?>
                      <?php endif ?>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
