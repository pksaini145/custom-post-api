<?php
// includes/CustomPostTypeMain.php
class CustomPostTypeMain
{

  public function initialize()
  {
    add_action('init', array($this, 'create_custom_post_type'));
  }

  public function create_custom_post_type()
  {
    register_post_type('news', array(
      'label' => __('News'),
      'public' => true,
      'has_archive' => true,
      'menu_icon' => 'dashicons-admin-post',
      'supports' => array('title'),
      'show_in_rest' => false, // Enable REST API access
    ));

    //Disable Gutenberg editor for news
    add_filter('use_block_editor_for_post_type', array($this, 'news_disable_gutenberg'), 10, 2);

    require_once('Submenu.php');

  }

  function news_disable_gutenberg($current_status, $post_type)
  {
    // Use your post type key 
    if ($post_type === 'news')
      return false;
    return $current_status;
  }
  
}