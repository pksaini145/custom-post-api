<?php
class JsManager
{

  public function initialize()
  {
    add_action('admin_enqueue_scripts', array($this, 'cpa_enqueue_scripts'));
  }

  public function cpa_enqueue_scripts()
  {
    wp_enqueue_script(CPTA . '-js', CPTA_PLUGIN_URL . '/assets/js/addremoveform.js');
    // wp_localize_script(CPTA.'-js','cpta_obj', array('plugin_url'=>CPTA_PLUGIN_URL,'text' => CPA) );
  }
}
