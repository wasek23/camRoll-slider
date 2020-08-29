<?php
/*
 * Plugin Name: camRoll Slider
 * Description: camRoll is a slider/carousel plugin that enables the user to navigate between slides by clicking/tapping the navigation thumbnails. To show slider in page or post use [camRoll_slider] shortcode in page or post.
 * Author: Wasek Bellah
 * Author URI: https://wasek-bellah.web.app/
 * Version: 1.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: camRoll
 */


// CSS and JS
function camRoll_css_js() {
    wp_enqueue_style('camRoll_slider', plugin_dir_url( __FILE__ ) . 'css/camroll_slider.css', '', 1.0, 'all');
    wp_enqueue_style('camRoll_style', plugin_dir_url( __FILE__ ) . 'css/camroll_style.css', '', time(), 'all');
   
    wp_enqueue_script('jquery331', 'https://code.jquery.com/jquery-3.3.1.min.js', '', 3.3);
    wp_enqueue_script('camRoll_slider_min_js', plugin_dir_url( __FILE__ ) . 'js/camroll_slider.min.js', '', 1.0, true);
    wp_enqueue_script('camRoll_script', plugin_dir_url( __FILE__ ) . 'js/camroll_custom.js', '', time(), true);
}
add_action('wp_enqueue_scripts', 'camRoll_css_js');


// Register Custom Post
function camRoll_slider(){
    register_post_type('camRoll', array(
        'labels'      => array(
            'name'          => __('camRoll Slider', 'camRoll'),
            'add_new'       => __('Add Slider', 'camRoll'),
            'add_new_item'  => __('Add Slider Item', 'camRoll'),
            'edit_item'     => __('Edit Slider Item', 'camRoll'),
            'new_item'      => __('New Slider Item', 'camRoll'),
            'view_item'     => __('View Slider Item', 'camRoll'),
            'view_items'    => __('View Slider', 'camRoll')
        ),
        'public'      => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports'    => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-images-alt'
    ));
}
add_action('init', 'camRoll_slider');


// ShortCode
function camRoll_slider_shortcode(){
    $camRollLoop = new WP_Query(array(
        'post_type' => 'camRoll'
    ));

    if($camRollLoop->have_posts()) : ?>
        <div class="camRoll-container">
            <div id="camRoll-slider" class="crs-wrap">
                <div class="crs-screen">
                    <div class="crs-screen-roll">

                        <?php while($camRollLoop->have_posts()) : $camRollLoop->the_post(); ?>
                            <div class="crs-screen-item" style="background-image: url(<?php the_post_thumbnail_url() ?>)">
                                <div class="crs-screen-item-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>
                </div> <!-- CRS Screen -->

                <div class="crs-bar">
					<div class="crs-bar-roll-current"></div>
					
					<div class="crs-bar-roll-wrap">
						<div class="crs-bar-roll">
                        
                            <?php while($camRollLoop->have_posts()) : $camRollLoop->the_post(); ?>
                                <div class="crs-bar-roll-item" style="background-image: url(<?php the_post_thumbnail_url() ?>)"></div>
                            <?php endwhile; ?>

                        </div>
					</div>
				</div> <!-- CRS bar -->
			</div> <!-- My Slider -->
        </div> <!-- Container -->
    <?php else : echo '<h3>No camRoll Slider found, please add slider.</h3>';
    endif;
}
add_shortcode('camRoll_slider', 'camRoll_slider_shortcode');     