
// set menu list fixed height dynamically
var wheight = $(window).outerHeight() ,
header_height = $(".navbar").innerHeight() ; 
$(".menu").height( wheight - header_height )  ; 
$(".data").height( wheight - header_height )  ; 



function re_size_page(){
    // Justify Slider Height
    var wheight = $(window).outerHeight() ,
        header_height = $(".navbar").innerHeight() ; 
    $(".menu").height( wheight - header_height ) ; 
    $(".data").height( wheight - header_height )  ; 
    console.log(header_height) ; 
}

// show/hide category items
$(".category-dropdown-icon").each(function(){
    $(this).on("click", function(){
        
        $(this).toggleClass("fa-rotate-90") ; 
        let target = $(this).data("target") ; 
        $("#"+target).slideToggle("fast") ; 
    });
});

