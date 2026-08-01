<?php
/**
 * Plugin Name: DrDrabio Contact Form
 * Plugin URI: https://drdrabio.vn
 * Description: Form liên hệ Dr.Drabio kết nối Google Sheets.
 * Version: 1.0.0
 * Author: Ly Sương
 * License: GPL2
 * Text Domain: drdrabio-contact
 */

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Plugin Constants
|--------------------------------------------------------------------------
*/

define('DRDRABIO_VERSION', '1.0.0');

define('DRDRABIO_PATH', plugin_dir_path(__FILE__));

define('DRDRABIO_URL', plugin_dir_url(__FILE__));

/*
|--------------------------------------------------------------------------
| Include Files
|--------------------------------------------------------------------------
*/

require_once DRDRABIO_PATH . 'includes/shortcode.php';
require_once DRDRABIO_PATH . 'includes/submit.php';

/*
|--------------------------------------------------------------------------
| Load CSS & JS
|--------------------------------------------------------------------------
*/

function drdrabio_enqueue_assets()
{

    wp_enqueue_style(
        'drdrabio-style',
        DRDRABIO_URL . 'assets/style.css',
        array(),
        DRDRABIO_VERSION
    );

    wp_enqueue_script(
        'drdrabio-script',
        DRDRABIO_URL . 'assets/script.js',
        array('jquery'),
        DRDRABIO_VERSION,
        true
    );

    wp_localize_script(
        'drdrabio-script',
        'drdrabio',

        array(

            'ajax_url' => admin_url('admin-ajax.php'),

            'nonce' => wp_create_nonce('drdrabio_nonce'),

            'apps_script' =>
            'https://script.google.com/macros/s/AKfycbz0Lp1bXLdO1z7rbumEqJjTB-wAE_Kj5Dt2zDV2Mb52Nc-e6htm5dExg97jddfKDE4_uQ/exec'

        )

    );

}

add_action(
    'wp_enqueue_scripts',
    'drdrabio_enqueue_assets'
);

/*
|--------------------------------------------------------------------------
| Shortcode
|--------------------------------------------------------------------------
*/

function drdrabio_shortcode()
{

    ob_start();

    drdrabio_render_contact();

    return ob_get_clean();

}

add_shortcode(
    'drdrabio_contact',
    'drdrabio_shortcode'
);

/*
|--------------------------------------------------------------------------
| AJAX
|--------------------------------------------------------------------------
*/

add_action(
    'wp_ajax_drdrabio_submit',
    'drdrabio_submit'
);

add_action(
    'wp_ajax_nopriv_drdrabio_submit',
    'drdrabio_submit'
);