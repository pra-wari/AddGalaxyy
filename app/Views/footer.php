<style>
.sasa ul {
    margin-bottom: 0px;
}

@media screen and (max-width: 767px) {
    .sasa {
        display: block !important;
    }

    .sasa ul {
        font-size: 13px;
    }
}
</style>
<!-- FOOTER START -->
<?php
$noofrows = count($states)/4;
$noofrows = ceil($noofrows);
$noofrowsmobile = count($states)/2;
$noofrowsmobile = ceil($noofrowsmobile);
$id = session()->get('id');
?>
<div class="footroom ybtb mobile-view">
    <a class="ybtb__li ybtb__li--new ybtb__li--favs js-ytbt_home" href="<?php echo base_url();?>">
        <div style="width:20px; height:20px;" class="sprites_mobile_main__home yicon ysvg"></div>
        <div class="ybtb__label">Home</div>
    </a>
    <?php if(session()->get('usertype')=='admin'){?>
        <a class="ybtb__li ybtb__li--new ybtb__li--myads js-ytbt_ads" href="<?php echo $id?base_url('/admin/allads'):base_url('/login');?>">
            <div style="width:20px; height:20px;" class="sprites_mobile_main__stack yicon ysvg ybtb__myads"></div>
            <div class="ybtb__label">My Ads</div>
        </a>
    <?php }else{ ?>
        <a class="ybtb__li ybtb__li--new ybtb__li--myads js-ytbt_ads" href="<?php echo $id?base_url('/dashboard'):base_url('/login');?>">
            <div style="width:20px; height:20px;" class="sprites_mobile_main__stack yicon ysvg ybtb__myads"></div>
            <div class="ybtb__label">My Ads</div>
        </a>
    <?php } ?>
    <a href="<?php echo $id?base_url('/postad'):base_url('/login');?>" class="ybtb__li ybtb__li--new ybtb__li--post_new js-ybtb_post js-post_ad" data-pagetype="INDEX" data-position="tabbar">
        <div style="width:20px; height:20px;" class="sprites_mobile_main__add yicon ysvg"></div>
        <div class="ybtb__label">Post Ad</div>
    </a>
    <a class="ybtb__li ybtb__li--new js-ybtb_button_inbox ybtb__li--mc_new" data-menu_count="" href="<?php echo $id?base_url('/users/messages/'.$id):base_url('/login');?>">
        <div style="width:20px; height:20px;" class="sprites_mobile_main__usermessage yicon ysvg"></div>
        <div class="ybtb__label">Messages</div>
    </a>
