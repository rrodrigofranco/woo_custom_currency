<?php
/**
 * Plugin Name: Woo Custom Currency
 * Description: Plugin criado para mudar o símbolo da moeda
 * Plugin URI: https://rrodrigofranco.github.io
 * Author: Rodrigo Franco
 * Version: 1.0.0
**/

//* Don't access this file directly
defined( 'ABSPATH' ) or die();

/**
 * Start the function
 **/
 
// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
function woocommerce_product_custom_fields()
{
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    // Custom Product Text Field
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_product_text_field',
            'placeholder' => 'Digite o símbolo da sua moeda',
            'label' => __('Moeda Personalisada', 'woocommerce'),
            'desc_tip' => 'true'
        )
    );
    echo '</div>';
}

// Save Fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields_save($post_id)
{
    // Custom Product Text Field
    $woocommerce_custom_product_text_field = $_POST['_custom_product_text_field'];
    update_post_meta($post_id, '_custom_product_text_field', esc_attr($woocommerce_custom_product_text_field));
}

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

//Change symbol
function change_existing_currency_symbol( $currency_symbol, $currency ) {
    global $post;
    $simbolo = get_post_meta($post->ID, '_custom_product_text_field', true);
	if(!empty($simbolo)){
		$currency_symbol = $simbolo;
	}
    
    return $currency_symbol;
}

