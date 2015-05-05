<?php
/**!
 * Plugin Name: UW Disqus Terms
 * Plugin URI: http://uw.edu/
 * Description: Allows customizable terms of service for Disqus discussions. For use with UW-2014
 * Version: 1.0
 * Author: UW Web Team
 */

add_action('extend_uw_object', 'init_disqus_terms');

function init_disqus_terms($UW){
  require "class.uw-disqus-terms.php";
  $UW->Disqus_Terms = new UW_Disqus_Terms($UW);
}
