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
global $kkPositonMar;
if($kkPositonMar==8 || $kkPositonMar==13):
    ?>
    <div style="height:auto;max-height:300px;margin: 0 auto;display: inline-block;float: left;width: 100%;">
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