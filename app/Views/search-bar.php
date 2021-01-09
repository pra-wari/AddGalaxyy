<?php 
?>
<div class="search-bar mb-30 center-xs mobile-spacing">
  <div class="container">
    <form action="<?php echo base_url('/search');?>" method="post">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <?php 
          
          if(isset($states)){
            ?>
             <div class="select-dropdown select-dropdown1">
              <fieldset>
              <select id="region" name="region" class="form-control" required="required" data-error="Select Region">
                <option>Select Region</option>
                <?php 
                $selected='';
                foreach ($states as $key1 => $value1) { 
                    if(!$_POST){    
                        if (session()->get("state_id") == $value1['id']) {
                          $selected = "selected";
                        }else{
                          $selected='';
                        }
                    }else{
                        if ($_POST['region'] == $value1['id']) {
                          $selected = "selected";
                        }else{
                          $selected='';
                        }
                    }
                ?>
                      <option value="<?php echo $value1['id'];?>" <?php echo $selected;?>><?php echo $value1['name'];?></option>
                <?php } ?>
              </select>                                
              </fieldset>
              <div class="help-block with-errors"></div>
            </div>
            <?php
          }
          ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="select-dropdown select-dropdown2">
            <fieldset>
              <select id="selectedCat" name="category" class="countr option-drop form-control select2-hidden-accessible" required="required" tabindex="-1" aria-hidden="true">
                <option value="all">All Category</option>
                <?php foreach ($categories as $key => $value) { ?>
                      <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                <?php } ?>    
              </select>
            </fieldset>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 col-mb-12">
          <div class="key-word">
            <input type="hidden" id="selectedCategory" name="selectedCategory" value="">
            <input type="text" name="keyword" required="required" value="" placeholder="Enter Keywords here ...">
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 col-mb-12 text-right mobile-side" style="padding-right: 40px;">
          <button type="submit" class="btn-color btn big-width"> <i class="fa fa-search"></i>Search</button> 
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$('#selectedCat').on('change',function(){
  console.log();
  var select = $(this).val();
  $('#selectedCategory').val(select);
});
</script>
  