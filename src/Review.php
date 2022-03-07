<?php

namespace Joshua\WooFakeReviews;

if ( !defined('ABSPATH' ) ) exit;

use Joshua\WooFakeReviews\Generator;
use Joshua\WooFakeReviews\Product;

require WFR_BASE_PATH . 'inc/helpers/date-handler.php';

class Review
{
    public function createReview($id, $numReviews, $latestDate, $fiveStar = null)
    {
        $generator = new Generator();
        for ($i = 0; $i < $numReviews; $i++):
            $setDate = randDate($latestDate);

            // Get values for comments
            $randCom = $generator->getComment();
            $userDetails = $generator->getUser();
            if (!empty($fiveStar)):
                $ratings = $fiveStar;
            else:
                $ratings = array(4, 5);
            endif;
            // Randomize The Rating For Product
            shuffle($ratings);

            $comment_id = wp_insert_comment(array(
                'comment_post_ID' => $id,
                'comment_author' => $userDetails['username'],
                'comment_author_email' => $userDetails['email'],
                'comment_author_url' => '',
                'comment_content' => $randCom,
                'comment_type' => '',
                'comment_parent' => 0,
                'user_id' => 10000,
                'comment_author_IP' => '',
                'comment_agent' => '',
                'comment_date' => $setDate,
                'comment_approved' => 1,
            ));

            update_comment_meta($comment_id, 'verified', 1, true);
            update_comment_meta($comment_id, 'rating', $ratings[0], 1);

        endfor;

    }

    public function allReview($numReviews, $latestDate, $fiveStar = null)
    {

        $generator = new Generator();
        $products = new Product();
        $allProducts = $products->getProducts();

        foreach ($allProducts as $product):
            // Get The Product Ids for all in store
            $productId = $product['product_id'];

            for ($i = 0; $i < $numReviews; $i++):

                $setDate = randDate($latestDate);

                // Get values for comments
                $randCom = $generator->getComment();
                $userDetails = $generator->getUser();
                if (!empty($fiveStar)):
                    $ratings = $fiveStar;
                else:
                    $ratings = array(4, 5);
                endif;
                // Randomize The Rating For Product
                shuffle($ratings);

                $comment_id = wp_insert_comment(array(
                    'comment_post_ID' => $productId,
                    'comment_author' => $userDetails['username'],
                    'comment_author_email' => $userDetails['email'],
                    'comment_author_url' => '',
                    'comment_content' => $randCom,
                    'comment_type' => '',
                    'comment_parent' => 0,
                    'user_id' => 10000,
                    'comment_author_IP' => '',
                    'comment_agent' => '',
                    'comment_date' => $setDate,
                    'comment_approved' => 1,
                ));

                //Update comments verfied badge
                update_comment_meta($comment_id, 'verified', 1, true);
                //Update comments rating
                update_comment_meta($comment_id, 'rating', $ratings[0], 1);


            endfor;

        endforeach;
    }

    public function csvCreateReview($csv)
    {
        foreach ($csv as $review):
            $comment_id = wp_insert_comment(array(
                'comment_post_ID' => $review['product_id'],
                'comment_author' => $review['author'],
                'comment_author_email' => $review['author_email'],
                'comment_author_url' => $review['author_url'],
                'comment_content' => $review['review_content'],
                'comment_type' => '',
                'comment_parent' => 0,
                'user_id' => 10000,
                'comment_author_IP' => '',
                'comment_agent' => '',
                'comment_date' => $review['review_date'],
                'comment_approved' => 1,
            ));
            update_comment_meta($comment_id, 'verified', 1, true);
            update_comment_meta($comment_id, 'rating', $review['rating'], 1);
        endforeach;
    }

    public function randomReviewSchedule()
    {
        $generator = new Generator();
        $products = new Product();
        $allProducts = $products->getProducts();

        $randCom = $generator->getComment();
        $userDetails = $generator->getUser();

        $productsList = array(); // Store products in array

        foreach ($allProducts as $product):
            array_push($productsList, $product['product_id']);
        endforeach;

        shuffle($productsList);
        $randomProduct = $productsList[0];

        $ratings = array(4, 5);
        shuffle($ratings);

        $comment_id = wp_insert_comment(array(
            'comment_post_ID' => $randomProduct,
            'comment_author' => $userDetails['username'],
            'comment_author_email' => $userDetails['email'],
            'comment_author_url' => '',
            'comment_content' => $randCom,
            'comment_type' => '',
            'comment_parent' => 0,
            'user_id' => 10000,
            'comment_author_IP' => '',
            'comment_agent' => '',
            'comment_date' => date('Y-m-d H:i:s'),
            'comment_approved' => 1,
        ));

        update_comment_meta($comment_id, 'verified', 1, true);
        update_comment_meta($comment_id, 'rating', $ratings[0], 1);
    }
}
