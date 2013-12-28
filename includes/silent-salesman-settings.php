<?php

class SilentSalesmanPro_Settings {

    public function __construct() {
        $this->includes();
        global $ss_standards, $options;
        $ss_standards = get_option('silentsalesman');

        add_action('admin_menu', array(&$this, 'silentsalesman_add_page'));
    }

    public function includes() {
        include_once( 'plugins/ss_404.php' ); 
        include_once( 'plugins/ss_woocommerce.php' );
    }

    /**
     * Add menu page
     */
    public function silentsalesman_add_page() {
		$silentsalesman_page = add_submenu_page('edit.php?post_type=page', __('Silent Salesman', 'silentsalesman'), __('Silent Salesman', 'silentsalesman'), 'manage_options', 'silentsalesman_options_page', array($this, 'silentsalesman_options_do_page'));

    }

    /**
     * Build the options page.
     */
    public function silentsalesman_options_do_page() {
        ?>      
        <div class="wrap">
            <div class="icon32" id="icon-options-general"><br /></div>
            <h2><?php _e('Silent Salesman Settings', 'silentsalesman') ?></h2>
        <?php
        if (isset($_GET['tab'])) {
            $active_tab = $_GET['tab'];
        } else {
            //set display_options tab as a default tab.
            $active_tab = 'standard_options';
        }
 
		?>
		<h2 class="nav-tab-wrapper">  
            <a href="?post_type=page&page=silentsalesman_options_page&tab=standard_options" class="nav-tab <?php echo $active_tab == 'standard_options' ? 'nav-tab-active' : ''; ?>">404 Options</a>  
			<a href="?post_type=page&page=silentsalesman_options_page&tab=search_options" class="nav-tab <?php echo $active_tab == 'search_options' ? 'nav-tab-active' : ''; ?>">Search Options</a> 
		</h2> 
		<?php     
         
        global $options;
        //print_r($options); //for debugging
        $ss_standards = get_option('silentsalesman');
		//print_r($ss_search);
		//print_r($ss_standards);
		//print_r($click_options);
		//print_r($cart_options);
		
        ?>

        <form method="post" action="options.php">
        <?php
		if ($active_tab == 'standard_options') {
			settings_fields('silentsalesman');
            do_settings_sections('silentsalesman');
			submit_button();			
        }
		else {
		?>
			<p style="margin-top:20px;font-size: 18px;margin-bottom:20px;line-height: 24px;">This feature is only available in the pro version, but get a 25% discount if you're one<br /> of the first 20 buyers! See below for more info.</p>
		<?php
		}    
        ?>
        </form>
		<div style="line-height: 20px; background: #F3F3F3;-moz-border-radius: 3px;border-radius: 3px;padding: 10px;-moz-box-shadow: 0 0 5px #ff0000;-webkit-box-shadow: 0 0 5px#ff0000;box-shadow: 0 0 5px #ff0000;padding: 10px;margin:0px auto; font-size: 13.8px;width: 60%;float: left"> 
			<h2><?php _e('Get Silent Salesman Pro!','silentsalesman') ?></h2>
			<br>
			<strong><?php _e('Limited Offer:','silentsalesman') ?> <span style="color: red"><?php _e('25% off!','silentsalesman') ?></span></strong> - 
			<span><?php _e('Valid for first 25 customers only.','silentsalesman')?></span>
			<span><?php _e('Use Coupon Code ','silentsalesman')?></span><strong><span><?php _e('silentsalesman25','silentsalesman')?></span></strong>
			<span><?php _e('at checkout.','silentsalesman')?></span>
			<br>
			<br>
			<?php _e('Includes all the great standard features found in this free version plus:','silentsalesman') ?>
			<br>
			<ul style="list-style-type:circle;margin-left: 40px">
				<li><?php _e('The option to add the same functionality to an empty search results page','silentsalesman') ?></li>
				<li><?php _e('Priority Customer Support','silentsalesman') ?></li>
				<li><?php _e('First access to new features & functionality','silentsalesman') ?></li>
			</ul>
			<?php
			$menucartadmore = '<a href="https://wpovernight.com/downloads/silent-salesman-pro/?utm_source=wordpress&utm_medium=silentsalesman&utm_campaign=silentsalesmanintro">';
			printf (__('Need to see more? %sClick here%s to check it out!','silentsalesman'), $menucartadmore,'</a>'); ?><br><br>
			<a class="button button-primary" style="text-align: center;margin: 0px auto" href="https://wpovernight.com/downloads/silent-salesman-pro/?utm_source=wordpress&utm_medium=silentsalesman&utm_campaign=silentsalesmanintro"><?php _e('Buy Now','silentsalesman') ?></a>
		</div>
		
		<?php
    }

