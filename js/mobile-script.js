jQuery(document).ready(function() {
    jQuery("#menu_main_btn").click(function(){
        if(jQuery(this).hasClass("active")){
            jQuery(this).removeClass("active");
            jQuery("#header_main_mobile #curtain").removeClass("active");
            jQuery("#header_main_mobile #menu_main").removeClass("active");
        }else{
            jQuery(this).addClass("active");
            jQuery("#header_main_mobile #curtain").addClass("active");
            jQuery("#header_main_mobile #menu_main").addClass("active");
        }
    });
    jQuery("#curtain").click(function(){
        jQuery("#menu_main_btn").removeClass("active");
        jQuery("#header_main_mobile #curtain").removeClass("active");
        jQuery("#header_main_mobile #menu_main").removeClass("active");
    });
    jQuery("#header_main_mobile #search #search_btn").click(function(){
        if(!jQuery(this).parent().hasClass("active")){
            jQuery(this).parent().addClass("active");
            jQuery("#header_main_mobile #search #search_close").attr("style","display:inherit;");
        }
    });
    jQuery("#header_main_mobile #search #search_close").click(function(){
        if(jQuery(this).parent().hasClass("active")){
            jQuery(this).parent().removeClass("active");
            jQuery(this).removeAttr("style");
        }
    });
    jQuery('#search_input').keydown(function(event){
        if(event.keyCode==13){
            //alert(1);
            document.location.href = "http://domtradera.ru/?s=" + jQuery('#search_input').val();
            return false;
        }
    });
});

/**
 * ajax обновление главной страницы мобильнойверсии
 */
jQuery(document).ready(function(){
     setInterval('show()',300000);
 });
 function show() {
     jQuery.ajax({
         url: "/wp-content/themes/newspaperly/ajax/get_news_main.php",
         cache: false,
         type: "post",
         success: function(html){
             if(html != "null"){
                 //alert(1);
                 $("#main").html(html);
             }
         }
     });
 }
/**
 * ajax кнопка вверх
 */

jQuery(document).ready(function(){

    $(window).scroll(function(){
        if ($(this).scrollTop() > 10) {
            $('.scrollup1').fadeIn();
        } else {
            $('.scrollup1').fadeOut();
        }
    });

    $('.scrollup1').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 200);
        return false;
    });

});

jQuery(document).ready(function () {
    //windowSizeMain();
    //windowSizePI();
    fontSize();
    /*jQuery(window).resize(function() {
        windowSizeMain();
        windowSizePI();
    });*/
});

jQuery ($('.blogposts-list-content h2.entry-title a').each(function(){
    var fontSize = 8;
    var rowHeight = $(this).height();
    while(rowHeight<60){
        fontSize=fontSize+1;
        $(this).css({fontSize: fontSize+'px'});
        rowHeight = $(this).height();
    }
}))
       // var width = $('.blogposts-list-content h2.entry-title a').width(); // ширина, от которой идет отсчет
      //  var fontSize = 12; // минимальный размер шрифта
       // var bodyWidth = $('.blogposts-list-content h2.entry-title').width();
      //  var multiplier = bodyWidth / width;
       // if ($('.blogposts-list-content h2.entry-title').width() >= width) {
       //     fontSize = fontSize * multiplier;
       //     $('.blogposts-list-content h2.entry-title a').css({fontSize: fontSize + 'px'});
       // }
   // });
;