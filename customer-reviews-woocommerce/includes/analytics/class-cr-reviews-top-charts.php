<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CR_Reviews_Top_Charts' ) ) :

class CR_Reviews_Top_Charts {

	public static function count_ratings( $rating ) {
		$count_ratings = 0;

		// WPML compatibility
		if ( has_filter( 'wpml_current_language' ) ) {
			global $sitepress;
			if ( $sitepress ) {
				remove_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );
			}
		}

		// count product reviews
		$args = array(
			'number'       => '',
			'parent'       => 0,
			'count'        => true,
			'type__not_in' => array( 'cr_qna' ),
			'meta_key'     => 'rating',
			'lang'         => '' // Polylang compatibility
		);
		if ( $rating > 0 ) {
			$args['meta_value'] = intval( $rating );
		}
		// add_filter( 'comments_clauses', array( 'CR_Reviews_List_Table', 'filter_include_shop_reviews' ), 10, 1 );
		$count_ratings = get_comments( $args );

		// WPML compatibility
		if ( has_filter( 'wpml_current_language' ) ) {
			global $sitepress;
			if ( $sitepress ) {
				add_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );
			}
		}

		return $count_ratings;
	}

	public static function count_ratings_by_source( $source ) {
		$count_ratings = 0;

		// WPML compatibility
		if ( has_filter( 'wpml_current_language' ) ) {
			global $sitepress;
			if ( $sitepress ) {
				remove_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );
			}
		}

		// count product reviews
		$args = array(
			'number'       => '',
			'parent'       => 0,
			'count'        => true,
			'type__not_in' => array( 'cr_qna' ),
			'meta_key'     => ['rating'],
			'lang'         => '' // Polylang compatibility
		);
		if ( $source ) {
			$args['meta_query'][] = array(
				'key' => $source,
				'compare' => 'EXISTS'
			);
		}
		add_filter( 'comments_clauses', array( 'CR_Reviews_List_Table', 'filter_include_shop_reviews' ), 10, 1 );
		$count_ratings = get_comments( $args );

		// WPML compatibility
		if ( has_filter( 'wpml_current_language' ) ) {
			global $sitepress;
			if ( $sitepress ) {
				add_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );
			}
		}

		return $count_ratings;
	}

	public static function get_reviews_top_row_stats() {
		check_ajax_referer( 'cr-reviews-top-row', 'cr_nonce' );

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			die( '-2' );
		}

		$five  = self::count_ratings(5);
		$four  = self::count_ratings(4);
		$three = self::count_ratings(3);
		$two   = self::count_ratings(2);
		$one   = self::count_ratings(1);

		$all = $five + $four + $three + $two + $one;

		if ( 0 < $all ) {
			$five  = (float) $five;
			$four  = (float) $four;
			$three = (float) $three;
			$two   = (float) $two;
			$one   = (float) $one;

			$five_prcnt   = floor( $five / $all * 100 );
			$five_rnd     = $five / $all * 100 - $five_prcnt;
			$four_prcnt   = floor( $four / $all * 100 );
			$four_rnd     = $four / $all * 100 - $four_prcnt;
			$three_prcnt  = floor( $three / $all * 100 );
			$three_rnd    = $three / $all * 100 - $three_prcnt;
			$two_prcnt    = floor( $two / $all * 100 );
			$two_rnd      = $two / $all * 100 - $two_prcnt;
			$one_prcnt    = floor( $one / $all * 100 );
			$one_rnd      = $one / $all * 100 - $one_prcnt;

			$hundred = $five_prcnt + $four_prcnt + $three_prcnt + $two_prcnt + $one_prcnt;
			if ( $hundred < 100 ) {
				$to_distribute = 100 - $hundred;
				$roundings = array( '5' => $five_rnd, '4' => $four_rnd, '3' => $three_rnd, '2' => $two_rnd, '1' => $one_rnd );
				arsort($roundings);
				$roundings = array_filter( $roundings, function( $value ) {
					return $value > 0;
				} );
				while( $to_distribute > 0 && count( $roundings ) > 0 ) {
					foreach( $roundings as $key => $value ) {
						if ( $to_distribute > 0 ) {
							switch( $key ) {
								case 5:
									$five_prcnt++;
									break;
								case 4:
									$four_prcnt++;
									break;
								case 3:
									$three_prcnt++;
									break;
								case 2:
									$two_prcnt++;
									break;
								case 1:
									$one_prcnt++;
									break;
								default:
									break;
							}
							$to_distribute--;
						} else {
							break;
						}
					}
				}
			}
			$average = ( 5 * $five + 4 * $four + 3 * $three + 2 * $two + 1 * $one ) / $all;
		} else {
			$five_prcnt = $five = 0;
			$four_prcnt = $four = 0;
			$three_prcnt = $three = 0;
			$two_prcnt = $two = 0;
			$one_prcnt = $one = 0;
			$average = 0;
		}

		// count reviews by source
		$via_cusrev      = self::count_ratings_by_source( 'ivole_order' );
		$via_cusrev_priv = self::count_ratings_by_source( 'ivole_order_priv' );
		$via_local       = self::count_ratings_by_source( 'ivole_order_locl' );
		$via_any         = self::count_ratings_by_source( '' );

		$total = $via_any;

		$sources = array(
			'via_reminders' => (object) array(
				'label' => __( 'In response to reminders', 'customer-reviews-woocommerce' ),
				'count' => $via_cusrev + $via_cusrev_priv + $via_local,
				'part' => 0,
				'class' => 'chartColor1'
			),
			'via_onsite' => (object) array(
				'label' => __( 'On-site reviews and other', 'customer-reviews-woocommerce' ),
				'count' => $via_any - $via_cusrev - $via_cusrev_priv - $via_local,
				'part' => 0,
				'class' => 'chartColor2'
			)
		);

		// calculate percentage of different statuses
		if ( 0 < $total ) {
			foreach ( $sources as $source ) {
				$source->part = round( $source->count / $via_any * 100 );
				$source->count = number_format_i18n( $source->count );
			}
		}

		wp_send_json(
			array(
				'average' => number_format_i18n( $average, 1 ),
				'ratings' => array_values( array(
					5 => (object) array(
						'label' => '5',
						'count' => html_entity_decode( number_format_i18n( $five, 0 ) ),
						'part'  => $five_prcnt,
						'class' => 'chartColor1'
					),
					4 => (object) array(
						'label' => '4',
						'count' => html_entity_decode( number_format_i18n( $four, 0 ) ),
						'part' => $four_prcnt,
						'class' => 'chartColor2'
					),
					3 => (object) array(
						'label' => '3',
						'count' => html_entity_decode( number_format_i18n( $three, 0 ) ),
						'part' => $three_prcnt,
						'class' => 'chartColor3'
					),
					2 => (object) array(
						'label' => '2',
						'count' => html_entity_decode( number_format_i18n( $two, 0 ) ),
						'part' => $two_prcnt,
						'class' => 'chartColor4'
					),
					1 => (object) array(
						'label' => '1',
						'count' => html_entity_decode( number_format_i18n( $one, 0 ) ),
						'part' => $one_prcnt,
						'class' => 'chartColor5'
					)
				) ),
				'total' => html_entity_decode( number_format_i18n( $via_any, 0 ) ),
				'sources' => array_values( $sources )
			)
		);
	}

}

endif;
