<?php
/*
+----------------------------------------------------------------------
| Copyright (c) 2018 Genome Research Ltd.
| This is part of the Wellcome Sanger Institute extensions to
| wordpress.
+----------------------------------------------------------------------
| This extension to Worpdress is free software: you can redistribute
| it and/or modify it under the terms of the GNU Lesser General Public
| License as published by the Free Software Foundation; either version
| 3 of the License, or (at your option) any later version.
|
| This program is distributed in the hope that it will be useful, but
| WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
| Lesser General Public License for more details.
|
| You should have received a copy of the GNU Lesser General Public
| License along with this program. If not, see:
|     <http://www.gnu.org/licenses/>.
+----------------------------------------------------------------------

# Support functions to make ACF managed pages easier to render..
# This is a very simple class which defines templates {and an
# associated template language which can then be used to render
# page content... more easily...}
#
# See foot of file for documentation on use...
#
# Author         : js5
# Maintainer     : js5
# Created        : 2018-02-09
# Last modified  : 2018-02-12

 * @package   SimpleCookie
 * @author    JamesSmith james@jamessmith.me.uk
 * @license   GLPL-3.0+
 * @link      https://jamessmith.me.uk/base-theme-class/
 * @copyright 2018 James Smith
 *
 * @wordpress-plugin
 * Plugin Name: Simple cookie..
 * Plugin URI:  https://jamessmith.me.uk/base-theme-class/
 * Description: Support functions to apply simple templates to acf pro data structures!
 * Version:     0.0.1
 * Author:      James Smith
 * Author URI:  https://jamessmith.me.uk
 * Text Domain: base-theme-class-locale
 * License:     GNU Lesser General Public v3
 * License URI: https://www.gnu.org/licenses/lgpl.txt
 * Domain Path: /lang
 */

class SimpleCookie {
  public function __construct() {
    $this->add_js();
  }

//----------------------------------------------------------------------
// Add CSS/javascript files from definition list...
// If they start with http or / then they are treated as absolute
// o/w they are treated relative to the template directory...
//----------------------------------------------------------------------

  function add_js() {
    add_action( 'wp_enqueue_scripts',         array( $this, 'enqueue_scripts'), - PHP_INT_MAX );
    add_action( 'admin_init', [ $this, simplecookie_mysettings ] );
    if ( is_admin() ) {
      add_action('admin_menu', array($this,'simplecookie_admin_menu' ));
    }
    return $this;
  }

  public function enqueue_scripts() {
    // Push styles into header...
    if( get_option('simplecookie_custom_active') !== 'no' ) {
      wp_enqueue_style(  'simple-cookie', '/wp-content/plugins/simple-cookie/cookies-min.css',        array(),null,false);
      if( get_option( 'simplecookie_custom_css' ) ) {
        wp_enqueue_style(  'simple-cookie-cust', get_theme_file_uri( get_option( 'simplecookie_custom_css' ) ), array(), null, false );
      }
      wp_enqueue_script( 'simple-cookie', '/wp-content/plugins/simple-cookie/cookies-vanilla-gcc.js', array(),null,true);
      if( get_option( 'simplecookie_custom_js' ) ) {
        wp_enqueue_script(  'simple-cookie-cust', get_theme_file_uri( get_option( 'simplecookie_custom_js' ), array(), null, true ) );
      }
    }
  }


  function simplecookie_admin_menu() {
    add_options_page( 'Simple cookie', 'Simple cookie', 'administrator',
      'Simple cookie', [ $this, 'simplecookie_html_page' ] );
  }

  function simplecookie_mysettings() { // whitelist options
    register_setting( 'simplecookie', 'simplecookie_custom_active'  );
    register_setting( 'simplecookie', 'simplecookie_custom_js'  );
    register_setting( 'simplecookie', 'simplecookie_custom_css' );
  }

  function simplecookie_html_page() {
?>
  <div>
    <h2>Simple Cookie Options</h2>
    <form method="post" action="options.php">
<?php
      settings_fields( 'simplecookie' );
      do_settings_sections( 'simplecookie' );
    //wp_nonce_field('update-options');
      $act =  get_option('simplecookie_custom_active');
?>
      <table class="form-table">
        <tr>
          <th>Cookie popup active?</th>
          <td><select name="simplecookie_custom_active" id="simplecookie_custom_active">
                <option <?= $act !== 'no' ? 'selected="selected" ' : '' ?>value="yes">Popup active</option>
                <option <?= $act === 'no' ? 'selected="selected" ' : '' ?>value="no" >Popup inactive</option>
              </select></td>
        </tr>
        <tr>
          <th>Cookie js path:</th>
          <td><input class="regular-text code" name="simplecookie_custom_js" type="text" id="simplecookie_custom_js"
                value="<?= get_option('simplecookie_custom_js'); ?>" /></td>
        </tr>
        <tr>
          <th>Cookie CSS path:</th>
          <td><input class="regular-text code" name="simplecookie_custom_css" type="text" id="simplecookie_custom_css"
                value="<?= get_option('simplecookie_custom_css'); ?>" /></td>
        </tr>
      </table>
 <?php submit_button();  ?>
    </form>
  </div>
<?php
  }
}
new SimpleCookie();
