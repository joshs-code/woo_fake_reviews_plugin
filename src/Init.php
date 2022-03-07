<?php

namespace Joshua\WooFakeReviews;

if ( !defined('ABSPATH' ) ) exit;

class Init
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Init();
        }

        return self::$instance;
    }

    public function startUp()
    {
        add_action('admin_menu', array(new Manage\Admin\AdminSettings, 'settingsPage'));
        add_action('admin_post_get_reviews', array(new Ajax, 'getReviews'));
        add_action('admin_post_bulk_reviews', array(new Ajax, 'bulkReviews'));
        add_action('admin_post_delete_all', array(new Data\Operation, 'delete'));
        add_action('admin_post_upload_csv', array(new Ajax, 'getCsv'));
        add_action('admin_post_random_post', array(new Ajax, 'randomPost'));
        add_action('admin_init', array(new Data\Task, 'wfrSchedule'));
    }

}
