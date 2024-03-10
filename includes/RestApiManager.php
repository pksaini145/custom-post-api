<?php

class RestApiManager
{

  private $table_name;

  public function __construct()
  {
    $this->table_name = 'records';
  }

  public function initialize()
  {
    add_action('rest_api_init', function () {

      register_rest_route('action', '/form-validation', array(
        'methods' => 'POST',
        'callback' => array($this, 'custom_form_validation_callback'),
        'permission_callback' => '__return_true', // Adjust permission as needed
      ));

      register_rest_route('action', '/form-data', array(
        'methods' => 'GET',
        'callback' => array($this, 'custom_form_data'),
        'permission_callback' => '__return_true', // Adjust permission as needed
      ));

    });
  }

  public function custom_form_data()
  {
    $db_manager = new DbManager();
    $alldata = $db_manager->get_data($this->table_name);
    return array('success' => true, 'message' => 'All saved Data.', 'data' => $alldata);
  }

  public function custom_form_validation_callback(WP_REST_Request $request)
  {
    $data = $request->get_json_params();


    $errors = [];

    // Email validation


    if (isset($data['email']) && !is_email($data['email'])) {
      $errors[] = 'Invalid email format.';
    }

    // Phone number validation (basic example)
    if (isset($data['phone']) && !preg_match('/^\d{10}$/', $data['phone'])) {
      $errors[] = 'Invalid phone number format.';
    }

    // Website URL validation
    if (isset($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
      $errors[] = 'Invalid url format.';
    }

    // Add other validation rules as needed using appropriate regular expressions or libraries

    if (!empty($errors)) {
      return new WP_Error('validation_error', 'Form validation failed.', array('errors' => $errors));
    }

    // If validation passes, return success message or process data further

    $db_manager = new DbManager();

    // $alldata = $db_manager->get_data($this->table_name);
    // // return array('success'=> true, 'message' => 'All saved Data.','data' => $alldata);
    // print_r($alldata);

    if ($data['email'] == '' && $data['phone'] == '' && $data['website'] == '') {
      return new WP_Error('validation_error', 'Form validation failed.', array('errors' => 'Atleast one field rquired to Save Data.'));
    }

    $data = array(
      'email' => $data['email'],
      'phone' => $data['phone'],
      'url' => $data['url']
    );

    $insert_id = $db_manager->insert_data($this->table_name, $data);

    if ($insert_id) {

      return array('success' => true, 'message' => "Data inserted successfully with ID: " . $insert_id);

    } else {

      return array('success' => false, 'message' => "Error inserting data!");
    }

  }
}