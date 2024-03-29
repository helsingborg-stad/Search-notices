<?php

/**
 * Plugin Name:       Search Notices
 * Plugin URI:        https://github.com/helsingborg-stad/Search-notices
 * Description:       Enables option to add notices to search result of specific keywords
 * Version: 3.0.3
 * Author:            Kristoffer Svanmark @Lexicon IT-Konsult , Sebastian Thulin @Helsingborg stad
 * Author URI:        https://github.com/helsingborg-stad
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       search-notices
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('SEARCHNOTICES_PATH', plugin_dir_path(__FILE__));
define('SEARCHNOTICES_URL', plugins_url('', __FILE__));
define('SEARCHNOTICES_TEMPLATE_PATH', SEARCHNOTICES_PATH . 'templates/');

load_plugin_textdomain('search-notices', false, plugin_basename(dirname(__FILE__)) . '/languages');

// Autoload from plugin
if (file_exists(SEARCHNOTICES_PATH . 'vendor/autoload.php')) {
    require_once SEARCHNOTICES_PATH . 'vendor/autoload.php';
}
require_once SEARCHNOTICES_PATH . 'Public.php';

// Start application
new SearchNotices\App();