</div>
<div class="footer">
  <div class="container-fluid">
    <div class="row hidemobile" style="margin-bottom: -80px;margin-top:20px;">
      <div class="col-md-3">
        <ul>
        <?php 
        $i=0;
        foreach ($states as $key => $value) {
            $i++;
            ?>
            <li class="zoom"><a class="states1 <?php if($selectedState==$value['id']){ echo 'stateactive';}?>" href="#" onclick="setState('<?php echo $value['id'];?>');"><?php echo $value['name'];?></a></li>
            <?php
            if($i%$noofrows==0){
                echo '</ul></div><div class="col-md-3"><ul>';
            }
        }
        ?>
        </ul>
      </div>
      </div>
    </div>


    <div class="row showmobile" style="margin-bottom: -80px;">
      <div class="col-md-6" style="font-size: 13px;margin-top: 8px;display: inline-block;float:left;">
        <ul style="margin-left: 5px;">
        <?php 
        $j=0;
        foreach ($states as $key => $value) {
            $j++;
            ?>
            <li class="zoom"><a class="states1 <?php if($selectedState==$value['id']){ echo 'stateactive';}?>" href="#" onclick="getState('<?php echo $value['id'];?>');getCountry(1);get_state_modal(1);"><?php echo $value['name'];?></a></li>
            <?php
            if($j%$noofrowsmobile==0){
                echo '</ul></div><div class="col-md-6" style="font-size: 13px;margin-top: 0;display: inline-block;float:right;"><ul>';
            }
        }
        ?></ul>
      </div>
    </div>
    <div class="footer-inner">
      <div class="footer-top">
        <div class="row">
          <div class="col-md-4 col-sm-12 col-xs-12 f-col">
            <div class="footer-static-block">
              <span class="opener plus"></span>
              <div class="f-logo">
                <a href="<?php echo base_url(); ?>" class="">
                  <img src="<?php echo base_url('public/images/logo.png'); ?>" style="width:100%;" alt="Addgalaxy">
                </a>
              </div>
              <div class="footer-block-contant">
                <p><?php echo $hotlinks[7]['option_value'];?></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-12 col-xs-12 f-col">
            <div class="footer-static-block">
              <span class="opener plus"></span>
              <h3 class="title"><span></span>Hot Links</h3>
              <ul class="footer-block-contant link hot-link">
              <?php 
                foreach ($hotlinks as $key1 => $value1) {
                 ?>
                <li><a href="<?php echo $value1['option_value']; ?>" class="<?php echo $value1['icon_path']=='google-plus'?'google':$value1['icon_path']; ?>"><i
                      class="fa fa-<?php echo $value1['icon_path']; ?>"></i></a></li>
                 <?php
                }
              ?>
              </ul>
            </div>
          </div>
          <div class="col-md-4 col-sm-12 col-xs-12 f-col">
            <div class="footer-static-block">
              <span class="opener plus"></span>
              <h3 class="title"><span></span>Quick Links</h3>
              <ul class="footer-block-contant link">
                <li><a href="<?php echo base_url(); ?>"><span class="icon1"><i class="fa fa-angle-double-right"></i></span>
                    Home</a></li>
                <li><a href="<?php echo base_url('/login'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span> Login</a></li>
                <li><a href="<?php echo base_url('/disclaimer'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>Disclaimer</a></li>
                <li><a href="<?php echo base_url('/privacy-policy'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>Privacy &amp; Policy</a></li>
                <li><a href="<?php echo base_url('/about-us'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>About Us</a></li>
                <li><a href="<?php echo base_url('/terms-condition'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>Terms &amp; Condition</a></li>
                <li><a href="<?php echo base_url('/refund-cancellation'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>Refund &amp; Cancellation</a></li>
                <li><a href="<?php echo base_url('/pricing'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>Pricing</a></li>
                <li><a href="<?php echo base_url('/contact-us'); ?>"><span class="icon1"><i
                        class="fa fa-angle-double-right"></i></span>Contact us</a></li>

              </ul>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="footer-bottom mtb-30">
        <div class="row">
          <div class="col-sm-4">
            <div class="copy-right center-xs"><?php echo $hotlinks[6]['option_value'];?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="scroll-top">
    <div id="scrollup"></div>
</div>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url('public/js/bootstrap.min(1).js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery-ui(1).js'); ?>"></script>
<script src="<?php echo base_url('public/js/fotorama.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery.magnific-popup.js'); ?>"></script>
<script src="<?php echo base_url('public/js/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo base_url('public/js/select2.full.js'); ?>"></script>
<script src="<?php echo base_url('public/js/custom.js'); ?>"></script>
<script src="<?php echo base_url('public/js/swiper.min.js'); ?>"></script>
<script src="<?php echo base_url('public/js/bootstrap.min(2).js'); ?>"></script>
<script src="<?php echo base_url('public/js/validator.js'); ?>"></script>
<script src="<?php echo base_url('public/js/contact-3.js'); ?>"></script>
<script>
function myFunctionImage() {
    var checkBox = document.getElementById("myCheckImage");
    var checkBox2 = document.getElementById("myCheck2Image");
    var text = document.getElementById("textImage");
    var text2 = document.getElementById("text2Image");
    if (checkBox.checked == true) {
        text.style.display = "block";
        text2.style.display = "none";
        document.getElementById("filterResult1").style.display = "none";
        checkBox2.checked = false;
    }
    if (checkBox.checked == false && checkBox2.checked == false) {
        document.getElementById("filterResult1").style.display = "block";
    }

}

