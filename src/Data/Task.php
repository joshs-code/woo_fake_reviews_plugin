<?php

namespace Joshua\WooFakeReviews\Data;

use Joshua\WooFakeReviews\Review;

if ( !defined('ABSPATH' ) ) exit;

class Task
{
    public function wfrSchedule()
    {
        if (get_option('wfr_schedule') == 1):
            if (!wp_next_scheduled('wfrdo_cron')):
                wp_schedule_event(time(), 'daily', 'wfrdo_cron');
            endif;
        else:
            wp_clear_scheduled_hook('wfrdo_cron');
        endif;
        add_action('wfrdo_cron', array($this, 'wfrdoTask'));
    }

    public function wfrdoTask()
    {
        $randomReview = new Review();
        $randomReview->randomReviewSchedule();
    }
}
