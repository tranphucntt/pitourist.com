<?php
/**
 * Template Name: Home page france
 * The main template file for display tour page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

get_header();
?>

<div class="page_content_wrapper " style="">
<?php
      //Get Page RevSlider
      $page_revslider = get_post_meta($current_page_id, 'page_revslider', true);
      $page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
      $page_header_below = get_post_meta($current_page_id, 'page_header_below', true);

      if(!empty($page_revslider) && $page_revslider != -1 && empty($page_header_below))
      {
      	echo '<div class="page_slider ';
      	if(!empty($page_menu_transparent))
      	{
  	    	echo 'menu_transparent';
      	}
      	echo '">'.do_shortcode('[rev_slider '.$page_revslider.']').'</div>';
      }
  ?>
  <?php
     //Include custom tour search feature
     echo tour;
   get_template_part("/templates/template-tour-search");
  ?>
	 <?php echo tg_apply_content($post->post_content); ?>


<br class="clear"/>

<?php get_footer(); ?>
