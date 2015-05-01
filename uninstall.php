<?php
if(!defined('WP_UNINSTALL_PLUGIN'))
    exit;

    /** following code deletes the database table
     * and the plugin options after uninstall.
     */
global $wpdb;

$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ghazaledb");
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'ghazaledb_%'" );