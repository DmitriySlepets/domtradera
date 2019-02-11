<?php
/**
 * newspaperly functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package newspaperly
 */

/**
 * каунтер рекламы
 */
$kkPositonMar = 4;
/**
 * каунтер вывода плашек в статьях
 */
$countMet = 0;
/**
 * Получаем ключевые слова, в зависимости от id статьи
 */
function getKeywords(){
    $post_id = get_the_ID();
    if( is_front_page() ){
        return 'Курсы валют,Прогнозы Форекс,Аналитика Форекс,Статьи о Форекс,Торговля на бирже,Торговля на Форекс,Брокеры Форекс,Валютные пары,Анализ рынка Форекс,Начинающему трейдеру,Новости Форекс,Стратегии торговли,Экономический Календарь,Психология трейдинга';
    }else{
        if($post_id>0){
            $server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
            mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
            mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));


            $query_search = "SELECT * FROM kk_metatags WHERE post_id = $post_id";
            $res_search = mysqli_query($server_bd, $query_search);

            $kewordsOutput = "";
            if( $res_search ) {
                foreach ( $res_search as $keyWord ) {
                    if(strlen($kewordsOutput)==0){
                        $kewordsOutput = $keyWord['keyword'];
                    }else{
                        $kewordsOutput = $kewordsOutput.','.$keyWord['keyword'];
                    }
                }
            }

            mysqli_close($server_bd);

            return $kewordsOutput;
        }else{
            return 'Курсы валют,Прогнозы Форекс,Аналитика Форекс,Статьи о Форекс,Торговля на бирже,Торговля на Форекс,Брокеры Форекс,Валютные пары,Анализ рынка Форекс,Начинающему трейдеру,Новости Форекс,Стратегии торговли,Экономический Календарь,Психология трейдинга';
        }
    }
}

/**
 * Получает первую картинку из контента указанной записи.
 * Если у записи есть миниатюра, то получит её URL.
 *
 * @param  integer/WP_Post  $post         ID или объект поста, картинку из контента которого нужно получить.
 *                                        По умолчанию: текущий пост
 * @param  string           $default_src  URL на картинку по умолчанию, если не удалось найти её в контенте записи.
 * @return string           URL на картинку.
 */
function get_post_first_image_src( $post = 0, $default_src = '/images/no_photo.jpg' ){
    if( ! $post || ! is_object($post) ) $post = get_post($post);

    // если у записи есть миниатюра
    if( $thumbnail_id = get_post_meta( $post->ID, '_thumbnail_id', true ) )
        if( $src = wp_get_attachment_url( $thumbnail_id ) )
            return $src;

    // миниатюры нет, ищем в контенте
    preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $post->post_content, $match );

    if( ! $match )
        return $default_src;

    return $match[1];
}


