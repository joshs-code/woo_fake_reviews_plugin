<?php

 if ( !defined('ABSPATH' ) ) exit;

class Deactivator
{
    public static function deactivate()
    {
        if (!get_option('wfr_schedule')) {
            delete_option('wfr_schedule');
        }

        wp_clear_scheduled_hook('wfrdo_cron');

    }
}
