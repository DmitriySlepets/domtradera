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
                 jQuery("#main").html(html);
             }
         }
     });
 }
/**
 * ajax кнопка вверх
 */

jQuery(document).ready(function(){

    jQuery(window).scroll(function(){
        if ( jQuery(this).scrollTop() > 10) {
            jQuery('.scrollup1').fadeIn();
        } else {
            jQuery('.scrollup1').fadeOut();
        }
    });

    jQuery('.scrollup1').click(function(){
        jQuery("html, body").animate({ scrollTop: 0 }, 200);
        return false;
    });
});

//current tab id
window.onfocus = function(){
        $(window).scroll(function () {
            clearTimeout($("#auto_update").html());
            perem = setTimeout(function () {
                document.location.href = window.location.href;
            }, 1000);
            $("#auto_update").html(perem);
        });
    };
/**
 * ajax обновление главной страницы
 */
jQuery(document).ready(function(){
    var perem = setTimeout(function () {
        document.location.href = window.location.href;
    },300000);
    $("#auto_update").html(perem);
});
/*(function( jQuery ){

    jQuery.fn.fitText = function( kompressor, options ) {

        // Setup options
        var compressor = kompressor || 1,
            settings = jQuery.extend({
                'minFontSize' : Number.NEGATIVE_INFINITY,
                'maxFontSize' : Number.POSITIVE_INFINITY
            }, options);

        return this.each(function(){

            // Store the object
            var $this = jQuery(this);

            // Resizer() resizes items based on the object width divided by the compressor * 10
            var resizer = function () {
                jQuery.css('font-size', Math.max(Math.min(jQuery.width() / (compressor*10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
            };

            // Call once to set.
            resizer();

            // Call on resize. Opera debounces their resize by default.
            jQuery (window).on('#blogposts-list-content h2.entry-title a', resizer);

        });


    };

})( jQuery );*/
/*jQuery("#blogposts-list-content h2.entry-title a").resizer(jQuery);*/

