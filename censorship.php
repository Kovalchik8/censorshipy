<?php 
  /*
  Plugin Name: Censorshipy
  Description: Add censorship to your blog
  Author: Roman Kovalchik
  Author URI: http://www.kovalchik.com.ua/
  Version: 1.1
  */
?>

<?php

class CENSOR_Plugin {

  // class constructor
  public function __construct() {

    // define constants
    define('PLUGIN_DIR', dirname(__FILE__).'/' );
    define('TABLE_ROWS', 3);
    define('OPTIONS_FIELD_NAME', 'censorshipy-plugin');

    // variables
    $this->settings = array();
    $this->filterTypes = array(
      'content' => 'content',
      'title' => 'title',
      'comments' => 'comments'
    );

    // add styles
    add_action('admin_print_styles', array($this, 'censorshipAssets') );

    // create custom plugin settings menu
    add_action('admin_menu', array($this, 'createCensorshipPlugin') );

    // form setting for filtering
    $this->formSettings();

    // filtering using wp hooks
    add_filter( 'the_content', function($data) {
      return $this->censorshipFilter($data, $this->filterTypes['content']);
    } );
    add_filter( 'the_title', function($data) {
      return $this->censorshipFilter($data, $this->filterTypes['title']);
    } );
    add_filter( 'comment_text', function($data) {
      return $this->censorshipFilter($data, $this->filterTypes['comments']);
    } );

  }

  public function censorshipAssets() {
    wp_enqueue_style( 'myCSS', plugins_url( 'assets/censor.css', __FILE__ ) );
    wp_enqueue_script( 'myJS', plugins_url( 'assets/censor.js', __FILE__ ) );
  }

  public function createCensorshipPlugin() {

    //create new top-level menu
    add_menu_page('Censorship Settings', 'Censorshipy', 'administrator', __FILE__, array($this, 'censorshipSettingsPage'), plugins_url( 'censorshipy/images/shield.png'));
  
    //call register settings function
    add_action( 'admin_init', array($this, 'registerCensorshipSettings') );
  }

  //register our settings
  public function registerCensorshipSettings() {

    for ($i = 1; $i <= TABLE_ROWS; $i++) {
      register_setting( OPTIONS_FIELD_NAME, 'option-left-' . $i, 'sanitize_text_field' );
      register_setting( OPTIONS_FIELD_NAME, 'option-right-' . $i, 'sanitize_text_field' );
      register_setting( OPTIONS_FIELD_NAME, 'title-' . $i );
      register_setting( OPTIONS_FIELD_NAME, 'content-' . $i );
      register_setting( OPTIONS_FIELD_NAME, 'comments-' . $i );
    }

  }

  // plugin page content
  public function censorshipSettingsPage() { include_once (PLUGIN_DIR . 'includes/plugin-page.php'); }

  // fill the array with settings from the database
  public function formSettings() {

    for ($i = 1; $i <= TABLE_ROWS; $i++) {

      array_push( $this->settings, array(
        'left' => get_option( 'option-left-' . $i ),
        'right' => get_option( 'option-right-' . $i ),
        'title' => get_option('title-' . $i),
        'content' => get_option('content-' . $i),
        'comments' => get_option('comments-' . $i)
      ));

    }

  }

  public function censorshipFilter($data, $type) {
    foreach($this->settings as $setting) {
      if ($setting[$type] == 1 && $setting['left'])
        $data = str_ireplace($setting['left'], $setting['right'], $data);
    }
    return $data;
  }
    
}

new CENSOR_Plugin();

?>