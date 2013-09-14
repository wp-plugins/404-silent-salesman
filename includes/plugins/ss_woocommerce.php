<?php
if ( ! class_exists( 'SilentSalesmanPro_Settings_WooCommerce' ) ) {
	class SilentSalesmanPro_Settings_WooCommerce extends SilentSalesmanPro_Settings {     
	
	    /**
	     * Construct.
	     */
	    public function __construct() {
                add_action('admin_init', array(&$this, 'wc_init_settings'));
	    }
			
            public function wc_init_settings() {
			
                $ss_standard = 'silentsalesman';
            add_settings_field(
                'woocommerce_header', __('<h3>WooCommerce Settings</h3>', 'silentsalesman'), array(&$this, 'header_element_callback'), $ss_standard, 'plugin_settings', array(
                'menu' => $ss_standard,
                'id' => 'woocommerce_header',
                )
            );
            
            add_settings_field(
                '404_product_count', __('Set maximum number of products to display', 'silentsalesman'), array(&$this, 'select_element_callback'), $ss_standard, 'plugin_settings', array(
                'menu' => $ss_standard,
                'id' => '404_product_count',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '6' => '6',
                    '8' => '8',
                    '9' => '9',
                    '12' => '12',
                    '15' => '15',
                ),
                    )
            );
        
            add_settings_field(
                '404_column_count', __('Set maximum number of columns to display', 'silentsalesman'), array(&$this, 'select_element_callback'), $ss_standard, 'plugin_settings', array(
                'menu' => $ss_standard,
                'id' => '404_column_count',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ),
                )
            );
        
        add_settings_field(
                '404_product_type', __('Which type of products would you like to display?', 'silentsalesman'), array(&$this, 'select_element_callback'), $ss_standard, 'plugin_settings', array(
            'menu' => $ss_standard,
            'id' => '404_product_type',
            'options' => array(
                '1' => __('Recent Products' , 'silentsalesman'),
                '2' => __('Featured Products' , 'silentsalesman'),
                '3' => __('On Sale Products' , 'silentsalesman'),
                '4' => __('Best Selling Products' , 'silentsalesman'),
                '5' => __('Top Rated Products' , 'silentsalesman'),
            ),
                )
        );
        
        // Register settings.
        
            }
	
        public function wc_default_settings() {  
                
        // backwards compatibility > fetch old settings variable
        $page_404_productcount = get_option('404_ss_prodnumb');
        $page_404_colcount = get_option('404_ss_colnumb');
        $page_404_prodtype = get_option('404_ss_prodtype');

        $ss_standard_default = array(
            '404_product_count' => isset($page_404_productcount['page_404_productcount']) ? $page_404_productcount['page_404_productcount'] : '3',
            '404_column_count' => isset($page_404_colcount['page_404_colcount']) ? $page_404_colcount['page_404_colcount'] : '3',
            '404_product_type' => isset($page_404_prodtype['page_404_prodtype']) ? $page_404_prodtype['page_404_prodtype'] : '1',
        );
        
        $ss_search_default = array(
            'search_product_count' => isset($page_404_productcount['page_404_productcount']) ? $page_404_productcount['page_404_productcount'] : '3',
            'search_column_count' => isset($page_404_colcount['page_404_colcount']) ? $page_404_colcount['page_404_colcount'] : '3',
            'search_product_type' => isset($page_404_prodtype['page_404_prodtype']) ? $page_404_prodtype['page_404_prodtype'] : '1',
        );

        // clean up after ourselves :o)
        delete_option('404_ss_prodnumb');
        delete_option('404_ss_colnumb');
        delete_option('404_ss_prodtype');

        add_option('ss_standard', $ss_standard_default);
        add_option('ss_search', $ss_search_default);
        }	
		
	}
        $SilentSalesmanPro_Settings_WooCommerce = new SilentSalesmanPro_Settings_WooCommerce();
}
