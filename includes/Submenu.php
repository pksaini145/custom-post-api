<?php
function cptui_plugin_menu()
{

  add_submenu_page('edit.php?post_type=news', 'Add/Edit News Categories', 'Add/Edit News Categories', 'manage_options', 'news_category_manage', 'news_category_manage');
}
add_action('admin_menu', 'cptui_plugin_menu');


function news_category_manage()
{

  if (isset($_POST['Save']) && $_POST['news_category'] != '') {
    $data['news_category'] = $_POST['news_category'];
    // $data['usersubject6'] = $_POST['usersubject6'];
    $updatedata = update_option('cutompost_api', $data);
    if ($updatedata) {
      $current_data = get_option('cutompost_api', true);
      $current_news = $current_data['news_category'];

      echo "Data Saved Successfully.";

    }
  }

  // Display your form and data here
  echo '<div class="wrap">';
  echo '<h2>Manage News Categories</h2>';
  echo '<form action="' . menu_page_url('news_category_manage', false) . '" method="post">';

  // Your form with "Add More" and "Remove" functionality

  echo '<div class="' . CPA . ' input_fields_wrap">
    <a class="add_field_button button-secondary">Add More</a>';

  $current_data = get_option('cutompost_api', true);
  $news_category = $current_data['news_category'];

  if (!empty($news_category)) {
    foreach ($news_category as $text) {
      if ($text != '') {
        echo '<div><input type="text" name="news_category[]" value="' . $text . '"></div>';
      }

    }
  } else {
    echo '<div><input type="text" name="news_category[]"></div>';
  }


  echo '</div>';
  echo '<input type="submit" name="Save" value="Save">';
  echo '</form>';
  // ...

  echo '</div>';

}