    /**
     * Header Callback
     *
     * Renders the header.
     *
     * @since 1.0
     * @param array $args Arguments passed by the setting
     * @return void
     */
    function header_element_callback($args) {
        echo '';
    }

    /**
     * Text field callback.
     *
     * @param  array $args Field arguments.
     *
     * @return string      Text field.
     */
    public function text_element_callback($args) {
        $menu = $args['menu'];
        $id = $args['id'];
        $size = isset($args['size']) ? $args['size'] : '25';

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $disabled = (isset($args['disabled'])) ? ' disabled' : '';
        $html = sprintf('<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" size="%4$s"%5$s/>', $id, $menu, $current, $size, $disabled);

        // Displays option description.
        if (isset($args['description'])) {
            $html .= sprintf('<p class="description">%s</p>', $args['description']);
        }

        echo $html;
    }

    /**
     * Search Editor.
     *
     * @param  array $args Field arguments.
     *
     * @return string      Text field.
     */
    public function searcheditor_element_callback($args) {
		$menu = $args['menu'];
        $id = $args['id'];
        $size = isset($args['size']) ? $args['size'] : '25';

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $disabled = (isset($args['disabled'])) ? ' disabled' : '';
        //$html = sprintf('<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" size="%4$s"%5$s/>', $id, $menu, $current, $size, $disabled);
        $html = wp_editor($current, 'sssearcheditor');

        // Displays option description.
        if (isset($args['description'])) {
            $html .= sprintf('<p class="description">%s</p>', $args['description']);
        }

        echo $html;
    }

