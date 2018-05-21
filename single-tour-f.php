<?php
/**
 * The main template file for display single post tour.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

$page_style = 'Right Sidebar';
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

if(empty($page_sidebar))
{
	$page_sidebar = 'Page Sidebar';
}
get_header();

//Include custom header feature
//Get Tour Meta
$tour_country= get_post_meta($current_page_id, 'tour_country', true);
$tour_price= get_post_meta($current_page_id, 'tour_price', true);
$tour_price_discount= get_post_meta($current_page_id, 'tour_price_discount', true);
$tour_price_currency= get_post_meta($current_page_id, 'tour_price_currency', true);
$tour_availability= get_post_meta($current_page_id, 'tour_availability', true);
$tour_booking_url= get_post_meta($current_page_id, 'tour_booking_url', true);
$ngay_trong_tour = get_post_meta($current_page_id, 'so_ngay_trong_tour', true);
$tour_des = get_post_meta($current_page_id, 'mo_ta_hanh_trinh', true);
//Get number of your days
$tour_start_date= get_post_meta($current_page_id, 'tour_start_date', true);
$tour_end_date= get_post_meta($current_page_id, 'tour_end_date', true);
$tour_start_date_raw= get_post_meta($current_page_id, 'tour_start_date_raw', true);
$tour_end_date_raw= get_post_meta($current_page_id, 'tour_end_date_raw', true);
$tour_days = pp_date_diff($tour_start_date_raw, $tour_end_date_raw);
$current = get_bloginfo('language');


?>

    <div class="uk-text-center uk-panel"></div>
    <div class="uk-panel  uk-header  uk-cover-background" style="height:50px;">
    <div class="uk-overlay-panel uk-flex uk-flex-middle uk-flex-center" style="background-color: #0164DC;">
      <div class=" sing_tile uk-text-center">
        <?php single_post_title(); ?>
      </div>
    </div>
    </div>
    <div class="inner">

    	<!-- Begid Main content -->
    	<div class="inner_wrapper">

    		<?php

				if($tour_days > 0)
				{
				    $tour_days = intval($tour_days+1).' '.__( 'Days', THEMEDOMAIN );
				}
				else
				{
				    $tour_days = intval($tour_days+1).' '.__( 'Day', THEMEDOMAIN );
				}

				$tour_price_display = 0;
				if(empty($tour_price_discount))
				{
				    if(!empty($tour_price))
				    {
              if ($current == 'fr-FR') {
				    	$tour_price_display = pp_number_format($tour_price).'<span class="currency">'.$tour_price_currency.'</span>';
              }
              else $tour_price_display = $tour_price_currency.pp_number_format($tour_price);
				    }
				}
				else
				{
				    $tour_price_display = '<span class="tour_normal_price">'.$tour_price_currency.pp_number_format($tour_price).'</span>';
				    $tour_price_display.= '<span class="tour_discount_price">'.$tour_price_currency.pp_number_format($tour_price_discount).'</span>';
				}

    			//Check if display tour attribute
    			$pp_tour_attribute = get_option('pp_tour_attribute');
    			if(empty($pp_tour_attribute))
    			{
    				//Set tour attribute block class
					$tour_block_class = 'one_fifth';
					$tour_block_count = 5;

					if(empty($tour_start_date) OR empty($tour_end_date))
					{
						$tour_block_count--;
						$tour_block_count--;
					}

					if(empty($tour_price_display))
					{
						$tour_block_count--;
					}

					switch($tour_block_count)
					{
						case 5:
						default:
							$tour_block_class = 'one_fifth';
						break;

						case 4:
							$tour_block_class = 'one_fourth';
						break;

						case 3:
							$tour_block_class = 'one_third';
						break;

						case 2:
							$tour_block_class = 'one_half';
						break;

						case 1:
							$tour_block_class = 'one';
						break;
					}
				?>

        <?php if ($current != 'fr-FR') {
          ?>

        <div class="tour_meta_wrapper">
					<div class="page_content_wrapper ">
						<?php
					    	if(!empty($tour_start_date) && !empty($tour_end_date))
					    	{
					    ?>
					    <div class="<?php echo esc_attr($tour_block_class); ?>">
					    	<div class="tour_meta_title"><?php echo _e( 'Date', THEMEDOMAIN ); ?></div>
					    	<div class="tour_meta_value"><?php echo date_i18n('d M', strtotime($tour_start_date)); ?> - <?php echo date_i18n('d M', strtotime($tour_end_date)); ?></div>
					    </div>
					    <div class="<?php echo esc_attr($tour_block_class); ?>">
					    	<div class="tour_meta_title"><?php echo _e( 'Duration', THEMEDOMAIN ); ?></div>
					    	<div class="tour_meta_value"><?php echo $tour_days; ?></div>
					    </div>
					    <?php
						    }
						?>
					    <?php
					    	if(!empty($tour_price_display))
					    	{
					    ?>
					    <div class="<?php echo esc_attr($tour_block_class); ?>">
					    	<div class="tour_meta_title"><?php echo _e( 'Price', THEMEDOMAIN ); ?></div>
					    	<div class="tour_meta_value"><?php echo $tour_price_display; ?></div>
					    </div>
					    <?php
					    	}
					    ?>
					    <div class="<?php echo esc_attr($tour_block_class); ?>">
					    	<div class="tour_meta_title" style="line-height:55px;min-height:55px;"><?php echo _e( 'LIÊN HỆ', THEMEDOMAIN ); ?></div>
					    	<div class="tour_meta_value"><?php echo $tour_availability; ?></div>
					    </div>
					    <div class="<?php echo esc_attr($tour_block_class); ?> last">
					    	<a id="tour_book_btn" <?php if(!empty($tour_booking_url)) { ?>href="<?php echo $tour_booking_url; ?>"<?php }?> class="button center">
                  <?php if ($current =="vi") {
                        echo _e( 'Đặt ngay', THEMEDOMAIN );}
                        else if ($current == "fr-FR")
                        {echo _e( 'Reserve maintenant', THEMEDOMAIN );}
                              else {echo _e( 'Book Now', THEMEDOMAIN );} ?></a>
					    </div>
					</div>
				</div>
			<?php
				}
            }
			?>

      <?php
        $fields = CFS()->get('gallery');
        if(!empty($fields))
        { ?>      <?php       /*  $test= CFS()->get( 'test' );
        echo $test;
        echo wp_get_attachment_image( $test, array('700', '600'), "", array( "class" => "img-responsive" ) );
        echo get_post_meta( $test, '_wp_attachment_image_alt', true); */


      ?>
      <div class="uk-panel" style="z-index:-1;"></div>
          <div class="page_content_wrapper">
          <div class="" uk-grid>
              <div class="uk-width-2-3@m">
                <div class="uk-slidenav-position uk-panel uk-margin-bottom uk-margin-top" data-uk-slideshow="{autoplay:true,height:'400px'}" >
                <ul class="uk-slideshow" >
                    <?php
        foreach ( $fields as $field ) {?> <li><?php echo wp_get_attachment_image( $field['image'], array('700', '600'), "", array( "class" => "img-responsive" ) ); ?>                        </li>                    <?php
                  }                    ?>
          </ul>
              <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
              <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
              <div class="uk-slidenav-position uk-margin-top uk-hidden-small" data-uk-slider="{infinite: false}">

              <div class="uk-slider-container slider-set">
                  <ul class="uk-slider uk-grid-width-medium-1-6 uk-grid-small">
                  <?php $i=0;   foreach ( $fields as $field )
                  {
                  ?>
                      <li data-uk-slideshow-item="<?php echo $i;$i++; ?>" style="height:100px;">
                        <div class="uk-cover-container">
                          <canvas width="100%" height="60" style="width:100%;"></canvas>
                          <?php echo wp_get_attachment_image( $field['image'], array('100', '60'), "", array( "uk-cover" => "" ) ); ?>


                        </div>
                      </li>
                    <?php

                        }
                    ?>
                  </ul>
                   <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                   <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                  </div>

                </div>
     
                </div>
              </div>
              <div class="uk-width-1-3@m ">
              <div class="box-right">
                  <h3 class="similar-title">Similar Tours</h3>
                  <div class="uk-margin-top">
                <?php

                      // get the custom post type's taxonomy terms

                      $custom_taxterms = wp_get_object_terms( $post->ID, 'tourcats', array('fields' => 'ids') );
                      // arguments
                      $args = array(
                      'post_type' => 'tours',
                      'post_status' => 'publish',
                      'posts_per_page' => 6, // you may edit this number
                      'orderby' => 'rand',
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'tourcats',
                              'field' => 'id',
                              'terms' => $custom_taxterms
                          )
                      ),
                      'post__not_in' => array ($post->ID),
                      );
                      $related_items = new WP_Query( $args );
                      // loop over query
                      if ($related_items->have_posts()) :
                      echo '<ul style="list-style:none;">';
                      while ( $related_items->have_posts() ) : $related_items->the_post();

                      ?>
                          <li class="uk-margin-small-bottom">
                            <div uk-grid class="uk-grid-collapse">
                            <div class="uk-width-1-5">
                              <div class="uk-cover-container">
                                  <a href="<?php the_permalink(); ?>">
                                    <canvas width="400" height="250"></canvas>
                                    <?php echo get_the_post_thumbnail( get_the_ID(),'thumbnail', array( 'class' => 'uk-cover' ) ); ?>
                                  </a>
                                </div>
                                  </div>
                            <div class="uk-width-4-5 uk-flex uk-flex-middle" style="padding-left:10px;">  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                            </div>
                          </li>
                      <?php
                      endwhile;
                      echo '</ul>';
                      endif;
                      // Reset Post Data
                      wp_reset_postdata();
                      ?>

              </div>
              <!--div class="uk-flex uk-flex-middle uk-flex-center uk-margin-top" style="border: 1px solid red;
    padding: 20px;">
                <?php $red = "red"; ?>

                <a id="call_to_action_tour_book_btn" <?php if(!empty($tour_booking_url)) { ?>href="<?php echo $tour_booking_url; ?>"<?php }?> class="button  uk-margin-remove <?php echo $red; ?>"><?php

                if ($current =="vi") {
                      echo _e( 'Đặt ngay', THEMEDOMAIN );}
                      else if ($current == "fr-FR")
                      {echo _e( 'RÉSERVER', THEMEDOMAIN );}
                            else {
                            echo _e( 'Book Now', THEMEDOMAIN );
                             }
                ?></a>
                <div class="price-en">
                <?php

                if(!empty($tour_price_display))
                {
                  switch ($current ) {
                    case 'fr-FR':
                      echo '<div >A partir de</div>';
                      echo '<div class="gia-dep">'.$tour_price_display.'</div>';
                      echo '<div>par personne</div>';
                      break;
                      case 'vi':
                        echo '<div>Giá chỉ</div>';
                        echo '<div class="gia-dep">'.$tour_price_display.'</div>';
                        echo '<div>cho một người</div>';
                      break;

                    default:
                    echo '<div>From</div>';
                    echo '<div class="gia-dep">'.$tour_price_display.'</div>';
                    echo '<div>per person</div>';
                      break;
                  }

                }
                ?>
              </div>
              </div-->
            </div></div>
          </div>


  </div>
  <?php

  }

    ?>
    <!-- This is the tabbed navigation containing the toggling elements -->

    <div class="page_content_wrapper  ?> ">
      <div class="uk-panel"></div>
      <br class="clear" />


    <?php if ($current == "vi"){ ?>
    <ul class="uk-tab red" data-uk-tab="{connect:'#my-id'}" style="padding-top:30px;">
        <li><a href="">Tổng quan</a></li>
        <li><a href="">Hành trình</a></li>
        <li><a href="">Giá và Dịch vụ</a></li>
        <li><a href="">Bản đồ tour</a></li>
    </ul>
    <div class="uk-panel" style="padding:20px;">
    <ul id="my-id" class="uk-switcher uk-margin" >
        <li><?php
        if (have_posts())
        {
          while (have_posts()) : the_post();

          the_content();

              endwhile;
          }
        ?>
        <?php
          //Get Social Share

        ?></li>
        <li><?php   echo CFS()->get( 'hanh_trinh' ); ?></li>
        <li><?php   echo CFS()->get( 'gia_dich_vu' ); ?></li>
        <li><?php echo get_post_meta($post->ID, 'tour_map', true); ?></li>
    </ul>

      </div>
   <?php } elseif ($current == "en-GB") { ?>

   <ul class="uk-tab red" data-uk-tab="{connect:'#my-id'}" style="padding-top:30px;">
       <li><a href="">Overview</a></li>
       <li><a href="">Itinerary Details</a></li>
       <li><a href="">Prices & Services</a></li>
       <li><a href="">Tour map</a></li>
   </ul>
   <div class="uk-panel" style="padding:20px;">
   <ul id="my-id" class="uk-switcher uk-margin" >
       <li><?php
       if (have_posts())
       {
         while (have_posts()) : the_post();

         the_content();

             endwhile;
         }
       ?>
       <?php
         //Get Social Share

       ?></li>
       <li><?php   echo CFS()->get( 'hanh_trinh' ); ?></li>
       <li><?php   echo CFS()->get( 'gia_dich_vu' ); ?></li>
       <li><?php echo get_post_meta($post->ID, 'tour_map', true); ?></li>
   </ul>

     </div>
   <?php } ?>

   <?php if ($current == "fr-FR"){ ?>

   <ul class="uk-tab" data-uk-tab="{connect:'#my-id'}" style="padding-top:30px;">
       <li><a href="">DESCRIPTIF</a></li>
       <li><a href="">PROGRAMME DÉTAILLÉE</a></li>
       <li><a href="">PRIX ET SERVICE</a></li>
       <li><a href="">TOUR MAP</a></li>
   </ul>
   <div class="uk-panel" style="padding:20px;">
   <ul id="my-id" class="uk-switcher uk-margin" >
       <li><?php
       if (have_posts())
       {
         while (have_posts()) : the_post();

         the_content();

             endwhile;
         }
       ?>
       <?php
         //Get Social Share

       ?></li>
       <li><?php   echo CFS()->get( 'hanh_trinh' ); ?></li>
       <li><?php   echo CFS()->get( 'gia_dich_vu' ); ?></li>
       <li><?php echo get_post_meta($post->ID, 'tour_map', true); ?></li>

   </ul>



  </div>
   <?php } ?>


   </div>
    <!-- This is the container of the content items -->
	    	<div class="sidebar_content full_width">
		    	<div class="page_content_wrapper  ">
            <div uk-grid>
              <div class="uk-width-1-2 booking-block">
                <div class="">

    							<!--a id="call_to_action_tour_book_btn" <?php if(!empty($tour_booking_url)) { ?>href="<?php echo $tour_booking_url; ?>"<?php }?> class="button <?php echo $red; ?>"><?php

                  if ($current =="vi") {
                        echo _e( 'Đặt ngay', THEMEDOMAIN );}
                        else if ($current == "fr-FR")
                        {echo _e( 'RÉSERVER', THEMEDOMAIN );}
                              else {
                                echo _e( 'Book Now', THEMEDOMAIN );

                              }
                  ?></a-->
                   <div class="uk-flex uk-flex-middle uk-flex-center uk-margin-top" style="border: 1px solid red;
    padding: 20px;margin-bottom:10px">
                <?php $red = "red"; ?>

                <a id="call_to_action_tour_book_btn" <?php if(!empty($tour_booking_url)) { ?>href="<?php echo $tour_booking_url; ?>"<?php }?> class="button  uk-margin-remove <?php echo $red; ?>"><?php

                if ($current =="vi") {
                      echo _e( 'Đặt ngay', THEMEDOMAIN );}
                      else if ($current == "fr-FR")
                      {echo _e( 'RÉSERVER', THEMEDOMAIN );}
                            else {
                            echo _e( 'Book Now', THEMEDOMAIN );
                             }
                ?></a>
                <div class="price-en">
                <?php

                if(!empty($tour_price_display))
                {
                  switch ($current ) {
                    case 'fr-FR':
                      echo '<div >A partir de</div>';
                      echo '<div class="gia-dep">'.$tour_price_display.'</div>';
                      echo '<div>par personne</div>';
                      break;
                      case 'vi':
                        echo '<div>Giá chỉ</div>';
                        echo '<div class="gia-dep">'.$tour_price_display.'</div>';
                        echo '<div>cho một người</div>';
                      break;

                    default:
                    echo '<div>From</div>';
                    echo '<div class="gia-dep">'.$tour_price_display.'</div>';
                    echo '<div>per person</div>';
                      break;
                  }

                }
                ?>
              </div>
              </div>
    						</div>
              </div>
              <div class="uk-width-1-2 share-block">
                <?php
    			    		//Get Social Share
    						get_template_part("/templates/template-share");
    			    	?>

              </div>
            </div>

		    	</div>

		    	<?php
		    		//Check if enable comment
		    		$pp_tour_comment = get_option('pp_tour_comment');

		    		if(!empty($pp_tour_comment))
		    		{
		    	?>
		    	<div class="page_content_wrapper">
		    	<?php
						comments_template( '' );
				?>
		    	</div>
				<?php
		    		}
		    	?>

		    	<?php
          /*
		    		$pp_page_bg = '';
		    	    //Get page featured image
				    if(has_post_thumbnail($current_page_id, 'full') && empty($term))
				    {
				        $image_id = get_post_thumbnail_id($current_page_id);
				        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
				        $pp_page_bg = $image_thumb[0];
				    }

				    if(isset($image_thumb[0]))
				    {
					   $background_image = $image_thumb[0];
						$background_image_width = $image_thumb[1];
						$background_image_height = $image_thumb[2];
					}

				    if(!empty($pp_page_bg))
				    {
		    	?>
			    	<div class="tour_call_to_action parallax" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url('<?php echo $pp_page_bg; ?>');"<?php } ?>>
						<div class="parallax_overlay_header tour"></div>

						<div class="tour_call_to_action_box">
							<div class="tour_call_to_action_price"><?php _e( "Starting Price", THEMEDOMAIN ); ?> <?php echo $tour_price_display; ?></div>
							<div class="tour_call_to_action_book"><?php _e( "Book This Tour", THEMEDOMAIN ); ?></div>
							<a id="call_to_action_tour_book_btn" <?php if(!empty($tour_booking_url)) { ?>href="<?php echo $tour_booking_url; ?>"<?php }?> class="button"><?php echo _e( 'Book Now', THEMEDOMAIN ); ?></a>
						</div>
			    	</div>
		    	<?php
        }*/
		    	?>

		    	<?php
		    		if(empty($pp_tour_attribute))
					{
						//Set tour attribute block class
						$tour_block_class = 'one_fourth';
						$tour_block_count = 4;

						if(empty($tour_start_date) OR empty($tour_end_date))
						{
							$tour_block_count--;
							$tour_block_count--;
						}

						if(empty($tour_price_display))
						{
							$tour_block_count--;
						}

						switch($tour_block_count)
						{
							case 4:
							default:
								$tour_block_class = 'one_fourth';
							break;

							case 3:
								$tour_block_class = 'one_third';
							break;

							case 2:
								$tour_block_class = 'one_half';
							break;

							case 1:
								$tour_block_class = 'one';
							break;
						}
						?>
			    	<div class="tour_meta_wrapper toaction">
						<div class="page_content_wrapper">
							<?php
						    	if(!empty($tour_start_date) && !empty($tour_end_date))
						    	{
						    ?>
						    <div class="<?php echo esc_attr($tour_block_class); ?>">
						    	<div class="tour_meta_title"><?php echo _e( 'Date', THEMEDOMAIN ); ?></div>
						    	<div class="tour_meta_value"><?php echo date_i18n('d M', strtotime($tour_start_date)); ?> - <?php echo date_i18n('d M', strtotime($tour_end_date)); ?></div>
						    </div>
						    <div class="<?php echo esc_attr($tour_block_class); ?>">
						    	<div class="tour_meta_title"><?php echo _e( 'Duration', THEMEDOMAIN ); ?></div>
						    	<div class="tour_meta_value"><?php echo $tour_days; ?></div>
						    </div>
                <div class="<?php echo esc_attr($tour_block_class); ?>">
                 <div class="tour_meta_title"><?php echo _e( 'TRANSPORT', THEMEDOMAIN ); ?></div>
                 <div class="tour_meta_value"><?php echo $tour_days; ?></div>
               </div>
						    <?php
						    	}
						    ?>
						    <?php
						    	if(!empty($tour_price_display))
						    	{
						    ?>
						    <div class="<?php echo esc_attr($tour_block_class); ?>">
						    	<div class="tour_meta_title"><?php echo _e( 'Price', THEMEDOMAIN ); ?></div>
						    	<div class="tour_meta_value"><?php echo $tour_price_display; ?></div>
                  <div></div>
						    </div>
						    <?php
						    	}
						    ?>
						    <div class="<?php echo esc_attr($tour_block_class); ?> last">
						    	<div class="tour_meta_title"><?php echo _e( 'Availability', THEMEDOMAIN ); ?></div>
						    	<div class="tour_meta_value"><?php echo $tour_availability; ?></div>
						    </div>
						</div>
					</div>
				<?php
					}
				?>


		    	<?php
		    	$pp_tour_next_prev = get_option('pp_tour_next_prev');
		    	if(!empty($pp_tour_next_prev))
		    	{
				    //Get Previous and Next Post
				    $prev_post = get_previous_post();
				    $next_post = get_next_post();
				?>
				<div class="blog_next_prev_wrapper tour">
				   <div class="post_previous">
				      	<?php
				    	    //Get Previous Post
				    	    if (!empty($prev_post)):
				    	    	$prev_image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($prev_post->ID), 'thumbnail', true);
				    	    	if(isset($prev_image_thumb[0]))
				    	    	{
									$image_file_name = basename($prev_image_thumb[0]);
				    	    	}
				    	?>
				      		<span class="post_previous_icon"><i class="fa fa-angle-left"></i></span>
				      		<div class="post_previous_content">
				      			<h6><?php echo _e( 'Previous Tour', THEMEDOMAIN ); ?></h6>
				      			<strong><a <?php if(isset($prev_image_thumb[0]) && $image_file_name!='default.png') { ?>class="post_prev_next_link" data-img="<?php echo $prev_image_thumb[0]; ?>"<?php } ?> href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a></strong>
				      		</div>
				      	<?php endif; ?>
				   </div>
				   <span class="separated"></span>
				   <div class="post_next">
				   		<?php
				    	    //Get Next Post
				    	    if (!empty($next_post)):
				    	    	$next_image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'thumbnail', true);
				    	    	if(isset($next_image_thumb[0]))
				    	    	{
									$image_file_name = basename($next_image_thumb[0]);
				    	    	}
				    	?>
				      		<span class="post_next_icon"><i class="fa fa-angle-right"></i></span>
				      		<div class="post_next_content">
				      			<h6><?php echo _e( 'Next Tour', THEMEDOMAIN ); ?></h6>
				      			<strong><a <?php if(isset($prev_image_thumb[0]) && $image_file_name!='default.png') { ?>class="post_prev_next_link" data-img="<?php echo $next_image_thumb[0]; ?>"<?php } ?> href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a></strong>
				      		</div>
				      	<?php endif; ?>
				   </div>
				</div>
				<?php
				}
				?>
		    </div>

    	</div>

    </div>
    <!-- End main content -->

