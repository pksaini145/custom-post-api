<?php
/**
 * Plugin Name: Custom Post API
 * Description: Creates a custom post and Rest Api To Store Wordpress Data.
 * Author: Pradeep Saini
 * Version: 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}
require_once('includes/DbManager.php');

class CustomPostApi
{

  private $table_name;

  public function __construct()
  {
    $this->table_name = 'records';
    define('CPTA_PLUGIN', __FILE__);
    define('CPA', 'custom-post-api');
    define('CPTA_PLUGIN_URL', untrailingslashit(plugins_url('', CPTA_PLUGIN)));
  }

  public function init()
  {
    register_activation_hook(__FILE__, array($this, 'activate_plugin'));

  }

  public function activate_plugin()
  {
    $this->create_table_if_exists_drop();

    // Default category Assign to News Category Dropdown
    $catdata[] = 'Default';
    $data['news_category'] = $catdata;
    //Store in option table plugin data
    add_option('cutompost_api', $data);
  }

  private function create_table_if_exists_drop()
  {
    $db_manager = new DbManager(); // (Instantiate DbManager class below)
    $sql = 'CREATE TABLE ' . $this->table_name . ' (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL );';
    $db_manager->create_table($this->table_name, $sql);
  }

  public function rendercpta()
  {
    require_once('includes/CustomPostTypeMain.php');
    require_once('includes/CustomMetaBox.php');
    require_once('includes/JsManager.php');
    require_once('includes/RestApiManager.php');
  }
}

$cpta = new CustomPostApi();
$cpta->init();
$cpta->rendercpta();

// Initialize plugin components
$post_type_manage = new CustomPostTypeMain();
$post_type_manage->initialize();

$meta_box = new CustomMetaBox();
$meta_box->initialize();

$js = new JsManager();
$js->initialize();

$restApi = new RestApiManager();
$restApi->initialize();



