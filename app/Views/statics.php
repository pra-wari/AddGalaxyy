<?php echo view('header'); 
$user_id = session()->get('id');
$d = array('page'=> $module);
$dateArray = array();
$d = array('page'=> $module,'adstype'=>$extras['adstype'],'currentPage'=>$currentpage,'categories',$categories);
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
            <?php echo view('statics-bar',$d);?> 
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
                                <div class="" style="overflow:hidden;">
                                    <div class="col-md-12">
                                        <h1>Statics</h1>
                                            <p class="lead">Total No of Ads: <?php echo $adscount;?></p>
                                            <div class="messages"></div>
                                            <div class="controls">
                                            <div id="chart_div"></div>
                                            <?php 
                                            /*foreach ($settings as $key => $value) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="form_email"><?php echo $value['option_name'];?>: </label>
                                                        <input id="title" type="text" maxlength="65" name="<?php echo $value['icon_path'];?>"
                                                            class="form-control"
                                                            placeholder="Please enter a Url *" required="required"
                                                            data-error="Title should be atleast 10 chars long"
                                                            value="<?php echo $value['option_value'];?>">
                                                        <div class="help-block with-errors" id="titleerrorid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }*/
                                            ?>
                                    <script>
                                        google.charts.load('current', {packages: ['corechart', 'bar']});
                                        google.charts.setOnLoadCallback(drawBasic);

                                        function drawBasic() {
                                            var data = google.visualization.arrayToDataTable([
                                                ['Country', 'Total Ads'],
                                                <?php 
                                                foreach ($countries as $key => $value) {
                                                   ?>
                                                        ['<?php echo $value['country_name'];?>', <?php echo $value['adscount'];?>],
                                                   <?php
                                                }    
                                                ?>
                                            ]);

                                            var options = {
                                                title: 'Total No Of Ads Country Wise',
                                                chartArea: {width: '50%'},
                                                hAxis: {
                                                title: 'Total No of Ads',
                                                minValue: 0
                                                },
                                                vAxis: {
                                                title: 'Country'
                                                }
                                            };

                                            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                                            chart.draw(data, options);
                                            }
                                        </script>
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
<?php echo view('footer',$extras);?>