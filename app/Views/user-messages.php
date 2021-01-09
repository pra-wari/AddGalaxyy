<?php echo view('header'); 
$user_id = session()->get('id');
$d = array('page'=> $module);
$adArray = array();
foreach ($messages as $key => $value) {
	$adArray[$value['ad_id']]=$value['ad_name'];
}

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
                <div class="product-listing1">
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <?php if(count($messages)>0){?>
                            <div class="col-md-6 left-box">
								<div class="row">
									<div class="col-md-6">
										<select name="action" class="form-control" id="allads">
											<option value="">All</option>
											<?php foreach ($adArray as $key1 => $value1) {?>
												<option value="<?php echo $key1;?>"><?php echo $value1;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-6">
									<span class="filter"><a href="#" data-id="" class="status">All</a> / <a href="#" data-id="1" class="status">Read</a> / <a data-id="0" href="#" class="status">Unread</a></span>
										<!--<select name="action" class="form-control" id="status">
											<option value="">All</option>
											<option value="1">Read</option>
											<option value="0">Unread</option>
										</select>-->
									</div>
								</div>
                                <div class="list-group">
                                    <?php 
                                    $i=0;
                                    foreach ($messages as $key => $value) { ?>
                                    <a data-id="<?php echo $value['ad_id'];?>" data-msgid="<?php echo $value['id'];?>" data-status="<?php echo $value['read'];?>" href="#<?php /*echo base_url('/users/messages/'.$user_id.'?msgid='.$value['id']);*/?>" class="list-group-item list-group-item-action flex-column align-items-start <?php if(!isset($_REQUEST['msgid']) && $key==0){echo 'active';}?><?php if(isset($_REQUEST['msgid']) && $value['id']==$_REQUEST['msgid']){ echo 'active';}?> <?php if($value['read']==1 && $i!=0){ echo 'list-group-item-dark';}?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img class="img-thumbnail-new" src="<?php echo base_url('/public/images/user-icon.jpg');?>">
                                        </div>
                                        <div class="col-md-9">    
                                            <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?php echo $value['sender_name'];?></h5>
                                            <small class=""><?php
                                            $newDate1 = date("d-m-Y h:i:s A", strtotime($value['lastmessagedate']));
                                            echo $newDate1;
                                            ?></small>
                                            </div>
                                            <p class="mb-1"><?php 
                                            //print_r($value);
                                            echo $value['message'];?></p>
                                        </div>
                                    </div>
                                    </a>
                                    <?php $i++;} ?>
                                </div>
                            </div>
                            <div class="col-md-5 right-box">
								<div class="card-title">
								    <?php if(isset($title['title'])){?>
								        <h5><?php echo $title['title'];?></h5>
								    <?php }else{ ?>
								    <h5></h5>
								    <?php } ?>
									
									<a href="<?php echo base_url('/users/deleteallchat/'.$enquiry_id);?>">Delete Chat</a>
								</div>		
								<div class="card-body msg_card_body">
								<?php foreach ($chat as $key1=> $value1) {
									$newDate = date("d-m-Y h:i:s A", strtotime($value1['created_date']));
									?>
										<div class="d-flex mb-4 <?php if($value1['sender_id']==$user_id){ echo 'justify-content-end';}else{ echo 'justify-content-start';}?>">
											<div class="<?php if($value1['sender_id']==$user_id){ echo 'msg_cotainer_send';}else{ echo 'msg_cotainer';}?>">
												<span class="msgbox"><?php echo $value1['message'];?></span>
												<span class="msg_time"><?php echo $newDate;?></span>
											</div>
										</div>
									<?php
								}?>
								</div>
								<div class="tightingbox">
									<!-- <form action="<?php echo base_url('/users/sendmessage/');?>" method="post"> -->
										<input type="hidden" id="sender_id" name="sender_id" value="<?php echo $user_id;?>">
										<input type="hidden" id="enquiry_id" name="enquiry_id" value="<?php echo $enquiry_id;?>">
										<textarea id="w3review" name="message" rows="2" cols="39"></textarea>
										<button id="submitbtn" class="btn btn-secondary" type="button" name="submit">Send</button>
									<!-- </form> -->
								</div>
                            </div>
                            <?php }else{ ?>
                            <h3>Messages Not Available.</h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right side gallery end -->
    </div>
	<script>
$("#w3review").keypress(function(event) {
	console.log(event.keyCode); 
    if (event.keyCode === 13) { 
        $("#submitbtn").click(); 
    } 
}); 

$(document).ready(function(){
	$(document).on('click','#submitbtn',function(){
		var objToday = new Date(),
		
		curYear = objToday.getFullYear(),
		curHour = objToday.getHours() > 12 ? objToday.getHours() - 12 : (objToday.getHours() < 10 ? "0" + objToday.getHours() : objToday.getHours()),
		curMinute = objToday.getMinutes() < 10 ? "0" + objToday.getMinutes() : objToday.getMinutes(),
		curSeconds = objToday.getSeconds() < 10 ? "0" + objToday.getSeconds() : objToday.getSeconds(),
		curMeridiem = objToday.getHours() > 12 ? "PM" : "AM";
		var dd = String(objToday.getDate()).padStart(2, '0');
		var mm = String(objToday.getMonth() + 1).padStart(2, '0'); //January is 0!
		var today = dd + "-" + mm + "-" + curYear +" "+curHour + ":" + curMinute + ":" + curSeconds +" "+ curMeridiem;
	
		var sender_id=$('#sender_id').val();
		var enquiry_id=$('#enquiry_id').val();
		var message = $('#w3review').val();
		var html='<div class="d-flex mb-4 justify-content-end"><div class="msg_cotainer_send">';
		html +='<span class="msgbox">'+message+'</span>';
		html +='<span class="msg_time">'+today+'</span>';
		html +='</div></div>';
		$('.msg_card_body').append(html);	
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('/users/sendmessage')?>',
			data: {
				'sender_id': sender_id,
				'enquiry_id': enquiry_id,
				'message': message
			},
			success: function (data) {
				
			}
		});					
	});
	$('.list-group .list-group-item').on('click', function() {
			var selectedId = $(this).attr('data-msgid');
			$('.list-group .list-group-item').each(function(){
				if($(this).hasClass('active')){
					$(this).removeClass('active').addClass('list-group-item-dark');
				}
			});
			$(this).removeClass('list-group-item-dark').addClass('active');
			$.ajax({
				type: 'POST',
                url: '<?php echo base_url('/users/getMessages')?>',
                data: {
                    'con': selectedId
                },
                success: function (data) {
                    $('.right-box').html(data);
                }
            });
		});
});
</script>
	<script>
		$('select#allads').on('change', function() {
			var selected = this.value;
			if(selected){
				$(".list-group-item").each(function(index) {
					if(jQuery(this).attr('data-id')==selected){
						jQuery(this).css('display', "block");
					}else{
						jQuery(this).css('display', "none");
					}
				});
			}else{
				$(".list-group-item").each(function(index) {
					jQuery(this).css('display', "block");
				});
			}
		});
		$('.status').on('click', function() {
			var selected = $(this).attr('data-id');
			if(selected){
				$(".list-group-item").each(function(index) {
					if(jQuery(this).attr('data-status')==selected){
						jQuery(this).css('display', "block");
					}else{
						jQuery(this).css('display', "none");
					}
				});
			}else{
				$(".list-group-item").each(function(index) {
					jQuery(this).css('display', "block");
				});
			}
		});
	</script>							
</section>
<?php echo view('footer',$extras);?>