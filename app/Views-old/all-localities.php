<?php echo view('header'); 
$user_id = session()->get('id');
$dateArray = array();
foreach ($region as $key => $value) {
    $newDate = date("d-m-Y", strtotime($value['created_date']));
    $dateArray[] = $newDate;
}
$dateArray=array_unique($dateArray);
$d = array('page'=> $module,'date'=>$dateArray,'currentPage'=>$currentpage);
// $d = array('page'=> $module,'currentPage'=>$currentpage);
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
            <?php echo view('admin-bar',$d);?>
                <div class="product-listing1">
                    <div class="row">
                        <div class="container1">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <a href="<?php echo base_url('/admin/addlocality');?>">
                                    <button type="button" class="btn btn-secondary btn-sm btn-block">Add New Locality</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="table-responsive" style="overflow:hidden;">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th scope="col"><input type="checkbox" id="checkAll"></th>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Locality Name</th>
                                            <th scope="col">City</th>
                                            <th scope="col">State</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($region as $key => $value) { 
                                            $newDate = date("d-m-Y", strtotime($value['created_date']));
                                            ?>
                                            <tr class="test" data-date="<?php echo $newDate;?>">
                                            <td><input type="checkbox" value="<?php echo $value['id'];?>" class="checkSingle"></td>
                                            <td scope="row"><?php echo $value['id'];?></td>
                                            <td><?php echo $value['name'];?></td>
                                            <td><?php echo $value['data']['cityname'];?></td>
                                            <td><?php echo $value['data']['statename'];?></td>
                                            <td><?php echo $value['data']['countriesname'];?></td>
                                            <td><a href="<?php echo base_url('/admin/editlocality/'.$value['id']);?>" class="option"><i class="fa fa-pencil"></i></a>
                                            <a href="<?php echo base_url('/admin/deletelocality/'.$value['id']);?>" class="option"><i class="fa fa-trash"></i></a>
                                            </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-end">
                                    <?php if ($pager) :?>
                                    <?php $pagi_path='admin/'.$currentpage; ?>
                                    <?php $pager->setPath($pagi_path); ?>
                                    <?= $pager->links() ?>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#total_ads_count').text('9');
                                $('.total_ads_countnew').text('9');
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
<?php echo view('footer',$extras);?>