</div>

<?php
	$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full') && empty($term))
    {
        $image_id = get_post_thumbnail_id($current_page_id);
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        $pp_page_bg = $image_thumb[0];
    }

    wp_enqueue_script("jquery.validate", get_template_directory_uri()."/js/jquery.validate.js", false, THEMEVERSION, true);
    wp_register_script("script-booking-form", get_template_directory_uri()."/templates/script-booking-form.php", false, THEMEVERSION, true);
	$params = array(
	  'ajaxurl' => admin_url('admin-ajax.php'),
	  'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
	);
	wp_localize_script( 'script-booking-form', 'tgAjax', $params );
	wp_enqueue_script("script-booking-form", get_template_directory_uri()."/templates/script-booking-form.php", false, THEMEVERSION, true);
?>
<div id="tour_book_wrapper" <?php if(!empty($pp_page_bg)) { ?>style="background-image: url('<?php echo $pp_page_bg; ?>');"<?php } ?>>
	<div class="tour_book_content">
		<a id="booking_cancel_btn" href="javascript:;"><i class="fa fa-close"></i></a>
		<div class="tour_book_form">
			<div class="tour_book_form_wrapper">
				<h2 class="ppb_title"><?php
        if ($current =="vi") {
             echo _e( 'Đặt ngay ', THEMEDOMAIN );}
             else if ($current == "fr-FR")
             {echo _e( 'RÉSERVER ', THEMEDOMAIN );}
                   else {echo _e( 'Booking for', THEMEDOMAIN );}

         ?><?php echo get_the_title(); ?></h2>
				<div id="reponse_msg"><ul></ul></div>

				<!--form id="pp_booking_form" method="post" action="/wp-admin/admin-ajax.php">
			    	<input type="hidden" id="action" name="action" value="pp_booking_mailer"/>
			    	<input type="hidden" id="tour_title" name="tour_title" value="<?php echo get_the_title(); ?>"/>
			    	<input type="hidden" id="tour_url" name="tour_url" value="<?php echo get_permalink($current_page_id); ?>"/>

			    	<div class="one_half">

				    	<label for="first_name"><?php
              if($current=="vi")
              {
                echo _e( 'Họ của bạn', THEMEDOMAIN );
              }
              else if($current=="fr-FR"){echo _e( 'Prénom', THEMEDOMAIN ); }
                   else { echo _e( 'First Name', THEMEDOMAIN ); }
              ?></label>
						  <input id="first_name" name="first_name" type="text" class="required_field"/>
			    	</div>

					<div class="one_half last">
						<label for="last_name"><?php
            if($current=="vi")
            {
              echo _e( 'Tên của bạn', THEMEDOMAIN );
            }
            else if($current=="fr-FR") {echo _e( 'Nom de famille', THEMEDOMAIN ); }
                 else { echo _e( 'last Name', THEMEDOMAIN ); }
            ?></label>
						<input id="last_name" name="last_name" type="text" class="required_field"/>
					</div>

					<br class="clear"/><br/>

					<div class="one_half">
						<label for="email"><?php echo _e( 'Email', THEMEDOMAIN ); ?></label>
						<input id="email" name="email" type="text" class="required_field"/>
					</div>

					<div class="one_half last">
						<label for="phone"><?php
            if($current=="vi")
            {
              echo _e( 'Điện thoại', THEMEDOMAIN );
            }
            else if($current=="fr-FR") {echo _e( 'Téléphone', THEMEDOMAIN ); }
                 else {   echo _e( 'Phone', THEMEDOMAIN );  }

            ?></label>
						<input id="phone" name="phone" type="text"/>
					</div>

					<br class="clear"/><br/>

					<div class="one">

						<label for="message"><?php
            if($current=="vi")
            {
              echo _e( 'Để lại lời nhắn', THEMEDOMAIN );
            }
            else if($current=="fr-FR") {echo _e( 'Message supplémentaire', THEMEDOMAIN ); }
                 else {     echo _e( 'Additional Message', THEMEDOMAIN );  }

            ?></label>
					    <textarea id="message" name="message" rows="7" cols="10"></textarea>
					</div>

					<br class="clear"/>

				    <div class="one">
					    <p>
		    				<input id="booking_submit_btn" class="<?php echo $red; ?>"type="submit" value="<?php


                 if ($current =="vi") {
                       echo _e( 'Đặt ngay', THEMEDOMAIN );}
                       else if ($current == "fr-FR")
                       { echo _e( 'RÉSERVER', THEMEDOMAIN );}
                             else { echo _e( 'Book By Email', THEMEDOMAIN ); } ?>">


					    </p>
				    </div>
				</form-->
        <?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
			</div>
		</div>
	</div>
	<div class="parallax_overlay_header tour"></div>
</div>

<?php get_footer(); ?>
<script type="text/javascript">
  jQuery(document).ready(function(){
    _title = jQuery(".sing_tile").text();
    jQuery("#input_1_1").val(_title);
  })
</script>
