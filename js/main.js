$(document).ready(function(){
 
  navEffects();
  ingredientsEffects();
  fadingBanner();

  function navEffects(){
    var headerHeight = $('header').outerHeight(),
        mobileNav = $('.mobile-nav');

    tabbing();
    // NAV BAR DROPDOWN
    $('.dropdown').hover(
      function(){
          $(this).children('.sub-menu').stop(true,true).slideDown(200);
      },
      function(){
        $(this).children('.sub-menu').slideUp(200);
      }
    );
 
    // STICKY NAV
    setHeaderStick = function() {
      var windowScrollPosition = $(this).scrollTop(),
          marginToScroll = headerHeight/2;

      if (windowScrollPosition > marginToScroll ) {
        $('header').addClass('stick');
        $('body').css('margin-top', headerHeight);
      }
    
      if (windowScrollPosition < marginToScroll) {
        $('header').removeClass('stick');
        $('body').css('margin-top', 0);
      }
    }

    setHeaderStick();

    $( window ).resize(function() {
      headerHeight = $('header').outerHeight();
    });

    $(window).scroll(function(){
      setHeaderStick();
    });
   
  //Mobile Menu controls
    function tabbing(){
      var mobileMenu = $('.mobile-menu'),
          currentOpen = "",
          overlay = "<div class='mobile-overlay'></div>",
          menuWidth = mobileMenu.outerWidth();

      mobileMenu.css('margin-right', -menuWidth);
      $('.menu-btn').click(function(){
        $('body').css('overflow', 'hidden');
        menuWidth = mobileMenu.outerWidth();
        mobileMenu.css('margin-right', -menuWidth);
        mobileMenu.fadeIn(50);
        mobileMenu.css('margin-right', '0px');
        $('header').append(overlay);
      });
     
      mobileMenu.on('click','.close-btn' ,function(){
        $('body').css('overflow', 'visible');
        mobileMenu.css('margin-right', -menuWidth);
        mobileMenu.fadeOut(300);
        $('.mobile-overlay').remove();
      });
      $links =  $('.mobile-links').find('a');
      $links.click(function(e){
        $this = $(this).parent();
        $subMenu = $this.find('.sub-menu');
        if($subMenu.length > 0){
          if(currentOpen[0] != $subMenu[0] && currentOpen){
            currentOpen.stop(true,true).slideUp(300);
            currentOpen = "";
          }
          if(currentOpen[0] == $subMenu[0]){
            currentOpen.stop(true,true).slideUp(300);
            currentOpen = "";
          }else{
            $subMenu.stop(true,true).slideDown(300);
            currentOpen = $subMenu;
          }
        }
      });
    }
  }

  function fadingBanner(){
    var slide = $('.sliding-banner'),
        length = slide.length,
        count = 0;
    
    setInterval(function () {
      slide.eq(count).fadeOut(1000);
      count >= length-1 ? count = 0 : count++;
      slide.eq(count).fadeIn(1000);
    }, 5000)

  }

  $(".selection").on('change','.language',function(e){
    value = $(".language option:selected").val();
    window.location.href = value;
  });//end click 

  // PRODUCT TABS
  $('ul.product-tabs li:first').addClass('active').show(); 

  $('.tab-content:first').show(); 
 
  $('ul.product-tabs li').click(function() {
    $('ul.product-tabs li').removeClass('active'); 
    $(this).addClass('active'); 
    $('.tab-content').hide(); 

    var activeTab = $(this).find('a').attr('href'); 
    $(activeTab).fadeIn(); 
    return false;
  });
  
  function ingredientsEffects(){
    var $ingredients = $('.ingredient'),
        $currentOpen = $ingredients.first(),
        $sortLinks = $('.sort');
     $currentOpen.addClass('active');
    $currentOpen.children('.content').slideDown();

    // intialize();
    // INGREDIENTS ACCORDIANS
    $sortLinks.click(function(){
      var data = $(this).data('tag');
      showCurrent(data);
    });

    function showCurrent(tag){
      var data = tag.toString().toLowerCase();
      $ingredients.hide();
      $ingredients.each(function(){

        ingred = $(this);
        var str = ingred.data('tag').toString().toLowerCase();
        if(data.indexOf(str) > -1){
          ingred.fadeIn();
        }
      });
    }
    $ingredients.click(function(){
      clicked = $(this);
      
      if($currentOpen == "none"){
        clicked.children('.content').slideDown();
        $currentOpen = clicked;
        $currentOpen.addClass('active');

      }else if($currentOpen[0] == clicked[0]){
        $currentOpen.children('.content').slideUp();
        $currentOpen.removeClass('active');
        $currentOpen ="none";
      }else{
         $currentOpen.children('.content').slideUp();
         $currentOpen.removeClass('active');
         clicked.children('.content').slideDown();
         $currentOpen = clicked;
         $currentOpen.addClass('active');
      }
    });
  }


  // TESTIMONIALS MASONRY
  $('.testimonials .grid').masonry({
    itemSelector: '.testimonial-item',
      "gutter": 50
  });



  /* Thanks to CSS Tricks for pointing out this bit of jQuery
  http://css-tricks.com/equal-height-blocks-in-rows/
  It's been modified into a function called at page load and then each time the page is resized. One large modification was to remove the set height before each new calculation. */

  equalheight = function(container){

  var currentTallest = 0,
       currentRowStart = 0,
       rowDivs = new Array(),
       $el,
       topPosition = 0;
     $(container).each(function() {

     $el = $(this);
     $($el).height('auto')
     topPostion = $el.position().top;

     if (currentRowStart != topPostion) {
       for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
         rowDivs[currentDiv].height(currentTallest);
       }
       rowDivs.length = 0; // empty the array
       currentRowStart = topPostion;
       currentTallest = $el.height();
       rowDivs.push($el);
     } else {
       rowDivs.push($el);
       currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
    }
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
   });
  }

  $(window).load(function() {
    equalheight('.product-teaser , .media-teaser');
  });


  $(window).resize(function(){
    equalheight('.product-teaser , .media-teaser');
  });
});