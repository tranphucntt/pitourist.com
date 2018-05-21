<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style("uikit",trailingslashit( get_stylesheet_directory_uri() ) . "css/uikit.min.css");
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'animation.css','jquery-ui','magnific-popup','flexslider','tooltipster','parallax','flexslider-css','supersized','odometer-theme','screen-css','fontawesome','responsive' ) );
        wp_enqueue_script("uikit-js",trailingslashit( get_stylesheet_directory_uri() ) ."js/uikit.min.js");
        wp_enqueue_script("uikit-icon",trailingslashit( get_stylesheet_directory_uri() ) ."js/uikit-icons.min.js");
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css' );

// END ENQUEUE PARENT ACTION

function france_list_tour($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'items' => 8,
		'tourcat' => '',
		'order' => 'default',
		'custom_css' => '',
		'layout' => 'fullwidth',
	), $atts));

	if(!is_numeric($items))
	{
		$items = 8;
	}

	$return_html = '<div class="ppb_tour '.$size.' withpadding ';

	$columns_class = 'three_cols';
	if($layout=='fullwidth')
	{
		$columns_class.= ' fullwidth';
	}
	$element_class = 'one_third gallery3';
	$tour_h = 'h5';

	if(empty($content) && empty($title))
	{
		$return_html.='nopadding ';
	}

	$return_html.= '" ';

	if(!empty($custom_css))
	{
		$return_html.= 'style="'.urldecode($custom_css).'" ';
	}

	$return_html.= '>';

	$return_html.='<div class="uk-panel';

	$return_html.= '" style="text-align:center">';

	//Display Title
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title">'.$title.'</h2>';
	}

	//Display Content
	if(!empty($content) && !empty($title))
	{
		$return_html.= '<div class="page_caption_desc">'.$content.'</div>';
	}

	//Display Horizontal Line
	if(empty($content) && !empty($title))
	{
		$return_html.= '<br/>';
	}

	$tour_order = 'ASC';
	$tour_order_by = 'menu_order';
	switch($order)
	{
		case 'default':
			$tour_order = 'ASC';
			$tour_order_by = 'menu_order';
		break;

		case 'newest':
			$tour_order = 'DESC';
			$tour_order_by = 'post_date';
		break;

		case 'oldest':
			$tour_order = 'ASC';
			$tour_order_by = 'post_date';
		break;

		case 'title':
			$tour_order = 'ASC';
			$tour_order_by = 'title';
		break;

		case 'random':
			$tour_order = 'ASC';
			$tour_order_by = 'rand';
		break;
	}

	//Get tour items
	$args = array(
	    'numberposts' => $items,
	    'order' => $tour_order,
	    'orderby' => $tour_order_by,
	    'post_type' => array('tours'),
	    'suppress_filters' => 0,
	);

	if(!empty($tourcat))
	{
		$args['tourcats'] = $tourcat;
	}
	$tours_arr = get_posts($args);

	if(!empty($tours_arr) && is_array($tours_arr))
	{
		$return_html.= '<div class="uk-width-1-1"><div class="uk-panel effect2" style="padding:20px;border:1px solid #C8C8C8;">';

		foreach($tours_arr as $key => $tour)
		{

			$image_url = '';
			$tour_ID = $tour->ID;

			if(has_post_thumbnail($tour_ID, 'large'))
			{
			    $image_id = get_post_thumbnail_id($tour_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'full', true);
			    $small_image_url = wp_get_attachment_image_src($image_id, 'gallery_grid', true);
			}

			//Get Tour Meta
      $hanh_trinh = get_post_meta($tour_ID, 'mo_ta_hanh_trinh', true);
			$tour_permalink_url = get_permalink($tour_ID);
			$tour_title = $tour->post_title;
      $tour_so_nguoi = get_post_meta($tour_ID,'so_nguoi',true);
			$tour_country= get_post_meta($tour_ID, 'tour_country', true);
			$tour_price= get_post_meta($tour_ID, 'tour_price', true);
      $giam_gia = get_post_meta($tour_ID,'giam_gia',true);
			$tour_price_discount= get_post_meta($tour_ID, 'tour_price_discount', true);
			$tour_price_currency= get_post_meta($tour_ID, 'tour_price_currency', true);
			$tour_discount_percentage = 0;
			$tour_price_display = '';

			if(!empty($tour_price))
			{
				if(!empty($tour_price_discount))
				{
					if($tour_price_discount < $tour_price)
					{
						$tour_discount_percentage = intval((($tour_price-$tour_price_discount)/$tour_price)*100);
					}
				}

				if(empty($tour_price_discount))
				{
					$tour_price_display = pp_number_format($tour_price).'<sup>'.$tour_price_currency.'</sup>';
				}
				else
				{
					$tour_price_display = pp_number_format($tour_price_discount).'<sup>'.$tour_price_currency.'</sup>';
				}
			}

			//Get number of your days
			$tour_days = 0;
			$tour_start_date= get_post_meta($tour_ID, 'tour_start_date', true);
			$tour_end_date= get_post_meta($tour_ID, 'tour_end_date', true);
			if(!empty($tour_start_date) && !empty($tour_end_date))
			{
				$tour_start_date_raw= get_post_meta($tour_ID, 'tour_start_date_raw', true);
				$tour_end_date_raw= get_post_meta($tour_ID, 'tour_end_date_raw', true);
				$tour_days = pp_date_diff($tour_start_date_raw, $tour_end_date_raw);
				if($tour_days > 0)
				{
					$tour_days = intval($tour_days+1).' '.__( 'Days', THEMEDOMAIN );
				}
				else
				{
					$tour_days = intval($tour_days+1).' '.__( 'Day', THEMEDOMAIN );
				}
			}
			$tour_permalink_url = get_permalink($tour_ID);

			//Begin display HTML
			$return_html.= '<div class="uk-panel uk-flex uk-flex-middle uk-margin">';
      if ($giam_gia != '')
      {
      $return_html.='<div class="onsale-off"><div class="burst-8"></div><div class="burst-8-text">-'.$giam_gia.'%</div></div>';
      }

      $return_html.= '<a class="uk-overlay-panel" href="'.$tour_permalink_url.'"></a>';
			$return_html.= '<div class="uk-width-1-4 ">';

			if(!empty($image_url[0]))
			{

				$return_html.= '<div class="uk-panel" style="height:98px;">
        <div class="uk-overlay-panel uk-cover-background"  style ="background-image:url('.$small_image_url[0].');" >
        		</div></div></div>';
			}

			if(!empty($tour_discount_percentage))
			{
				$return_html.= '<div class="tour_sale ';
				if($layout=='fullwidth')
				{
					$return_html.= 'fullwidth';;
				}
        			$return_html.= '"><div class="tour_sale_text">'.__( 'Best Deal', THEMEDOMAIN ).'</div>
        			'.$tour_discount_percentage.'% '.__( 'Off', THEMEDOMAIN ).'
        		</div></div>';
			}

			$return_html.= '<div class="uk-width-1-2 ';
			if($layout=='fullwidth')
			{
			    $return_html.= 'fullwidth';
			}
			$return_html.= ' "><div class="thumb_title">';

			if(!empty($tour_country))
	        {
	            	$return_html.= '<div class="tour_country">
	            		'.$tour_country.'
	            	</div>';
			    }

			        $return_html.= '<h3>'.$tour_title.'</h3>';
              if(!empty($hanh_trinh))
              {
                $return_html.='<p class="so_nguoi">'.$hanh_trinh.'</p>';
              }
              $return_html.='</div></div><div class="uk-margin-left uk-width-1-4 uk-flex uk-flex-center"><div class="thumb_meta">';

	        if(!empty($tour_days))
	        {
	            	$return_html.= '<div class="tour_days">
	            		'.$tour_days.'
	            	</div>';
	        }




	        if(!empty($tour_price_display))
	        {

            $return_html.='<p class="prix clr2">
                <span class="des">dès</span>
                <span class="prix-num">
                  <a href=""  class="clr2"><span>'.$tour_price_display.'</span></a>
                </span>
                <span class="ttc">TTC</span>
              </p>';
              $return_html.='<p class="so_nguoi">'.$tour_so_nguoi.'</p>';
	        }
	            $return_html.= '</div>';


			$return_html.= '</div>';
			$return_html.= '</div>';
		}

		$return_html.= '</div>';
	}

	$return_html.= '</div></div></div>';
	return $return_html;
}

add_shortcode('france_list_tour', 'france_list_tour');
function ring_short_code()
{
 $return_html.='<div class="quick-alo-phone quick-alo-green quick-alo-show uk-hidden@m" id="quick-alo-phoneIcon" style="bottom:0;left:0;top:auto;">  <div class="phone-ring uk-panel">
 <div class="quick-alo-ph-circle  ">
 </div>
 <div class="quick-alo-ph-circle-fill"></div>
 <div class="quick-alo-ph-img-circle uk-inline">
 <a class=" uk-overlay uk-light uk-hidden@l " href="tel:+849 622 944 77"></a>
</div>    
</div></div>';
 return $return_html;
}
add_shortcode('ring_short_code', 'ring_short_code');

add_action( 'pre_get_posts', function( $q )
{
    if( $title = $q->get( '_meta_or_title' ) )
    {
        add_filter( 'get_meta_sql', function( $sql ) use ( $title )
        {
            global $wpdb;            

            // Only run once:
            static $nr = 0; 
            if( 0 != $nr++ ) return $sql;

            // Modified WHERE
            $sql['where'] = sprintf(
                " AND ( %s AND %s ) ",
                $wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title),
                mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
            );
           // var_dump($sql);die();
            return $sql;
        });
    }
});