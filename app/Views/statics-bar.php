<?php
if(!isset($date)){
    $date = array();
}
if(!isset($plan)){
    $plan = array();
}
$pageName = $currentPage?$currentPage:$page;
$staticsCategory = session()->get('staticsCategory');
$staticsTypeAds = session()->get('staticsTypeAds');
$staticslocation = session()->get('staticslocation');
$staticscities = session()->get('staticscities');
?>
<input type="hidden" id="currentPage" name="currentPage" value="<?php echo $pageName;?>">
<div class="row">
        <div class="col-md-3 entryClass">
        <span class="searchspan">Sort: </span>
            <select name="action" class="form-control" id="typeofads">
                <option value="">By Type of Ads</option>
                <?php 
                foreach ($adstype as $key => $value) {
                    ?>
                   <option value="<?php echo $value['type'];?>" <?php if($staticsTypeAds==$value['type']){echo 'selected';}?>><?php echo $value['plan_name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 entryClass">
            <span class="searchspan">Sort: </span>
            <select id="sortcategory" name="sortdate" class="form-control">
                <option value="">By Category</option>
                <?php 
                foreach ($categories as $key1 => $value1) {
                    ?>
                    <option value="<?php echo $value1['id'];?>" <?php if($staticsCategory==$value1['id']){echo 'selected';}?>><?php echo $value1['name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 entryClass">
            <span class="searchspan">Sort: </span>
            <select id="sortlocation" name="sortdate" class="form-control">
                <option value="">By State</option>
                <?php 
                foreach ($extras['states'] as $key2 => $value2) {
                    ?>
                    <option value="<?php echo $value2['id'];?>" <?php if($staticslocation==$value2['id']){echo 'selected';}?>><?php echo $value2['name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
         <?php if($staticslocation){ ?>
        <div class="col-md-3 entryClass">
            <span class="searchspan">Sort: </span>
            <select id="sortcities" name="sortdate" class="form-control">
                <option value="">By Cities</option>
                <?php 
                foreach ($extras['cities'] as $key3 => $value3) {
                    ?>
                    <option value="<?php echo $value3['id'];?>" <?php if($staticscities==$value3['id']){echo 'selected';}?>><?php echo $value3['name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>
         <?php } ?>       
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
  $("#sortcategory").on("change", function() {
    var value = $(this).val().toLowerCase();
    var data = new FormData();
    data.append('pagename', $('#currentPage').val());
    data.append('category', value);
    $.ajax({
        url: '<?php echo base_url('/dashboard/setstaticscategory')?>',
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
  $("#sortlocation").on("change", function() {
    var value = $(this).val().toLowerCase();
    var data = new FormData();
    data.append('pagename', $('#currentPage').val());
    data.append('location', value);
    $.ajax({
        url: '<?php echo base_url('/dashboard/setstaticslocation')?>',
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

  $("#sortcities").on("change", function() {
    var value = $(this).val().toLowerCase();
    var data = new FormData();
    data.append('pagename', $('#currentPage').val());
    data.append('cities', value);
    $.ajax({
        url: '<?php echo base_url('/dashboard/setstaticscity')?>',
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

  $("#typeofads").on("change", function() {
    var value = $(this).val().toLowerCase();
    var data = new FormData();
    data.append('pagename', $('#currentPage').val());
    data.append('typeofads', value);
    $.ajax({
        url: '<?php echo base_url('/dashboard/setstaticstypeads')?>',
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