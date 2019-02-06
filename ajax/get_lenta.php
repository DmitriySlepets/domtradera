
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