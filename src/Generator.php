<?php

namespace Joshua\WooFakeReviews;

if ( !defined('ABSPATH' ) ) exit;

class Generator
{

    public function getComment()
    {
        $url = WFR_URL . 'js/data/reviews.json';
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_URL, $url);
        $result = curl_exec($handle);
        curl_close($handle);

        $result = json_decode($result, true);
        shuffle($result);
        return $result[0]['comment'];

    }

    public function getUser()
    {
        $url = WFR_URL . 'js/data/userdetails.json';
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_URL, $url);
        $result = curl_exec($handle);
        curl_close($handle);

        $result = json_decode($result, true);
        shuffle($result);
        $userDetails = array(
            'username' => $result[0]['name'],
            'email' => $result[0]['email'],
        );
        return $userDetails;

    }
}
