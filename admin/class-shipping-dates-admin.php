<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.alexandregaboriau.fr/en/
 * @since      1.0.0
 *
 * @package    Shipping_Dates
 * @subpackage Shipping_Dates/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shipping_Dates
 * @subpackage Shipping_Dates/admin
 * @author     Alexandre Gaboriau <contact@alexandregaboriau.fr>
 */
class Shipping_Dates_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shipping-dates-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
                 
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shipping-dates-admin.js', array( 'jquery' ), $this->version, false );
	}
        
        
        public function add_shipping_dates_product_data_tab( $product_data_tabs ) {
            $product_data_tabs['shipping-dates'] = array(
                'label'  => __( 'Recurring Shipping Class', 'shipping-dates' ),
                'target' => 'shipping_dates_data',
            );
            return $product_data_tabs;
        }
        
        
        public function add_shipping_dates_data_fields() {
            global $woocommerce, $post;
            ?>
            <div id="shipping_dates_data" class="panel woocommerce_options_panel">
                
                <?php
                    $select_shipping_classes = get_post_meta( $post->ID, '_select_shipping_class', true );
                    $select_shipping_classes = explode( '###', $select_shipping_classes );
                    
                    $shipping_date = get_post_meta( $post->ID, '_datepicker_shipping_class', true );
                    $shipping_date = explode( '###', $shipping_date );


                    $shipping_classes = get_terms( array('taxonomy' => 'product_shipping_class', 'hide_empty' => false ) );

                    // Get all shipping classes
                    $select_array['noshipping'] = __( 'No Shipping Class', 'shipping_dates' );
                    foreach( $shipping_classes as $shipping_class ) {
                        $select_array[ $shipping_class->term_id ] = $shipping_class->name;
                    }
                ?>

                <div id="shipping_form">

                <?php 
                    $counter_shipping_class = 0;
                    
                    foreach( $select_shipping_classes as $shipping_class_value ) {
                        
                        // Shipping class block
                        echo '<div class="options_group group_'.$counter_shipping_class.' shipping_group">';
                        
                        
                        // Shipping class select
                        woocommerce_wp_select(
                            array( 
                                'id'      => '_select_shipping_class_'.$counter_shipping_class.'[]', 
                                'value'   => $select_shipping_classes[$counter_shipping_class],
                                'name'    => '_select_shipping_class[]', 
                                'label'   => __( 'Choose shipping Class', 'shipping_dates' ),
                                'options' =>  $select_array
                            )
                        );
                        
                        // Shipping date datepicker
                        woocommerce_wp_text_input( array( 
                            'type'          => 'text',
                            'id'            => '_datepicker_shipping_class_'.$counter_shipping_class.'[]', 
                            'class'         => 'datepicker_shipping_class', 
                            'value'         => $shipping_date[$counter_shipping_class],
                            'name'          => '_datepicker_shipping_class[]', 
                            'label'         => __( 'From the date', 'shipping-dates' ),
                            'placeholder'   => __( 'Select Date', 'shipping-dates' ),
                            'description'   => __( 'Date format : "mm-dd" of the current year', 'shipping-dates' ),
                            'desc_tip'      => false,
                        ) );
                        
                        if( 0 != $counter_shipping_class ) {
                            echo '<input class="remove-shipping-block button" type="button" value="'. __( 'Remove', 'shipping_dates' ) .'"/>';
                        }
                        
                        echo '</div>';
                        // End Shipping class block
                        
                        $counter_shipping_class++;
                    }
                    
                    ?>
                </div> 
                
                <div class="options_group">
                    <input class="add-shipping-block button add_attribute" type="button" value="<?php _e( 'Add new date', 'shipping_dates' ); ?>"/>
                </div>
                
                
            </div>
            <?php
        }
        
        
        public function woocommerce_process_product_shipping_dates_save( $post_id ){
            
            // Get datas
            $values_shipping_class = isset( $_POST['_select_shipping_class'] ) ? (array)$_POST['_select_shipping_class'] : array();
            $values_shipping_class = array_map( 'sanitize_text_field', $values_shipping_class );
            
            $values_shipping_date = isset( $_POST['_datepicker_shipping_class'] ) ? (array)$_POST['_datepicker_shipping_class'] : array();
            $values_shipping_date = array_map( 'sanitize_text_field', $values_shipping_date );
            
            $values_shipping_class = implode( "###", $values_shipping_class );
            $values_shipping_date  = implode( "###", $values_shipping_date );
            
            // Save fields
            update_post_meta( $post_id, '_select_shipping_class', $values_shipping_class );
            update_post_meta( $post_id, '_datepicker_shipping_class', $values_shipping_date );
        }
        
        public function check_shipping_dates( $post_id ) {
            
            // Get  WooCommerce products
            if( $post_id ) {
                $args_product = array(
                    'p'               => intval( $post_id ), 
                    'post_type'       => 'product',
                    'posts_per_page'  => '-1'
                );
            } else {
                $args_product = array(
                    'post_type'       => 'product',
                    'posts_per_page'  => '-1'
                );
            }
            
            $query_product = new WP_Query( $args_product );
            
            // Loop for each WooCommerce products
            while( $query_product->have_posts() ) {
                $query_product->the_post();
                
                $product_id = get_the_ID();
                
                // Get shipping classes
                $shipping_class = get_post_meta( $product_id, '_select_shipping_class', true );
                $shipping_class = explode( '###', $shipping_class );

                // Get shipping dates
                $shipping_date = get_post_meta( $product_id, '_datepicker_shipping_class', true );
                $shipping_date = explode( '###', $shipping_date );
                $current_time  = time();
                
                // Shipping class ids
                $shipping_class_array = array();
                foreach( $shipping_class as $shipping_class_id ) {
                    if( 'noshipping' == $shipping_class_id ) {
                        $shipping_class_array[] = 0;
                    } else {
                        $shipping_class_array[] = $shipping_class_id;
                    }
                    
                }
                
                $counter_dates = 0;
                // Shipping dates
                foreach( $shipping_date as $shipping_date_id ) {
                    
                    // Date filled
                    if( !empty( $shipping_date_id ) ) {
                    
                        // Get timestamp of the date provided
                        $shipping_dateTime  = new DateTime( date('Y') . '-' . $shipping_date_id ); 
                        $shipping_timestamp = $shipping_dateTime->format('U'); 

                        // Set the shipping class to the product
						
                        if( $current_time > $shipping_timestamp ) {
                            
                            // Avoid infinite loop
                            remove_all_actions( 'woocommerce_update_product' );
                            
                            $shipsetproduct = wc_get_product( $product_id );
                            $shipsetproduct->set_shipping_class_id( $shipping_class_array[$counter_dates] );
                            $shipsetproduct->save();
                        }
                    
                    }
                    
                    $counter_dates++;
                }
                
            }
            
        }

}