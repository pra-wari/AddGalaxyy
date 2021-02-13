// JavaScript Document
$(function() {
 "use strict";

  function responsive_dropdown () {
    /* ---- For Mobile Menu Dropdown JS Start ---- */
      $('#menu span.opener').on("click", function() {
        var menuopener = $(this);
        if (menuopener.hasClass("plus")) {
          menuopener.parent().find('.mobile-sub-menu').slideDown();
          menuopener.removeClass('plus');
          menuopener.addClass('minus');
        }
        else
        {
          menuopener.parent().find('.mobile-sub-menu').slideUp();
          menuopener.removeClass('minus');
          menuopener.addClass('plus');
        }
        return false;
      });
    /* ---- For Mobile Menu Dropdown JS End ---- */
    /* ---- For Sidebar JS Start ---- */
      $('.sidebar-box span.opener').on("click", function(){
        var sidebaropener = $(this);
        if (sidebaropener.hasClass("plus")) {
          sidebaropener.parent().find('.sidebar-contant').slideDown();
          sidebaropener.removeClass('plus');
          sidebaropener.addClass('minus');
        }
        else
        {
          sidebaropener.parent().find('.sidebar-contant').slideUp();
          sidebaropener.removeClass('minus');
          sidebaropener.addClass('plus');
        }
        return false;
      });
    /* ---- For Sidebar JS End ---- */
    /* ---- For Footer JS Start ---- */
      $('.footer-static-block span.opener').on("click", function(){
        var footeropener = $(this);
        if (footeropener.hasClass("plus")) {
          footeropener.parent().find('.footer-block-contant').slideDown();
          footeropener.removeClass('plus');
          footeropener.addClass('minus');
        }
        else
        {
          footeropener.parent().find('.footer-block-contant').slideUp();
          footeropener.removeClass('minus');
          footeropener.addClass('plus');
        }
        return false;
      });
    /* ---- For Footer JS End ---- */

    /* ---- For category-dropdown JS Start ---- */
      $('.category-list span.opener').on("click", function(){
        var categoryopener = $(this);
        if (categoryopener.hasClass("plus")) {
          categoryopener.parent().find('.category-block-contant').slideDown();
          categoryopener.removeClass('plus');
          categoryopener.addClass('minus');
        }
        else
        {
          categoryopener.parent().find('.category-block-contant').slideUp();
          categoryopener.removeClass('minus');
          categoryopener.addClass('plus');
        }
        return false;
      });
    /* ---- For category-dropdown JS End ---- */

    /*---Mobile menu icon Start---*/
    $('.navbar-toggle').on("click", function(){
      var menu_id = $('#menu');
      var nav_icon = $('.navbar-toggle i');
      if(menu_id.hasClass('menu-open')){
        menu_id.removeClass('menu-open');
        nav_icon.removeClass('fa-close');
        nav_icon.addClass('fa-bars');
      }else{
        menu_id.addClass('menu-open');
        nav_icon.addClass('fa-close');
        nav_icon.removeClass('fa-bars');
      }
    });
    /*---Mobile menu icon End---*/
  }

  
  function search_open () {
    /* ----- Search open close Start  ------ */
    $('.search-opener').on("click", function(){
      var topsearch = $('.top-search-bar');
      if(topsearch.hasClass('open')){
        topsearch.removeClass('open');
      }else{
        topsearch.addClass('open');
      }
    });
    /* ----- Search open close Start  ------ */
  }

  function owlcarousel_slider () {
    /* ------------ OWL Slider Start  ------------- */

      // Sub category
      


      /* ----- pro_cat_slider Start  ------ */
        $('.pro_cat_slider').owlCarousel({
            
            onInitialize : function(element){
            owl.children().sort(function(){
                return Math.round(Math.random()) - 0.5;
            }).each(function(){
                $(this).appendTo($('.pro_cat_slider'));
            });
        },
          loop:true,
          items: 5,
          slideTransition: 'linear',
          navigation: true,
          pagination: false,
          rewindNav:true,
          rewindSpeed : 0,
          checkVisibility: true,
          lazyLoad:false,
          itemsDesktop : [1199, 4],
          itemsDesktopSmall : [991, 3],
          itemsTablet : [768, 2],
          itemsTabletSmall : false,
          itemsMobile : [419, 1],
          autoPlay:4000,
          
        });
        $('.product-slider-view-1').owlCarousel({
          items: 5,
          navigation: true,
          pagination: false,
          loop:true,
          rewindNav:false,
          itemsDesktop : [1199, 4],
          itemsDesktopSmall : [991, 3],
          itemsTablet : [768, 2],
          itemsTabletSmall : false,
          itemsMobile : [419, 4],
          autoPlay:4000,
          
        });
      /* ----- pro_cat_slider End  ------ */

      /* ----- pro_cat_slider Start  ------ */
        $('.product-slider-sidebar').owlCarousel({
          items: 1,
          navigation: true,
          pagination: false,
          itemsDesktop : [1199, 1],
          itemsDesktopSmall : [991, 1],
          itemsTablet : [768, 1],
          itemsTabletSmall : false,
          itemsMobile : [419, 1]
        });
      /* ----- pro_cat_slider End  ------ */

      /* ----- best-seller-pro Start  ------ */
        $('.best-seller-pro').owlCarousel({
          items: 2,
          navigation: true,
          pagination: false,
          itemsDesktop : [1199, 2],
          itemsDesktopSmall : [991, 1],
          itemsTablet : [767, 2],
          itemsTabletSmall : false,
          itemsMobile : [450, 1]
        });
      /* ----- best-seller-pro End  ------ */

      /* ----- blog_slider Start  ------ */
        $('.blog_slider').owlCarousel({
          items: 3,
          navigation: true,
          pagination: false,
          itemsDesktop : [1199, 3],
          itemsDesktopSmall : [991, 2],
          itemsTablet : [768, 2],
          itemsTabletSmall : false,
          itemsMobile : [419, 1]
        });
      /* ----- blog_slider End  ------ */

      /* ----- brand-logo Start  ------ */
        $('#brand-logo').owlCarousel({
      	  items: 5,
      	  navigation: true,
      	  pagination: false,
      	  itemsDesktop : [1199, 3],
      	  itemsDesktopSmall : [991, 3],
      	  itemsTablet : [768, 2],
      	  itemsTabletSmall : false,
      	  itemsMobile : [479, 1]
      	});
      /* ----- brand-logo End  ------ */

      /* ---- Testimonial Start ---- */
        $("#client, .main-banner").owlCarousel({
       
          //navigation : true,  Show next and prev buttons
          slideSpeed : 300,
          paginationSpeed : 400,
          autoPlay: false,
          pagination:false,
          singleItem:true,
          navigation:true
        });
      /* ----- Testimonial End  ------ */

    /* ------------ OWL Slider End  ------------- */
  }

  function scrolltop_arrow () {
   /* ---- Page Scrollup JS Start ---- */
   //When distance from top = 250px fade button in/out
    $(window).scroll(function(){
        var scrollup = $('#scrollup');
        if ($(this).scrollTop() > 250) {
            scrollup.fadeIn(300);
        } else {
            scrollup.fadeOut(300);
        }
    });
    //On click scroll to top of page t = 1000ms
    $('#scrollup').on("click", function(){
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });
    /* ---- Page Scrollup JS End ---- */
  }


   function custom_tab() {
   /* ----------- product category Tab Start  ------------ */
    $('.tab-stap').on('click', 'li', function() {
        $('.tab-stap li').removeClass('active');
        $(this).addClass('active');
        
        $(".product-slider-main").fadeOut();
        var currentLiID = $(this).attr('id');
        $("#data-"+currentLiID).fadeIn();
        return false;
    });
    /* ------------ product category Tab End  ------------ */
    /* ------------ Account Tab JS Start ------------ */
    $('.account-tab-stap').on('click', 'li', function() {
        $('.account-tab-stap li').removeClass('active');
        $(this).addClass('active');
       
        $(".account-content").fadeOut();
        var currentLiID = $(this).attr('id');
        $("#data-"+currentLiID).fadeIn();

        return false;
    });
    /* ------------ Account Tab JS End ------------ */
    /* ------------ checkout-step Tab JS Start ------------ */
    $('.checkout-tab-stap').on('click', 'li', function() {
        $('.checkout-tab-stap li').removeClass('active');
        $(this).addClass('active');
        
        $(".checkout-content").fadeOut();
        var currentLiID = $(this).attr('id');
        $("#data-"+currentLiID).fadeIn();
    });
    /* ------------ checkout-step Tab JS End ------------ */
  }

    function setminheight(){
        $( ".pro_cat" ).css("min-height",$(".product-slider-main").height() );
        $( ".pro-detail-main" ).css("min-height",$(".special-products-block").height() );
    }

    /* Price-range Js Start */
  function price_range () {
      var amount = $("#amount");
      var sliderrange = $("#slider-range");
      sliderrange.slider({
      range: true,
      min: 0,
      max: 100000,
      values: [ val1, val2 ],
      slide: function( event, ui ) {
      amount.val( "₹" + ui.values[ 0 ] + " - ₹" + ui.values[ 1 ] );
      }
      });
      amount.val( "₹" + sliderrange.slider( "values", 0 ) +
      " - ₹" + sliderrange.slider( "values", 1 ) );
  }
    /* Price-range Js End */

    /*Select Menu Js Start*/
    function option_drop() {
      function matchStart (term, text) {
        if (text.toUpperCase().indexOf(term.toUpperCase()) == 0) {
          return true;
        }
       
        return false;
      }
       
      $.fn.select2.amd.require(['select2/compat/matcher'], function (oldMatcher) {
        $(".option-drop").select2({
          matcher: oldMatcher(matchStart)
        })
      });
    }
    /*Select Menu Js Ends*/


    /* Product Detail Page Tab JS Start */
  function description_tab () {
    $("#tabs li a").on("click", function(e){
      var title = $(e.currentTarget).attr("title");
      $("#tabs li a").removeClass("selected")
      $(".tab_content li div").removeClass("selected")
      $(".tab-"+title).addClass("selected")
      $(".items-"+title).addClass("selected")
      $("#items").attr("class","tab-"+title);

      return false;
    });
  }
    /* Product Detail Page Tab JS End */

  $(document).on("ready", function() {
    owlcarousel_slider (); responsive_dropdown (); price_range (); description_tab (); scrolltop_arrow (); setminheight(); custom_tab (); search_open (); option_drop();
  });

  $( window ).on( "resize", function() {
    setminheight();
  });
});

  $( window ).on( "load", function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");
  });

  $(document).ready(function(){
    $('#myModal1').on('hidden.bs.modal', function () {
      window.location.reload();
    });
  });