function myFunction2Image() {
    var checkBox = document.getElementById("myCheckImage");
    var checkBox2 = document.getElementById("myCheck2Image");
    var text = document.getElementById("textImage");
    var text2 = document.getElementById("text2Image");
    if (checkBox2.checked == true) {
        text2.style.display = "block";
        text.style.display = "none";
        document.getElementById("filterResult1").style.display = "none";
        checkBox.checked = false;
    }
    if (checkBox.checked == false && checkBox2.checked == false) {
        document.getElementById("filterResult1").style.display = "block";
    }

}

function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var checkBox2 = document.getElementById("myCheck2");
    var text = document.getElementById("text");
    var text2 = document.getElementById("text2");
    if (checkBox.checked == true) {
        text.style.display = "block";
        text2.style.display = "none";
        document.getElementById("filterResult1").style.display = "none";
        checkBox2.checked = false;
    }
    if (checkBox.checked == false && checkBox2.checked == false) {
        document.getElementById("filterResult1").style.display = "block";
    }

}

function myFunction2() {
    var checkBox = document.getElementById("myCheck");
    var checkBox2 = document.getElementById("myCheck2");
    var text = document.getElementById("text");
    var text2 = document.getElementById("text2");
    if (checkBox2.checked == true) {
        text2.style.display = "block";
        text.style.display = "none";
        document.getElementById("filterResult1").style.display = "none";
        checkBox.checked = false;
    }
    if (checkBox.checked == false && checkBox2.checked == false) {
        document.getElementById("filterResult1").style.display = "block";
    }

}
</script>
<script type="text/javascript">
function fetchCountry() {
    var id = 1;
    url = "<?php echo base_url();?>/home/country";
    $.ajax({
        type: "POST",
        url: url,
        data: {
            "id": id
        },
        success: function(data) {
            $("#country").html(data);
        }
    });
}
fetchCountry();

function getState(val) {
    console.log('getState');
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/home/getState",
        data: {
            'con': val
        },
        success: function(data) {
            console.log(data);
            $("#state-select").html(data);
            $("#state-select1").html(data);
        }
    });
}

function getCity(val) {
    // return false;
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/home/getCity",
        data: {
            'con': val
        },
        success: function(data) {
            console.log(data);
            $("#city-select").html(data);
            $("#city-select1").html(data);
            // $("#hidden").html(con2);
        },
    });
    //location.reload();
}

function getRegion(val) {
    // return false;
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/home/getRegion",
        data: {
            'con': val
        },
        success: function(data) {
            console.log(data);
            $("#region-select").html(data);
            $("#region-select1").html(data);
            // $("#hidden").html(con2);
        },
    });
    //location.reload();
}

function setRegion(val) {
    // return false;
    $('#upgraderegionId').val(val);
    <?php if($currentpage!='allads'){?>
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/home/setRegion",
        data: {
            'con': val
        },
        success: function(data) {
            console.log(data);
        },
    });
    location.reload();
    <?php }else{?>
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/home/getPlans",
            data: {
                'con': val
            },
            success: function(data) {
                console.log(data);
                $("#plans-select1").html(data);
            },
        });
        console.log('==>3',val);
    <?php } ?>
}
function getPlanmeta(val){
    var region=$('#upgraderegionId').val();
    $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>/home/getPlansmeta",
            data: {
                'con': val,
                'region': region,
            },
            success: function(data) {
                console.log(data);
                $("#duration-select1").html(data);
            },
        });
        console.log('==>2',val);
}
function upgrade(val){
    console.log('==>1',val);
    $('#upgradeplanId').val(val);
    $('#upgradebtn').show();
}
function setCity(val) {
    // return false;
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/home/setCity",
        data: {
            'con': val
        },
        success: function(data) {
            console.log(data);
        },
    });
    location.reload();
}
function setState(val) {
    // return false;
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/home/setState",
        data: {
            'con': val
        },
        success: function(data) {
            console.log(data);
        },
    });
    location.reload();
}

