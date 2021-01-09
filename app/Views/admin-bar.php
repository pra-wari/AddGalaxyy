<?php
if(!isset($date)){
    $date = array();
}
if(!isset($plan)){
    $plan = array();
}
$pageName = $currentPage?$currentPage:$page;
$showentry = session()->get($pageName);
?>
<input type="hidden" id="currentPage" name="currentPage" value="<?php echo $pageName;?>">
<div class="row">
        <?php if($page!='dashboard' && $pageName!='invoices' && $pageName!='allinvoices'){?>
                <div class="col-md-3">
                    <select name="action" class="form-control" id="bulkaction">
                        <option value="">Bulk Action</option>
                        <option value="delete">Delete</option>
                    </select>
                </div>
        <?php } ?>
        <div class="col-md-3 entryClass">
            <span class="searchspan">Show: </span> 
            <select id="showentry" name="showentry" class="form-control entries">
                <option value="10" <?php if($showentry=='10'){echo 'selected';}?>>10</option>
                <option value="25" <?php if($showentry=='25'){echo 'selected';}?>>25</option>
                <option value="50" <?php if($showentry=='50'){echo 'selected';}?>>50</option>
                <option value="100" <?php if($showentry=='100'){echo 'selected';}?>>100</option>
            </select>
        </div>
        <?php if($pageName!='localities'){?>
        <div class="col-md-2 entryClass">
            <span class="searchspan">Sort: </span>
            <select id="sortdate" name="sortdate" class="form-control">
                <option value="">By Date</option>
                <?php 
                foreach ($date as $key => $value) {
                    $newDate = date("d-m-Y", strtotime($value));
                    ?>
                    <option value="<?php echo $newDate;?>"><?php echo $newDate;?></option>
                    <?php
                }
                ?>
            </select>
        </div>
            <?php } ?>
        <?php 
        if($pageName=='allads'){
            ?>
            <div class="col-md-2 entryClass">
                <span class="searchspan">Sort: </span>
                <?php
                    $planid = isset($_REQUEST['plan_id'])?$_REQUEST['plan_id']:0;
                ?>
                <select id="sortplan" name="sortplan" class="form-control">
                    <option value="">By Plan</option>
                    <?php 
                    foreach ($plan as $key => $value) {
                        ?>
                        <option value="<?php echo $value['id'];?>" <?php if($value['id']==$planid){echo 'selected';}?>><?php echo $value['plan_name'];?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <?php
        }
        ?>
        <div class="col-md-3">
            <div class="form-group pull-right" style="display: inline-flex;">
                <span class="searchspan">Search: </span><input type="text" id="myInput" class="search form-control"
                    placeholder="What you looking for?">
            </div>
        </div>
    </div>
<script>
$(document).ready(function(){
    var array = [];
    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
        for (var i = 0; i < checkboxes.length; i++) {
            array.push(checkboxes[i].value)
        }
    });
    $(".checkSingle").change(function(){
        array = [];
        var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
        for (var i = 0; i < checkboxes.length; i++) {
            array.push(checkboxes[i].value)
        }
    });
<?php if($page=='dashboard'){ ?>
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    console.log(value);
    jQuery('.freeadd').each(function(){
        var val = jQuery(this).attr('data-text').toLowerCase();
        if(val.indexOf(value) != -1){
            jQuery(this).css('display','block');
        }else{
            jQuery(this).css('display','none');
        }
    });
  });
  $("#sortdate").on("change", function() {
    var value = $(this).val().toLowerCase();
    console.log(value);
    if(value){
        jQuery('.freeadd').each(function(){
            var val = jQuery(this).attr('data-date').toLowerCase();
            if(val==value){
                jQuery(this).css('display','block');
            }else{
                jQuery(this).css('display','none');
            }
        });
    }else{
        jQuery('.freeadd').each(function(){
            jQuery(this).css('display','block');
        });
    }
  });

<?php }else{ ?>
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("#sortdate").on("change", function() {
        var value = $(this).val().toLowerCase();
        console.log(value);
        if(value){
            $("#myTable tr.test").filter(function() {
                $(this).toggle($(this).attr('data-date')==value);
            });
        }else{
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).attr('data-date')!=value);
            });
        }
    });
<?php } ?>

$("#sortplan").on("change", function() {
        var value = $(this).val().toLowerCase();
        console.log(value);
        if(value){
            location.href = '/admin/allads/?plan_id='+value;
        }else{
            location.href = '/admin/allads';
        }
    });
  $("#bulkaction").on("change", function() {
      console.log('bulkAction');
      console.log(array);
      $.ajax({
        url: '<?php echo base_url('/dashboard/deleteData')?>',
        data: {data:array,page:'<?php echo $pageName;?>'},
        type: 'POST',
        success: function (data) {
            data = JSON.parse(data);
           if(data.status=='success'){
            location.reload(true);
           }else{
            alert(data.msg);
           }
        }
    });
  });

  $("#showentry").on("change", function() {
    var value = $(this).val().toLowerCase();
    var data = new FormData();
    data.append('pagename', $('#currentPage').val());
    data.append('showlimit', value);
    $.ajax({
        url: '<?php echo base_url('/dashboard/showlimit')?>',
        data: data,
        processData: false,
        cache: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
           console.log(data);
           location.reload(true);
        }
    });
  });
});
</script>