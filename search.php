<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package newspaperly
 */

get_header(); ?>

	<section id="primary" class="featured-content content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) : ?>

			<header class="fbox page-header">
				<h1 class="page-title"><?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Результат поиска: %s', 'newspaperly' ), '<span>' . get_search_query() . '</span>' );
				?></h1>
			</header><!-- .page-header -->
            <ul class="kk_title_tags">
            </ul>
            <div class="kk_control_panel">
                <div style="display: inline"><a style="cursor:pointer;" onclick="incheckTags();">снять все</a></div>/<div style="display: inline"><a style="cursor:pointer;" onclick="checkTags();">выбрать все</a></div>
            </div>
            <?php
            //вывод всех тегов
			
			$server_bd = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('No connect to Server');
			mysqli_select_db($server_bd, DB_NAME) or die('No connect to DB');
			mysqli_query($server_bd, "SET NAMES 'utf8'") or die(mysqli_error($server_bd));
			
            $tags = get_tags();
            $html_tags = '<div class="kk_post_tags"><span>Фильтры ленты:</span>';
            foreach ($tags as $tag) {
                $tag_link = get_tag_link($tag->term_id);
                //href='{$tag_link}'
				
				//Ищем число записей по ID тега
				$kk_num = 0;
				$termID = $tag->term_id;
				$query_search_tax = "SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = $termID";
				if ($res_tax = mysqli_query($server_bd, $query_search_tax)) {
				$row_tax = mysqli_fetch_assoc($res_tax);
				$termTaxID = (int)$row_tax['term_taxonomy_id'];
					$query_search_posts = "SELECT object_id FROM `wp_term_relationships` WHERE `term_taxonomy_id` = $termTaxID";
					$res_posts = mysqli_query($server_bd, $query_search_posts);
					$kk_num = mysqli_num_rows($res_posts); 
				}
				
                if($kk_num > 0){					
					$html_tags .= "<a  title='{$tag->name} Tag' class='{$tag->slug}' id='kk_item_tag'>";
					$html_tags .= "{$tag->name}</a>";
				}else{
					$html_tags .= "<a  title='{$tag->name} Tag' class='{$tag->slug}' id='kk_item_tag' style = 'color: #808080; border-color: #808080;'>";
					$html_tags .= "{$tag->name}</a>";
				}
            }
            $html_tags .= '</div>';
            echo $html_tags;
            ?>
            <div class="kk_content">
                <?php
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', get_post_format() );

                endwhile;
                ?>
            </div>
            <?php
				echo '<div class="text-center paging-navs">';
				the_posts_pagination();
				echo '</div>';

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
            <?php

            //вывод всех тегов
            $tags = get_tags();
            $html_tags = '<div class="kk_post_tags"><span>Фильтры ленты:</span>';
            foreach ($tags as $tag) {
                $tag_link = get_tag_link($tag->term_id);
                //href='{$tag_link}'
                $html_tags .= "<a  title='{$tag->name} Tag' class='{$tag->slug}' id='kk_item_tag'>";
                $html_tags .= "{$tag->name}</a>";
            }
            $html_tags .= '</div>';
            echo $html_tags;
            ?>
		</main><!-- #main -->
	</section><!-- #primary -->
    <script>
        jQuery('.kk_post_tags a').click(function () {
            var nameTag = jQuery(this).attr("title").replace(" Tag","");
            //1.проверим нет ли уже такого тега
            var haveTag = false;
            jQuery( ".kk_title_tags li h1" ).each(function( index ) {
                if(jQuery(this).text()==nameTag){
                    haveTag = true;
                }
            });
            //2.добавим если нет
            if(!haveTag){
                jQuery('.kk_title_tags').append( '<li><h1 class="page-title" style="display:inline;font-size:30px;">'+nameTag+'</h1><a onclick="closeTag(jQuery(this));"><img src="/wp-content/themes/newspaperly/icons/cross.png" /></a></li>' );
            }
            ajaxUpdateContent();
        });
        function closeTag(el){
            var countEl = el.parent().html().length;
            el.parent().remove();
            //alert(jQuery(".kk_title_tags").html().length);
            if(jQuery(".kk_title_tags").html().length<=countEl){
                window.location.href = location.href;
            }else{
                ajaxUpdateContent();
            }
        }
        function incheckTags(){
            jQuery( ".kk_title_tags li h1" ).each(function( index ) {
                jQuery(this).parent().remove();
            });
            window.location.href = location.href;
        }
        function checkTags(){
            jQuery( ".kk_post_tags a" ).each(function( index ) {
                nameTag = jQuery(this).attr("title").replace(" Tag", "");
                //1.проверим нет ли уже такого тега
                var haveTag = false;
                jQuery(".kk_title_tags li h1").each(function (index) {
                    if (jQuery(this).text() == nameTag) {
                        haveTag = true;
                    }
                });
                //2.добавим если нет
                if (!haveTag) {
                    jQuery('.kk_title_tags').append('<li><h1 class="page-title" style="display:inline;font-size:30px;">' + nameTag + '</h1><a onclick="closeTag(jQuery(this));"><img src="/wp-content/themes/newspaperly/icons/cross.png" /></a></li>');
                }
            });
            ajaxUpdateContent();
        }
        function ajaxUpdateContent(){
            //1.получим список отобранных тегов
            var strTags="";
            jQuery( ".kk_title_tags li h1" ).each(function( index ) {
                if(strTags.length==0){
                    strTags = jQuery(this).text();
                }else{
                    strTags = strTags + "," + jQuery(this).text();
                }
            });
            //2.отправим пост запрос ajax
            jQuery.ajax({
                url: "/kk_script/ajax/getPostsSearchForTags.php",
                cache: false,
                type: "post",
                data: 'TheStrTags='+strTags+'&Search='+jQuery(".page-title span").html(),
                success: function(html){
                    jQuery('.kk_content').html(html);
                    jQuery('.paging-navs').remove();
                }
            });
        }
    </script>
<?php
get_sidebar();
get_footer();
