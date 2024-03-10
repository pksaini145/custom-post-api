<?php

class CustomMetaBox
{

  public function initialize()
  {
    add_action('save_post', array($this, 'save_meta_data'));
    add_action('add_meta_boxes', array($this, 'render_meta_box'));
  }

  public function render_meta_box()
  {

    add_meta_box(
      'news_caption',                 // Unique ID
      'News Caption',      // Box title
      array($this, 'news_caption_meta_box'),  // Content callback, must be of type callable
      'news',                          // Post type
      'normal',
      'high'
    );
    add_meta_box(
      'news_category',                 // Unique ID
      'News Category',      // Box title
      array($this, 'news_category_meta_box'),  // Content callback, must be of type callable
      'news',                         // Post type
      'side',
      'high'
    );

  }

  public function news_caption_meta_box($post)
  {
    wp_nonce_field(basename(__FILE__), 'news_caption_nonce');
    $caption = get_post_meta($post->ID, 'news_caption', true);
    echo '<label for="news_caption">Caption:</label><br>';
    echo '<textarea name="news_caption" style="width:100%" id="news_caption">' . esc_textarea($caption) . '</textarea>';
  }

  public function news_category_meta_box($post)
  {
    wp_nonce_field(basename(__FILE__), 'news_category_nonce');
    $category = get_post_meta($post->ID, 'news_category', true);
    $current_data = get_option('cutompost_api', true);
    $categories = $current_data['news_category'];
    echo '<label for="news_category">Category:</label>';
    echo '<select name="news_category" id="news_category">';
    foreach ($categories as $key => $value) {
      echo '<option value="' . $value . '" ' . selected($value, $category, false) . '>' . $value . '</option>';
    }
    echo '</select>';
    echo '<br>';
    echo '<a href="'.menu_page_url('news_category_manage', false).'"><p>Add More Category</p></a>';
  }

  public function save_meta_data($post)
  {
    /* Verify the nonce before proceeding. \*/
    if (!isset($_POST['news_caption_nonce']) || !wp_verify_nonce($_POST['news_caption_nonce'], basename(__FILE__)))
      return $post;
    if (!isset($_POST['news_category_nonce']) || !wp_verify_nonce($_POST['news_category_nonce'], basename(__FILE__)))
      return $post;

    /* Get the meta key. \*/
    $news_caption_key = 'news_caption';

    /* Get the meta key. \*/
    $news_category_key = 'news_category';

    $news_caption = (isset($_POST['news_caption']) && $_POST['news_caption'] != '') ? sanitize_textarea_field($_POST['news_caption']) : '';
    $news_category = (isset($_POST['news_category']) && $_POST['news_category'] != '') ? $_POST['news_category'] : '';
    update_post_meta($post, $news_caption_key, $news_caption);

    update_post_meta($post, $news_category_key, $news_category);

  }


}