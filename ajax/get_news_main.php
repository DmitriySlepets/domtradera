<?php
/**
 * Template part for displaying posts
 *
 * @package newspaperly
 */
// подгружаем среду WordPress
require_once('/var/www/u0526235/data/www/domtradera.ru/wp-load.php');
?>
<?php
    global $post;
    $tmp_post = $post;
    $args = array('posts_per_page' => 10);
    $myposts = get_posts($args);
    foreach ($myposts as $post):
        setup_postdata($post);
        get_template_part('template-parts/content', get_post_format());
    endforeach;
    echo '<div class="text-center paging-navs">';
    the_posts_pagination();
    echo '</div>';
    // возвращаем былое значение $post
    $post = $tmp_post;
?>