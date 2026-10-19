<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$customer_images = array();
$customer_videos = array();
foreach ( get_comment_meta( $review->comment_ID, CR_Reviews::REVIEWS_META_IMG ) as $pic ) {
	if ( ! empty( $pic['url'] ) ) {
		$customer_images[] = $pic['url'];
	}
}
foreach ( get_comment_meta( $review->comment_ID, CR_Reviews::REVIEWS_META_LCL_IMG ) as $pic ) {
	$attachment_url = wp_get_attachment_image_url( $pic, $image_size );
	if ( $attachment_url ) {
		$customer_images[] = $attachment_url;
	}
}
foreach ( get_comment_meta( $review->comment_ID, CR_Reviews::REVIEWS_META_VID ) as $video ) {
	if ( ! empty( $video['url'] ) ) {
		$customer_videos[] = $video['url'];
	}
}
foreach ( get_comment_meta( $review->comment_ID, CR_Reviews::REVIEWS_META_LCL_VID ) as $video ) {
	$attachment_url = wp_get_attachment_url( $video );
	if ( $attachment_url ) {
		$customer_videos[] = $attachment_url;
	}
}
$count_customer_images = count( $customer_images );
$count_customer_videos = count( $customer_videos );
if ( ! $count_customer_images && ! $count_customer_videos ) {
	return;
}
if ( ! empty( $thumbnails ) ) :
?>
<div class="image-row cr-media-thumbnails">
	<?php foreach ( $customer_videos as $index => $url ) :
		$title = sprintf( __( 'Video #%1$d from %2$s', 'customer-reviews-woocommerce' ), $index + 1, $review->comment_author );
	?>
		<a class="cr-media-thumbnail" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
			<video preload="metadata" muted playsinline class="image-row-vid" src="<?php echo esc_url( $url . '#t=0.1' ); ?>" data-crmedia="vid" data-crtitle="<?php echo esc_attr( $title ); ?>"></video>
			<img class="cr-comment-videoicon" src="<?php echo esc_url( CR_Utils::cr_get_plugin_dir_url() . 'img/video.svg' ); ?>" alt="">
		</a>
	<?php endforeach; ?>
	<?php foreach ( $customer_images as $index => $url ) :
		$title = sprintf( __( 'Image #%1$d from %2$s', 'customer-reviews-woocommerce' ), $index + 1, $review->comment_author );
	?>
		<a class="cr-media-thumbnail" href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
			<img class="image-row-img" src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" data-crmedia="pic">
		</a>
	<?php endforeach; ?>
</div>
<?php
	return;
endif;
?>
<div class="image-row">
	<?php foreach ( $customer_videos as $index => $url ) :
		$title = sprintf( __( 'Video #%1$d from %2$s', 'customer-reviews-woocommerce' ), $index + 1, $review->comment_author );
	?>
		<video preload="metadata" class="image-row-vid<?php echo $index ? ' image-row-vid-none' : ''; ?>" src="<?php echo esc_url( $url . '#t=0.1' ); ?>" data-crmedia="vid" data-crtitle="<?php echo esc_attr( $title ); ?>"></video>
		<?php if ( ! $index ) : ?>
			<img class="cr-comment-videoicon" src="<?php echo esc_url( CR_Utils::cr_get_plugin_dir_url() . 'img/video.svg' ); ?>" alt="<?php echo esc_attr( $title ); ?>">
		<?php endif; ?>
	<?php endforeach; ?>
	<?php foreach ( $customer_images as $index => $url ) : ?>
		<img class="image-row-img<?php echo $count_customer_videos || $index ? ' image-row-img-none' : ''; ?>" src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( sprintf( __( 'Image #%1$d from %2$s', 'customer-reviews-woocommerce' ), $index + 1, $review->comment_author ) ); ?>"<?php echo ! $count_customer_videos && ! $index ? ' loading="lazy"' : ''; ?> data-crmedia="pic">
	<?php endforeach; ?>
	<div class="media-row-count">
		<?php if ( $count_customer_videos ) : ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="cr-grid-icon-counter-video"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z" /><path d="M3 6m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /></svg>
			<span><?php echo esc_html( $count_customer_videos ); ?></span>
		<?php endif; ?>
		<?php if ( $count_customer_images ) : ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="40" height="27" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cr-grid-icon-counter-photo"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" /></svg>
			<span><?php echo esc_html( $count_customer_images ); ?></span>
		<?php endif; ?>
	</div>
</div>
