<?php
class DbManager
{

  private $wpdb;

  public function __construct()
  {
    global $wpdb;
    $this->wpdb = $wpdb;
  }



  public function create_table($table_name, $sql)
  {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
      // Drop existing table
      $wpdb->query("DROP TABLE $table_name");
    }

    dbDelta($sql);
  }


  public function get_data($table_name, $where_clause = '', $order_by = '', $limit = 0)
  {
    global $wpdb;

    $sql = "SELECT * FROM $table_name";

    // Add WHERE clause if provided
    if ($where_clause) {
      $sql .= " WHERE $where_clause";
    }

    // Add ORDER BY clause if provided
    if ($order_by) {
      $sql .= " ORDER BY $order_by";
    }

    // Add LIMIT clause if provided
    if ($limit > 0) {
      $sql .= " LIMIT $limit";
    }

    $results = $wpdb->get_results($sql);

    return $results;
  }
  public function insert_data($table_name, $data)
  {
    global $wpdb;

    // Prepare the SQL statement
    $wpdb->insert(
      $table_name,
      $data
    );

    // Check for errors and handle them if needed
    if (!$wpdb->insert_id) {
      // Handle insertion error
    }

    return $wpdb->insert_id;

  }

}
