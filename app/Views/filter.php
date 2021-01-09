<?php //echo count($listing);
// print_r($premiumlisting[0]);
if(isset($premiumlisting[0])){
   $count = count($premiumlisting);;
}else{
   // print_r($premiumlisting[0]);
   $count=0;
}

?>

                  <div class="top-bar">
                    <div class="top-bar-left">
                      <span>Total Ads - </span><span id="total_ads_count"><?php echo count($listing)+$count?></span>
                    </div>
                    <div class="top-bar-right">
                      
                    </div>
                  </div>
                  <?php if($count){foreach($premiumlisting as $k1=>$v1){?>
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
                            <div class="badge">
                              <span>Premium</span>
                            </div>
                            <?php
                              }
                              ?>
                            <!--<a href="<?php echo base_url('ads/view/'.$v1['id']);?>">-->
                              <div class="product-item-details product-a">
                                <div class="row">
                                  <div class="col-md-12 col-xs-12 p-mobile">
                                    <div class="product-item-name" id="product-mobile-view" style="margin-bottom:0px">
                                      <a href="<?php echo base_url('ads/view/'.$v1['id']);?>"><b><?php echo $v1['title'];?></b></a>
                                    </div><!-- end title -->
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12 col-xs-12">
                                    <p class="description">
                                    <?php 
                                    echo implode(' ', array_slice(explode(' ', $v1['description']), 0, 5))."..\n"; 
                                    //echo $v1['description'];
                                    ?></p><!-- description -->
                                  </div>
                                </div>

                                <div class="row">
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
                                      </li> <!-- cat- title-->
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
                                          class="fa fa-clock-o fa-fw"></i><span><?php echo explode(" ",$v1['date'])[0];?></span>
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
                  <?php } } ?>
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
                                      echo implode(' ', array_slice(explode(' ', $v2['description']), 0, 5))."..\n"; 
                                      //echo $v2['description'];
                                    ?></p><!-- description -->
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-7">
                                    <div class="price-box" id="price-phone">
                                      <span class="price"><i class="fa fa-rupee"></i><?php echo $v2['price'];?></span>
                                    </div>
                                    <ul class="product-item-details-inner" id="product-inner">
                                    <li><i class="fa fa-th-large fa-fw hidden-xs"></i><span class="hidden-xs">
                                      <?php foreach ($v2['categories'] as $ckey => $cat) {
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
                                      </li> <!-- cat- title-->
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
                            <!--</a>-->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                     }   
                     ?>


                </div>