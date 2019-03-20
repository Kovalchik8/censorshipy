<?php 
  /*
  Plugin Name: Censorshipy
  Description: Add censorship to your blog
  Author: Roman Kovalchik
  Author URI: http://www.kovalchik.com.ua/
  Version: 1.0
  */
?>

<?php

class CENSOR_Plugin {

  // class constructor
  public function __construct() {

    define( 'PLUGIN_DIR', dirname(__FILE__).'/' );

    // add styles
    add_action('admin_print_styles', array($this, 'add_my_stylesheet') );

    // create custom plugin settings menu
    add_action('admin_menu', array($this, 'createCensorshipPlugin') );

    // filtering
    add_filter( 'the_content', array($this, 'censorshipContent') );
    add_filter( 'the_title', array($this, 'censorshipTitle') );
    add_filter( 'comment_text', array($this, 'censorshipComment') );

  }

  public function add_my_stylesheet() {
    wp_enqueue_style( 'myCSS', plugins_url( '/censor.css', __FILE__ ) );
  }

  public function createCensorshipPlugin() {

    //create new top-level menu
    add_menu_page('Censorship Settings', 'Censorshipy', 'administrator', __FILE__, array($this, 'censorshipSettingsPage'), plugins_url( 'censorshipy/images/shield.png'));
  
    //call register settings function
    add_action( 'admin_init', array($this, 'registerCensorshipSettings') );
  }

  //register our settings
  public function registerCensorshipSettings() {
    register_setting( 'censorship-plugin-test', 'option-one-left' );
    register_setting( 'censorship-plugin-test', 'option-one-right' );
    register_setting( 'censorship-plugin-test', 'option-two-left' );
    register_setting( 'censorship-plugin-test', 'option-two-right' );
    register_setting( 'censorship-plugin-test', 'option-three-left' );
    register_setting( 'censorship-plugin-test', 'option-three-right' );
    register_setting( 'censorship-plugin-test', 'option-one-title' );
  }

  // plugin page content
  public function censorshipSettingsPage() { 
    include_once (PLUGIN_DIR . 'includes/plugin-page.php');
   }

  // filter content from all posts
  public function censorshipContent($content) {
    $content = str_ireplace(get_option('option-one-left'), get_option('option-one-right'), $content);
    $content = str_ireplace(get_option('option-two-left'), get_option('option-two-right'), $content);
    $content = str_ireplace(get_option('option-three-left'), get_option('option-three-right'), $content);
    return $content;
  }

  // filter title from all posts
  public function censorshipTitle($title) {
    $title = str_ireplace(get_option('option-one-left'), get_option('option-one-right'), $title);
    $title = str_ireplace(get_option('option-two-left'), get_option('option-two-right'), $title);
    $title = str_ireplace(get_option('option-three-left'), get_option('option-three-right'), $title);
    return $title;
  }

  // filter all comments
  public function censorshipComment( $comment_text ) {
    $comment_text = str_ireplace(get_option('option-one-left'), get_option('option-one-right'), $comment_text);
    $comment_text = str_ireplace(get_option('option-two-left'), get_option('option-two-right'), $comment_text);
    $comment_text = str_ireplace(get_option('option-three-left'), get_option('option-three-right'), $comment_text);
    return $comment_text;
  }
    
}

new CENSOR_Plugin();

?>