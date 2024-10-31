<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
delete_option( 'pfb_woo_options' );