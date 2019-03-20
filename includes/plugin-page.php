<div class="wrap">
  <h1>Censorshipy</h1>

  <?php 

  // message after settings were updated
  if( isset($_GET['settings-updated']) ) { ?>

  <div id='message' class='updated'>
    <p><strong><?php _e('Settings saved.') ?></strong></p>
  </div>

  <?php } ?>

  <?php

    global $new_whitelist_options;

    $option_names = $new_whitelist_options[ 'censorship-plugin-test' ];

    foreach ($option_names as $option_name) {
      echo get_option($option_name).'<br>';
    }

  ?>

  <p>Easily add censorship to your blog posts (both title and content) and comments.</p>
  <span> Just leave right field empty in order to delete (not replace) a particular word from your blog/comments.</span>

  <form method="post" action="options.php">
    <?php settings_fields( 'censorship-plugin-test' ); ?>

    <table class="form-table">

      <tr class='form-table__top' valign="top">
        <th scope="row">№</th>
        <td>Change this</td>
        <td>To this</td>
        <td>Title</td>
      </tr>

      <tr valign="top">
        <th scope="row">1</th>
        <td><input type="text" name="option-one-left"
            value="<?php echo esc_attr( get_option('option-one-left') ); ?>" /></td>
        <td><input type="text" name="option-one-right"
            value="<?php echo esc_attr( get_option('option-one-right') ); ?>" /></td>
        <td><input type="checkbox" name="option-one-title" value='1' <?php checked(1, get_option('option-one-title'), true); ?> /></td>
      </tr>

      <tr valign="top">
        <th scope="row">2</th>
        <td><input type="text" name="option-two-left"
            value="<?php echo esc_attr( get_option('option-two-left') ); ?>" /></td>
        <td><input type="text" name="option-two-right"
            value="<?php echo esc_attr( get_option('option-two-right') ); ?>" /></td>
      </tr>

      <tr valign="top">
        <th scope="row">3</th>
        <td><input type="text" name="option-three-left"
            value="<?php echo esc_attr( get_option('option-three-left') ); ?>" /></td>
        <td><input type="text" name="option-three-right"
            value="<?php echo esc_attr( get_option('option-three-right') ); ?>" /></td>
      </tr>

    </table>

    <?php submit_button(); ?>

  </form>

</div>