<?php

namespace Joshua\WooFakeReviews;

if ( !defined('ABSPATH' ) ) exit;

class Product
{
    public function getProducts()
    {
        $allProducts = [];

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );

        $loop = new \WP_Query($args);

        while ($loop->have_posts()): $loop->the_post();
            global $product;

            $allProducts[] = array(
                'product_id' => $product->id,
                'product_name' => $product->name,
            );

        endwhile;

        wp_reset_query();

        return $allProducts;
    }
}
