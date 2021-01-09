<?php echo view('header'); 
$user_id = session()->get('id');
$dateArray = array();
foreach ($users as $key => $value) {
    $newDate = date("d-m-Y", strtotime($value['date']));
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
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="table-responsive" style="overflow:hidden;">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th scope="col"><input type="checkbox" id="checkAll"></th>
                                            <th scope="col">S.no</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Verification</th>
                                            <th scope="col">Total No of ads</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($users as $key => $value) {
                                            $newDate = date("d-m-Y", strtotime($value['date']));
                                            ?>
                                            <tr class="test" data-date="<?php echo $newDate;?>">
                                            <td scope="row"><input type="checkbox" value="<?php echo $value['id'];?>" class="checkSingle"></td>
                                            <td scope="row"><?php echo $value['id'];?></td>
                                            <td><?php echo $value['firstname'];?></td>
                                            <td><?php echo $value['lastname'];?></td>
                                            <td><?php echo $value['mobile'];?></td>
                                            <td><?php echo $value['email'];?></td>
                                            <td>
                                            <?php if($value['verified']==0){
                                                ?>
                                                <a href="<?php echo base_url('/admin/sendverificationmail/'.$value['id']);?>">Send Email</a>
                                                <?php
                                            }else{
                                                echo 'Verified';
                                            }
                                            ?>
                                            </td>
                                            <td>
                                            <?php 
                                                foreach ($value['noofads'] as $k2 => $v2) {
                                                    ?>
                                                    <a href="<?php echo base_url('/admin/adsbyuser/'.$value['id']);?>"><?php echo $v2['COUNT(*)'];?></a>
                                                    <?php
                                                }
                                            ?>
                                            </td>
                                            <!--<td><img src="<?php //echo base_url($value['icon_path']);?>"></td>-->
                                            <td><?php echo $value['valid']==1?'Active':'InActive';?></td>
                                            <td><!--<a href="<?php //echo base_url('/admin/edituser/'.$value['id']);?>" class="option"><i class="fa fa-pencil"></i></a>-->
                                            <a href="<?php echo base_url('/admin/deleteuser/'.$value['id']);?>" class="option"><i class="fa fa-trash"></i></a>
                                            <?php if($value['valid']==0){?>
                                            <a href="<?php echo base_url('/admin/enableuser/'.$value['id']);?>" class="option"><i class="fa fa-eye"></i></a>
                                            <?php }else{ ?>
                                                <a href="<?php echo base_url('/admin/disableuser/'.$value['id']);?>" class="option"><i class="fa fa-eye-slash"></i></a>
                                            <?php } ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-end">
                                    <?php if ($pager) :?>
                                    <?php $pagi_path='admin/allads'; ?>
                                    <?php $pager->setPath($pagi_path); ?>
                                    <?= $pager->links() ?>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
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