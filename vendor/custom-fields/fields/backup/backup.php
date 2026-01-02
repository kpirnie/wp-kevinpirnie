<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'KPT_FW_Field_backup' ) ) {
  class KPT_FW_Field_backup extends KPT_FW_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $unique = $this->unique;
      $nonce  = wp_create_nonce( 'kpt_fw_backup_nonce' );
      $export = add_query_arg( array( 'action' => 'kpt_fw-export', 'unique' => $unique, 'nonce' => $nonce ), admin_url( 'admin-ajax.php' ) );

      echo $this->field_before();

      echo '<textarea name="kpt_fw_import_data" class="kpt_fw-import-data"></textarea>';
      echo '<button type="submit" class="button button-primary kpt_fw-confirm kpt_fw-import" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Import', 'kpt_fw' ) .'</button>';
      echo '<hr />';
      echo '<textarea readonly="readonly" class="kpt_fw-export-data">'. esc_attr( json_encode( get_option( $unique ) ) ) .'</textarea>';
      echo '<a href="'. esc_url( $export ) .'" class="button button-primary kpt_fw-export" target="_blank">'. esc_html__( 'Export & Download', 'kpt_fw' ) .'</a>';
      echo '<hr />';
      echo '<button type="submit" name="kpt_fw_transient[reset]" value="reset" class="button kpt_fw-warning-primary kpt_fw-confirm kpt_fw-reset" data-unique="'. esc_attr( $unique ) .'" data-nonce="'. esc_attr( $nonce ) .'">'. esc_html__( 'Reset', 'kpt_fw' ) .'</button>';

      echo $this->field_after();

    }

  }
}
