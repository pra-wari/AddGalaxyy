<?php echo view('header'); 
$user_id = session()->get('id');
$dateArray = array();
foreach ($invoice as $key => $value) {
    $newDate = date("d-m-Y", strtotime($value['created_at']));
    $dateArray[] = $newDate;
}
$dateArray=array_unique($dateArray);
$d = array('page'=> $module,'date'=>$dateArray,'currentPage'=>$currentpage);
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
                    <div class="row">
                        <div class="container1">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <!--<a href="<?php //echo base_url('/admin/generateInvoice');?>">
                                    <button type="button" class="btn btn-secondary btn-sm btn-block">Generate Invoice</button>
                                </a>-->
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
                                            <th scope="col"><input type="checkbox" id="checkAll" id="checkAll"></th>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Plan Name</th>
                                            <th scope="col">Plan Duration</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Action</th>
                                            <!--<th scope="col">Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($invoice as $key => $value) {
                                            $newDate = date("d-m-Y", strtotime($value['created_at']));
                                            ?>
                                            <tr class="test" data-date="<?php echo $newDate;?>">
                                            <th scope="row"><input type="checkbox"></th>
                                            <th scope="row"><?php echo $value['id'];?></th>
                                            <td><?php echo $value['email'];?></td>
                                            <td><?php echo $value['plan_name'];?></td>
                                            <td><?php echo $value['plan_duration'];?></td>
                                            <td><?php echo $value['price'];?></td>
                                            <td><?php echo $value['created_at'];?></td>
                                            <td><?php echo $value['plansmeta'][0]['plan_price'];?></td>
                                            <td><!--<a href="<?php echo base_url('/users/editinvoice/'.$value['id']);?>" class="option"><i class="fa fa-pencil"></i></a>-->
                                            <a href="<?php echo base_url('/PdfController/htmlToPDF/'.$value['id']);?>" class="option"><i class="fa fa-download"></i></a>
                                            </td>
                                            <?php /* <td><a href="<?php echo base_url('/admin/editinvoice/'.$value['id']);?>" class="option"><i class="fa fa-pencil"></i></a>-->
                                            <a href="<?php echo base_url('/admin/deleteinvoice/'.$value['id']);?>" class="option"><i class="fa fa-trash"></i></a>
                                            <?php if($value['valid']==0){?>
                                            <a href="<?php echo base_url('/admin/enableinvoice/'.$value['id']);?>" class="option"><i class="fa fa-eye"></i></a>
                                            <?php }else{ ?>
                                                <a href="<?php echo base_url('/admin/disableinvoice/'.$value['id']);?>" class="option"><i class="fa fa-eye-slash"></i></a>
                                            <?php } ?>
                                            </td><?php */ ?>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-end">
                                    <?php if ($pager) :?>
                                    <?php $pagi_path='users/'.$currentpage; ?>
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