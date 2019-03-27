<?php
/**
 * Our admin panels interface file
 */

add_action('admin_menu', 'setup_menu');

function setup_menu(){
    add_menu_page( 'Defender', 'Defender', 'edit_files', 'defender-plugin', 'index_action' );
}

function index_action(){
    include('templates/home.php');
}