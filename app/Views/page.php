<?php echo view('header');
//echo view('search-bar');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <h1><?php echo $page[0]['page_name'];?></h1>
                <p class="lead"></p>
                <form name="ad-form" id="ad-form" method="post" action="<?php echo base_url('/users/submitad');?>"
                    role="form" enctype="multipart/form-data" onsubmit="return checkTitle();">
                    <div class="messages"></div>
                    <input type="hidden" name="tid" id="tid" readonly />
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $page[0]['content'];?>
                            </div>
                        </div>
                            
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assests/js/contact.js"></script>
<style>
    .states1 {
        color: #337ab7 !important;
    }
    .zoomstate {
        font-size: 20px !important;
    }
</style>
<?php echo view('footer',$extras);?>
<script>
    jQuery(document).ready(function(){
        $('#add_more_images').click(function(){
            if($('#filediv input').length<10){
                $('#filediv').append('<input name="file[]" type="file" id="file" multiple />');
            }else{
                $('.image-help-block').text('Maximum 10 images can be uploaded');
            }
            
        });
    });
    function submitPost() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/admin/submitPost",
            data: $('#ad-form').serialize(),
            success: function (data) {
                console.log(data);
                return false;
                $("#state").html(data);
            }
        });
    }

    function getState1(id) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/admin/getPostState",
            data: {
                'con': id
            },
            success: function (data) {
                $("#state").html(data);
            }
        });
    }

    function getCity1(val) {
        // return false;
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/admin/getPostCity",
            data: {
                'con': val
            },
            success: function (data) {
                console.log(data);
                $("#city").html(data);
                // $("#hidden").html(con2);
            },
        });
        //location.reload();
    }

    function getRegion1(val) {
        // return false;
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/admin/getPostRegion",
            data: {
                'con': val
            },
            success: function (data) {
                console.log(data);
                $("#region-sel").html(data);
                // $("#hidden").html(con2);
            },
        });
        //location.reload();
    }
    $(document).ready(function(){
        $(document).on('change','#region-sel',function(){
            var selectedId=$(this).val();
            //console.log('change',selectedId);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url();?>/admin/getplanbyRegion",
                data: {
                    'con': selectedId
                },
                success: function (data) {
                    var res = JSON.parse(data);
                    $.each(res, function(key, value) {
                        var html='<option value="">Select Duration</option>';
                        $.each(value.plan, function(key1, value1) {
                            console.log('meta=',value1);
                            html += '<option value="'+value1.plan_price+'-'+value1.id+'">'+value1.plan_duration+'</option>';
                        });
                        $("#duration"+value.id).html(html);
                    });
                },
            });
        });
    });

    function selectdays(id) {
        // console.log(id);
    }

    function getPrice(selected, id, type) {
        // console.log(price+"  "+id);
        var res = selected.split('-');
        console.log('===>1',res);
        console.log('===>1',type);
        if(res[0]==0){
            $("#plan_price" + id).val('Free');
        }else{
            $("#plan_price" + id).val(res[0]);
        }
        $("#selectedDuration").val(res[1]);
        $("#plantype").val(type);
    }
</script>