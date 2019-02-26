<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newspaperly
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="keywords" content="<?php echo getKeywords(); ?>" />
	<?php wp_head(); ?>
	<script type="text/javascript" async src="https://scripts.witstroom.com/check/238"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>	
    <meta name="yandex-verification" content="2669e8c2cd6a4531" />
	<meta name="yandex-verification" content="f99435f4173340a1" />
    <?php if($_SERVER['REQUEST_URI'] != '/' && strpos($_SERVER['REQUEST_URI'],'page')==false){?>
        <meta property="og:image" content="<?php echo get_post_first_image_src(); ?>">
    <?php }else{ ?>
        <meta property="og:image" content="http://domtradera.ru/wp-content/uploads/2018/09/cropped-logo_main.png">
    <?php } ?>
    <script src="//wp-content/themes/newspaperly/js/common.new.v18.js"></script>
    <script>
          jQuery(document).ready(function () {
            windowSizeMain();
            windowSizePI();
            /*jQuery(window).resize(function() {
                windowSizeMain();
                windowSizePI();
            });*/
        });
        function windowSizeMain(){
            if (jQuery(window).width() <= '992'){
                jQuery('.blogposts-list-content h2.entry-title a').each(function() {
                    var heightTitleA = jQuery(this).height();
                    var widthTitleA = jQuery(this).width();
                    if (heightTitleA < 80) {
                        var coeff_width = widthTitleA/ heightTitleA;
                        if(coeff_width>2.5){
                            coeff_width = 2
                        }
                        var sizeFont = coeff_width * 11;
                        if(sizeFont>0){
                            sizeFont = sizeFont * 0.9;
                        }
                        var lineHeight = sizeFont;
                        if(lineHeight<11){
                            lineHeight = 11;
                        }
                        jQuery(this).attr("style","font-size:"+sizeFont + "px !important;line-height:" + lineHeight + "px");
                    }/*else{
                        jQuery(this).attr("style","font-size:"+sizeFont + "px !important;line-height:" + lineHeight + "px");
                    }*/
                });
            }else{
                jQuery('.blogposts-list-content h2.entry-title a').each(function() {
                    jQuery(this).removeAttr("style");
                });
            }
        }
        function windowSizePI() {
            jQuery('.grid-items .element.element_0.title a').each(function() {
                var heightTitleA = jQuery(this).height();
                var widthTitleA = jQuery(this).width();
                if (heightTitleA < 80) {
                    var coeff_width = widthTitleA / heightTitleA;
                    if(coeff_width>2.5){
                        coeff_width = 2
                    }
                    var sizeFont = coeff_width * 11;
                    if(sizeFont>0){
                        sizeFont = sizeFont*0.9;
                    }
                    var lineHeight = sizeFont;
                    if(lineHeight<11){
                        lineHeight = 11;
                    }
                    jQuery(this).css("font-size", sizeFont + "px");
                    jQuery(this).css("line-height", lineHeight + "px");
                }
            });
        }
    </script>
    <?php
    /*require_once 'lib/mobile-detect/Mobile_Detect.php'; // Подключаем скрипт
    $detect = new Mobile_Detect; // Создаём экземпляр класса
    if( $detect->isTablet() ) {
        echo "<link rel='stylesheet' id='newspaperly-style-css'  href='http://domtradera.ru/wp-content/themes/newspaperly/css/tablet-style.css' type='text/css' media='all' />";
        //echo '<h1>tablet</h1>';
    }elseif( $detect->isiPad() ) {
        echo "<link rel='stylesheet' id='newspaperly-style-css'  href='http://domtradera.ru/wp-content/themes/newspaperly/css/tablet-style.css' type='text/css' media='all' />";
        //echo '<h1>tablet</h1>';
    }elseif( $detect->isMobile()){
        echo "<link rel='stylesheet' id='newspaperly-style-css'  href='http://domtradera.ru/wp-content/themes/newspaperly/css/mobile-style.css' type='text/css' media='all' />";
        echo "<script type='text/javascript' src='http://domtradera.ru/wp-content/themes/newspaperly/js/mobile-script.js'></script>";
        //echo '<h1>mobile</h1>';
    }
    */
    ?>
</head>

<body <?php body_class(); ?>>
	 <div id="lenta" style="display: none">2</div>
    <?php //getStyleForDevice(); ?>
	<div id="page" class="site">
		<header id="masthead" class="sheader site-header clearfix">
			<div class="content-wrap">
                <?php echo getTopPanel(); ?>
				<!-- Header background color and image is added to class below -->
				<div class="header-bg">
                    <div class="site-branding branding-logo">
                        <div style="float: left;margin-right: 10px;"><?php the_custom_logo(); ?></div>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php
                        $description = esc_html( get_bloginfo( 'description', 'display' ) );
                        if ( $description || is_customize_preview() ) : ?>
                            <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></br>Полный обзор финансовых рынков</br>Все новости, аналитика, прогнозы</p>
                            <?php
                                getLastPostAndSocials();
                            endif;?>
                    </div><!-- .site-branding -->
                </div>

                <?php echo getMainMenu(); ?>
            </div>
            <?php echo getMobileHeader(); ?>
      
        </header>
        <div style="height:auto;max-height:300px;margin: 0 auto;" class="yandex-cotext">
             <!-- Yandex.RTB R-A-291518-2 -->
            <div id="yandex_rtb_R-A-291518-2"></div>
            <script type="text/javascript">
                (function(w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function() {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-291518-2",
                            renderTo: "yandex_rtb_R-A-291518-2",
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

					<div class="content-wrap">


						<!-- Upper widgets -->
						<div class="header-widgets-wrapper">
							<?php if ( is_active_sidebar( 'headerwidget-1' ) ) : ?>
								<div class="header-widgets-three header-widgets-left">
									<?php dynamic_sidebar( 'headerwidget-1' ); ?>
								</div>
							<?php endif; ?>

							<?php if ( is_active_sidebar( 'headerwidget-2' ) ) : ?>
								<div class="header-widgets-three header-widgets-middle">
									<?php dynamic_sidebar( 'headerwidget-2' ); ?>
								</div>
							<?php endif; ?>

							<?php if ( is_active_sidebar( 'headerwidget-3' ) ) : ?>
								<div class="header-widgets-three header-widgets-right">
									<?php dynamic_sidebar( 'headerwidget-3' ); ?>				
								</div>
							<?php endif; ?>
						</div>

					</div>

					<div id="content" class="site-content clearfix">
						<div class="content-wrap">
							<div class="content-wrap-bg">
