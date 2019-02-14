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
 * ajax обновление главной страницы
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
$(window).scroll(function(){
    if ($(this).scrollTop() > 10) {
        $('.scrollup').fadeIn();
    } else {
        $('.scrollup').fadeOut();
    }
});

$('.scrollup').click(function(){
    $("html, body").animate({ scrollTop: 0 }, 200);
    return false;
});