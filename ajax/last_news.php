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

?>
