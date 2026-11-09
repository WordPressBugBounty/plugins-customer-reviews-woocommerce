<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CR_Utils' ) ) :

	class CR_Utils {

		public static function cr_locate_template( $template_name, $template_path, $default_path ) {
			$template = locate_template(
				array(
					trailingslashit( $template_path ) . $template_name,
					$template_name,
				)
			);
			if ( ! $template ) {
				$template = $default_path . $template_name;
			}
			return apply_filters( 'cr_locate_template', $template, $template_name, $template_path, $default_path );
		}

		public static function cr_language_attributes() {
			$doctype = 'html';
			$attributes = array();

			if ( function_exists( 'is_rtl' ) && is_rtl() ) {
				$attributes[] = 'dir="rtl"';
			}

			$lang = get_bloginfo( 'language' );
			if ( $lang ) {
				if ( 'text/html' === get_option( 'html_type' ) || 'html' === $doctype ) {
					$attributes[] = 'lang="' . esc_attr( $lang ) . '"';
				}

				if ( 'text/html' !== get_option( 'html_type' ) || 'xhtml' === $doctype ) {
					$attributes[] = 'xml:lang="' . esc_attr( $lang ) . '"';
				}
			}

			$output = implode( ' ', $attributes );

			echo $output;
		}

		public static function cr_get_plugin_dir_url() {
			return plugin_dir_url( dirname( dirname( __FILE__ ) ) );
		}

		/**
		* Base URL of the CusRev API. Define CR_API_URL in wp-config.php to point it
		* at a local/dev environment
		*/
		public static function cr_api_url() {
			return defined( 'CR_API_URL' ) ? untrailingslashit( CR_API_URL ) : 'https://api.cusrev.com';
		}

		/**
		* Adds a search condition to the arguments of a comment query. The standard 'search'
		* argument of WP_Comment_Query must not be used for frontend searches because it
		* searches over non-public fields (comment_author_email, comment_author_IP).
		* This helper restricts the search to public fields only (comment_author,
		* comment_content).
		*/
		public static function add_comment_search( $args, $search ) {
			$search = trim( (string) $search );
			if ( '' === $search ) {
				return $args;
			}
			$args['cr_search'] = $search;
			// 'cr_search' is a custom query var and is not included in the comment query
			// cache key, so the search term is appended to 'cache_domain' (a standard
			// query var) to prevent cache collisions between different search terms
			$cache_domain = empty( $args['cache_domain'] ) ? 'core' : $args['cache_domain'];
			$args['cache_domain'] = $cache_domain . '_cr_search_' . md5( $search );
			if ( ! has_filter( 'comments_clauses', array( 'CR_Utils', 'restrict_comment_search_clauses' ) ) ) {
				add_filter( 'comments_clauses', array( 'CR_Utils', 'restrict_comment_search_clauses' ), 10, 2 );
			}
			return $args;
		}

		/**
		* A 'comments_clauses' filter that applies the search condition added by
		* the add_comment_search function to public fields only
		*/
		public static function restrict_comment_search_clauses( $clauses, $query ) {
			global $wpdb;
			if ( ! empty( $query->query_vars['cr_search'] ) ) {
				$like = '%' . $wpdb->esc_like( $query->query_vars['cr_search'] ) . '%';
				$search_sql = $wpdb->prepare(
					'( comment_author LIKE %s OR comment_content LIKE %s )',
					$like,
					$like
				);
				if ( ! empty( $clauses['where'] ) ) {
					$clauses['where'] .= ' AND ' . $search_sql;
				} else {
					$clauses['where'] = $search_sql;
				}
			}
			return $clauses;
		}

	}

endif;
