<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newspaperly
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
</article><!-- #post-<?php the_ID(); ?> -->
<?php
global $kkPositonMar,$wpdb;
if($kkPositonMar==8 || $kkPositonMar==13):
    $results = $wpdb->get_results( "SELECT * FROM kk_brokers" );
    ?>
    <?php
    if(count($results)>0):
        $itemResult = $results[rand(0,count($results)-1)];
        if(strlen($itemResult->img)>0) {
            echo '<main id="main" class="site-main brokers">';
            $cover = "contain";
            $detect = get_mobile_detect(); // Создаём экземпляр класса
            ?>
            <article id="post"
                     class="posts-entry fbox blogposts-list post type-post status-publish format-standard hentry">
                <div class="blogposts-list-content">
                    <?php if ($detect->isMobile()): ?>
                    <a href="<?php echo $itemResult->href; ?>" target="_blank" rel="bookmark"><img class="anons-list"
                                                                                                   src="<?php echo $itemResult->img; ?>"
                                                                                                   width="80"
                                                                                                   height="80"
                                                                                                   style="object-fit: contain;"></a>
                    <header class="entry-header">
                        <?php else: ?>
                        <a href="<?php echo $itemResult->href; ?>" target="_blank" rel="bookmark"><img
                                    class="anons-list" src="<?php echo $itemResult->img; ?>" width="80" height="80"
                                    style="object-fit: <?php echo $cover; ?>; width: 80px; height: 80px;"></a>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php echo $itemResult->href; ?>" target="_blank"
                                                       rel="bookmark"><?php echo $itemResult->title; ?></a></h2>
                            <?php endif; ?>
                        </header><!-- .entry-header -->
                        <div class="entry-content">
                            <a href="<?php echo $itemResult->href; ?>" target="_blank"
                               rel="bookmark"><?php echo $itemResult->description; ?></a>
                        </div><!-- .entry-content -->
                </div><!--.blogposts-list-content-->
            </article>

            <?php
            echo '</main>';
        }
    endif;
    ?>
    <div class="yandex_list" style="height:auto;max-height:300px;margin: 0 auto;display: inline-block;float: left;width: 100%;">
        <!-- Yandex.RTB R-A-291518-<?php echo $kkPositonMar; ?> -->
        <div id="yandex_rtb_R-A-291518-<?php echo $kkPositonMar; ?>"></div>
        <script type="text/javascript">
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-291518-<?php echo $kkPositonMar; ?>",
                        renderTo: "yandex_rtb_R-A-291518-<?php echo $kkPositonMar; ?>",
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
<?php
endif;
$kkPositonMar = $kkPositonMar + 1;
?>
