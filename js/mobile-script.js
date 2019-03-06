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


/*jQuery(document).ready(function(){
    $text.length = $(".blogposts-list-content h2.entry-title a");

    if($text.length <= 10) newWidth = 16;
    else  newWidth = ($text.length*16)/250;

    $('.blogposts-list-content h2.entry-title a').css('font-size',newWidth+'px'+'!important');
});*/
/*function resize(block){
    block.css({
        'transform-origin': '0 0',
        'transform': 'scaleX(1) scaleY(1)'
    });
    var parent = block.parent(),
        block_width = block.outerWidth(),
        block_height = block.outerHeight(),
        parent_width = parent.width(),
        parent_height = parent.height(),
        coeffX = parent_width / block_width,
        coeffY = parent_height / block_height;

    block.css({
        'transform-origin': '0 0',
        'transform': 'scaleX('+coeffX+') scaleY('+coeffY+')'
    });

}
resize($('.entry-title'));
jQuery(document).ready(function(){
$(window).on('resize', function(){
    resize($('.entry-title'));
});
});

$('.resizable').resizable();
*/


if( jQuery().flowtype ){
    $("#entry-title a").flowtype('minimum : 500,\n' +
        ' maximum : 1200'+'fontRatio : 30'+'minFont : 12'+'maxFont : 40');
}
