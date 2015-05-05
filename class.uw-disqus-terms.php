<?php

class UW_Disqus_Terms {

  function __construct($UW)
  {
    //add setting
    add_action('admin_menu', array($this, 'setup_sections'));
    add_action('admin_init', array($this, 'setup_options'));
    $this->uw_object_extensions($UW);
  }

  function setup_sections(){
    add_options_page('Disqus Options', 'Disqus Options', 'edit_theme_options', 'disqus_options', array($this, 'disqus_options_html'));
    add_settings_section('disqus_options_section', 'Configure some options for the Disqus comment system', array($this, 'disqus_options_section_callback'), 'disqus_options');
  }

  function disqus_options_html() {
    ?>
    <div ng-app="disqusOptions">
      <div ng-controller="disqusOptionsCtrl as options" ng-init="options.showInit('<?php echo get_option('show_disqus_tos'); ?>')">
        <form method="post" action="options.php">
          <?php
          settings_fields('disqus_options_group');
          do_settings_sections('disqus_options');
          submit_button();
          ?>
        </form>
      </div>
    </div>
    <?php
  }

  function disqus_options_section_callback(){
    //nothing needed. Just wordpress verbosity
    return;
  }
  
  function setup_options(){
    $this->register_settings();
    $this->add_settings_fields();
  }

  function register_settings(){
    register_setting('disqus_options_group', 'show_disqus_tos'); 
    register_setting('disqus_options_group', 'disqus_tos_text'); 
  }
  
  function add_settings_fields() {
    add_settings_field('show_disqus_tos', 'Show terms of use for Disqus comments?', array($this, 'show_disqus_tos_callback'), 'disqus_options', 'disqus_options_section');
    add_settings_field('disqus_tos_text', 'Text of Disqus terms of use:', array($this, 'disqus_tos_text_callback'), 'disqus_options', 'disqus_options_section');
  }

  function show_disqus_tos_callback(){
    ?>
    <input type='checkbox' name="show_disqus_tos" ng-model="options.show_tos">
    <?php
  }

  function disqus_tos_text_callback(){
    $text = get_option('disqus_tos_text');
    ?>
    <input type='text' name="disqus_tos_text" ng-disabled="!options.show_tos" value="<?php echo $text ?>">
    <?php
  }
  
  function uw_object_extensions($UW){
    //admin scripts
    $UW->Scripts->SCRIPTS['angular'] = array (
        'id'        => 'angular',
        'url'       => 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min.js',
        'deps'      => array(),
        'version'   => '1.0',
        'admin'     => true,
      );
    $UW->Scripts->SCRIPTS['disqus_terms_admin'] = array (
        'id'        => 'disqus_terms_admin',
        'url'       => plugins_url('js/disqus_tos_admin.js', __FILE__),
        'deps'      => array( 'angular' ),
        'version'   => '1.0',
        'admin'     => true,
      );

    if (get_option('show_disqus_tos') == 'on'){
      //only add these if we're showing the disqus tos
      $UW->Scripts->SCRIPTS['disqus_terms'] = array (
          'id'        => 'disqus_terms',
          'url'       => plugins_url('js/uw.disqus-terms.js', __FILE__),
          'deps'      => array( 'backbone' ),
          'version'   => '1.0',
          'admin'     => false,
          'variables' => array('disqus_tos_text' => get_option('disqus_tos_text'))
        );
      $UW->Styles->STYLES['disqus_terms'] = array (
          'id'        => 'disqus_terms',
          'url'       => plugins_url('css/uw.disqus-terms.css', __FILE__),
          'deps'      => array(),
          'version'   => '1.0',
          'admin'     => false
        );
    }
  }
}
