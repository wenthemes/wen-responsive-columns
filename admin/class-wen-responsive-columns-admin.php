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
    <div id="WRC-popup-form" style="display:none">
      <div>
      <style>
      .wrc-form-content{
        margin: 5px;
      }
      .wrc-form-content .form-row{
        clear: both;
        margin-bottom: 10px;
      }

      </style>
        <div class="wrc-form-content">

          <div class="form-row">
            <label for="wrc-grid"><?php _e( 'Grid:', 'wen-responsive-columns' ); ?></label>
            <select name="wrc-grid" id="wrc-grid">
              <option value=""><?php _e( 'Select', 'wen-responsive-columns' ); ?></option>
              <option value="2"><?php _e( '2', 'wen-responsive-columns' ); ?></option>
              <option value="3"><?php _e( '3', 'wen-responsive-columns' ); ?></option>
              <option value="4"><?php _e( '4', 'wen-responsive-columns' ); ?></option>
              <option value="5"><?php _e( '5', 'wen-responsive-columns' ); ?></option>
              <option value="12"><?php _e( '12', 'wen-responsive-columns' ); ?></option>
            </select>
          </div><!-- .form-row -->

          <div class="form-row">
            <label for="wrc-column-number"><?php _e( 'Number of Columns:', 'wen-responsive-columns' ); ?></label>
            <select name="wrc-column-number" id="wrc-column-number">
              <option value=""><?php _e( 'Select', 'wen-responsive-columns' ); ?></option>
            </select>
          </div><!-- .form-row -->

          <div class="form-row">
            <input type="button" id="WRC-submit" class="button-primary" value="<?php esc_attr( _e( 'Insert', 'wen-responsive-columns' ) ); ?>" name="submit" disabled="disabled" />
          </div><!-- .form-row -->

        </div><!-- .wrc-form-content -->

        <script type="text/javascript">
          jQuery(document).ready(function($){

            // Populate columns select options
            function wrc_populate_columns(){
              // Grid value
              var wrc_grid = $('#wrc-grid').val();
              var options_html = '';
              if( ! wrc_grid ){
                options_html += '<option value="">Select</option>';
              }
              else{
                for( var i = 0; i < wrc_grid ; i++ ){
                  var opt = i + 1.0;
                  // Make 2 column selected by default
                  var selected_text = ( 1 == i ) ? ' selected="selected" ' : '';
                  // Append option
                  options_html += '<option value="' + opt + '"' + selected_text + '>' + opt + '</option>';
                }
              }
              // Empty all select option at first
              $('#wrc-column-number').html('');
              // Append options html to select field
              $('#wrc-column-number').append( options_html );
            }

            // Trigger change of Grid field
            $('#wrc-grid').change(function(e){
              wrc_populate_columns();
            });


            // Trigger Submit button
            $('#WRC-submit').click(function(e){
              e.preventDefault();

              var shortcode = '[wrc_column';
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


      </div>
    </div><!-- #WRC-popup-form -->
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
