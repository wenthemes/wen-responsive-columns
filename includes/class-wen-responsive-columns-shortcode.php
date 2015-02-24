<?php

/**
 * The file that defines shortcode
 *
 * @link       http://wenthemes.com
 * @since      1.0.0
 *
 * @package    WEN_Responsive_Columns
 * @subpackage WEN_Responsive_Columns/includes
 */

/**
 * Shortcode class.
 *
 * This class contains shortcode stuff.
 *
 * @since      1.0.0
 * @package    WEN_Responsive_Columns
 * @subpackage WEN_Responsive_Columns/includes
 * @author     WEN Themes <info@wenthemes.com>
 */
class WEN_Responsive_Columns_Shortcode {

  public function init() {

    add_shortcode( 'wrc_column', array( $this, 'wen_responsive_columns_shortcode_callback' ) );

  }

  function wen_responsive_columns_shortcode_callback( $atts, $content = "" ){

    $args = shortcode_atts( array(
      'grid'  => '2',
      'width' => '1',
      'type'  => '',
    ), $atts, 'wrc_column' );

    $output = '';
    // Start
    if ( 'start' == $args['type'] ) {
      $output .= '<div class="wrc-column-grid wrc-column-grid-' . $args['grid'] . '">';
    }

    // Content
    $output .= '<div class="wrc-column wrc-column-width-' . $args['width'];
    if ( 'start' == $args['type'] ) {
      $output .= ' wrc-column-start';
    }
    else if ( 'end' == $args['type'] ) {
      $output .= ' wrc-column-end';
    }
    $output .= '">';
    $output .= apply_filters( 'wrc_column_content', $content );
    $output .= '</div>';

    // End
    if ( 'end' == $args['type'] ) {
      $output .= '</div><!-- .wrc-column-grid -->';
    }

    return $output;

  }



}
