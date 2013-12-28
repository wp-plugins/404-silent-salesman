<?php

/*
  Plugin Name: Silent Salesman
  Plugin URI: www.wpovernight.com/
  Description: 404 Silent Salesman turns dead 404 error traffic into profits. Just install the plugin and navigate to the options page under pages -> Silent Salesman
  Version: 1.0.2
  Author: Jeremiah Prummer
  Author URI: www.wpovernight.com/about
  License: GPL2
 */
/*  Copyright 2013 Jeremiah Prummer (email : jeremiah.prummer@yahoo.com)

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

class SilentSalesmanPro {

    public function __construct() {
        
        //Setup our options and inclues
        $this->includes();
        //register_activation_hook(__FILE__, array('SilentSalesmanPro_Settings', 'default_settings'));
        $this->options = get_option('silentsalesman');
        $this->settings = new SilentSalesmanPro_Settings();

        if($this->options['404_page_display']) {
            add_action('wp', array(&$this, 'silentsalesman_404_redirect'));
			add_action( 'template_redirect', array( &$this, 'redirect_404' ), 0 );
            add_action('template_redirect', array( &$this, 'is_page_function' ), 0 );
        }    
        
    }

    /**
     * Load additional classes and functions
     */
    public function includes() {

        include_once( 'includes/silent-salesman-settings.php' );
    }

    public function silentsalesman_404_redirect() {
        //public function generate_404_page() {
        global $options, $woocommerce, $wp_query;
        $content = '';
        //Page Content if WooCommerce is active
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            //Set Variables
            $product_number = $this->options['404_product_count'];
            $column_number = $this->options['404_column_count'];
            $display_type = $this->options['404_product_display'];
            $product_type = $this->options['404_product_type'];
            $content = $this->options['404_page_content'];

            // Set product output
            if ($product_type == 1) {
                $product_shortcode = '[recent_products per_page="' . $product_number . '" columns="' . $column_number . '" orderby="date" order="desc"]';
            }
            if ($product_type == 2) {
                $product_shortcode = '[featured_products per_page="' . $product_number . '" columns="' . $column_number . '" orderby="date" order="desc"]';
            }
            if ($product_type == 3) {
                $product_shortcode = '[sale_products per_page="' . $product_number . '" columns="' . $column_number . '" orderby="date" order="desc"]';
            }
            if ($product_type == 4) {
                $product_shortcode = '[best_selling_products per_page="' . $product_number . '" columns="' . $column_number . '" orderby="date" order="desc"]';
            }
            if ($product_type == 5) {
                $product_shortcode = '[top_rated_products per_page="' . $product_number . '" columns="' . $column_number . '" orderby="date" order="desc"]';
            }
            switch ($display_type) {
                case(1):
                    $ss_404_page_content = '<div><p>' . $content . '</p></div>';
                    break;
                case(2);
                    $ss_404_page_content = '<div>' . $product_shortcode . '</div>';
                    break;
                case(3);
                    $ss_404_page_content = '<div><p>' . $content . '</p>' . $product_shortcode . '</div>';
                    break;
            }
        }
        //Page Content if WooCommerce is not Active
        else {
            $ss_404_page_content = $this->options['404_page_content'];
        }
        // Create 404 Page       
        $activate_404 = $this->options['404_page_display'];
        $page_title = $this->options['404_page_title'];
        //Check if page exists
        $page_check_404 = get_page_by_title($page_title);
        //What to do if box is checked
        if ($activate_404) {
            $ss_404_page = array(
                'post_title' => $page_title,
                'post_content' => $ss_404_page_content,
                'post_status' => 'publish',
                'post_author' => 1,
                'post_type' => 'page'
            );
            // If page doesn't exist, create it
            if (!isset($page_check_404->ID)) {
                $ss_404_post_id = wp_insert_post($ss_404_page);
            }
            //if page does exist, edit it
            if (isset($page_check_404->ID)) {
                $ss_404_page_update = array(
                    'post_title' => $page_title,
                    'ID' => $page_check_404->ID,
                    'post_content' => $ss_404_page_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_type' => 'page'
                );
                wp_update_post($ss_404_page_update);
            }
        }
        //}
        //global $wp_query, $options;
    }
    
    public function redirect_404() {
    	global $options, $wp_query;
    	if ($wp_query->is_404) {
            $page_title = $this->options['404_page_title'];
            $redirect_404_url = esc_url(get_permalink(get_page_by_title($page_title)));	
            wp_redirect( $redirect_404_url );
        	add_action('wp', array(&$this, 'redirection'));
        	exit();
        }
    }
	
    public function is_page_function() {
        global $options;
        $page_title = $this->options['404_page_title'];
    	if (is_page($page_title)) {
            header("Status: 404 Not Found");
        }
        else {
            return;
        }
    }

}

$SilentSalesman = new SilentSalesmanPro();
?>