(function( $ ){

    $.fn.slabText = function(options) {

        // Add the slabtexted classname to the body to initiate the styling of
        // the injected spans
        $("body").addClass("slabtexted");

        return this.each(function(){

            if(options) {
                $.extend(settings, options);
            };

            var $this               = $(this),
                self                = this,
                settings            = $.extend({}, $.fn.slabText.defaults, options),
                keepSpans           = $("a.slabtext", $this).length,
                words               = keepSpans ? [] : String($.trim($this.text())).replace(/\s{2,}/g, " ").split(" "),
                origFontSize        = null,
                idealCharPerLine    = null,
                resizeThrottle      = null,
                viewportWidth       = $(window).width(),
                headLink            = $this.find("a:first").attr("href") || $this.attr("href"),
                linkTitle           = headLink ? $this.find("a:first").attr("title") : "";

            if(!keepSpans && settings.minCharsPerLine && words.join(" ").length < settings.minCharsPerLine) {
                return;
            };

            // Calculates the pixel equivalent of 1em within the current header
            var grabPixelFontSize = function() {
                var dummy = jQuery('<div style="display:none;font-size:1em;margin:0;padding:0;height:auto;line-height:1;border:0;">&nbsp;</div>').appendTo($this),
                    emH   = dummy.height();
                dummy.remove();
                return emH;
            };

            // Most of this function is a (very) stripped down AS3 to JS port of
            // the slabtype algorithm by Eric Loyer with the original comments
            // left intact
            // http://erikloyer.com/index.php/blog/the_slabtype_algorithm_part_1_background/
            var resizeSlabs = function resizeSlabs() {

                // Cache the parent containers width
                var parentWidth = $this.width(),
                    fs;

                // Sanity check to prevent infinite loop
                if(parentWidth == 0) {
                    return;
                };

                // Remove the slabtextdone and slabtextinactive classnames to enable the inline-block shrink-wrap effect
                $this.removeClass("slabtextdone slabtextinactive");

                if(settings.viewportBreakpoint && settings.viewportBreakpoint > viewportWidth
                    ||
                    settings.headerBreakpoint && settings.headerBreakpoint > parentWidth) {
                    // Add the slabtextinactive classname to set the spans as inline
                    // and to reset the font-size to 1em (inherit won't work in IE6/7)
                    $this.addClass("slabtextinactive");
                    return;
                };

                fs = grabPixelFontSize();
                // If the parent containers font-size has changed or the "forceNewCharCount" option is true (the default),
                // then recalculate the "characters per line" count and re-render the inner spans
                // Setting "forceNewCharCount" to false will save CPU cycles...
                if(!keepSpans && (settings.forceNewCharCount || fs != origFontSize)) {

                    origFontSize = fs;

                    var newCharPerLine      = Math.min(60, Math.floor(parentWidth / (origFontSize * settings.fontRatio))),
                        wordIndex           = 0,
                        lineText            = [],
                        counter             = 0,
                        preText             = "",
                        postText            = "",
                        finalText           = "",
                        lineLength,
                        slice,
                        preDiff,
                        postDiff;

                    if(newCharPerLine != 0 && newCharPerLine != idealCharPerLine) {
                        idealCharPerLine = newCharPerLine;

                        while (wordIndex < words.length) {

                            postText = "";

                            // build two strings (preText and postText) word by word, with one
                            // string always one word behind the other, until
                            // the length of one string is less than the ideal number of characters
                            // per line, while the length of the other is greater than that ideal
                            while (postText.length < idealCharPerLine) {
                                preText   = postText;
                                postText += words[wordIndex] + " ";
                                if(++wordIndex >= words.length) {
                                    break;
                                };
                            };

                            // This bit hacks in a minimum characters per line test
                            // on the last line
                            if(settings.minCharsPerLine) {
                                slice = words.slice(wordIndex).join(" ");
                                if(slice.length < settings.minCharsPerLine) {
                                    postText += slice;
                                    preText = postText;
                                    wordIndex = words.length + 2;
                                };
                            };

                            // calculate the character difference between the two strings and the
                            // ideal number of characters per line
                            preDiff  = idealCharPerLine - preText.length;
                            postDiff = postText.length - idealCharPerLine;

                            // if the smaller string is closer to the length of the ideal than
                            // the longer string, and doesn’t contain less than minCharsPerLine
                            // characters, then use that one for the line
                            if((preDiff < postDiff) && (preText.length >= (settings.minCharsPerLine || 2))) {
                                finalText = preText;
                                wordIndex--;
                                // otherwise, use the longer string for the line
                            } else {
                                finalText = postText;
                            };

                            lineLength = $.trim(finalText).length;

                            // HTML-escape the text
                            finalText = $('<div/>').text(finalText).html()

                            // Wrap ampersands in spans with class `amp` for specific styling
                            if(settings.wrapAmpersand) {
                                finalText = finalText.replace(/&amp;/g, '<a class="amp">&amp;</a>');
                            };

                            finalText = $.trim(finalText);

                            lineText.push('<a class="slabtext slabtext-linesize-' + Math.floor(lineLength / 10) + ' slabtext-linelength-' + lineLength + '">' + finalText + "</a>");
                        };

                        $this.html(lineText.join(" "));
                        // If we have a headLink, add it back just inside our target, around all the slabText spans
                        if(headLink) {
                            $this.wrapInner('<a href="' + headLink + '" ' + (linkTitle ? 'title="' + linkTitle + '" ' : '') + '/>');
                        };
                    };
                } else {
                    // We only need the font-size for the resize-to-fit functionality
                    // if not injecting the spans
                    origFontSize = fs;
                };

                $("a.slabtext", $this).each(function() {
                    var $a       = $(this),
                        innerText   = $a.text(),
                        wordSpacing = innerText.split(" ").length > 1,
                        diff,
                        ratio,
                        fontSize;

                    if(settings.postTweak) {
                        $a.css({
                            "word-spacing":0,
                            "letter-spacing":0
                        });
                    };

                    ratio    = parentWidth / $a.width();
                    fontSize = parseFloat(this.style.fontSize) || origFontSize;

                    $a.css("font-size", Math.min((fontSize * ratio).toFixed(settings.precision), settings.maxFontSize) + "px");

                    // Do we still have space to try to fill or crop
                    diff = !!settings.postTweak ? parentWidth - $a.width() : false;

                    // A "dumb" tweak in the blind hope that the browser will
                    // resize the text to better fit the available space.
                    // Better "dumb" and fast...
                    if(diff) {
                        $a.css((wordSpacing ? 'word' : 'letter') + '-spacing', (diff / (wordSpacing ? innerText.split(" ").length - 1 : innerText.length)).toFixed(settings.precision) + "px");
                    };
                });

                // Add the class slabtextdone to set a display:block on the child spans
                // and avoid styling & layout issues associated with inline-block
                $this.addClass("slabtextdone");

                // Fire the callback if required
                if(typeof settings.onRender == 'function') {
                    settings.onRender.call(self);
                };
            };

            // Immediate resize
            resizeSlabs();

            if(!settings.noResizeEvent) {
                $(window).resize(function() {
                    // Only run the resize code if the viewport width has changed.
                    // we ignore the viewport height as it will be constantly changing.
                    if($(window).width() == viewportWidth) {
                        return;
                    };

                    viewportWidth = $(window).width();

                    clearTimeout(resizeThrottle);
                    resizeThrottle = setTimeout(resizeSlabs, settings.resizeThrottleTime);
                });
            };
        });
    };

    $.fn.slabText.defaults = {
        // The ratio used when calculating the characters per line
        // (parent width / (font-size * fontRatio)).
        "fontRatio"             : 0.78,
        // Always recalculate the characters per line, not just when the
        // font-size changes? Defaults to true (CPU intensive)
        "forceNewCharCount"     : true,
        // Do we wrap ampersands in <span class="amp">
        "wrapAmpersand"         : true,
        // Under what pixel width do we remove the slabtext styling?
        "headerBreakpoint"      : null,
        "viewportBreakpoint"    : null,
        // Don't attach a resize event
        "noResizeEvent"         : false,
        // By many milliseconds do we throttle the resize event
        "resizeThrottleTime"    : 300,
        // The maximum pixel font size the script can set
        "maxFontSize"           : 999,
        // Do we try to tweak the letter-spacing or word-spacing?
        "postTweak"             : true,
        // Decimal precision to use when setting CSS values
        "precision"             : 3,
        // The min num of chars a line has to contain
        "minCharsPerLine"       : 0,
        // Callback function fired after the headline is redrawn
        "onRender"              : null
    };

})(jQuery);





