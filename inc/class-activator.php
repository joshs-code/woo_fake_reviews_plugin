<?php

if ( !defined('ABSPATH' ) ) exit;

class Activator
{
    public static function activate()
    {

        update_option('wfr_schedule', 0);

    }
}
