<?php echo view('header');
$url='';
$date=date_create($listing[0]['date']);
if($categories1[0]['parent_id']=='0'){
    $url= 'category/view/'.$categories1[0]['id'];
}else{
    $url= 'subcategory/view/'.$categories1[0]['id']; 
}
?>
<div class="search-bar center-xs">
    <div class="container">
        <div class="bread-crumb center-xs">
            <div class="page-title"><?php echo $categories1[0]['name'];?></div>
            <div class="bread-crumb-inner right-side float-none-xs">
                <ul>
                    <li><a href="<?php echo base_url();?>">Home</a><i class="fa fa-angle-right"></i></li>
                    <?php foreach ($mainBreadcrumbs as $key => $value) { ?>
                        <li><a href="<?php echo base_url('/category/view/'.$value['parent_id'])?>"><?php echo $value['parent_cat'];?></a><i class="fa fa-angle-right"></i></li>
                        <li><span><?php echo $value['child_cat'];?></span></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function(){
    $('.bxslider').bxSlider({
        auto: true,
        autoControls: true,
        stopAutoOnClick: true,
        pager: true,
        //slideWidth: 600
    });
});
</script>
<!-- Bread Crumb END -->
<!-- CONTAIN START -->
<section class="ptb-95">
    <div class="container">
        <div class="add-detail">
            <div class="row">
                <div class="col-sm-8 pb-xs-60">
                    <div class="post-info"> 
                        <ul>
                            <li>
                                <div class="avtar"><img src="http://addgalaxy.com/assests/home/images/profile-icon.png" alt=""></div>
                                <span>By</span><a href="#"> <?php echo $user[0]->firstname;?></a>
                            </li>
                            <li>
                                <span>Posted<a href="javascript:void(0);"> <?php echo date_format($date,"d-M-Y");?></a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="sharethis-inline-share-buttons"></div>
                    <h3><?php echo $listing[0]['title'];?></h3>
                    <div><?php if(($listing[0]['id']-1)>0){ ?>
                        <a class="btn btn-primary" href="<?php echo base_url('ads/view/'.($listing[0]['id']-1));?>">Previous</a><?php } ?>
                        <a class="btn btn-default" href="<?php echo base_url('ads/view/'.($listing[0]['id']+1));?>">Next</a></div>
                    </div>
            </div>
            <hr>
            <div class="modern-version-block-tabs">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="hidden-xs hidden-sm">
                            <ul>
                                <li><a href="#description" class="page-scroll"><i class="fa fa-file-text"></i>
                                        Description</a></li>
                                <!--li><a href="#video" class="page-scroll"><i class="fa fa-video-camera"></i> Video</a></li-->
                                <li><a href="#location" class="page-scroll"><i class="fa fa-location-arrow"></i>
                                        Location Map</a></li>
                                <li><a href="#report_form" class="page-scroll"><i class="fa fa-file-text"></i>
                                        Report</a></li>
                            </ul>
                        </div>
                    </div>



                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 pb-xs-60">
            <div class="row">
            <?php if(count($listing[0]['images'])>0){?>
            <div class="bxslider">
                <?php foreach ($listing[0]['images'] as $k1 => $v1) { ?>
                    <div><img src="<?php echo base_url($v1['image_path']);?>"></div>
                <?php } ?>
            </div>
            <?php } ?>
            </div>          

                <div class="row">
                    <div class="col-xs-12 mb-60">
                        <div class="fotorama" data-nav="thumbs" data-allowfullscreen="native">
                            <a href="#"><img src="http://addgalaxy.com/assests/home/images/vap_47462068.jpg"
                                    alt="Everypick"></a>
                            <a href="#"><img src="http://addgalaxy.com/assests/home/images/" alt="Everypick"></a>
                        </div>

                        <div class="add-detail" id="description">
                            <div class="short-features">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-xs-12">
                                        <span><strong>Ad ID</strong> :</span><?php echo $listing[0]['id'];?>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-xs-12 no-padding">
                                        <span><strong>Date</strong> :</span><?php echo date_format($date,"d-M-Y");?></div>
                                    <div class="col-sm-3 col-md-3 col-xs-12 no-padding">
                                        <span><strong>Country</strong> :</span>India</div>
                                        <div class="col-sm-3 col-md-3 col-xs-12 no-padding">
                                        <span><strong>Price</strong> :</span>Rs. <?php echo $listing[0]['price'];?></div>
                                </div>
                                <div class="row">
                                <?php 
                                $i=0;
                                foreach ($listing[0]['attributes'] as $k1 => $v1) {
                                $i++;
                                ?>
                                    <div class="col-sm-3 col-md-3 col-xs-12 <?php if($i>1){ echo 'no-padding';}?>">
                                        <span><strong><?php echo $v1['attribute_name'];?></strong> :</span><?php echo $v1['option_name'];?>
                                    </div>
                                    <?php
                                    if($i%4==0){
                                        echo '</div><div class="row">';
                                    }
                                        }?>
                                </div>
                            </div>
                            <p><?php echo $listing[0]['description'];?></p>
                            <hr>
                            <div class="row">
                            <div class="col-sm-8 pb-xs-60">

                            </div>
                            <?php ?>
                            </div>
                            <div id="location">
                                <h3>Location</h3>
                                <?php
                                $str='';
                                if(isset($listing[0]['location'][0]['region'])){
                                    $str .= $listing[0]['location'][0]['region'];
                                }
                                if(isset($listing[0]['location'][0]['city'])){
                                    $str .= $listing[0]['location'][0]['city'];
                                }
                                if(isset($listing[0]['location'][0]['state'])){
                                    $str .= $listing[0]['location'][0]['state'];
                                }
                                if(isset($listing[0]['location'][0]['country'])){
                                    $str .= $listing[0]['location'][0]['country'];
                                }
                                
                                ?>
                                <iframe src="https://www.google.com/maps?q=<?php echo $str;?>&output=embed"
                                    width="100%" height="450" frameborder="0" style="border:0"></iframe>
                            </div>
                            <div id="report_form" style="margin-top:20px;display:none">
                                <h3>Report</h3>
                                <form action="http://addgalaxy.com/home/report" method="post">
                                    <input type="hidden" name="ad_id" value="277">
                                    <input type="hidden" name="cat_id" value="6">
                                    <div>
                                        <label for="email">Email</label><input type="email" id="email" name="email"
                                            placeholder="Enter email id" class="form-control">
                                    </div>
                                    <div>
                                        <label for="report">Why do you want to report this ad?</label>
                                        <textarea id="report" name="report" placeholder="Enter your report here..."
                                            class="form-control"></textarea>
                                    </div>
                                    <input type="submit" value="submit" name="submit" class="btn btn-danger">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- update on 26-4-->
            <div class="col-sm-4 mb-xs-30">
                <div class="sidebar-block">
                    <div class="country-locations mb-20">
                        <img src="http://addgalaxy.com/assests/home/images/earth-globe.png" alt="">
                        <div id="word-count">
                            <?php if(isset($listing[0]['location'][0]['region'])){?> 
                            <a href="javascript:void(0)"><?php echo $listing[0]['location'][0]['region'];?></a>,
                            <?php } ?>
                            <?php if(isset($listing[0]['location'][0]['city'])){?> 
                            <a href="javascript:void(0)"><?php echo $listing[0]['location'][0]['city'];?></a>,
                            <?php } ?>
                            <?php if(isset($listing[0]['location'][0]['state'])){?> 
                            <a href="javascript:void(0)"><?php echo $listing[0]['location'][0]['state'];?></a>,
                            <?php } ?>
                            <?php if(isset($listing[0]['location'][0]['country'])){?> 
                            <a href="javascript:void(0)"><?php echo $listing[0]['location'][0]['country'];?></a>,
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="sidebar-block gray-box">
                    <div class="sidebar-box listing-box mb-40">
                        <span class="opener plus"></span>
                        <div class="main_title sidebar-title">
                            <h3>Safety tips for deal</h3>
                        </div>
                        <div class="sidebar-contant">
                            <ol>
                                <li>Use a safe location to meet seller</li>
                                <li>Avoid cash transactions</li>
                                <li>Beware of unrealistic offers</li>
                            </ol>
                        </div>
                    </div>
                    <div style="padding: 0px 10px;">
                        <h3>Get Best Quote</h3><br />
                        <form>
                        <input type="hidden" id="ad_id" name="ad_id" value="<?php echo $listing[0]['id'];?>">
                        <input type="hidden" id="sender_id" name="sender_id" value="<?php echo session()->get('id');?>">
                        <input type="hidden" id="owner_id" name="owner_id" value="<?php echo $listing[0]['user_id'];?>">
                        <input type="text" id="sender_name" name="sender_name" class="form-control" required="true"
                            placeholder="Enter Your Name"><br />
                        <input type="email" id="sender_email" name="sender_email" class="form-control email" required="true"
                            placeholder="Enter your email Id"><br />
                        <input type="text" id="sender_mobile" name="sender_mobile" class="form-control" required="true"
                            placeholder="Enter your Mobile number"><br />
                        <textarea id="message" name="message" placeholder="Enter your message" required="true"
                            class="form-control"></textarea><br />
                        <input id="myad_sbmit" type="button" class="btn btn-danger" value="Submit" name="submit"><br />
                        </form>
                        <div id="query-response"></div>
                    </div>
                    <!-- update on 26-4-end-->


                </div>
                <div id="report_form" class="sidebar-block gray-box">
                    <div class="sidebar-box listing-box mb-40">
                        <span class="opener plus"></span>
                        <div class="main_title sidebar-title">
                            <h3>Report Ad</h3>
                        </div>
                        <div class="sidebar-contant">
                            
                        </div>
                    </div>
                    <div style="padding: 0px 10px;">
                        <form>
                        <input type="hidden" id="ad_id" name="ad_id" value="<?php echo $listing[0]['id'];?>">
                        <input type="hidden" id="sender_id" name="sender_id" value="<?php echo session()->get('id');?>">
                        <input type="hidden" id="owner_id" name="owner_id" value="<?php echo $listing[0]['user_id'];?>">
                        <input type="text" id="sender_name-report" name="sender_name" class="form-control" required="true"
                            placeholder="Enter Your Name"><br />
                        <textarea id="message-report" name="message" placeholder="Enter your message" required="true"
                            class="form-control"></textarea><br />
                        <input id="myad_sbmit_report" type="button" class="btn btn-danger" value="Submit" name="submit"><br />
                        </form>
                        <div id="query-response-report"></div>
                    </div>
                    <!-- update on 26-4-end-->


                </div>
                <script>
                    $(document).ready(function(){
                        $('#myad_sbmit').click(function (e) {
                            var data = new FormData();
                            data.append('ad_id', $('#ad_id').val());
                            data.append('sender_id', $('#sender_id').val());
                            data.append('owner_id', $('#owner_id').val());
                            data.append('sender_name', $('#sender_name').val());
                            data.append('sender_email', $('#sender_email').val());
                            data.append('sender_mobile', $('#sender_mobile').val());
                            data.append('message', $('#message').val());
                            $.ajax({
                                url: '<?php echo base_url('/ads/addChat')?>',
                                data: data,
                                processData: false,
                                cache: false,
                                contentType: false,
                                type: 'POST',
                                success: function (data) {
                                    var result = JSON.parse(data);
                                    $('#query-response').html(result.msg);
                                }
                            });
                        });
                        $('#myad_sbmit_report').click(function (e) {
                            var data = new FormData();
                            data.append('ad_id', $('#ad_id').val());
                            data.append('sender_id', $('#sender_id').val());
                            data.append('owner_id', $('#owner_id').val());
                            data.append('sender_name', $('#sender_name-report').val());
                            data.append('message', $('#message-report').val());
                            $.ajax({
                                url: '<?php echo base_url('/ads/addReport')?>',
                                data: data,
                                processData: false,
                                cache: false,
                                contentType: false,
                                type: 'POST',
                                success: function (data) {
                                    var result = JSON.parse(data);
                                    $('#query-response-report').html(result.msg);
                                }
                            });
                        });
                    });
                </script>                    

            </div>
        </div>
    </div>
    </div>

    </div>
</section>
<!-- CONTAINER END -->
<style>
    .states1 {
        color: #337ab7 !important;
    }

    .zoomstate {
        font-size: 20px !important;
    }
</style>
<?php echo view('footer',$extras);?>