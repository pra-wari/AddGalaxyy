<?php echo view('header'); 
$user_id = session()->get('id');
$dateArray = array();
foreach ($invoice as $key => $value) {
    $newDate = date("d-m-Y", strtotime($value['created_at']));
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
                            <form name="invoice-form" id="invoice-form" method="post"
                                            action="<?php echo base_url('/admin/searchinvoices');?>" role="form"
                                            enctype="multipart/form-data">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="startDate" class="form-control"
                                            placeholder="Start Date" id="startDate" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="endDate" class="form-control" placeholder="End Date"
                                            id="endDate" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                        <button type="submit" class="btn btn-secondary btn-sm btn-block">Search</button>
                                </div>
                                <div class="col-md-3"></div>
                            </form>
                        </div>
                    </div>
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <h3>Total Payments Recieved <?php echo $total;?></h3>
                                <div class="table-responsive" style="overflow:hidden;">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Plan Name</th>
                                                <th scope="col">Plan Duration</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Invoice Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                                <!--<th scope="col">Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($invoice as $key => $value) { 
                                            $newDate = date("d-m-Y", strtotime($value['created_at']));
                                            ?>
                                            <tr class="test" data-date="<?php echo $newDate;?>">
                                                <td scope="row">
                                                    <?php if($value['id']<10){
                                                echo '00'.$value['id'];
                                            }else if($value['id']>=10 && $value['id']< 100){ 
                                                echo '0'.$value['id'];
                                            }else{
                                                echo $value['id'];
                                            };
                                            ?></td>
                                                <td><?php echo $value['email'];?></td>
                                                <td><?php echo $value['plan_name'];?></td>
                                                <td><?php echo $value['plan_duration'];?></td>
                                                <td><?php echo $value['price'];?></td>
                                                <td><?php echo $value['created_at'];?></td>
                                                <td><?php echo $value['valid']==1?'Active':'InActive';?></td>
                                                <td><!--<a href="<?php echo base_url('/admin/editinvoice/'.$value['id']);?>"
                                                        class="option"><i class="fa fa-pencil"></i></a>-->
                                                    <a href="<?php echo base_url('/PdfController/htmlToPDF/'.$value['id']);?>"
                                                        class="option"><i class="fa fa-download"></i></a>
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
    <script>
        $(function () {
            $("#startDate").datepicker({
                dateFormat:'yy-mm-dd'
            });
            $("#endDate").datepicker({
                dateFormat:'yy-mm-dd'
            });
        });
    </script>
</section>
<?php echo view('footer',$extras);?>