<?php echo view('header'); 
$user_id = session()->get('id');
$dateArray = array();
foreach ($listing as $key => $value) {
    $newDate = date("d-m-Y", strtotime($value['date']));
    $dateArray[] = $newDate;
}
$dateArray=array_unique($dateArray);
$d = array('page'=> $module,'date'=>$dateArray,'currentPage'=>$currentpage,'plan'=>$allplan);
// $d = array('page'=> $module,'currentPage'=>$currentpage);
?>
 <form action="<?php echo base_url('/home/upgrade');?>" method="post">
    <div id="upgradeModal" class="modal fade" tabindex="-1" role="dialog">
    <input type="hidden" id="upgradeListingId" name="upgradeListingId" value="">
    <input type="hidden" id="upgradeexistingId" name="upgradeexistingId" value="">
    <input type="hidden" id="upgraderegionId" name="upgraderegionId" value="">
    <input type="hidden" id="upgradeplanId" name="upgradeplanId" value="">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">×</span></button>
            <h4 class="modal-title">Upgrade Now</h4>
          </div>
          <div class="modal-body">
            <!-- <select id="changeCountry" name="changeCountry">
                <option value="">Select Country</option>
                <?php foreach ($countries as $key1 => $value1) {
                    ?>
                    <option value="<?php echo $value1['id'];?>"><?php echo $value1['name'];?></option>
                    <?php 
                }?>
            </select>
            <div id="state-select1"></div>
            <div id="city-select1"></div>
            <div id="region-select1"></div> -->
            <div id="plans-select1"></div>
            <div id="duration-select1"></div>
            <div id="response1"></div>
            <button id="upgradebtn" type="submit" class="btn" style="display:none">Upgrade</button>    
          </div>
          <!--<div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="state_submit">Save changes</button>
      </div>-->
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </form>
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
                                    <table id="myTable" class="admin-dashboard-table table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input type="checkbox" id="checkAll" value="0"></th>
                                                <th scope="col">Id</th>
                                                <th scope="col">User Email</th>
                                                <th scope="col">Request Paid</th>
                                                <th scope="col">Allow</th>
                                                <th scope="col">Disallow</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Plan</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Country</th>
                                                <th scope="col">States</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listing as $key => $value) { 
                                                $newDate = date("d-m-Y", strtotime($value['date']));
                                                ?>
                                            <tr class="test" data-date="<?php echo $newDate;?>">
                                                <td scope="row"><input type="checkbox" value="<?php echo $value['id'];?>" class="checkSingle"></td>
                                                <td><?php if($value['id']<10){
                                                echo '00'.$value['id'];
                                            }else if($value['id']>=10 && $value['id']< 100){ 
                                                echo '0'.$value['id'];
                                            }else{
                                                echo $value['id'];
                                            };
                                            ?></td>
                                                <td><?php echo $value['userEmail'];?></td>
                                                
                                                <td>
                                            <?php if($value['premium_status']==1) {   ?>
                                            <a href="<?php echo base_url()."/admin/planactive/premium/1/".$value['id'];
                                        ?>">Active Premium</a><br><br>
                                            <?php } ?>
                                            <?php if($value['sgallery_status']==1) {   ?>
                                            <a href="<?php echo base_url()."/admin/planactive/sgallery/1/".$value['id'];
                                        ?>">Active SideBar</a><br><br>
                                            <?php } ?>
                                            <?php if($value['featured_status']==1) {   ?>
                                            <a href="<?php echo base_url()."/admin/planactive/featured/1/".$value['id'];
                                        ?>">Active Slider</a><br><br>
                                            <?php } ?>
                                            
                                            <?php if($value['premium_status']==2) {   ?>
                                            <a href="<?php echo base_url()."/admin/planactive/premium/0/".$value['id'];
                                        ?>">Deactive Premium</a><br><br>
                                            <?php } ?>
                                            <?php if($value['sgallery_status']==2) {   ?>
                                            <a href="<?php echo base_url()."/admin/planactive/sgallery/0/".$value['id'];
                                        ?>">Deactive SideBar</a><br><br>
                                            <?php } ?>
                                            <?php if($value['featured_status']==2) {   ?>
                                            <a href="<?php echo base_url()."/admin/planactive/featured/0/".$value['id'];
                                        ?>">Deactive Slider</a><br><br>
                                            <?php } ?>
                                            </td>
                                            <td>
                                            <a href="#" class="premium" id="<?php echo $value['id']?>">Allow Premium<?php foreach($value['plans'] as $key1 => $value1){
                                            echo "(".$value1['remaining'].")";
                                        }?></a>
                                   
                                   <div class="col-md-2 allow-popup" id="<?php echo "prepopup". $value['id'];?>">
                                        <button type="button" value="<?php echo $value['id'] ?>" class="close prepopupclose">&times;</button>
                                        <form action="<?php echo base_url()."/admin/planactive/premium/1/".$value['id'];
                                        ?>" method="post">
                                            <input class="form-control" name="days" type="text" placeholder="Type days"/>
                                            <button class="btn btn-info" type="submit">Allow</button>
                                        </form>
                                    </div>


                                        <a href="<?php echo base_url()."/admin/planactive/sgallery/1/".$value['id'];
                                        ?>">Allow SideBar</a><br><br>

                                        <a href="<?php echo base_url()."/admin/planactive/featured/1/".$value['id'];
                                        ?>">Allow Slider</a><br><br>
                                            
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url()."/admin/planactive/premium/0/".$value['id'];
                                        ?>">Disallow Premium</a>

                                        <a href="<?php echo base_url()."/admin/planactive/sgallery/0/".$value['id'];
                                        ?>">Disallow SideBar</a><br><br>

                                        <a href="<?php echo base_url()."/admin/planactive/featured/0/".$value['id'];
                                        ?>">Disallow Slider</a><br><br>
                                                
                                            </td>
                                                
                                                <td><?php echo $value['categoryName'];?></td>
                                                <td><?php foreach ($value['plans'] as $key1 => $value1) {
                                                    if($value1['remaining']>0){
                                                        echo $value1['plan_name']." (".$value1['remaining'].")"."<br />";
                                                    }else{
                                                        echo $value1['plan_name']." (<a href='#'>Expired</a>)"."<br />";
                                                    }
                                                    ?>
                                     (<a class="option upgradenow" data-planid="<?php echo $value1['currentPlan'];?>" data-id="<?php echo $value['id'];?>">Upgrade</a>)
                                                    <?php
                                                    }?>
                                                </td>
                                                <td><a href="<?php echo base_url('/ads/view/'.$value['id']);?>"><?php echo $value['title'];?></a></td>
                                                <td><?php echo 'INDIA';?></td>
                                                <td><?php echo $value['region'];?></td>
                                                <td>
                                                    <a href="<?php echo base_url('admin/editlisting/'.$value['id'])?>"
                                                        class="option">
                                                        <i class="fa fa-pencil"></i></a>
                                                    <a href="<?php echo base_url('admin/deletelisting/'.$value['id'])?>"
                                                        class="option">
                                                        <i class="fa fa-trash"></i></a>
                                                    <?php if($value['valid']==1){?>
                                                    <a href="<?php echo base_url('admin/disablelisting/'.$value['id'])?>"
                                                        class="option">
                                                        <i class="fa fa-eye-slash"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="<?php echo base_url('admin/enablelisting/'.$value['id'])?>"
                                                        class="option">
                                                        <i class="fa fa-eye"></i></a>
                                                    <?php } ?>
                                                </td>
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
                        <script>
                            $(document).ready(function () {
                                $('#total_ads_count').text('9');
                                $('.total_ads_countnew').text('9');
                                $('.upgradenow').click(function(){
                                    $('#upgradeModal').modal('show');
                                    $('#upgradeListingId').val($(this).attr('data-id'));
                                    $('#upgradeexistingId').val($(this).attr('data-planid'));
                                    setRegion($('#upgraderegionId').val());
                                });
                                // $(document).on('change','#changeCountry',function(){
                                //     getState($(this).val());
                                // });
                                $(".premium").click(function(){
                                    $(".allow-popup").slideUp();
                                    var id = $(this).attr('id');
                                    var popup = "#prepopup"+id;
                                    $(popup).slideDown('slow');
                                });
                                $(".prepopupclose").click(function(){
                                    var id = $(this).attr('value');
                                    var popup = "#prepopup"+id;
                                    $(popup).slideUp('slow');
                                });
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