function getCountry(val) {
    return false;
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url();?>/categories/country",
        data: {
            'con2': val
        },
        success: function(data) {
            //alert(data);
            $("#hidden").html(con2);
        },
    });
    //location.reload();
}


    function get_state_modal(val) {
        console.log();
        // $.ajax({
        //     type:"POST",
        //     url: "<?php echo base_url();?>/home/set_state", 
        //     data:{'name':val}, //data:'id='+ id  & 'name='+ name;,    for multiples
        //     success: function(result){
        //     $("#response1").html(result);
        // }});
        $('#myModal1').modal('show');
    };
    function openRenewModal(listing,plan){
        console.log(listing);
        console.log(plan);
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>/users/fetchDetails", 
            data:{'listing':listing,'plan':plan},
            success: function(result){
                var result = JSON.parse(result);
                if(result.status=='success'){
                    $('#plan_id').val(plan);
                    $('#listing_id').val(listing);
                    $('#renewresponse1').text("Hi you are renewing "+result.data[0]['plan_name']+" for "+result.data[0]['plan_duration']+". you need to pay RS "+result.data[0]['plan_price']+".");
                    $('#myModal2').modal('show');
                }
            }
        });
    }
    jQuery('#renewbutton').click(function(){
        var plan = $('#plan_id').val();
        var listing = $('#listing_id').val();
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>/users/renewplan", 
            data:{'listing':listing,'plan':plan},
            success: function(result){
                console.log(result);
                /*var result = JSON.parse(result);
                if(result.status=='success'){
                    $('#plan_id').val(plan);
                    $('#listing_id').val(listing);
                    $('#renewresponse1').text("Hi you are renewing "+result.data[0]['plan_name']+" for "+result.data[0]['plan_duration']+". you need to pay RS "+result.data[0]['plan_price']+".");
                    $('#myModal2').modal('show');
                }*/
            }
        });
    });
   </script>
   
   <script type="text/javascript">
var val1=0;
var val2=10000;
</script>

   <!-- pagination js start -->

<script>
    $(".product-a").each(function() {
    $(this).wrapAll("<a href='" + $(this).find("a").attr("href") + "' />")
});
</script>
 <script>
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('.pager');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
      pager.children().eq(1).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        } else {
            pager.find('.prev_link').hide();
        }

        if (page < (numPages - 1)) {
            pager.find('.next_link').show();
        } else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
        pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};

$(document).ready(function() {

    $('#myTable').pageMe({
        pagerSelector: '#myPager',
        showPrevNext: true,
        hidePageNumbers: false,
        perPage: 100
    });

});
</script>
<!-- pagination js end -->
    <script>

   
</script>
<script>
// var cat = document.getElementById("category").value;
// var subcat = document.getElementById("subcategory").value;
// var listactive = "list"+cat;
// if(cat){
//     var la = document.getElementsByClassName(listactive);
//      la.classList.toggle("active");
//      la.nextElementSibling.style.display = "block";
// }      
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
</script>
<script>
    (function() {
  
  $(".panel").on("show.bs.collapse hide.bs.collapse", function(e) {
    if (e.type=='show'){
      $(this).addClass('active');
    }else{
      $(this).removeClass('active');
    }
  });  

}).call(this);
</script>

<script>
    $('#'+active_cat).addClass("in");
    //alert(active_cat);