if ( ! function_exists( 'newspaperly_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */

function newspaperly_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on newspaperly, use a find and replace
		 * to change 'newspaperly' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'newspaperly', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 300 );

		add_image_size( 'newspaperly-grid', 350 , 230, true );
		add_image_size( 'newspaperly-slider', 850 );
		add_image_size( 'newspaperly-small', 300 , 180, true );


		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1'	=> esc_html__( 'Primary', 'newspaperly' ),
			) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'newspaperly_custom_background_args', array(
			'default-color' => '#f1f1f1',
			'default-image' => '',
			'default-image' => '%1$s/images/bg.png',
			) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'flex-width'  => true,
			'flex-height' => true,
			) );
	}
	endif;
	add_action( 'after_setup_theme', 'newspaperly_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function newspaperly_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'newspaperly_content_width', 640 );
}
add_action( 'after_setup_theme', 'newspaperly_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function newspaperly_widgets_init() {
/**
 * Widgets shown in the header, beside the logo.
 */
register_sidebar( array(
	'name'          => esc_html__( 'Header Widget', 'newspaperly' ),
	'id'            => 'banner-widget',
	'description'   => esc_html__( 'Add widgets to the header banner here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="banner-widget widget swidgets-wrap %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><h3 class="widget-title">',
	'after_title'   => '</h3></div>',
	) );

/**
 * Widgets shown in the sidebar.
 */
register_sidebar( array(
	'name'          => esc_html__( 'Sidebar', 'newspaperly' ),
	'id'            => 'sidebar-1',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="fbox swidgets-wrap widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><div class="sidebar-title-border"><h3 class="widget-title">',
	'after_title'   => '</h3></div></div>',
	) );

register_sidebar( array(
	'name'          => esc_html__( 'Footer Widget (1)', 'newspaperly' ),
	'id'            => 'footerwidget-1',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="fbox widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><h3 class="widget-title">',
	'after_title'   => '</h3></div>',
	) );

register_sidebar( array(
	'name'          => esc_html__( 'Footer Widget (2)', 'newspaperly' ),
	'id'            => 'footerwidget-2',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="fbox widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><h3 class="widget-title">',
	'after_title'   => '</h3></div>',
	) );

register_sidebar( array(
	'name'          => esc_html__( 'Footer Widget (3)', 'newspaperly' ),
	'id'            => 'footerwidget-3',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="fbox widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><h3 class="widget-title">',
	'after_title'   => '</h3></div>',
	) );

/**
 * Widgets shown under the navigation.
 */
register_sidebar( array(
	'name'          => esc_html__( 'Top Widget (1)', 'newspaperly' ),
	'id'            => 'headerwidget-1',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="header-widget widget swidgets-wrap %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><div class="sidebar-title-border"><h3 class="widget-title">',
	'after_title'   => '</h3></div></div>',
	) );

register_sidebar( array(
	'name'          => esc_html__( 'Top Widget (2)', 'newspaperly' ),
	'id'            => 'headerwidget-2',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="header-widget widget swidgets-wrap %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><div class="sidebar-title-border"><h3 class="widget-title">',
	'after_title'   => '</h3></div></div>',
	) );

register_sidebar( array(
	'name'          => esc_html__( 'Top Widget (3)', 'newspaperly' ),
	'id'            => 'headerwidget-3',
	'description'   => esc_html__( 'Add widgets here.', 'newspaperly' ),
	'before_widget' => '<section id="%1$s" class="header-widget widget swidgets-wrap %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<div class="swidget"><div class="sidebar-title-border"><h3 class="widget-title">',
	'after_title'   => '</h3></div></div>',
	) );
}
add_action( 'widgets_init', 'newspaperly_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function newspaperly_scripts() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'newspaperly-style', get_stylesheet_uri() );
	wp_enqueue_script( 'newspaperly-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20170823', true );
	wp_enqueue_script( 'newspaperly-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20170823', true );	
	wp_enqueue_script( 'newspaperly-flexslider-jquery', get_template_directory_uri() . '/js/jquery.flexslider.js', array('jquery'), '20150423', true );
	wp_enqueue_script( 'newspaperly-script', get_template_directory_uri() . '/js/script.js', array(), '20160720', true );
    getStyleForDevice();
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'newspaperly_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Enqueue Google fonts, credits can be found in readme.
 */
function newspaperly_google_fonts() {

	wp_enqueue_style( 'newspaperly-google-fonts', 'http://fonts.googleapis.com/css?family=Lato:300,400,700,900|Merriweather:400,700', false ); 
}

add_action( 'wp_enqueue_scripts', 'newspaperly_google_fonts' );


/**
 * excerpt Changes
 */

function newspaperly_new_excerpt_more( $more ) {
	if ( ! is_admin() )
		/* If you want to change replace the dots after excerpt with something else, do it on the line below */
	return '...';
}
add_filter('excerpt_more', 'newspaperly_new_excerpt_more');

function newspaperly_custom_excerpt_length( $length ) {
	if ( ! is_admin() )
		/* If you want to change the excerpt length, change this number */
	return 32;
}
add_filter( 'excerpt_length', 'newspaperly_custom_excerpt_length', 1 );

/**
 * Blog Pagination 
 */
if ( !function_exists( 'newspaperly_numeric_posts_nav' ) ) {
	
	function newspaperly_numeric_posts_nav() {
		
		$prev_arrow = is_rtl() ? 'Previous' : 'Next';
		$next_arrow = is_rtl() ? 'Next' : 'Previous';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			if( !$current_page = get_query_var('paged') )
				$current_page = 1;
			if( get_option('permalink_structure') ) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}
			echo wp_kses_post(the_posts_pagination(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> 'Previous',
				'next_text'		=> 'Next',
				) ));
		}
	}
}





/**
 * * Copyright and License for Upsell button by Justin Tadlock - 2016 © Justin Tadlock. customizer button https://github.com/justintadlock/trt-customizer-pro
 */
require_once( trailingslashit( get_template_directory() ) . 'justinadlock-customizer-button/class-customize.php' );


/**
 * Compare page CSS
 */

