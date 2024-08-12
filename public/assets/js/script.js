$(document).ready(function(){

    new Splide( '.slide-innov-main-slide', {
        type   : 'fade',
        autoplay: true,
        interval: 3000,
        speed: 1000,
        rewind: true,
        fixedWidth: '70%',
        heightRatio: 0.5,
        height: 'auto',
        pagination : false,
        arrows     : true,
        cover      : true,
    }).mount();
});

$(document).ready(function(){

$("input[name='txtSearch']").keyup(function() {
    // console.log($(this).val());
    var queries = $(this).val();
    $(".home-course-list").load("includes/load-search.php", {
        searchQuery: queries
    });
});

//  Show mobile menu on hamburger click
var btnHam = $("#hamburger-menu-icon");
$(btnHam).on({
    click: function() {
        $(this).toggleClass("open");
        $(".side-menu-canvas.mobile .menu-section").toggleClass("show");
        $(".mobile-header .mobile-header-canvas").toggleClass("active");
        $("body").toggleClass("disable-scroll");
        $("html").toggleClass("disable-scroll");
    }
});

// # add active to latest year in archives
var archiveLatestYear = $(".news-archives .section-news-year .nav-item:first-child .nav-link");
var archiveLatestTab = $(".news-archives .tab-content .tab-pane:first-child");
$(archiveLatestYear).addClass("active");
$(archiveLatestYear).attr("aria-selected","true");
$(archiveLatestTab).addClass("active show");

// # get sub-menu mobile's dropdown button of active link
var subMenuActive = $(".sub-menu-mobile .dropdown .dropdown-menu > a.active").text();
$(".sub-menu-mobile .dropdown > #dropdownMenuButton").text(subMenuActive);

// # disable image downloads for pages# ---
$('body').on('contextmenu', 'img', function(e){ 
    return false; 
});

// # sticky page sub-menu  for pages # ---
$(window).scroll(function(){
    if ($(window).scrollTop() >= 449) {
        $('.page-menu-items').addClass('fixed-menu');
    }
    else {
        $('.page-menu-items').removeClass('fixed-menu');
    }
});

$(window).scroll(function(){
    if($(window).scrollTop() + $(window).height() > $(document).height() - 300) {
        $('.page-menu-items').addClass('fixed-menu-hide');
        $('.page-menu-items').removeClass('fixed-menu-appear');
    }
    else {
        $('.page-menu-items').addClass('fixed-menu-appear');
        $('.page-menu-items').removeClass('fixed-menu-hide');
    }
});

// # sticky main menu # ---
var distance = $('.mobile-header .mobile-header-canvas').offset().top;
$(window).scroll(function(){
    if ($(window).scrollTop() >= distance) {
        $('.mobile-header .mobile-header-canvas').addClass('sticky-top');
    }
    else {
        $('.mobile-header .mobile-header-canvas').removeClass('sticky-top');
    }
});

// # tabs # ---

    // welcome tab list animation
    // setting waypoints
    // var i = 0;
    // $('.why-choose').waypoint(function() {
    //     $('.tab-active ul li').each(function() {
    //     setTimeout(function() {
    //         $('.tab-active ul li').css({
    //             animation: "slide-down .5s",
    //             opacity: "1"
    //         });
    //     }, i*500);
    //     i++; }) }, { 
    //         offset: '75%' 
    // });

    // why choose hover effect scale
    $(".wc-overlay").hover(
        function () {
            $(this).parent().find('img').addClass("scale-up");
            $(this).parent().find('.wc-icon').addClass("swipe-down");
        },
        function () {
            $(this).parent().find('img').removeClass("scale-up");
            $(this).parent().find('.wc-icon').removeClass("swipe-down");
        }
    );

    // college items hover effect scale
    $(".section-colleges .college-item").hover(
        function () {
            $(this).find('.image-wrapper img').addClass("scale-up");
        },
        function () {
            $(this).find('.image-wrapper img').removeClass("scale-up");
        }
    );

    var tabContName;

    // # welcome panel ---
    // show content when tab is clicked
    $(".tab-btn").click(function(){
        // get clicked tab associated content
        tabContName = $(this).attr("name");

        $('.tab-cont').not('#' + tabContName).removeClass('tab-active')
        $('#' + tabContName).addClass('tab-active')

        // add 'active' class to clicked tab
        // remove 'active' class to other tabs
        $('.tab-btn').not(this).removeClass('active')
        $(this).addClass('active')

        // welcome tab list animation
        // var i = 0;
        //     $('.tab-active ul li').each(function() {
        //     var _this = $(this);
        //     setTimeout(function() {
        //         _this.fadeIn();
        //     }, i*300);

        //     i++;
        // });
    });

    // hide all tab contents except the first one
    var firstTabCont = $('.tab-cont').attr('class').split(' ')[0];
    $(firstTabCont).toggleClass('tab-active').siblings().removeClass('tab-active');

    // # news panel ---
    // show content when research tab is clicked
    $(".news-tab-btn").click(function(){
        // get clicked tab associated content
        tabContName = $(this).attr("name");

        $('.news-box-cont').not('#' + tabContName).addClass('tab-pane')
    });


// # sliders # ---
    // slider options   
    new Splide( '.splide', {
        autoplay: true,
        interval: 5000,
        type   : 'fade',
        speed: 1000,
        rewind: true,
    }).mount();
    

    // university news slider options   
    new Splide( '.news-univ-splide', {
        type: 'loop',                   // use fade for fade effect; just set perPage: 0 and padding: 0
        direction: 'ttb',
        height: '27rem',            // height of actual slider
        autoHeight: true,
        // focus: 'center',
        // autoplay: true, 
        // interval: 5000,
        // speed: 1000,
    }).mount();


    // academic news slider options   
    new Splide( '.news-acad-splide', {
        type: 'loop',                   
        direction: 'ttb',
        height: '27rem',            
        autoHeight: true,
        // focus: 'center',
        // autoplay: true, 
        // interval: 5000,
        // speed: 1000,
    }).mount();


    // research news slider options   
    new Splide( '.news-research-splide', {
        type: 'loop',                 
        direction: 'ttb',
        height: '27rem',            
        autoHeight: true,
        // focus: 'center',
        // autoplay: true, 
        // interval: 5000,
        // speed: 1000,
    }).mount();


    // faculty and staff news slider options   
    new Splide( '.news-fns-splide', {
        type: 'loop',                  
        direction: 'ttb',
        height: '27rem',            
        autoHeight: true,
        // focus: 'center',
        // autoplay: true, 
        // interval: 5000,
        // speed: 1000,
    }).mount();

    // updates slider options   
    new Splide( '.updates-splide', {
        type: 'loop',                  
        direction: 'ttb',
        height: '27rem',       
        autoHeight: true, 
        // focus: 'center',
        // autoplay: true, 
        // interval: 5000,
        // speed: 1000,
    }).mount();
});