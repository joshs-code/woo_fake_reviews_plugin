<?php

namespace Joshua\WooFakeReviews;

use Joshua\WooFakeReviews\Data\Task;
use Joshua\WooFakeReviews\Review;

if ( !defined('ABSPATH' ) ) exit;

class Ajax
{
    public function getReviews()
    {
        if (isset($_POST['product']) && $_POST['amount'] && $_POST['latestdate']) {
            $id = sanitize_text_field($_POST['product']);
            $numReviews = sanitize_text_field($_POST['amount']);
            $latestDate = sanitize_text_field($_POST['latestdate']);
            $fiveStars = sanitize_text_field($_POST['fivestar']);

            $commentCreate = new Review();
            $commentCreate->createReview($id, $numReviews, $latestDate, $fiveStars);
            set_transient('wfr_success', 'Reviews have been added!', 60);
            $location = $_SERVER['HTTP_REFERER'];
            wp_safe_redirect($location);
            exit();
        }

        set_transient('wfr_error', 'An error has occured. Please make sure all fields are completed!', 60);
        $location = $_SERVER['HTTP_REFERER'];
        wp_safe_redirect($location);
        exit();

    }

    public function bulkReviews()
    {
        if (isset($_POST['amount']) && isset($_POST['latestdate'])) {
            $numReviews = sanitize_text_field($_POST['amount']);
            $latestDate = sanitize_text_field($_POST['latestdate']);
            $fiveStars = sanitize_text_field($_POST['fivestar']);
            $bulkCreate = new Review();
            $bulkCreate->allReview($numReviews, $latestDate, $fiveStars);
            set_transient('wfr_success', 'Reviews have been added!', 60);
            $location = $_SERVER['HTTP_REFERER'];
            wp_safe_redirect($location);
            exit();
        }

        set_transient('wfr_error', 'An error has occured. Please try again later!', 60);
        $location = $_SERVER['HTTP_REFERER'];
        wp_safe_redirect($location);
        exit();
    }

    public function getCsv()
    {
        if (isset($_FILES['csvFile'])) {
            /// Approved Mimes for CSV format
            $csvMimes = array(
                'text/csv',
                'text/plain',
                'application/csv',
                'text/comma-separated-values',
                'application/excel',
                'application/vnd.ms-excel',
                'application/vnd.msexcel',
                'text/anytext',
                'application/octet-stream',
                'application/txt',
            );

            // Check file uploaded against csvmines array
            if (in_array($_FILES['csvFile']['type'], $csvMimes)):
                require WFR_BASE_PATH . 'inc/helpers/csv.php';
                $csv = csvToArray($_FILES['csvFile']['tmp_name']);
                $csvCreate = new Review();
                $csvCreate->csvCreateReview($csv);
                set_transient('wfr_success', 'Reviews have been added!', 60);
                $location = $_SERVER['HTTP_REFERER'];
                wp_safe_redirect($location);
                exit();
            else:
                set_transient('wfr_error', 'Not a valid CSV format', 60);
                $location = $_SERVER['HTTP_REFERER'];
                wp_safe_redirect($location);
                exit();
            endif;

        }

    }

    public function randomPost()
    {
        if (isset($_POST['random'])):
            $check = sanitize_text_field($_POST['random']);
            if ($check == 1):
                update_option('wfr_schedule', '1');
                $task = new Task();
                $task->wfrSchedule();
            else:
                update_option('wfr_schedule', '0');
                $task = new Task();
                $task->wfrSchedule();
            endif;
        endif;

        set_transient('wfr_success', 'Random Reviews Daily Has Been Enabled!', 60);
        $location = $_SERVER['HTTP_REFERER'];
        wp_safe_redirect($location);
        exit();
    }
}
