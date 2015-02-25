<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://wenthemes.com
 * @since      1.0.0
 *
 * @package    WEN_Responsive_Columns
 * @subpackage WEN_Responsive_Columns/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WEN_Responsive_Columns
 * @subpackage WEN_Responsive_Columns/admin
 * @author     WEN Themes <info@wenthemes.com>
 */
class WEN_Responsive_Columns_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WEN_Responsive_Columns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WEN_Responsive_Columns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wen-responsive-columns-admin.css', array(), $this->version, 'all' );

	}

  /**
   * Hook Tiny MCE buttons.
   *
   * @since    1.0.0
   */
  function tinymce_button(){

    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
         add_filter( 'mce_buttons', array($this,'register_tinymce_button' ) );
         add_filter( 'mce_external_plugins', array($this,'add_tinymce_button' ) );
    }

  }

  /**
   * Register TinyMce Button.
   *
   * @since    1.0.0
   */
  function register_tinymce_button( $buttons ){

    array_push( $buttons, 'wen_responsive_columns' );
    return $buttons;

  }

  /**
   * Add TinyMCE Button.
   *
   * @since    1.0.0
   */
  function add_tinymce_button( $plugin_array ){

    $plugin_array['wen_responsive_columns'] = WEN_RESPONSIVE_COLUMNS_URL . '/admin/js/wen-responsive-columns-tinymce-plugin.js';
    return $plugin_array;

  }


  /**
   * TinyMCE popup.
   *
   * @since    1.0.0
   */
  function tinymce_popup(){
    ?>
    <div id="WLS-popup-form" style="display:none">
      <div>
      <?php
      $args = array(
        'posts_per_page' => -1,
        );
      $all_slides = get_posts($args);
       ?>
       <?php if ( ! empty($all_slides ) ): ?>
          <p><?php _e( 'Select Slider', 'wen-logo-slider' ); ?>
          <select name="wls-slide" id="wls-slide">
          <?php foreach ($all_slides as $key => $slide): ?>

              <option value="<?php echo esc_attr( $slide->ID); ?>"><?php echo esc_attr( $slide->post_title); ?></option>

          <?php endforeach ?>
          </select>
          </p>
          <p class="submit">
            <input type="button" id="WLS-submit" class="button-primary" value="<?php esc_attr( _e( 'Insert', 'wen-logo-slider' ) ); ?>" name="submit" />
          </p>
          <script type="text/javascript">

          jQuery(document).ready(function($){
            $('#WLS-submit').click(function(e){
              e.preventDefault();

              var shortcode = '[WLS';
              var wls_slide = $('#wls-slide').val();
              if ( '' != wls_slide) {
                shortcode += ' id="'+wls_slide+'"';
              }
              shortcode += ']';

              // inserts the shortcode into the active editor
              tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

              // closes Thickbox
              tb_remove();

            });
          });

             </script>

        <?php else: ?>
          <p><strong><?php _e( 'No slider found', 'wen-logo-slider' ); ?></strong></p>
       <?php endif ?>

      </div>
    </div><!-- #WLS-popup-form -->
    <?php


  }


  /**
   * HTML template for TinyMce opup.
   *
   * @since    1.0.0
   */
  function html_templates(){
    ?>
    <script type="text/template" id='template-wls-slider-item'>
      <div class="slide-item-wrap">
        <div class="slide-item-left">
          <div class="wls-form-row">
            <input type="hidden" name="slide_image_id[]" value="" class="wls-slide-image-id" />
            <input type="button" class="wls-select-img button button-primary" value="<?php _e( 'Upload', 'wen-logo-slider' ); ?>" data-uploader_button_text="<?php _e( 'Select', 'wen-logo-slider' );?>" data-uploader_title="<?php _e( 'Select Image', 'wen-logo-slider' );?>" />
            <div class="image-preview-wrap" style="display:none;" >
              <img class="img-preview" alt="<?php _e( 'Preview', 'wen-logo-slider' ); ?>" src="" />
              <a href="#" class="btn-wls-remove-image-upload">
                <span class="dashicons dashicons-dismiss"></span>
              </a>
            </div>

          </div>
        </div>
        <div class="slide-item-right">

          <div class="wls-form-row">
            <i class="dashicons dashicons-editor-textcolor"></i>
            <input type="text" name="slide_title[]" value="" placeholder="<?php _e( 'Enter Title', 'wen-logo-slider' ); ?>" class="txt-slide-title regular-text code" />
            <span class="description"><?php _e( 'Enter Title', 'wen-logo-slider' ); ?></span>
          </div>

          <div class="wls-form-row">
            <i class="dashicons dashicons-admin-site"></i>

            <input type="text" name="slide_url[]" value="" placeholder="<?php _e( 'Enter URL', 'wen-logo-slider' ); ?>" class="txt-slide-url regular-text code" />
            <span class="description"><?php _e( 'Enter URL', 'wen-logo-slider' ); ?></span>
          </div>

          <div class="wls-form-row">
            <i class="dashicons dashicons-share-alt2"></i>
            <select name="slide_new_window[]">
              <option value="yes"><?php _e( 'Yes', 'wen-logo-slider' ); ?></option>
              <option value="no"><?php _e( 'No', 'wen-logo-slider' ); ?></option>
            </select>
            <span class="description"><?php _e( 'Open in new window', 'wen-logo-slider' ); ?></span>

          </div>

          <input type="button" value="<?php  esc_attr( _e( 'Remove', 'wen-logo-slider' ) ); ?>" class="button btn-remove-slide-item"/>

        </div>
    </script>

    <?php
  }


  /**
   * Load TinyMce languages file.
   *
   * @since    1.0.0
   */
  function tinymce_external_language( $locales ){

    $locales ['wen-responsive-columns'] = WEN_RESPONSIVE_COLUMNS_DIR. '/admin/partials/wen-responsive-columns-tinymce-plugin-langs.php';
    return $locales;

  }

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WEN_Responsive_Columns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WEN_Responsive_Columns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wen-responsive-columns-admin.js', array( 'jquery' ), $this->version, false );

	}

}