function newspaperly_comparepage_css($hook) {
	if ( 'appearance_page_newspaperly-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'newspaperly-custom-style', get_template_directory_uri() . '/css/compare.css' );
}
add_action( 'admin_enqueue_scripts', 'newspaperly_comparepage_css' );

/**
 * Compare page content
 */

add_action('admin_menu', 'newspaperly_themepage');
function newspaperly_themepage(){
	$theme_info = add_theme_page( __('NewsPaperly','newspaperly'), __('NewsPaperly','newspaperly'), 'manage_options', 'newspaperly-info.php', 'newspaperly_info_page' );
}



function newspaperly_info_page() {
	$user = wp_get_current_user();
	?>
	<div class="wrap about-wrap newspaperly-add-css">
		<div>
			<h1>
				<?php echo esc_html('Welcome to NewsPaperly!','newspaperly'); ?>
			</h1>

			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo esc_html("Contact Support", "newspaperly"); ?></h3>
						<p><?php echo esc_html("Getting started with a new theme can be difficult, if you have issues with NewsPaperly then throw us an email.", "newspaperly"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/help-contact/', 'newspaperly'); ?>" class="button button-primary">
							<?php echo esc_html("Contact Support", "newspaperly"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo esc_html("View our other themes", "newspaperly"); ?></h3>
						<p><?php echo esc_html("Do you like our concept but feel like the design doesn't fit your need? Then check out our website for more designs.", "newspaperly"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/wordpress-themes/', 'newspaperly'); ?>" class="button button-primary">
							<?php echo esc_html("View All Themes", "newspaperly"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php echo esc_html("Premium Edition", "newspaperly"); ?></h3>
						<p><?php echo esc_html("If you enjoy NewsPaperly and want to take your website to the next step, then check out our premium edition here.", "newspaperly"); ?></p>
						<p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/newspaperly/', 'newspaperly'); ?>" class="button button-primary">
							<?php echo esc_html("Read More", "newspaperly"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<h2><?php echo esc_html("Free Vs Premium","newspaperly"); ?></h2>
		<div class="newspaperly-button-container">
			<a target="blank" href="<?php echo esc_url('https://superbthemes.com/newspaperly/', 'newspaperly'); ?>" class="button button-primary">
				<?php echo esc_html("Read Full Description", "newspaperly"); ?>
			</a>
			<a target="blank" href="<?php echo esc_url('https://superbthemes.com/demo/newspaperly/', 'newspaperly'); ?>" class="button button-primary">
				<?php echo esc_html("View Theme Demo", "newspaperly"); ?>
			</a>
		</div>


		<table class="wp-list-table widefat">
			<thead>
				<tr>
					<th><strong><?php echo esc_html("Theme Feature", "newspaperly"); ?></strong></th>
					<th><strong><?php echo esc_html("Basic Version", "newspaperly"); ?></strong></th>
					<th><strong><?php echo esc_html("Premium Version", "newspaperly"); ?></strong></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php echo esc_html("Header Background Color/Image", "newspaperly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Custom Header Logo Or Text	", "newspaperly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Hide Logo Text", "newspaperly"); ?></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Premium Support", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Recent Posts Widget", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Easy Google Fonts", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Pagespeed Plugin", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Only Show Upper Widgets On Front Page", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Replace Copyright Text", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Upper Widgets Colors", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Navigation Color", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Post/Page Color", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Blog Feed Color", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Footer Color", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Sidebar Color", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
				<tr>
					<td><?php echo esc_html("Customize Background Color", "newspaperly"); ?></td>
					<td><span class="cross"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/cross.png" alt="No" /></span></td>
					<td><span class="checkmark"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/icons/check.png" alt="Yes" /></span></td>
				</tr>
			</tbody>
		</table>

	</div>
	<?php
}

// для даты изменения
function main_get_the_date($the_date, $d, $post) {
    $d = 'd.m.Y';
    $date_now = date_format(date_create("now"), $d);
    $post = get_post($post);
    if ( !$post ) {
        return $the_date;
    }
    $the_date = mysql2date( $d, $post->post_date);
    if ($date_now == $the_date) {
        //$the_date = esc_html__( date("H:i"), 'main' );
        $the_date =  date("H:i", strtotime($post->post_date));
    }
    return $the_date;
}
add_filter( 'get_the_date', 'main_get_the_date', 10, 3 );

//получить теги
function the_tags_return( $before = null, $sep = ', ', $after = '' ) {
    if ( null === $before )
        $before = __('Tags: ');
    /**
     * 111218
     * убираем слово метки
     * codeking
     */
    $before = "";
    $the_tags = get_the_tag_list( $before, $sep, $after );

    if ( ! is_wp_error( $the_tags ) ) {
        return $the_tags;
    }

    return '';
}
function the_tags_f( $before = null, $sep = ', ', $after = '' ) {
    if ( null === $before )
        $before = __('Tags: ');
    /**
     * 111218
     * убираем слово метки
     * codeking
     */
    $before = "";
    $the_tags = get_the_tag_list( $before, $sep, $after );

    if ( ! is_wp_error( $the_tags ) ) {
        echo $the_tags;
    }
}

//получаем автора и время
function newspaperly_posted_on_return() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
    /* translators: %s: post date. */
    //esc_html_x( 'Posted on %s', 'post date', 'newspaperly' ),
        esc_html_x( '%s', 'post date', 'newspaperly' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    /**
     * 111218
     * добавление иконок авторов
     * codeking
     */
    $kk_image_path = get_the_author_meta( 'kk_user_image' );
    $kk_auth_href  = get_the_author_meta( 'kk_auth_href' );
    $byline = sprintf(
    /* translators: %s: post author. */
        esc_html_x( '%s', 'post author', 'newspaperly' ),
        '<span class="author vcard"><a class="url fn n" target="_blank" href="' . $kk_auth_href . '">' . '<img class = "kk_user_image" src = "'.$kk_image_path.'" />' . '</a></span>'
    //'<span class="author vcard"><a class="url fn n" href="https://fortrader.org/">fortrader.org</a></span>'
    );

    return '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

//формируем шапку на мобильном устройстве
function getMobileHeader(){
    $html = "";
    $html = $html . '<div id="header_main_mobile">';
        $html = $html . '<div id="menu_main_btn"></div>';
        $html = $html . '<div id="curtain"></div>';
        $html = $html . '<nav id="menu_main">';
            $html = $html . '<div class="viewport">';
                $html = $html . '<div class="overview">';
                    $html = $html . '<ul>';
                        $html = $html . '<li class="tap-highlighted active lineafter tomain"><a href="/">Лента</a></li>';
                        $html = $html . '<li class="tap-highlighted"><a href="/tag/акции/">Фильтр</a></li>';
                        $html = $html . '<li class="tap-highlighted"><a href="javascript:void(0);">Подборки</a></li>';
                        $html = $html . '<li class="tap-highlighted"><a href="javascript:void(0);">Информеры</a></li>';
                        $html = $html . '<li class="tap-highlighted"><a href="/brokers/">Брокеры</a></li>';
                        /*$html = $html . '<li class="tap-highlighted"><a href="https://www.hycm.com/ru/hylp/global/start-trading?campaignid=701D0000001iEFH&utm_source=affiliate&utm_medium=affiliate&utm_campaign=ETRASS_EN_Global_LP&a_aid=&clickid=EG7007359&eaid=72204">Начать торговать</a></li>';*/
                    $html = $html . '</ul>';
                $html = $html . '</div>';
            $html = $html . '</div>';
        $html = $html . '</nav>';
        $html = $html . '<a href="/" id="toplink">Дом Трейдера</a>';
        $html = $html . '<div id="search">';
            $html = $html . '<div id="search_btn"></div>';
            $html = $html . '<form id="s_inp_holder"><input id="search_input" class="t_zag1" type="search" autocomplete="on"></form>';
            $html = $html . '<div id="search_close"></div>';
        $html = $html . '</div>';

    $html = $html . '</div>';

    return $html;
}

//определяем усройство и подставляем нужные стили
function getStyleForDevice(){
    require_once 'lib/mobile-detect/Mobile_Detect.php'; // Подключаем скрипт
    $detect = new Mobile_Detect; // Создаём экземпляр класса
    if( $detect->isTablet() ) {
        wp_enqueue_style('tablet-style', get_template_directory_uri() . '/css/tablet-style.css', array(), '20181127', false);
        //echo '<h1>tablet</h1>';
    }elseif( $detect->isiPad() ) {
        wp_enqueue_style('tablet-style', get_template_directory_uri() . '/css/tablet-style.css', array(), '20181127', false);
        wp_enqueue_script( 'mobile-script', get_template_directory_uri() . '/js/tablet-script.js', array(), '20181127', false );
        //echo '<h1>tablet</h1>';
    }elseif( $detect->isMobile()){
        wp_enqueue_style( 'mobile-style', get_template_directory_uri() . '/css/mobile-style.css',array(),'20181127',false);
        wp_enqueue_script( 'mobile-script', get_template_directory_uri() . '/js/mobile-script.js', array(), '20181127', false );
        //echo '<h1>mobile</h1>';
    }
}
//иконки социальных сетей поделиться или подписаться к соцсети
function get_Social(){
    $html = "";
    $html = $html . '<div class="pu10 pd10 borderdown">';
    $html = $html . '<div class="article-share-name">';
    $html = $html . '<ul class="social-button-block">';
    $html = $html . '<li class="fb-share social-button" style="width:70px;"><a rel="nofollow" title="Поделиться в Facebook" href="//www.facebook.com/dialog/share?app_id=406317839387165&amp;utm_source=fbsharing&amp;utm_medium=social&amp;href=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank" style="width: 70px; height: 30px;"><span class="fb_counter" style="display: table;">8</span></a></li>';
    $html = $html . '<li class="vk-share social-button"><a rel="nofollow" title="Поделиться в Vkontakte" href="//vk.com/share.php?utm_source=vksharing&amp;utm_medium=social&amp;url=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"><span class="vk_counter"></span></a></li>';
    $html = $html . '<li class="ok-share social-button"><a rel="nofollow" class="soc_ok" title="Поделиться в Одноклассники" href="//www.odnoklassniki.ru/dk?utm_source=oksharing&amp;utm_medium=social&amp;st.cmd=addShare&amp;st.s=1&amp;st._surl=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"><span class="ok_counter"></span></a></li>';
    $html = $html . '<li class="twi-share social-button"><a rel="nofollow" class="soc_twi" title="Поделиться в Twitter" href="//twitter.com/intent/tweet?via=gazetaru&amp;utm_source=twsharing&amp;utm_medium=social&amp;url=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"></a></li>';
    $html = $html . '<li class="lj-share social-button"><a rel="nofollow" class="soc_lj" title="Поделиться в ЖЖ" href="//www.livejournal.com/update.bml?&amp;event=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"></a></li>';
    $html = $html . '</ul>';
    $html = $html . '</div>';
    $html = $html . '<div id="share-anchor-top" style="position:relative;top:0;left:0;"></div>';
    $html = $html . '<div class="share-name-sticky">';
    $html = $html . '<div class="article-share-name">';
    $html = $html . '<ul class="social-button-block">';
    $html = $html . '<li class="fb-share social-button" style="width:70px;"><a rel="nofollow" title="Поделиться в Facebook" href="//www.facebook.com/dialog/share?app_id=406317839387165&amp;utm_source=fbsharing&amp;utm_medium=social&amp;href=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank" style="width: 70px; height: 30px;"><span class="fb_counter" style="display: table;">8</span></a></li>';
    $html = $html . '<li class="vk-share social-button"><a rel="nofollow" title="Поделиться в Vkontakte" href="//vk.com/share.php?utm_source=vksharing&amp;utm_medium=social&amp;url=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"><span class="vk_counter"></span></a></li>';
    $html = $html . '<li class="ok-share social-button"><a rel="nofollow" class="soc_ok" title="Поделиться в Одноклассники" href="//www.odnoklassniki.ru/dk?utm_source=oksharing&amp;utm_medium=social&amp;st.cmd=addShare&amp;st.s=1&amp;st._surl=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"><span class="ok_counter"></span></a></li>';
    $html = $html . '<li class="twi-share social-button"><a rel="nofollow" class="soc_twi" title="Поделиться в Twitter" href="//twitter.com/intent/tweet?via=gazetaru&amp;utm_source=twsharing&amp;utm_medium=social&amp;url=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"></a></li>';
    $html = $html . '<li class="lj-share social-button"><a rel="nofollow" class="soc_lj" title="Поделиться в ЖЖ" href="//www.livejournal.com/update.bml?&amp;event=https://www.gazeta.ru/politics/2019/01/28_a_12148573.shtml" target="_blank"></a></li>';
    $html = $html . '</ul>';
    $html = $html . '</div>';
    $html = $html . '</div>';
    $html = $html . '</div>';
    return html;
}
//подключаем основное меню

function getMainMenu(){
    $html = '';
    $html = $html . '<nav class="navbar">';
        $html = $html . '<div class="navbar-main">';
            $html = $html . '<div class="item"><a href="/">Лента</a></div>';
            $html = $html . '<div class="item"><a href="/tag/акции/">Фильтр</a></div>';
            $html = $html . '<div class="item"><a href="javascript:void(0);">Подборки</a></div>';
            $html = $html . '<div class="item"><a href="javascript:void(0);">Информеры</a></div>';
            $html = $html . '<div class="item"><a href="/brokers/">Брокеры</a></div>';
            /*$html = $html . '<div><a href="https://www.hycm.com/ru/hylp/global/start-trading?campaignid=701D0000001iEFH&utm_source=affiliate&utm_medium=affiliate&utm_campaign=ETRASS_EN_Global_LP&a_aid=&clickid=EG7007359&eaid=72204">Начать торговать</a></div>';*/
    $html = $html . '<div class="b-navbar-search">';
    $html = $html . '<div class="b-navbar-search-area">';
    $html = $html . '<form name="search" action="/">';
        $html = $html . '<input id="place_for_searchinput" type="text" name="s" placeholder="Поисковый запрос">';
        $html = $html . '<input type="submit" value="Найти →">';
        /*$html = $html . '<input name="p" value="search" class="hidden">';
        $html = $html . '<input name="how" value="pt" class="hidden">';*/
    $html = $html . '</form>';
    $html = $html . '</div>';
    $html = $html . '<div class="b-navbar-search-btn"></div>';
$html = $html . '</div>';

    $html = $html . '</nav>';

            return $html;
}

//формируем топ панель шапки
function getTopPanel(){
    $html = '';
    $html = $html . '<div class="header-top">';
        $html = $html . '<div class="nav-v2">';
            $html = $html . '<span class="currency">';
                $html = $html . '<a href="javascript:void(0);" rel="nofollow" class="xgjcreb">';
                $html = $html . '</a>';
            $html = $html . '</span>';
        $html = $html . '</div>';
        $html = $html . getSocialNetworks();
    $html = $html . '</div>';
    return $html;
}

//выводим последнюю новость и социальные сети для свернутой шапки
function getLastPostAndSocials(){
    echo '<div id="last-news">';
    $params = array(
        'posts_per_page' => '1',
        'post_status' => 'publish'
    );
    $recent_posts_array = get_posts( $params );
    foreach( $recent_posts_array as $recent_post_single ) :
        $kk_image_path = get_the_author_meta( 'kk_user_image', $recent_post_single->post_author);
        $kk_auth_href  = get_the_author_meta( 'kk_auth_href',$recent_post_single->post_author);

        echo '<p>' . date("H:i", strtotime($recent_post_single->post_date)) . '<span><a href="'.$kk_auth_href.'"><img src="'.$kk_image_path .'" /></a></span></p>';
        echo '<a href="'.get_permalink( $recent_post_single ).'" >' . $recent_post_single->post_title . '</a>';
    endforeach;
    echo '</div>';
    echo '<div id="social-scroll">';
        echo getSocialNetworks();
    echo '</div>';
}
//получить соц.сети
function getSocialNetworks(){
	$html = '';
	$html = $html . '<div class="b-social">';
	$html = $html . '<a rel="nofollow" href="https://www.facebook.com/domtradera/" title="Facebook" class="ooidx b-social-icon fb_i_v2" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="https://vk.com/domtradera" title="ВКонтакте" class="vk_i_v2 cpzeqo b-social-icon" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="https://www.ok.ru/group/55222905143410/" title="Одноклассники" class="ok_i_v2 b-social-icon kebk" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="https://www.instagram.com/domtradera" title="Instagram" class="b-social-icon waif mail_i_v2" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="https://twitter.com/domtradera" title="Twitter" class="vckn b-social-icon tw_i_v2" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="https://zen.yandex.ru/id/5bf28e70ce919800abda5a45" title="Яндекс Дзен" class="zen_i_v2 b-social-icon dozt" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="tg://resolve?domain=<domtradera>" title="Telegram" class="telegram_i_v2 sbtwue b-social-icon" target="_blank"></a>';
	$html = $html . '<a rel="nofollow" href="https://chat.whatsapp.com/EqGaNEO93Jr3fcCRPqYNmh" title="WhatsApp" class="rss_i_v2 b-social-icon ufthisy" target="_self"></a>';
	$html = $html . '<a rel="nofollow" href="https://invite.viber.com/?g2=AQBvYGUohi9ebkjdFGDJW7QLCTv3oJILFUi0tCa1SwR7xBMhI99HQlhaVyVpOg3l&lang=ru" title="Viber" class="b-social-icon xbqzz youtube_i_v2" target="_blank"></a>';
	$html = $html . '</div>';
	return $html;
}
//получить список брокеров
add_action( 'my_brokers', 'getPageBrokers');
/**
 *
 */
function get_mobile_detect(){
    require_once 'lib/mobile-detect/Mobile_Detect.php'; // Подключаем скрипт
    $detect = new Mobile_Detect; // Создаём экземпляр класса
    return $detect;
}
function getPageBrokers(){
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM kk_brokers" );
    $detect = get_mobile_detect();
?>
    <main id="main" class="site-main brokers">
<?php
    foreach ($results as $itemResult):
        //print_r($itemResult);
        //получим ширину и высоту картинки
        //разделим ширину на высоту, если больше 1, то будем использовать contain иначе cover
        try{
            $size = @getimagesize("http://domtradera.ru" . $itemResult->img);
            $imgWidth = $size[0];
            $imgHeight = $size[1];
            //print_r($size);
            //echo "width=" . $imgWidth . ";";
            //echo "height=" . $imgHeight . ";";
            if ($imgHeight == 0 or $imgWidth == $imgHeight) {
                $cover = "cover";
            } else {
                $imgInteger = intdiv($imgWidth, $imgHeight);
                //echo "integer=" . $imgInteger . ";";
                $cover = ($imgInteger >= 1) ? "contain" : "cover";
            }
        }catch (Exception $ex) {
            //Выводим сообщение об исключении.
            //echo $ex->getMessage();
            $cover = "cover";
        }
?>
        <article id="post" class="posts-entry fbox blogposts-list post type-post status-publish format-standard hentry">
            <div class="blogposts-list-content">
                <?php if ($detect->isMobile()): ?>
                    <a href="<?php echo $itemResult->href;?>" target="_blank" rel="bookmark"><img class="anons-list" src="<?php echo $itemResult->img;?>" width="80" height="80" style="object-fit: contain;"></a>
                    <header class="entry-header">
                <?php else: ?>
                    <a href="<?php echo $itemResult->href;?>" target="_blank" rel="bookmark"><img class="anons-list" src="<?php echo $itemResult->img;?>" width="80" height="80" style="object-fit: <?php echo $cover;?>; width: 80px; height: 80px;"></a>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php echo $itemResult->href;?>" target="_blank" rel="bookmark"><?php echo $itemResult->title;?></a></h2>
                <?php endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <a href="<?php echo $itemResult->href;?>" target="_blank" rel="bookmark"><?php echo $itemResult->description;?></a>
                </div><!-- .entry-content -->
            </div><!--.blogposts-list-content-->
        </article>
<?php
    endforeach;
?>
    </main>
<?php
}
//добавить контекстную рекламу в статью
//вызов в /wp-includes/post-template.php
function addMarketInContent($in_content){
    $html = "";
    if(strlen($in_content)>5000){
        $other_html = substr($in_content,5000);
        $html .= substr($in_content,0, 5000);
        $ar_content = explode("</p>", $other_html);
        for($i=0;$i<count($ar_content);$i++){
            if($i==4){
                $html .= '
            <div id="single_yandex1">
                <!-- Yandex.RTB R-A-291518-4 -->
                <div id="yandex_rtb_R-A-291518-4"></div>
                <script type="text/javascript">
                    (function(w, d, n, s, t) {
                        w[n] = w[n] || [];
                        w[n].push(function() {
                            Ya.Context.AdvManager.render({
                                blockId: "R-A-291518-4",
                                renderTo: "yandex_rtb_R-A-291518-4",
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
            ';
            }elseif($i==8){
                $html .= '
            <div id="single_yandex2">
                <!-- Yandex.RTB R-A-291518-5 -->
                <div id="yandex_rtb_R-A-291518-5"></div>
                <script type="text/javascript">
                    (function(w, d, n, s, t) {
                        w[n] = w[n] || [];
                        w[n].push(function() {
                            Ya.Context.AdvManager.render({
                                blockId: "R-A-291518-5",
                                renderTo: "yandex_rtb_R-A-291518-5",
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
            ';
            }elseif($i==12){
                $html .= '
            <div id="single_yandex3">
                <!-- Yandex.RTB R-A-291518-6 -->
                <div id="yandex_rtb_R-A-291518-6"></div>
                <script type="text/javascript">
                    (function(w, d, n, s, t) {
                        w[n] = w[n] || [];
                        w[n].push(function() {
                            Ya.Context.AdvManager.render({
                                blockId: "R-A-291518-6",
                                renderTo: "yandex_rtb_R-A-291518-6",
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
            ';
            }else{
                $html .= $ar_content[$i];
            }
        }
    }else{
        $html .= $in_content;
    }


    return $html;
}
//добавим соц. сети в статью
//вызов в /wp-includes/post-template.php
function addSocialInArticle($in_content){
   //в $in_content будет ваша статья
    /**
     * дробим входящую статью, чтобы узнать есть ли там img
     */
    $html = "";
    /*$ar_content = explode("<img", $in_content);
	//print_r($ar_content);
    if(count($ar_content)>0) {
        //здесь пробегаемся форичем
        $i = 0;
        foreach ($ar_content as $item) {
            if ($i == 0) {
                $html .= $item;
                $i++;
                continue;
            } else{
                $pos_p = strpos($item, '<p');
				$pos_div = strpos($item, '<div');
				$pos_span = strpos($item, '<span');
				$arrayTags = array();
				if ($pos_p != false) {
					$arrayTags[] = $pos_p;
				}
				if ($pos_div != false) {
					$arrayTags[] = $pos_div;
				}
				if ($pos_span != false) {
					$arrayTags[] = $pos_span;
				}
				$pos = min($arrayTags);
                $rest = substr($item, 0, $pos);
                $html .= '<img' . $rest;
                $html .= getSocialHtml();
 
                $html .= substr($in_content, strlen($html) - strlen(getSocialHtml()));
                break;
            };

        }$html .= getSocialHtml();
    }*/


    if(strlen($html)==0) {
        $html.= $in_content . getSocialHtml();
    }
    return $html;
}
function getSocialHtml(){
    $html = '<div class="pu10 pd10 borderdown">
                <div class="article-share-name">             
                Поделитесь этой статьей
                 <ul class="social-button-block">
               <li class="fb-share social-button"><a rel="nofollow" title="Поделиться в Facebook" href="//www.facebook.com/dialog/share?app_id=406317839387165&amp;utm_source=fbsharing&amp;utm_medium=social&amp;href='.get_url().'" target="_blank"></a></li>
                <li class="vk-share social-button"><a rel="nofollow" title="Поделиться в Vkontakte" href="//vk.com/share.php?utm_source=vksharing&amp;utm_medium=social&amp;url='.get_url().'" target="_blank"></a></li>
                <li class="ok-share social-button"><a rel="nofollow"  title="Поделиться в Одноклассники" href="//www.odnoklassniki.ru/dk?utm_source=oksharing&amp;utm_medium=social&amp;st.cmd=addShare&amp;st.s=1&amp;st._surl='.get_url().'" target="_blank"></a></li>
                 <li class="twi-share social-button"><a rel="nofollow"  title="Поделиться в Twitter" href="//twitter.com/intent/tweet?via=domtraderaru&amp;utm_source=twsharing&amp;utm_medium=social&amp;url='.get_url().'" target="_blank"></a></li>
                 </ul>
                </div><div class="article-share-name"> 
                Присоединяйтесь к нашим сообществам
                <ul class="b-social" style="margin-bottom:0px;">
                <a rel="nofollow" href="https://www.facebook.com/domtradera/" title="Facebook" class="ooidx b-social-icon fb_i_v2" target="_blank"></a>
                <a rel="nofollow" href="https://vk.com/domtradera" title="ВКонтакте" class="vk_i_v2 cpzeqo b-social-icon" target="_blank"></a>
                <a rel="nofollow" href="https://www.ok.ru/group/55222905143410/" title="Одноклассники" class="ok_i_v2 b-social-icon kebk" target="_blank"></a>
                <a rel="nofollow" href="https://www.instagram.com/domtradera" title="Instagram" class="b-social-icon waif mail_i_v2" target="_blank"></a>
                <a rel="nofollow" href="https://twitter.com/domtradera" title="Twitter" class="vckn b-social-icon tw_i_v2" target="_blank"></a>
                <a rel="nofollow" href="https://zen.yandex.ru/id/5bf28e70ce919800abda5a45" title="Яндекс Дзен" class="zen_i_v2 b-social-icon dozt" target="_blank"></a>
                <a rel="nofollow" href="tg://resolve?domain=&lt;domtradera&gt;" title="Telegram" class="telegram_i_v2 sbtwue b-social-icon" target="_blank"></a>
                <a rel="nofollow" href="https://chat.whatsapp.com/EqGaNEO93Jr3fcCRPqYNmh" title="WhatsApp" class="rss_i_v2 b-social-icon ufthisy" target="_self"></a>
                <a rel="nofollow" href="https://invite.viber.com/?g2=AQBvYGUohi9ebkjdFGDJW7QLCTv3oJILFUi0tCa1SwR7xBMhI99HQlhaVyVpOg3l&amp;lang=ru" title="Viber" class="b-social-icon xbqzz youtube_i_v2" target="_blank"></a>
</ul>            
               </div>
               </div>';
    return $html;
}
function get_url(){
    global $post;
    return get_permalink($post);

}
/**
 * ajax главной страницы
 */
function true_loadmore_scripts() {
    wp_enqueue_script('jquery'); // скорее всего он уже будет подключен, это на всякий случай
    wp_enqueue_script( 'true_loadmore', get_stylesheet_directory_uri() . '/loadmore.js', array('jquery') );
}

add_action( 'wp_enqueue_scripts', 'true_loadmore_scripts' );

function true_load_posts(){
    $args = unserialize(stripslashes($_POST['query']));
    $args['paged'] = $_POST['page'] + 1; // следующая страница
    $args['post_status'] = 'publish';
    $q = new WP_Query($args);
    if( $q->have_posts() ):
        while($q->have_posts()): $q->the_post();
            /*
             * Со строчки 13 по 27 идет HTML шаблон поста, максимально приближенный к теме TwentyTen.
             * Для своей темы вы конечно же можете использовать другой код HTML.
             */
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('posts-entry fbox blogposts-list'); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-list-has-thumbnail">
                    <div class="featured-thumbnail">
                        <a href="<?php the_permalink() ?>" rel="bookmark">
                            <div class="thumbnail-img" style="background-image:url(<?php the_post_thumbnail_url( 'newspaperly-slider' ); ?>)"></div>
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="blogposts-list-content">
                        <?php echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><img class="anons-list" src="' . get_post_first_image_src() . '" width="80" height="80" /></a>'; ?>
                        <header class="entry-header">
                            <?php
                            if ( is_singular() ) :
                                the_title( '<h1 class="entry-title">', '</h1>' );
                            else :
                                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                            endif;
                            if ( 'post' === get_post_type() ) : ?>
                                <div class="entry-meta">
                                    <div class="blog-data-wrapper">
                                        <div class="post-data-divider"></div>
                                        <div class="post-data-positioning">
                                            <div class="post-data-text">
                                                <?php newspaperly_posted_on(); ?><span class="kk_tags"><?php the_tags_f(); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .entry-meta -->
                                <?php
                            endif; ?>
                        </header><!-- .entry-header -->
                        <div class="entry-content">
                            <?php
                            the_excerpt( sprintf(
                                wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'newspaperly' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                get_the_title()
                            ) );
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newspaperly' ),
                                'after'  => '</div>',
                            ) );
                            ?>

                        </div><!-- .entry-content -->
                        <?php if ( has_post_thumbnail() ) : ?>
                    </div>
                <?php endif; ?>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_loadmore', 'true_load_posts');
add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');