    /**
     * 404 Editor
     *
     * @param  array $args Field arguments.
     *
     * @return string      Text field.
     */
    public function editor_element_callback($args) {
        global $wp_version;
		$menu = $args['menu'];
        $id = $args['id'];
        $size = isset($args['size']) ? $args['size'] : '25';

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $disabled = (isset($args['disabled'])) ? ' disabled' : '';
        $html = sprintf('<textarea cols="120" rows="15" id="%1$s" name="%2$s[%1$s]">', $id, $menu). $current;
		$html .= '</textarea>';
		//if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
		//$html = wp_editor( $current, 'sseditor' );
		//}

        // Displays option description.
        if (isset($args['description'])) {
            $html .= sprintf('<p class="description">%s</p>', $args['description']);
        }

        echo $html;
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    public function select_element_callback($args) {
        $menu = $args['menu'];
        $id = $args['id'];

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $disabled = (isset($args['disabled'])) ? ' disabled' : '';

        $html = sprintf('<select name="%1$s[%2$s]" id="%1$s[%2$s]"%3$s>', $menu, $id, $disabled);
        $html .= sprintf('<option value="%s"%s>%s</option>', '0', selected($current, '0', false), '');

        foreach ($args['options'] as $key => $label) {
            $html .= sprintf('<option value="%s"%s>%s</option>', $key, selected($current, $key, false), $label);
        }
        $html .= sprintf('</select>');

        if (isset($args['description'])) {
            $html .= sprintf('<p class="description">%s</p>', $args['description']);
        }

        echo $html;
    }

    /**
     * Displays a multiple selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    public function multiple_select_element_callback($args) {
        $html = '';
        foreach ($args as $id => $boxes) {
            $menu = $boxes['menu'];

            $ss_standards = get_option($menu);

            if (isset($ss_standards[$id])) {
                $current = $ss_standards[$id];
            } else {
                $current = isset($boxes['default']) ? $boxes['default'] : '';
            }

            $disabled = (isset($boxes['disabled'])) ? ' disabled' : '';

            $html .= sprintf('<select name="%1$s[%2$s]" id="%1$s[%2$s]"%3$s>', $menu, $id, $disabled);
            $html .= sprintf('<option value="%s"%s>%s</option>', '0', selected($current, '0', false), '');

            foreach ($boxes['options'] as $key => $label) {
                $html .= sprintf('<option value="%s"%s>%s</option>', $key, selected($current, $key, false), $label);
            }
            $html .= '</select>';

            if (isset($boxes['description'])) {
                $html .= sprintf('<p class="description">%s</p>', $boxes['description']);
            }
            $html .= '<br />';
        }


        echo $html;
    }

    /**
     * Checkbox field callback.
     *
     * @param  array $args Field arguments.
     *
     * @return string      Checkbox field.
     */
    public function checkbox_element_callback($args) {
        $menu = $args['menu'];
        $id = $args['id'];

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $disabled = (isset($args['disabled'])) ? ' disabled' : '';
        $html = sprintf('<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s %4$s/>', $id, $menu, checked(1, $current, false), $disabled);

        // Displays option description.
        if (isset($args['description'])) {
            $html .= sprintf('<p class="description">%s</p>', $args['description']);
        }

        echo $html;
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    public function radio_element_callback($args) {
        $menu = $args['menu'];
        $id = $args['id'];

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $html = '';
        foreach ($args['options'] as $key => $label) {
            $html .= sprintf('<input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s />', $menu, $id, $key, checked($current, $key, false));
            $html .= sprintf('<label for="%1$s[%2$s][%3$s]"> %4$s</label><br>', $menu, $id, $key, $label);
        }

        // Displays option description.
        if (isset($args['description'])) {
            $html .= sprintf('<p class="description">%s</p>', $args['description']);
        }

        echo $html;
    }

    /**
     * Displays a multicheckbox a settings field
     *
     * @param array   $args settings field args
     */
    public function icons_radio_element_callback($args) {
        $menu = $args['menu'];
        $id = $args['id'];

        $ss_standards = get_option($menu);

        if (isset($ss_standards[$id])) {
            $current = $ss_standards[$id];
        } else {
            $current = isset($args['default']) ? $args['default'] : '';
        }

        $icons = '';
        $radios = '';

        foreach ($args['options'] as $key => $iconnumber) {
            $icons .= sprintf('<td style="padding-bottom:0;font-size:16pt;" align="center"><label for="%1$s[%2$s][%3$s]"><i class="silentsalesman-icon-shopping-cart-%4$s"></i></label></td>', $menu, $id, $key, $iconnumber);
            $radios .= sprintf('<td style="padding-top:0" align="center"><input type="radio" class="radio" id="%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s"%4$s /></td>', $menu, $id, $key, checked($current, $key, false));
        }

        $html = '<table><tr>' . $icons . '</tr><tr>' . $radios . '</tr></table>';
        $html .= '<p class="description"><i>' . __('<strong>Please note:</strong> you need to open your website in a new tab/browser window after updating the cart icon for the change to be visible!', 'silentsalesman') . '</p>';

        echo $html;
    }

    /**
     * Section null callback.
     *
     * @return void.
     */
    public function section_options_callback() {

    }

    /**
     * Validate/sanitize options input
     */
    public function silentsalesman_options_validate($input) {
        // Create our array for storing the validated options.
        $output = array();

        // Loop through each of the incoming options.
        foreach ($input as $key => $value) {

            // Check to see if the current option has a value. If so, process it.
            if (isset($input[$key])) {

                // Strip all HTML and PHP tags and properly handle quoted strings.
                $output[$key] = strip_tags(stripslashes($input[$key]));
            }
        }

        // Return the array processing any additional functions filtered by this action.
        return apply_filters('silentsalesman_validate_input', $output, $input);
    }

}