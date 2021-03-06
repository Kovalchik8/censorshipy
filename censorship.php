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

  public function __construct() {

    // define constants
    define('MAX_TABLE_ROWS', 11); // including table header row
    define('MIN_TABLE_ROWS', 3); // without table header row

    $tableRows = get_option('censorshipy-rows', MIN_TABLE_ROWS);

    if ($tableRows >= MAX_TABLE_ROWS || $tableRows < MIN_TABLE_ROWS) 
      $tableRows = MIN_TABLE_ROWS;

    define('TABLE_ROWS', $tableRows);
    define('PLUGIN_DIR', dirname(__FILE__) . '/' );
    define('OPTIONS_FIELD_NAME', 'censorshipy-plugin');

    // variables
    $this->settings = array();

    // add assets
    add_action('admin_print_styles', array($this, 'censorshipAssets') );

    // create custom plugin settings menu
    add_action('admin_menu', array($this, 'createCensorshipPlugin') );

    // get settings for filtering
    $this->getSettings();

    // filtering using wp hooks
    add_filter( 'the_content', function($data) {
      return $this->censorshipFilter($data, 'content');
    } );
    add_filter( 'the_title', function($data) {
      return $this->censorshipFilter($data, 'title');
    } );
    add_filter( 'comment_text', function($data) {
      return $this->censorshipFilter($data, 'comments');
    } );

  }

  public function censorshipAssets() {
    wp_enqueue_style( 'myCSS', plugins_url( 'assets/censor.css', __FILE__ ) );
    wp_enqueue_script( 'myJS', plugins_url( 'assets/censor.js', __FILE__ ) );
    wp_localize_script( 'myJS', 'CensorshipyData',
      array( 'max_table_rows' => MAX_TABLE_ROWS ) 
    );
  }

  public function createCensorshipPlugin() {

    //create new top-level menu
    add_menu_page('Censorship Settings', 'Censorshipy', 'administrator', __FILE__, array($this, 'censorshipSettingsPage'), plugins_url( 'censorshipy/images/shield.png'));
  
    //call register settings function
    add_action( 'admin_init', array($this, 'registerCensorshipSettings') );
  }

  //register our settings
  public function registerCensorshipSettings() {

    register_setting( OPTIONS_FIELD_NAME, 'censorshipy-rows', 'sanitize_text_field' );

    for ($i = 1; $i <= MAX_TABLE_ROWS; $i++) {
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
  public function getSettings() {

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