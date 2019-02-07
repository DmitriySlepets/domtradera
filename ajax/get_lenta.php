
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
$startFrom = $_POST['startFrom'];
$tmp_post = $post;
$args = array('posts_per_page' => $post);
$myposts = get_posts($args);
foreach ($myposts as $post):
    $posts[] += $post->ID;
    setup_postdata($post);
    get_template_part('template-parts/content', get_post_format());
endforeach;

?>


// C какой статьи будет осуществляться вывод
$startFrom = $_POST['startFrom'];

// Получаем 10 статей, начиная с последней отображенной
$res = mysqli_query($db, "SELECT * FROM `articles` ORDER BY `article_id` DESC LIMIT {$startFrom}, 10");

// Формируем массив со статьями
$articles = array();
while ($row = mysqli_fetch_assoc($res))
{
$articles[] = $row;
}

// Превращаем массив статей в json-строку для передачи через Ajax-запрос
echo json_encode($articles);