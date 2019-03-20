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

    // global $new_whitelist_options;

    // $option_names = $new_whitelist_options[ OPTIONS_FIELD_NAME ];

    // foreach ($option_names as $option_name) {
    //   // echo get_option($option_name).'<br>';
    //   echo $option_name .'<br>';
    // }

  ?>

  <p>Easily add censorship to your blog posts and comments.</p>
  <span> Just leave right field empty in order to delete (not replace) a particular word or phrase.</span>

  <form method="post" action="options.php">
    <?php settings_fields( OPTIONS_FIELD_NAME ); ?>

    <table class="form-table">

      <tr class='form-table__top' valign="top">
        <th scope="row">№</th>
        <td>Change this</td>
        <td>To this</td>
        <td>Title</td>
        <td>Content</td>
        <td>Comments</td>
      </tr>

      <?php 

      for ($i = 1; $i <= TABLE_ROWS; $i++) { // loop trough all front-end fields

        $changeThis = 'option-left-' . $i;
        $toThis = 'option-right-' . $i;
        $titileName = 'title-' . $i;
        $contentName = 'content-' . $i;
        $commentsName = 'comments-' . $i;
        $titleCheckbox = checked(1, get_option('title-' . $i), false);
        $contentCheckbox = checked(1, get_option('content-' . $i), false);
        $commentsCheckbox = checked(1, get_option('comments-' . $i), false);

      ?>

      <tr valign="top">
        <th scope="row"><?php echo $i ?></th>
        <td>
          <input type="text" name="<?php echo $changeThis ?>"
            value="<?php echo esc_attr( get_option($changeThis) ); ?>" />
        </td>
        <td>
          <input type="text" name="<?php echo $toThis ?>"
            value="<?php echo esc_attr( get_option($toThis) ); ?>" />
        </td>
        <td>
          <input type="checkbox" name="<?php echo $titileName ?>" value='1'
            <?php echo $titleCheckbox ?> />
        </td>
        <td>
          <input type="checkbox" name="<?php echo $contentName ?>" value='1'
            <?php echo $contentCheckbox ?> />
        </td>
        <td>
          <input type="checkbox" name="<?php echo $commentsName ?>" value='1'
            <?php echo $commentsCheckbox ?> />
        </td>
      </tr>

      <?php }  ?>

    </table>

    <?php submit_button(); ?>

  </form>

</div>