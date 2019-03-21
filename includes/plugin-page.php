<div class="wrap">
  <h1>Censorshipy</h1>

  <?php 

  // message after settings were updated
  if( isset($_GET['settings-updated']) ) { ?>

  <div id='message' class='updated'>
    <p><strong><?php _e('Settings saved.') ?></strong></p>
  </div>

  <?php } ?>

  <div class="desc">
    <span>Easily add censorship to your blog posts and comments.</span>
    <span>Just leave right field empty in order to delete (not replace) a particular word or phrase.</span>
  </div>

  <form id="CensorshipyForm" method="post" action="options.php">
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

      foreach($this->settings as $key=>$setting) { $key++ ?>

        <tr valign="top">
          <th scope="row"><?php echo $key ?></th>
          <td>
            <input class="form-table__option-left" type="text" name="<?php echo 'option-left-' . $key ?>"
              value="<?php echo $setting['left']; ?>" />
          </td>
          <td>
            <input class="form-table__option-right" type="text" name="<?php echo 'option-right-' . $key ?>"
              value="<?php  echo $setting['right']; ?>" />
          </td>
          <td>
            <input type="checkbox" name="<?php echo 'title-' . $key ?>" value='1'
            <?php checked( 1, $setting['title'], true ); ?> />
          </td>
          <td>
            <input type="checkbox" name="<?php echo 'content-' . $key ?>" value='1'
              <?php checked( 1, $setting['content'], true ); ?> />
          </td>
          <td>
            <input type="checkbox" name="<?php echo 'comments-' . $key ?>" value='1'
            <?php checked( 1, $setting['comments'], true ); ?> />
          </td>
        </tr>

      <?php } ?>

    </table>

    <?php submit_button(); ?>

  </form>

</div>