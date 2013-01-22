<?php
/*
Plugin Name: 404 Silent Salesman
Plugin URI: www.wpovernight.com/plugins
Description: 404 Silent Salesman turns dead 404 error traffic into profits. Just install the plugin and navigate to the options page under pages -> 404 Silent Salesman
Version: 0.1
Author: Jeremiah Prummer
Author URI: www.wpovernight.com/about
License: GPL2
*/
/*  Copyright 2012 Jeremiah Prummer (email : jeremiah.prummer@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
?>
<?php

add_action('admin_init', 'silentsalesman_404_init');
add_action('admin_menu', 'silentsalesman_404_add_page');
add_action('wp', 'silentsalesman_404_redirect');

// Init plugin options to white list our options
function silentsalesman_404_init(){
	register_setting( 'silentsalesman_404_options', '404_page_content_display', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_page_title', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_page_content', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_ss_content', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_ss_prodnumb', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_ss_colnumb', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_ss_prodtype', 'silentsalesman_404_options_validate' );
	register_setting( 'silentsalesman_404_options', '404_active_state', 'silentsalesman_404_options_validate' );
}

// Add menu page
function silentsalesman_404_add_page() {

			add_submenu_page( 'edit.php?post_type=page' , '404 Silent Salesman' , '404 Silent Salesman' , 'manage_options', 'silentsalesman_404_options_page', 'silentsalesman_404_options_do_page');
}

// Draw the menu page itself
function silentsalesman_404_options_do_page() {

?>
	<div class="wrap">
	<div style="background: #F3F3F3;-moz-border-radius: 3px;border-radius: 3px;margin:5%;padding: 10px;-moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;width: 40%;float: left"> 
	<h1 style='margin-bottom: 30px;text-align: center'><?php _e('404 Silent Salesman','woothemes') ?></h1>
	<h3><?php _e("Just fill out the information below and you're good to go. Be sure to check/uncheck the Activate 404 Silent Salesman field as needed.","woothemes") ?></h3>
	<form method="post" action="options.php">
		<?php settings_fields('silentsalesman_404_options'); ?>
		<ul>
			<li>
				<?php $options = get_option('404_active_state'); ?>
				<input type="checkbox" name="404_active_state[404_activate]" value="1" <?php checked($options['404_activate'], 1); ?> />
				<?php _e('Activate 404 Silent Salesman','woothemes') ?>
			</li>
			<li>
				<?php $options = get_option('404_page_title'); ?>
				<input type="text" name="404_page_title[404_ptitle]" value="<?php echo $options['404_ptitle']; ?>" />
				<?php _e('Set the title for your 404 page','woothemes') ?>
			</li>
			
			<?php $options = get_option('404_ss_content'); ?>
			<li>	
				<input type="radio" name="404_ss_content[404_content_display]" value="1" <?php checked('1', $options['404_content_display']); ?> />
				<?php _e('Display Text Only.','woothemes') ?>
			</li>
			<li>
				<input type="radio" name="404_ss_content[404_content_display]" value="2" <?php checked('2', $options['404_content_display']); ?> />
				<?php _e('Display Products Only.','woothemes') ?>
			</li>
			<li>
				<input type="radio" name="404_ss_content[404_content_display]" value="3" <?php checked('3', $options['404_content_display']); ?> />
				<?php _e('Display both Text and Products.','woothemes') ?>
			</li>
			
			
			<li>
				<?php $options = get_option('404_ss_prodnumb'); ?>
				<input type="text" name="404_ss_prodnumb[404_prodnumb]" value="<?php echo $options['404_prodnumb']; ?>" />
				<?php _e('Number of products to display on page. We recommend 3 or 4.','woothemes') ?>
			</li>
			<li>
				<?php $options = get_option('404_ss_colnumb'); ?>
				<input type="text" name="404_ss_colnumb[404_colnumb]" value="<?php echo $options['404_colnumb']; ?>" />
				<?php _e('Number of columns to display on page. We recommend some multiple of the number of products you chose. (3 or 4 is usually best)','woothemes') ?>
			</li>
			<li>
				<?php $options = get_option('404_page_content'); ?>
				<?php _e('Write any text that you would like to display on the 404 page:','woothemes') ?>
				<textarea style="width: 100%;height: 200px" name="404_page_content[404_pcontent]" value="<?php echo $options['404_pcontent']; ?>" placeholder="Write any text that you would like to display on the 404 page"><?php echo $options['404_pcontent']; ?></textarea>
			</li>
			
			<?php $options = get_option('404_ss_prodtype'); ?>
			<li>	
				<input type="radio" name="404_ss_prodtype[404_product_display]" value="1" <?php checked('1', $options['404_product_display']); ?> />
				<?php _e('Display Latest Products.','woothemes') ?>
			</li>
			<li>
				<input type="radio" name="404_ss_prodtype[404_product_display]" value="2" <?php checked('2', $options['404_product_display']); ?> />
				<?php _e('Display Featured Products.','woothemes') ?>
			</li>
			
		</ul>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes' , 'woothemes') ?>" />
		</p>
	</form>
	<p>
	<?php $options = get_option('404_page_title'); ?>
	<a href="<?php echo esc_url( get_permalink( get_page_by_title( $options['404_ptitle'] ) ) ); ?>">See what your new 404 page looks like!</a>
	</p>
	</div>
	<div style="background: #F3F3F3;-moz-border-radius: 3px;border-radius: 3px;margin:5%;margin-left: 0%;padding: 10px;-moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;width: 40%;float: left">
		<h1 style='margin-bottom: 30px;text-align: center'><?php _e('Contribute' , 'woothemes') ?></h1>
		<h3><?php _e('This plugin is only possible because of your contributions. Please consider helping by:' , 'woothemes') ?></h3>
		<p style="margin-top: 40px;margin-bottom: 92px;line-height: 20px"><strong>
		<?php _e('Giving a small donation:' , 'woothemes') ?> <a class="button-primary" href="https://www.wpovernight.com/donate" target="_blank" style="float: right;margin-right: 152px"><?php _e('Donate' , 'woothemes') ?></a>
	<br><br>
		<?php _e('Rating/Reviewing this on WordPress:' , 'woothemes') ?> <a class="button-primary" href="http://wordpress.org/support/view/plugin-reviews/woocommerce-menu-bar-cart" target="_blank" style="float: right;margin-right: 140px"><?php _e('Review It' , 'woothemes') ?></a>
	<Br><br>
		<?php _e('Offering ideas/expertise:' , 'woothemes') ?> <a class="button-primary" href="https://wpovernight.com/contact/" target="_blank" style="float: right;margin-right: 93px"><?php _e('Make Suggestion' , 'woothemes') ?></a>
	</strong></p> 
	</div>
	</div>
<?php
}
// Sanitize and validate input. Accepts an array, return a sanitized array.
function silentsalesman_404_options_validate($input) {
	// Our first value is either 0 or 1
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );
	
	// Say our second option must be safe text with no HTML tags
	$input['sometext'] =  wp_filter_nohtml_kses($input['sometext']);
	
	return $input;
}
//Page Content if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
//Create 404 Page Content
//Set page text in variable
$content_404 = get_option('404_page_content');
$page_text_404 = $content_404['404_pcontent'];
//Display text only, products only, or both
$display_type_404 = get_option('404_ss_content');
$page_404_display_type = $display_type_404['404_content_display'];
//Set type of product to display in variable
$display_product_type = get_option('404_ss_prodtype');
$page_404_display_product_type = $display_product_type['404_product_display'];
//Set number of products in variable
$products_per_page = get_option('404_ss_prodnumb');
$display_products_per_page = $products_per_page['404_prodnumb'];
//Set number of columns in variable
$product_column_number = get_option('404_ss_colnumb');
$display_columns_number = $product_column_number['404_colnumb'];
// Set product output
if ($page_404_display_product_type == 1) {
	$product_404_display_shortcode = '[recent_products per_page="' .$display_products_per_page. '" columns="' .$display_columns_number. '" orderby="date" order="desc"]';
}
if ($page_404_display_product_type == 2) {
	$product_404_display_shortcode = '[featured_products per_page="' .$display_products_per_page. '" columns="' .$display_columns_number. '" orderby="date" order="desc"]';
}
if ($page_404_display_type == 1) {
	$ss_404_page_content = '<div><p>' .$page_text_404. '</p></div>';
}
if ($page_404_display_type == 2) {
	$ss_404_page_content = '<div>' . $product_404_display_shortcode . '</div>';
}
if ($page_404_display_type == 3) {
	$ss_404_page_content = '<div><p>' .$page_text_404. '</p>' . $product_404_display_shortcode . '</div>';
}
}
//Page Content if WooCommerce is not Active
else {
$content_404 = get_option('404_page_content');
$ss_404_page_content = $content_404['404_pcontent']; 
}
	// Create 404 Page
	$activate_404 = get_option('404_active_state');
	$activate_404_page = $activate_404['404_activate'];
	$title_404 = get_option('404_page_title');
	$page_title_404 = $title_404['404_ptitle'];
	//Check if page exists
	$page_check_404 = get_page_by_title($page_title_404);
	//What to do if box is checked
	if ($activate_404_page == 1) {
				$ss_404_page = array(
  				'post_title'    => $page_title_404,
  				'post_content'  => $ss_404_page_content,
  				'post_status'   => 'publish',
  				'post_author'   => 1,
  				'post_type'     => 'page'
				);
				// If page doesn't exist, create it
				if(!isset($page_check_404->ID)){
				$ss_404_post_id = wp_insert_post( $ss_404_page );
				}
				//if page does exist, edit it
				if(isset($page_check_404->ID)){
					$ss_404_page_update = array(
  					'post_title'    => $page_title_404,
  					'ID'            => $page_check_404->ID,
  					'post_content'  => $ss_404_page_content,
  					'post_status'   => 'publish',
  					'post_author'   => 1,
  					'post_type'     => 'page'
					);
				wp_update_post( $ss_404_page_update );
				}
	}
	/*
	//if page does exist, edit it
	if (($activate_404_page == 1) && (isset($page_check_404->ID))) {
		global $post;
		$ss_404_page_update = array(
  					'post_title'    => $page_title_404,
  					'ID'            => $ss_404_post_id,
  					'post_content'  => $ss_404_page_content,
  					'post_status'   => 'publish',
  					'post_author'   => 1,
  					'post_type'     => 'page'
					);
				wp_update_post( $ss_404_page_update );
	}
	*/
function silentsalesman_404_redirect() {
		global $wp_query;
		if ($wp_query->is_404) {
			$options = get_option('404_page_title');
			$redirect_404_url = esc_url( get_permalink( get_page_by_title( $options['404_ptitle'] ) ) );
			header("Status: 404 Not Found");
			header ("HTTP/1.1 301 Moved Permanently");
			header("Location:" .$redirect_404_url);
			die;
		}
}
?>