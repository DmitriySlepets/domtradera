<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newspaperly
 */
?>
</div>

<?php
if($_SERVER['REQUEST_URI'] != '/' && strpos($_SERVER['REQUEST_URI'],'page')==false){
    echo '<h1 class="entry-title" style="padding-top: 10px;background-color: #fff;margin-bottom: 0px;">Читайте также:</h1>';
    $detect = get_mobile_detect();
    if ($detect->isMobile()){
        echo do_shortcode("[the-post-grid id='45806']");
    }
    else{
        echo do_shortcode("[post_grid id='894']");
    }
}elseif($_SERVER['REQUEST_URI'] == '/'){
    ?>
    <script>
        /**
         * ajax обновление главной страницы
         */
        jQuery(document).ready(function(){
            var perem = setTimeout(function () {
                document.location.href = window.location.href;
            },300000);
            $("#auto_update").html(perem);
        });

    </script>
    <?php
}
?>

</div>
</div><!-- #content -->

<script>
    var elem = document.getElementsByClassName("text")[0];
    if (elem != undefined) {
        var parent = elem.parentNode;
        if (parent != undefined){
            var id = parent.id;
            if(id == "imgCarousel"){
                document.getElementsByClassName("text")[0].style.display = "none";
            }
        }
    }
</script>

<style>
    .post-grid .pagination {
        clear: both !important;
        line-height: normal;
        margin: 30px 0;
        text-align: center;
        display: none;
    }
    .tooltip_witstroom{
        display:none;
    }

</style>
<!--
<div id="marketing" class="yandex-cotext" style="height: auto;">
    <div id="yandex_rtb_R-A-291518-1"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-291518-1",
                    renderTo: "yandex_rtb_R-A-291518-1",
                    async: true
                });
            });
            t = d.getElementsByTagName("script")[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "//an.yandex.ru/system/context.js";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(this, this.document, "yandexContextAsyncCallbacks");
    </script>
</div>
-->
<div class="content-wrap" style="width:100%;max-width: 100%;">

    <footer id="colophon" class="site-footer clearfix">

        <?php if ( is_active_sidebar( 'footerwidget-1' ) ) : ?>
        <div class="footer-column-wrapper">
            <div class="footer-column-three footer-column-left">
                <?php dynamic_sidebar( 'footerwidget-1' ); ?>
            </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footerwidget-2' ) ) : ?>
                <div class="footer-column-three footer-column-middle">
                    <?php dynamic_sidebar( 'footerwidget-2' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footerwidget-3' ) ) : ?>
                <div class="footer-column-three footer-column-right">
                    <?php dynamic_sidebar( 'footerwidget-3' ); ?>
                </div>
            <?php endif; ?>
            <div class="site-info">
                &copy;<?php echo esc_html(date_i18n(__('Y','newspaperly'))); ?> <?php bloginfo( 'name' ); ?>

                <!-- Delete below lines to remove copyright from footer -->
                <span class="footer-info-right">

				</span>
                <!-- Delete above lines to remove copyright from footer -->

            </div>
        </div>
    </footer><!-- #colophon -->
</div>

</div><!-- #page -->



<div id="smobile-menu" class="mobile-only"></div>
<div id="mobile-menu-overlay"></div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter50084320 = new Ya.Metrika2({
                    id:50084320,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/50084320" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-124569881-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-124569881-1');
</script>

<?php wp_footer(); ?>
<div class="visual_counters">
    <script type="text/javascript" async src="https://scripts.witstroom.com/watch/238"></script>
    <script id="witstroom_informer" type="text/javascript" async src="https://scripts.witstroom.com/informer/238"></script>
    <!--LiveInternet counter-->
    <script type="text/javascript">
        document.write("<a href='//www.liveinternet.ru/click' "+ "target=_blank><img src='//counter.yadro.ru/hit?t22.6;r"+ escape(document.referrer)+((typeof(screen)=="undefined")?"": ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
            screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+ ";h"+escape(document.title.substring(0,150))+";"+Math.random()+ "' alt='' title='LiveInternet: показано число просмотров за 24"+
            " часа, посетителей за 24 часа и за сегодня' "+ "border='0' width='88' height='31'><\/a>")
    </script>
    <!--/LiveInternet-->
    <!-- Top100 (Kraken) Widget -->
    <span id="top100_widget"></span>
    <!-- END Top100 (Kraken) Widget -->

    <!-- Top100 (Kraken) Widget -->
    <span id="top100_widget"></span>
    <!-- END Top100 (Kraken) Widget -->

    <!-- Top100 (Kraken) Widget -->
    <span id="top100_widget"></span>
    <!-- END Top100 (Kraken) Widget -->

    <!-- Top100 (Kraken) Counter -->
    <script>
        (function (w, d, c) {
            (w[c] = w[c] || []).push(function() {
                var options = {
                    project: 6452208,
                    element: 'top100_widget',
                };
                try {
                    w.top100Counter = new top100(options);
                } catch(e) { }
            });
            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src =
                (d.location.protocol == "https:" ? "https:" : "http:") +
                "//st.top100.ru/top100/top100.js";
            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(window, document, "_top100q");
    </script>
    <noscript>
        <img src="//counter.rambler.ru/top100.cnt?pid=6452208" alt="Топ-100" />
    </noscript>
    <!-- END Top100 (Kraken) Counter -->

    <!-- Rating@Mail.ru counter -->
    <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({id: "3071834", type: "pageView", start: (new Date()).getTime()});
        (function (d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
            if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
        })(document, window, "topmailru-code");
    </script><noscript><div>
            <img src="https://top-fwz1.mail.ru/counter?id=3071834;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
        </div></noscript>
    <!-- //Rating@Mail.ru counter -->
    <!-- Rating@Mail.ru logo -->
    <a href="https://top.mail.ru/jump?from=3071834">
        <img src="https://top-fwz1.mail.ru/counter?id=3071834;t=479;l=1" style="border:0;" height="31" width="88" alt="Top.Mail.Ru" /></a>
    <!-- //Rating@Mail.ru logo -->
    <!--Яндекс Икс-->
    <a href="https://webmaster.yandex.ru/sqi?host=domtradera.ru"><img width="88" height="31" alt="" border="0" src="https://yandex.ru/cycounter?domtradera.ru&theme=light&lang=ru"/></a>
    <!--/Яндекс Икс-->

    <!-- Yandex.Metrika informer -->
    <a href="https://metrika.yandex.ru/stat/?id=51650093&amp;from=informer"
       target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/51650093/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                                           style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="51650093" data-lang="ru" /></a>
    <!-- /Yandex.Metrika informer -->
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym(51650093, "init", {
            id:51650093,
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/51650093" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</div>
<div id="auto_update" style="display: none"></div>
<a href="#" class="scrollup">Наверх</a>
<script type="text/javascript">
    $(document).ready(function(){
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
    });
</script>
</body>
</html>