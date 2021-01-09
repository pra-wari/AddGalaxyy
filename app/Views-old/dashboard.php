<?php echo view('header'); 
$user_id = session()->get('id');
$dateArray = array();
foreach ($listing as $key => $value) {
    $dateArray[] = $value['date'];
}
$d = array('page'=> $module,'date'=>$dateArray,'currentPage'=> $currentpage);
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
        <?php echo view('user-sidebar');?>
            <div class="col-md-9 col-sm-8" id="product-de">
            <?php echo view('admin-bar',$d);?>
                <div class="product-listing1">
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="" style="overflow:hidden;">
                                <?php foreach ($listing as $key => $value) { 
                                    $newDate = date("d-m-Y", strtotime($value['date']));
                                    ?>
                                    <div class="row freeadd" data-text="<?php echo $value['title'];?>" data-date="<?php echo $newDate;?>">
                                        <div class="col-xs-12 col-md-12">
                                            <div class="" style="margin-bottom:10px">
                                                <div class="rt-container">
                                                    <div class="col-xs-12 col-md-12">
                                                            <div class="product-item-details product-a">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-xs-12 p-mobile">
                                                                        <div class="product-item-name"
                                                                            id="product-mobile-view"
                                                                            style="margin-bottom:0px">
                                                                            <a
                                                                                href="<?php echo base_url('ads/view/'.$value['id'])?>"><b><?php echo $value['title'];?></b></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-xs-12">
                                                                        <p class="description">
                                                                            <a href="<?php echo base_url('admin/editlisting/'.$value['id'])?>"
                                                                                class="option"><i
                                                                                    class="fa fa-pencil"></i></a>
                                                                            <a href="<?php echo base_url('admin/deletelisting/'.$value['id'])?>"
                                                                                class="option"><i
                                                                                    class="fa fa-trash"></i></a>
                                                                            <a href="#" class="option"><i
                                                                                    class="fa fa-eye"></i> <?php echo $value['views'];?></a>
                                                                            <!--<a href="#" class="option">Free Ads:5677</a>-->
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12 col-xs-12">
                                                                        <?php foreach ($value['plans'] as $key1 => $value1) {
                                                                            
                                                                            if($value1['remaining']>0){
                                                                                ?>
                                                                                <div class="col-md-3"><?php echo $value1['plan_name']." (".$value1['remaining'].")";?></div>
                                                                                <?php
                                                                            }else{
                                                                                ?>
                                                                                <div class="col-md-3"><?php echo $value1['plan_name']." (<a class='renewbutton' onclick='openRenewModal(".$value['id'].",".$value1['planmeta'].")' href='#'>Renew</a>)";?></div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <?php if ($pager) :?>
                            <?php $pagi_path='/dashboard'; ?>
                            <?php $pager->setPath($pagi_path); ?>
                            <?= $pager->links() ?>
                            <?php endif ?>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#total_ads_count').text('9');
                                $('.total_ads_countnew').text('9');
                            });
                        </script>
                    </div>
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
<?php echo view('footer',$extras);?>