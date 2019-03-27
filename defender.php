<?php
/**
* Plugin Name: Defender FIM and Checker
* Plugin URI: --
* Description: This is a simple fim and file checker
* Version: 0.1
* Author: Sven Andrews
* Author URI: --
**/

// Database version control
global $defender_db_version;
$defender_db_version = '0.3';

define('DEFENDER_ROOT', dirname(__FILE__));

// installation hook
register_activation_hook( __FILE__, 'defender_install');

// Updater
add_action( 'plugins_loaded', 'update_check');

// Admin 
include('admin/interface.php');

function defender_install()
{
    global $defender_db_version;
    global $wpdb;
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $table_name = $wpdb->prefix . "defender_logs"; 
    $sql = "CREATE TABLE $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        scan_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        file_count INT,
        PRIMARY KEY (id)
      ) $charset_collate;";
      
      dbDelta( $sql );

      $table_name = $wpdb->prefix . "defender_files"; 
      $sql = "CREATE TABLE $table_name (
          id INT NOT NULL AUTO_INCREMENT,
          last_check datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          path TEXT,
          md5 TEXT,
          PRIMARY KEY (id)
        ) $charset_collate;";

        dbDelta( $sql );

        $table_name = $wpdb->prefix . "defender_warnings"; 
        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            last_check datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            path TEXT,
            PRIMARY KEY (id)
          ) $charset_collate;";
  
          dbDelta( $sql );

      add_option( 'defender_db_version', $defender_db_version );
}

function update_check() {
    global $defender_db_version;
    if ( get_site_option( 'defender_db_version' ) != $defender_db_version ):
        defender_install();
   endif;
}
