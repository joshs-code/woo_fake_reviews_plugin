<?php

namespace Joshua\WooFakeReviews\Manage\Admin;

use Joshua\WooFakeReviews\Product;

if ( !defined('ABSPATH' ) ) exit;

class AdminSettings
{
    public function settingsPage()
    {
        add_menu_page(
            'Woo Fake Reviews | Settings',
            'Woo Fake Reviews',
            'manage_options',
            'woo_fake_reviews',
            array($this, 'customPage'),
            'dashicons-media-spreadsheet'

        );
    }

    public function customPage()
    {
        $products = new Product();
        $allProducts = $products->getProducts();
        ?>
            <h1>Woo Fake Reviews</h1>
            <?php if (get_transient('wfr_success')): ?>
                <div class="notice notice-success is-dismissible"><?=get_transient('wfr_success');?></div>
            <?php endif;?>
            <?php if (get_transient('wfr_error')): ?>
                <div class="notice notice-error is-dismissible"><?=get_transient('wfr_error');?></div>
            <?php endif;?>
            <section>
                <h3>Single Product:</strong></h3>
                <p>Select your product and the amount of reviews you want to add</p>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <div style="margin-bottom:5px; margin-top:5px;">
                        <strong>Notice: </strong><small><u>[ Default is random 4-5 star ratings ]</u></small><br>
                        <input type="checkbox" name="fivestar" value="5">
                        <label for="">5 Star only reviews</label>
                    </div>
                    <input type="date" name="latestdate" required>
                    <select name="product" required>
                        <?php foreach ($allProducts as $product): ?>
                            <?php echo '<option value=" ' . esc_html__($product['product_id'], 'woo-fake-reviews') . '">' . esc_html($product['product_name'], 'woo-fake-reviews') . '</option>'; ?>
                        <?php endforeach;?>
                    </select>
                    <select name="amount" required >
                        <option selected="selected" value="">--Select--</option>
                    <?php for ($i = 0; $i <= 50; $i++): ?>
                    <?php echo "<option value='" . $i . "'>" . esc_html__($i) . "</option>"; ?>
                    <?php endfor;?>
                    </select>
                    <input type="hidden" name="action" value="get_reviews">
                    <input class="button-secondary" type="submit" value="Get Reviews">
                </form>
            </section>

            <section>
                <h3>Create reviews for all products in store:</h3>
                <p>Select the number of reviews for all products</p>
                <p>[ The higher the number the longer it will take to complete. Please dont refresh the page ]</p>
                <form style="margin-top:15px;" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <div style="margin-bottom:5px; margin-top:5px;">
                        <strong>Notice: </strong><small><u>[ Default is random 4-5 star ratings ]</u></small><br>
                        <input type="checkbox" name="fivestar" value="5">
                        <label for="">5 Star only reviews</label>
                    </div>
                    <input type="date" name="latestdate" required>
                    <select name="amount" required >
                        <option selected="selected" value="">--Select--</option>
                        <?php for ($i = 0; $i <= 100; $i++): ?>
                        <?php echo "<option value='" . $i . "'>" . $i . "</option>"; ?>
                        <?php endfor;?>
                    </select>
                    <input type="hidden" name="action" value="bulk_reviews">
                    <input class="button-secondary" type="submit" value="Create Bulk Reviews">
                </form>
            </section>


            <section>
                <h3>Upload your own CSV review files</h3>
                <form action="<?php echo esc_url('admin-post.php'); ?>" method="post" enctype="multipart/form-data">
                    <input type="file" name="csvFile">
                    <input type="hidden" name="action" value="upload_csv">
                    <input class="button-secondary" type="submit" value="Create CSV Reviews">
                </form>
            </section>

            <section>
                <h3>Create Random Comments Once a Day on Random Products</h3>
                <p>A random review will be created to a random product in your store once a day: <br> <small>[ Only works if someone visits your page once a day. Will not run if no visitors come to your page. ]</small></p>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <input type="radio" value="1" name="random" <?php if (get_option('wfr_schedule') == 1) {
            echo esc_html('checked');
        }
        ?> >
                    <label for="">Enable</label>
                    <input type="radio" value="0" name="random" <?php if (get_option('wfr_schedule') == 0) {
            echo esc_html('checked');
        }
        ?> >
                    <label for="">Disable</label>
                    <input type="hidden" name="action" value="random_post">
                    <input type="submit" value="Submit" class="button-secondary" >
                </form>
            </section>

            <section>
                <h3>Delete all generated reviews</h3>
                <div style="margin-bottom:5px;"> [ This will delete every review that the generator ever made! ]</div>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="delete_all">
                    <input type="submit" class="button-primary" value="Delete All Reviews">
                </form>
            </section>

        <?php
}
}