<?php
/*
	Uninstalling Customer Reviews for WooCommerce
*/

// if uninstall.php is not called by WordPress, die
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$cr_uninstall_options = array(
	'ivole_ajax_reviews_per_page',
	'ivole_ajax_reviews_sort',
	'ivole_customer_consent',
	'ivole_coupon_enable',
	'ivole_customer_consent_text',
	'ivole_enable_for',
	'ivole_enabled_categories',
	'ivole_product_feed_categories',
	'ivole_product_feed_identifiers',
	'ivole_google_brand_static',
	'ivole_language',
	'ivole_exclude_free_products',
	'ivole_reviews_verified',
	'ivole_referrals_tracking',
	'ivole_license_key',
	'ivole_registered_customers',
	'ivole_reviews_verified_page',
	'ivole_age_restriction',
	'ivole_activation_notice',
	'ivole_version',
	'ivole_update_votes_meta',
	'ivole_update_media_meta',
	'ivole_email_heading_coupon',
	'ivole_email_subject_coupon',
	'ivole_email_from_name',
	'ivole_email_footer',
	'ivole_email_from',
	'ivole_coupon_email_replyto',
	'ivole_coupon_enable_for_role',
	'ivole_coupon_enabled_roles',
	'ivole_coupon_type',
	'ivole_existing_coupon',
	'ivole_coupon_email_bcc',
	'ivole_email_coupon_color_bg',
	'ivole_email_coupon_color_text',
	'ivole_coupon_tiers',
	'ivole_coupon_prefix',
	'ivole_coupon__discount_type',
	'ivole_coupon__coupon_amount',
	'ivole_coupon__individual_use',
	'ivole_coupon__product_ids',
	'ivole_coupon__exclude_product_ids',
	'ivole_coupon__usage_limit',
	'ivole_coupon__expires_days',
	'ivole_coupon__free_shipping',
	'ivole_coupon__exclude_sale_items',
	'ivole_coupon__product_categories',
	'ivole_coupon__excluded_product_categories',
	'ivole_coupon__minimum_amount',
	'ivole_coupon__maximum_amount',
	'ivole_coupon__sharing',
	'ivole_email_heading',
	'ivole_email_subject',
	'ivole_form_header',
	'ivole_form_body',
	'ivole_email_replyto',
	'ivole_form_comment_required',
	'ivole_form_shop_rating',
	'ivole_form_attach_media',
	'ivole_form_rating_bar',
	'ivole_form_geolocation',
	'ivole_limit_reminders',
	'ivole_enable_for_role',
	'ivole_enabled_roles',
	'ivole_enable_for_guests',
	'ivole_email_bcc',
	'ivole_form_color_bg',
	'ivole_form_color_text',
	'ivole_form_color_el',
	'ivole_email_color_bg',
	'ivole_email_color_text',
	'ivole_shop_name',
	'ivole_enable_moderation',
	'ivole_test_secret_key',
	'ivole_reviews_milestone',
	'ivole_scheduler_type',
	'ivole_attach_image_quantity',
	'ivole_attach_image_size',
	'ivole_disable_lightbox',
	'ivole_reviews_histogram',
	'ivole_ajax_reviews',
	'ivole_attach_image',
	'ivole_form_attach_media',
	'ivole_reviews_shortcode',
	'ivole_reviews_voting',
	'ivole_trust_badge_floating',
	'ivole_captcha_secret_key',
	'ivole_reviews_nobranding',
	'ivole_enable_captcha',
	'ivole_captcha_site_key',
	'ivole_order_status',
	'ivole_enable',
	'ivole_delay',
	'ivole_product_feed_identifiers',
	'ivole_product_feed_enable_id_str_dat',
	'ivole_product_feed_cron',
	'ivole_product_reviews_feed_cron',
	'ivole_google_encode_special_chars',
	'ivole_google_min_review_length',
	'ivole_google_generate_xml_feed',
	'ivole_google_exclude_variable_parent',
	'ivole_product_feed_file_url',
	'ivole_product_feed_variations',
	'ivole_product_feed_attributes',
	'ivole_excl_product_ids',
	'ivole_product_feed_categories',
	'ivole_product_feed_categories_exclude',
	'ivole_product_feed',
	'ivole_google_field_map',
	'ivole_product_feed_enable_gtin',
	'ivole_product_feed_enable_mpn',
	'ivole_product_feed_enable_brand',
	'ivole_product_feed_enable_material',
	'ivole_product_feed_enable_multipack',
	'ivole_product_feed_enable_bundle',
	'ivole_product_feed_enable_identifier_exists',
	'ivole_questions_answers',
	'ivole_qna_count',
	'ivole_qna_captcha_secret_key',
	'ivole_qna_captcha_site_key',
	'ivole_qna_enable_captcha',
	'ivole_enable_manual',
	'ivole_ignore_duplicate_siteurl_notice',
	'ivole_siteurl',
	'ivole_ajax_reviews_form',
	'ivole_email_body',
	'ivole_email_body_coupon',
	'ivole_feed_file_url',
	'ivole_trust_badge_floating_type',
	'ivole_verified_owner',
	'ivole_avatars',
	'ivole_trust_badge_floating_location',
	'ivole_excl_out_of_stock',
	'ivole_store_stats',
	'ivole_qna_email_reply',
	'ivole_mailer_qna_reply',
	'ivole_email_from_name_qna_reply',
	'ivole_email_from_qna_reply',
	'ivole_email_bcc_qna_reply',
	'ivole_email_subject_qna_reply',
	'ivole_email_heading_qna_reply',
	'ivole_email_body_qna_reply',
	'ivole_verified_reviews',
	'ivole_mailer_review_reminder',
	'ivole_hidden_banners',
	'ivole_local_reviews_page',
	'ivole_verified_live_mode',
	'ivole_verified_links',
	'ivole_review_forms',
	'ivole_wa_message',
	'ivole_track_reminder_open',
	'ivole_review_login_url'
);

foreach ( $cr_uninstall_options as $uninstall_option ) {
	delete_option( $uninstall_option );
}

global $wpdb;
$forms_table = $wpdb->prefix . 'cr_local_forms';
$wpdb->query( "DROP TABLE IF EXISTS `$forms_table`;" );
$reminders_table = $wpdb->prefix . 'cr_reminders_log';
$wpdb->query( "DROP TABLE IF EXISTS `$reminders_table`;" );
$wpmail_log_table = $wpdb->prefix . 'cr_wpmail_log';
$wpdb->query( "DROP TABLE IF EXISTS `$wpmail_log_table`;" );

wp_cache_flush();
