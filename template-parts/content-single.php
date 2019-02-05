<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package newspaperly
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('posts-entry fbox'); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="featured-thumbnail">
			<?php the_post_thumbnail('newspaperly-slider'); ?>
		</div>
	<?php endif; ?>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<div class="blog-data-wrapper" style="display: inline-block;width: auto;">
				<div class="post-data-divider"></div>
				<div class="post-data-positioning">
					<div class="post-data-text">
						<?php newspaperly_posted_on(); ?>
					</div>
				</div>
			</div>
            <div style="display: inline-block;width: auto;">
                <?php the_tags_f(); ?>
            </div>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newspaperly' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->