</script>
<script>
    $("#property").change(function(){
    var property=$(this).val();
    //alert(property);

    if (property == "commercial office space" || property == "IT park office" || property ==
        "commercial shop" || property == "commercial showroom" || property == "commercial land" ||
        property ==
        "industrial shed" || property == "warehouse/Godown" || property == "industrial building" ||
        property ==
        "commercial office space") {
        document.getElementById('bedroom').style.display = "none";
        document.getElementById('kitchen').style.display = "none";
    } else if (property == "plot" || property == "agricultural land") {
        document.getElementById('bedroom').style.display = "none";
        document.getElementById('kitchen').style.display = "none";
        document.getElementById('furnished').style.display = "none";
    } else {
        document.getElementById('bedroom').style.display = "block";
        document.getElementById('kitchen').style.display = "block";
        document.getElementById('furnished').style.display = "block";
    }

});
</script>
<style>
  

  </style>
  
  <script>
      $(".product-slider-mainmobile").owlCarousel({
      items : 3,
      });
      </script>
      <script>
        (function() {
 
  var parent = document.querySelector(".price-slider");
  if(!parent) return;
 
  var
    rangeS = parent.querySelectorAll("input[type=range]"),
    numberS = parent.querySelectorAll("input[type=number]");
 
  rangeS.forEach(function(el) {
    el.oninput = function() {
      var slide1 = parseFloat(rangeS[0].value),
        	slide2 = parseFloat(rangeS[1].value);
 
      if (slide1 > slide2) {
		[slide1, slide2] = [slide2, slide1];
      }
 
      numberS[0].value = slide1;
      numberS[1].value = slide2;
      $('.fromRupees').val(slide1);
      $('.toRupees').val(slide2);
    }
  });
 
  numberS.forEach(function(el) {
    el.oninput = function() {
		var number1 = parseFloat(numberS[0].value),
		number2 = parseFloat(numberS[1].value);
		
      if (number1 > number2) {
        var tmp = number1;
        numberS[0].value = number2;
        numberS[1].value = tmp;
      }
 
      rangeS[0].value = number1;
      rangeS[1].value = number2;
    }
  });
 
})();
setFooterdata();
$('#isstateshow').html("&nbsp;");
$('#iscityshow').html("&nbsp;");
$('#isregionshow').html("&nbsp;");
function setFooterdata(){
$.ajax({
    url: "<?=site_url("home/setFooterData")?>",
    type: "post", // To protect sensitive data
    data: {
        ajax: true,
        variableX: "string",
        variableY: 25
        //and any other variables you want to pass via POST
    },
    success: function(response) {
        //console.log(response);
        // console.log("sasa");
        // return false;
        $("#desktopstate").html("");
        $("#desktopcity").html("");
        $("#desktopregion").html("");
        var obj = jQuery.parseJSON(response);
        //console.log(response);
        // debugger;
        $('#isstateshow').html("&nbsp;");
        $('#iscityshow').html("&nbsp;");
        $('#isregionshow').html("&nbsp;");
        $.each(obj, function(key, value) {
            $.each(value, function(key1, value1) {
                
                if (key == 'state') {
                    $("#desktopstate").append(
                        "<div class='col-md-2 col-sm-6 col-lg-3 col-xs-6'><ul><li class='zoom'><a class='states1 ' href='#' onclick='return setState("+value1.id+");'>" +
                        value1.name + "</a></li></ul></div>");
                        $('#isstateshow').html("State");
                }
                if (key == 'city') {
                    $("#desktopcity").append(
                        "<div class='col-md-2 col-sm-6 col-lg-2 col-xs-6'><ul><li class='zoom'><a class='states1 ' href='#' onclick='return setCity("+value1.id+");'>" +
                        value1.name + "</a></li></ul></div>");
                        $('#iscityshow').html("City");
                }
                if (key == 'region') {
                    $("#desktopregion").append(
                        "<div class='col-md-2 col-sm-6 col-lg-2 col-xs-6'><ul><li class='zoom'><a class='states1 ' href='#' onclick='return setRegion("+value1.id+");'>" +
                        value1.name + "</a></li></ul></div>");
                        $('#isregionshow').html("Region");
                }
            });
        });
    }
});
}
</script>
</body>

</html>