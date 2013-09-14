<?php
if ( ! class_exists( 'SilentSalesmanPro_Settings_404' ) ) {
	class SilentSalesmanPro_Settings_404 extends SilentSalesmanPro_Settings {     
	
	    /**
	     * Construct.
	     */
	    public function __construct() {
                add_action('admin_init', array(&$this, 'init_settings'));
                //include_once( 'ss_woocommerce.php' );
	    }
	
        public function init_settings() { 
        $ss_standard = 'silentsalesman';

        // Create option in wp_options.

        if (!get_option($ss_standard)) {
            add_option($ss_standard);
        }

        // Primary Options.
        add_settings_section(
                'plugin_settings', __('404 Page Settings', 'silentsalesman'), array(&$this, 'section_options_callback'), $ss_standard
        );
		
		add_settings_field(
                '404_header', __('<h3>Page Settings</h3>', 'silentsalesman'), array(&$this, 'header_element_callback'), $ss_standard, 'plugin_settings', array(
                'menu' => $ss_standard,
                'id' => '404_header',
                )
        );
		
        add_settings_field(
                '404_page_display', __('Activate 404 Silent Salesman', 'silentsalesman'), array(&$this, 'checkbox_element_callback'), $ss_standard, 'plugin_settings', array(
            'menu' => $ss_standard,
            'id' => '404_page_display',
                )
        );

        add_settings_field(
                '404_page_title', __('Enter your page title', 'silentsalesman'), array(&$this, 'text_element_callback'), $ss_standard, 'plugin_settings', array(
            'menu' => $ss_standard,
            'id' => '404_page_title',
                )
        );

        add_settings_field(
                '404_page_content', __('Write any text that you would like to display on the 404 page', 'silentsalesman'), array(&$this, 'editor_element_callback'), $ss_standard, 'plugin_settings', array(
            'menu' => $ss_standard,
            'id' => '404_page_content',
                )
        );

        add_settings_field(
                '404_product_display', __('Which would you like to display?', 'silentsalesman'), array(&$this, 'radio_element_callback'), $ss_standard, 'plugin_settings', array(
            'menu' => $ss_standard,
            'id' => '404_product_display',
            'options' => array(
                '1' => __('Text Only.', 'silentsalesman'),
                '2' => __('Products Only.', 'silentsalesman'),
                '3' => __('Both text and products.', 'silentsalesman'),
            ),
                )
        );
        /*
        add_settings_field(
                'shop_plugin', __('Select which e-commerce plugin you would like Menu Cart to work with', 'wpmenucart'), array(&$this, 'select_element_callback'), $ss_standard, 'plugin_settings', array(
            'menu' => $ss_standard,
            'id' => 'shop_plugin',
            'options' => $this->get_shop_plugins(),
                )
        );
        */
        // Register settings.

        register_setting($ss_standard, $ss_standard, array(&$this, 'silentsalesman_options_validate'));
    }
	
        /**
     * Default settings.
     */
    public function default_settings() {
        
        $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		
		$shop_plugins = array (
			'WooCommerce'				=> 'woocommerce/woocommerce.php',
			'Jigoshop'					=> 'jigoshop/jigoshop.php',
			'WP e-Commerce'				=> 'wp-e-commerce/wp-shopping-cart.php',
			'eShop'						=> 'eshop/eshop.php',
			'Easy Digital Downloads'	=> 'easy-digital-downloads/easy-digital-downloads.php',
	);
			
	$active_shop_plugins = array_intersect($shop_plugins,$active_plugins);
		
	//switch keys & values, then strip plugin path to folder
	foreach ($active_shop_plugins as $key => $value) {
		$filtered_active_shop_plugins[] = dirname($value);
	}

	$active_shop_plugins = $filtered_active_shop_plugins[0];
                
        // backwards compatibility > fetch old settings variable
        $page_404_display = get_option('404_active_state');
        $page_404_title = get_option('404_page_title');
        $page_404_content = get_option('404_page_content');
        $page_404_products = get_option('404_ss_content');

        $default = array(
            '404_page_display' => isset($page_404_display['page_404_display']) ? strtolower($page_404_display['page_404_display']) : '0',
            '404_page_title' => isset($page_404_title['page_404_title']) ? $page_404_title['page_404_title'] : '',
            '404_page_content' => isset($page_404_content['page_404_content']) ? $page_404_content['page_404_content'] : '',
            '404_product_display' => isset($page_404_products['page_404_products']) ? $page_404_products['page_404_products'] : '1',
            'shop_plugin' => $active_shop_plugins,
        );

        // clean up after ourselves :o)
        delete_option('404_active_state');
        delete_option('404_page_title');
        delete_option('404_page_content');
        delete_option('404_ss_content');

        add_option('silentsalesman', $default);
    }
		
	}
        $SilentSalesmanPro_Settings_404 = new SilentSalesmanPro_Settings_404();
}