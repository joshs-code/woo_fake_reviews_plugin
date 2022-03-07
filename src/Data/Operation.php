<?php

namespace Joshua\WooFakeReviews\Data;

if ( !defined('ABSPATH' ) ) exit;

class Operation
{
    public static function delete()
    {
        global $wpdb;
        $wpdb->delete('wp_comments', array('user_id' => 10000));
        set_transient( 'wfr_success', 'All reviews have been deleted!', 60 );
        $location = $_SERVER['HTTP_REFERER'];
        wp_safe_redirect($location);
        exit();
    }
}